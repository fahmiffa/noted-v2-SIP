<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\Head;
use App\Models\Links;
use App\Models\User;
use App\Models\Verifikator;
use App\Rules\MatchOldPassword;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use QrCode;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Fpdf;

class HomeController extends Controller
{
    public function profile()
    {
        $data = "Data Profil";
        return view('profile', compact('data'));
    }

    public function profiled(Request $request)
    {
        $rule = [
            'oldpassword' => ['required', new MatchOldPassword],
            'password' => 'required|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required',
        ];
        $message = [
            'required' => 'Field ini harus diisi',
            'confirmed' => 'Field :attribute Konfirm tidak valid',
            'regex' => 'Password harus kombinasi Huruf dan Angka',
        ];
        $request->validate($rule, $message);

        $user = User::where('id', Auth::user()->id)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr()->success('Update Berhasil', ['timeOut' => 5000]);
        return back();
    }

    private function chart()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $data = DB::table('heads')
            ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('YEAR(created_at)'))
            ->get();

        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
        ];

        $counts = array_fill(0, 12, 0); // Array untuk nilai default 0 untuk setiap bulan

        foreach ($data as $record) {
            $monthIndex = $record->month - 1; // Indeks bulan (0 = Jan, 1 = Feb, dst.)
            $counts[$monthIndex] = $record->count;
        }

        return [
            'months' => $months,
            'counts' => $counts,
        ];
    }

    public function index()
    {

        // admin, sekretariat
        if (Auth::user()->ijin('master_formulir')) {

            $chart = $this->chart();
            $head = Head::all();
            $verif = Head::doesnthave('kons')->get()->count();
            $kons = Head::has('kons')->get()->count();

            $bak = Head::whereHas('bak', function ($q) {
                $q->where('grant', 1);
            })->get()->count();

            $barp = Head::whereHas('barp', function ($q) {
                $q->where('grant', 1);
            })->get()->count();

            return view('home', compact('head', 'verif', 'kons', 'bak', 'barp', 'chart'));
        }

        // notulen (teknis)
        if (Auth::user()->ijin('bak')) {
            $comp = head::where('do', 1)->whereHas('notulen', function ($q) {
                $q->where('users', Auth::user()->id);
            })->count();

            $task = head::where('do', 0)->whereHas('notulen', function ($q) {
                $q->where('users', Auth::user()->id);
            })->count();

            // $comp  = head::has('tax')->count();
            // $task  = head::doesntHave('tax')->count();
            return view('main', compact('task', 'comp'));
        }

        // verifikator
        if (Auth::user()->ijin('doc_formulir')) {
            $comp = Verifikator::where('verifikator', Auth::user()->id)
                ->whereHas('doc', function ($q) {
                    $q->where('grant', 1);
                })->count();
            $task = Verifikator::where('verifikator', Auth::user()->id)
                ->whereHas('doc', function ($q) {
                    $q->where('grant', 0);
                })->count();
            return view('main', compact('task', 'comp'));
        }

        // kabid
        if (Auth::user()->ijin('verifikasi_bak')) {
            $task = head::whereHas('bak', function ($q) {$q->where('grant', 0);})->count();
            $comp = head::whereHas('bak', function ($q) {$q->where('grant', 1);})->count();
            return view('general', compact('task', 'comp'));
        }

    }

    public function req()
    {
        $val = Head::has('tax')->latest();
        $da = $val->get();
        $data = "Dokumen Permohonan";
        $ver = true;
        return view('req.index', compact('da', 'data', 'ver'));
    }

    public function monitoring()
    {
        $val = Head::latest();
        $da = $val->get();
        $data = "Monitoring Dokumen";
        $ver = true;
        return view('monitoring', compact('da', 'data', 'ver'));
    }

    private function LogFix($head)
    {
        if ($head->head_id) {
            $indexs = $head->parents->tmp->whereNotNull('deleted_at')->pluck('id')->toArray();
            $filter = $head->id;
            $val = array_filter($indexs, function ($value) use ($filter) {
                return $value == $filter;
            });

            if (count($val) > 0) {
                $keys = array_keys($val)[0];
                $no = $keys + 2;
            } else {
                $no = 0;
            }
        } else {
            $no = 1;
        }

        return $no;
    }

    public function docs($id)
    {
        $head = Head::where(DB::raw('md5(id)'), $id)->withTrashed()->first();
        $num = $this->LogFix($head);
        $docs = Formulir::where('name', $head->type)->first();

        $step = $head->step == 1 ? 0 : 1;

        if ($head->grant == 1) {
            $link = $head->links->where('ket', 'verifikasi')->first();
            $res = route('link', ['id' => $link->short]);
        } else {
            $res = $head->reg;
        }

        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($res));

        $data = compact('qrCode', 'docs', 'head', 'step', 'num');

        if ($head->step == 1) {
            $pdf = PDF::loadView('verifikator.doc.index', $data)->setPaper('a4', 'potrait');
            return $pdf->stream();
            return view('verifikator.doc.index', $data);
        } else {
            $pdf = PDF::loadView('verifikator.doc.home', $data)->setPaper('a4', 'potrait');
            return $pdf->stream();
            return view('verifikator.doc.home', $data);
        }
    }

    public function doc($id)
    {
        $head = Head::where(DB::raw('md5(id)'), $id)->first();
        return view('document.pdf',compact('head'));
        // if($head->grant == 1)
        // {
        //     $link = $head->links->where('ket','verifikasi')->first();
        //     $res = route('link',['id'=>$link->short]);
        // }
        // else
        // {
        //     $res = $head->reg;
        // }

        // $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($res));
        // $data = compact('qrCode', 'head');
        // $pdf = PDF::loadView('req.doc.index', $data)->setPaper('a4', 'potrait');
        // return $pdf->stream();    
    }

    public function view($id)
    {
        $head = Head::where(DB::raw('md5(id)'), $id)->first();

        if ($head) {
            $single = true;
            $public = true;
            $title = 'Dokumen Perhononan';
            return view('embed', compact('single', 'public', 'title', 'head'));
        } else {
            toastr()->error('Dokumen Invalid', ['timeOut' => 5000]);
            return redirect()->route('home');
        }

    }

    public function link($id)
    {
        $link = Links::where('short', $id)->first();

        if ($link) {
            $single = true;
            $public = true;
            $title = strtoupper(str_replace('_', ' ', $link->ket));
            return view('embed', compact('single', 'link', 'public', 'title'));
        } else {
            toastr()->error('Surat Invalid', ['timeOut' => 5000]);
            return redirect()->route('home');
        }

    }

    public function store(Request $request)
    {
        $rule = [
            'reg' => 'required',
            'doc' => 'required',
        ];
        $message = ['required' => 'Field ini harus diisi',
        ];
        $request->validate($rule, $message);
        $head = Head::where('reg', $request->reg)->where('nomor', $request->doc)->first();
        if ($head) {
            return back()->with('res', $head)->withInput();
        } else {
            toastr()->error('Dokumen tidak ditemukan', ['timeOut' => 5000]);
            return back();
        }

    }

    public function home()
    {
        return view('welcome');
    }
}
