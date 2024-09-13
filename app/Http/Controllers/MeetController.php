<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\Meet;
use App\Models\News;
use App\Models\Notulen;
use App\Models\Signed;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use PDF;

class MeetController extends Controller
{
    public function __construct()
    {
        $this->middleware('IsPermission:baarp');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        
        $val = Notulen::has('bak')->where('users', Auth::user()->id);
        $da = $val->latest()->get();

        $data = "Berita Acara Rapat Pleno";
        $ver = false;
        return view('document.barp.home', compact('da', 'data', 'ver'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meet = meet::whereNot('status', 1)->first();
        if ($meet) {
            return redirect()->route('step.meet', ['id' => md5($meet->id)]);
        } else {
            $doc = head::has('surat')->doesnthave('barp')->whereHas('bak', function ($q) {
                $q->where('grant', 1);
            })->latest()->get();
            $data = "Tambah BARP";
            return view('document.barp.create', compact('data', 'doc'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'doc' => 'required',
            'jenis' => 'required',
            'status' => 'required',
            'fungsi' => 'required',
            'nib' => 'required',
            'date' => 'required',
        ];

        $message = ['required' => 'Field ini harus diisi'];
        $request->validate($rule, $message);

        $input = $request->input();
        $filter = ['jenis', '_token', 'fungsi', 'status', 'nib', 'doc', 'date','val0','val1','val2','val3','uraian','pengajuan','disetujui','keterangan'];        
        $input = Arr::except($input, $filter);

        $da[] = $request->has('val0') ? 1 : 0;
        $da[] = $request->has('val1') ? 1 : 0;
        $da[] = $request->has('val2') ? 1 : 0;
        $da[] = $request->has('val3') ? 1 : 0;
    
        $input = array_merge($input, ['val'=> $da]);
        $header = [
            'nib' => $request->nib,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'fungsi' => $request->fungsi,
        ];

        $ur = $request->uraian;
        $peng = $request->pengajuan;
        $appr = $request->disetujui;
        $ket = $request->keterangan;
        $other = [];
        if($ur)
        {
            for ($i=0; $i < count($ur) ; $i++) { 
                $other[] = [
                    'uraian'=>$ur[$i],
                    'pengajuan'=>$peng[$i],
                    'disetujui'=>$appr[$i],
                    'keterangan'=>$ket[$i],
                ];
            }
        }

        $head = Head::where(DB::raw('md5(id)'), $request->doc)->first();
        $item = $head->barp ? $head->barp : new Meet;
        $item->head = $head->id;
        $item->tanggal = $request->date;
        $item->header = json_encode($header);
        $item->item = json_encode($input);
        $item->other = json_encode($other);
        $item->type = 'pleno';
        $item->status = 2;
        $item->save();       

        toastr()->success('Tambah Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('meet.index');
    }

    private function genPDF($news)
    {
        $head = $news->doc;
        $data = compact('news', 'head');

        $name = 'konsultasi_' . $head->reg . '.pdf';
        $dir = 'assets/data/';
        $path = $dir . $name;

        $pdf = PDF::loadView('document.bak.doc.index', $data)->setPaper('a4', 'potrait');
        Storage::disk('public')->put($path, $pdf->output());
        // return view('document.bak.doc.index',$data);
        // return $pdf->stream();

        $news->files = $path;
        $news->save();
    }

    public function step($id)
    {
        $meet = Meet::where(DB::raw('md5(head)'), $id)->first();
        $head = Head::where(DB::raw('md5(id)'), $id)->first();  

        if(!$meet)
        {
            $his = $head->barpTemp->whereNotNull('deleted_at');
            if($his->count() > 0)
            {
                $meet = ($meet) ? $meet : $his[0];
            }
        }

        $data = "Dokumen " . $head->number;
        return view('document.barp.create', compact('data', 'head','meet'));

    }

    public function doc($id)
    {
        $meet = Meet::where(DB::raw('md5(id)'), $id)->first();
        $news = $meet->doc->bak;
        $head = $meet->doc;
        $data = compact('news', 'head', 'meet');

        $pdf = PDF::loadView('document.barp.doc.index', $data)->setPaper('a4', 'potrait');
        // return view('document.barp.doc.index', $data);
        return $pdf->stream();
    }

    public function sign($id)
    {
        $news = Meet::where(DB::raw('md5(id)'), $id)->first();
        if($news->status == 1)
        {
            toastr()->error('Dokumen Sudah di publish', ['timeOut' => 5000]);
            return back();
        }
        $val  = Notulen::where('users',Auth::user()->id)->where('head',$news->head)->first();   
        $lead = $val->grade == 1 ? true : false;
        $single = true;
        $title = 'Tanda Tangan Dokumen BARP';
        $doc = 'barp';
        return view('document.barp.sign', compact('news', 'single','title','lead','doc'));
    }

    public function signed(Request $request, $id)
    {
        $meet = Meet::where(DB::raw('md5(id)'),$id)->first(); 
        if($request->user == 'pemohon' || $request->user == 'petugas')
        {
            $base64_image = $request->sign;
            if ($base64_image && $meet->primary == 'TPA') 
            {
                if ($request->user == 'petugas') {
                    $meet->sign = $base64_image;
                } else {
                    $meet->signs = $base64_image;
                }

                $meet->sign = $base64_image;
                $meet->save();
                toastr()->success('Tanda tangan berhasil, Complete', ['timeOut' => 5000]);            
            }
            else
            {
                toastr()->error('Invalid Data', ['timeOut' => 5000]);
            }

        }
        else
        {
            $sign = Signed::where(DB::raw('md5(user)'), $request->user)->where('head', $meet->head)->first();
            if ($sign) {
                $base64_image = $request->sign;

                if ($base64_image) {
                    $sign->barp = $base64_image;
                    $sign->save();
                    toastr()->success('Tanda tangan berhasil, Complete', ['timeOut' => 5000]);
                } else {
                    toastr()->error('Invalid Data', ['timeOut' => 5000]);
                }

            } else {
                toastr()->error('Invalid Data petugas', ['timeOut' => 5000]);
            }

        }
        
        return back();

    }

    public function pub(Request $request, $id)
    {
        $meet = Meet::where(DB::raw('md5(id)'),$id)->first();        
        if($meet)
        {

            $val  = Notulen::where('users',Auth::user()->id)->where('head',$meet->head)->first();  

            if($meet->sign == null && $val->user->roles->kode == 'TPA')
            {
                toastr()->error('Petugas belum tanda tangan', ['timeOut' => 5000]);
            }    
            else
            {
                $meet->status = 1; 
                $meet->save();
                toastr()->success('Publish  berhasil, Complete', ['timeOut' => 5000]);   
                return redirect()->route('meet.index');             
            }
        }
        else
        {
            toastr()->error('Invalid Data', ['timeOut' => 5000]);
        }
        return back();
        
    }

    public function next(Request $request, $id)
    {
        $meet = Meet::where(DB::raw('md5(id)'), $id)->first();
        if ($meet) {

            if ($meet->status == 2) {
                $input = $request->input();
                array_shift($input);
                $meet->item = json_encode($input);
                $meet->status = 1;
                $meet->save();

                toastr()->success('Tambah Data berhasil, Complete', ['timeOut' => 5000]);
                return redirect()->route('meet.index');
            }

        } else {
            toastr()->error('Invalid Data', ['timeOut' => 5000]);
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Meet $meet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meet $meet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meet $meet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meet $meet)
    {
        //
    }
}
