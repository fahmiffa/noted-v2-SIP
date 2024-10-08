<?php

namespace App\Http\Controllers;

use App\Models\Attach;
use App\Models\Consultation;
use App\Models\Formulir;
use App\Models\Head;
use App\Models\Links;
use App\Models\Meet;
use App\Models\News;
use App\Models\Schedule;
use App\Models\Signed;
use App\Models\Step;
use App\Models\Tax;
use App\Models\User;
use App\Models\Verifikator;
use App\Rules\MatchOldPassword;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use QrCode;
use App\Exports\HeadExport;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function profile()
    {
        $data = "Data Profil";
        return view('profile', compact('data'));
    }

    public function export(Request $request)
    {
        $rule = [
            'startDate' => 'required',
            'endDate' => 'required'
        ];
        $message = [
            'required' => 'Field ini harus diisi',     
        ];
        $request->validate($rule, $message);
        return Excel::download(new HeadExport([$request->startDate,$request->endDate]), 'export.xlsx');

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

    public function image(Request $request)
    {
        $rule = [
           'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ];

        $message = [
            'required' => 'Field ini harus diisi',
            'mimes' => 'Field :attribute ektensi tidak valid',
            'max' => 'ukuran maksimal 2MB',
        ];

        $request->validate($rule, $message);

        $pile = $request->file('image');
        $path = null;
        
        $user = User::where('id', Auth::user()->id)->first();      

        if ($pile) {
            $ext = $pile->getClientOriginalExtension();
            $path = $pile->storeAs(
                'assets/user/' .md5($user->id). '_user.' . $ext, ['disk' => 'public']
            );
        }

        $user->img = $path;
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

    private function summmary()
    {
        $barp = Meet::where('grant', 1)->get();
        
        $res = [];
        foreach($barp as $val)
        {
            $item = (object) json_decode($val->item);            
            $val = $item->val;
            foreach ($val as $key => $value) {
                $res[$key] = $value + $val[$key];
            }
        }
        return $res;
    }

    public function index()
    {
        $this->summmary();
        $chart = $this->chart();
        $head = Head::all();
        $jadwal = Head::doesnthave('kons')->where('grant', 1)->get()->count();
        $verif = Head::doesnthave('kons')->where('grant', 0)->get()->count();
        $kons = Head::has('kons')->where('do', 0)->get()->count();

        $bak = Head::whereHas('bak', function ($q) {
            $q->where('grant', 1);
        })->get()->count();

        $barp = Head::whereHas('barp', function ($q) {
            $q->where('grant', 1);
        })->get()->count();

        // admin, sekretariat
        if (Auth::user()->ijin('master_formulir')) {
            return view('home', compact('head', 'verif', 'kons', 'bak', 'barp', 'chart', 'jadwal'));
        }

        // notulen (teknis)
        if (Auth::user()->ijin('bak')) {

            $comp = head::where('do', 1)->whereHas('sign', function ($q) {
                $q->where('user', Auth::user()->id);
            })->count();

            $task = head::where('do', 0)->whereHas('sign', function ($q) {
                $q->where('user', Auth::user()->id);
            })->count();

            return view('main', compact('task', 'comp','verif', 'kons', 'bak', 'barp', 'chart', 'jadwal','head'));
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
            return view('main', compact('head', 'verif', 'kons', 'bak', 'barp', 'chart', 'jadwal','task','comp'));
        }

        // kabid
        if (Auth::user()->ijin('verifikasi_bak')) {
            $task = head::whereHas('bak', function ($q) {$q->where('do', 0);})->count();
            $comp = head::whereHas('bak', function ($q) {$q->where('do', 1);})->count();
            return view('general', compact('task', 'comp','head', 'verif', 'kons', 'bak', 'barp', 'chart', 'jadwal'));
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
                $no = $keys + 1;
            } else {
                $no = 0;
            }
        } else {
            $no = null;
        }

        return $no;
    }

    public function doc($id)
    {
        $head = Head::where(DB::raw('md5(id)'), $id)->first();
        return view('document.pdf', compact('head'));
    }

    public function dok($id, $par)
    {
        $head = Head::where(DB::raw('md5(id)'), $id)->first();

        if ($par == 'bak') {
            $news = $head->bak;
            $data = compact('news', 'head');

            $pdf = PDF::loadView('document.bak.doc.index', $data)->setPaper('legal', 'potrait');
            return $pdf->stream();
            return view('document.bak.doc.index', $data);
        } else if ($par == 'barp') {
            $meet = $head->barp;
            $news = $head->bak;
            $data = compact('news', 'head', 'meet');

            $pdf = PDF::loadView('document.barp.doc.index', $data)->setPaper('legal', 'potrait');
            return $pdf->stream();
            return view('document.barp.doc.index', $data);

        } else if ($par == 'tax') {
            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($head->nomor));
            $data = compact('qrCode', 'head');

            $pdf = PDF::loadView('document.tax.doc.index', $data)->setPaper('legal', 'potrait');
            return $pdf->stream();

        } else if ($par == 'attach') {
            $link = $head->links->where('ket', 'lampiran')->first();
            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate(route('link', ['id' => $link->short])));
            $data = compact('qrCode', 'head');

            $pdf = PDF::loadView('document.attach.doc.index', $data)->setPaper('legal', 'potrait');
            // return view('document.attach.doc.index', $data);
            return $pdf->stream();
        } else if ($par == 'verifikasi') {
            return  $this->verifikasi($id);
        }
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
        $uri = [];
        $link = Links::where('short', $id)->first();

        $title = strtoupper(str_replace('_', ' ', $link->ket));
        if ($link->ket == 'surat_undangan') {
            $uri[] = route('surat', ['id' => splitChar($link->head)]);
            if ($link->doc->kons->files) {
                $uri[] = asset('storage/' . $link->doc->kons->files);
            }
        }
        else if($link->ket == 'verifikasi')
        {
            // $uri[] = asset('storage/' . $link->files);

            $uri[] = route('req.dok', ['id' => md5($link->head), 'par'=>'verifikasi']);
        }
        else if($link->ket == 'lampiran')
        {
            $uri[] = route('req.dok', ['id' => md5($link->head), 'par'=>'attach']);
        }

        return view('document.embeds', compact('uri', 'title'));

    }

    // preview bak
    public function preview($id,$par)
    {    
        $uri = [];
        if($par == 'bak')
        {
            $news = News::where(DB::raw('md5(id)'), $id)->first();
            $uri []= route('doc.news', ['id' => md5($news->id)]);            
            if($news->files)
            {
                $uri[] = asset('storage/' . $news->files);
            }

            $title = $news->doc->numbDoc('bak');
        }


        return view('document.embeds', compact('uri', 'title'));

    }

    public function surat($id)
    {
        $id = str_replace('-', null, $id);
        $schedule = Schedule::where(DB::raw('md5(head)'), $id)->first();
        $link = Links::where('head', $schedule->head)->where('ket', 'surat_undangan')->first();
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate(route('link', ['id' => $link->short])));
        $data = compact('schedule', 'qrCode');
        $pdf = PDF::loadView('konsultasi.doc.index', $data)->setPaper('legal', 'potrait');
        return $pdf->stream();
        return view('konsultasi.doc.index', $data);
    }

    public function verifikasi($id)
    {
        $head = Head::where(DB::raw('md5(id)'), $id)->withTrashed()->first();
        $num = $this->LogFix($head);
        $docs = Formulir::where('name', $head->type)->first();

        $step = $head->step == 1 ? 0 : 1;

        $link = $head->links->where('ket', 'verifikasi')->first();
        $res = route('link', ['id' => $link->short]);

        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($res));

        $data = compact('qrCode', 'docs', 'head', 'step', 'num');
        if ($head->step == 1) {
            $pdf = PDF::loadView('verifikator.doc.index', $data)->setPaper('legal', 'potrait');
            return $pdf->stream();
            return view('verifikator.doc.index', $data);
        } else {
            $pdf = PDF::loadView('verifikator.doc.home', $data)->setPaper('legal', 'potrait');
            return $pdf->stream();
            return view('verifikator.doc.home', $data);
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

    public function truncate()
    {
        Head::truncate();
        Consultation::truncate();
        Links::truncate();
        News::truncate();
        Meet::truncate();
        Signed::truncate();
        Step::truncate();
        Schedule::truncate();
        Tax::truncate();
        Attach::truncate();
    }
}
