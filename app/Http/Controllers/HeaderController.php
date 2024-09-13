<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Head;
use DB;
use PDF;
use App\Models\Meet;
use App\Models\Signed;

class HeaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('IsPermission:verifikasi_bak');
    }

    public function ba()
    {
        $val = Head::has('kons')->whereNotNull('tang')->latest();
        $da = $val->get();
        $data = "Berita Acara";
        $ver = true;
        return view('document.ba',compact('da','data','ver'));
    }

    public function baSign($id)
    {
        $head = Head::where(DB::raw('md5(id)'),$id)->first();   
        $single = true;   
        $title = 'Tanda Tangan Dokumen';
        $sign = true;
        return view('document.sign',compact('single','title','head','sign'));
    }

    public function baSigned(Request $request, $id)
    {
        $bak = News::where(DB::raw('md5(head)'), $id)->first();

        if($request->type == 0)
        {
            $bak->sign = $request->sign;
            $bak->grant = 1;
            $bak->save();
            toastr()->success('Tanda tangan berhasil Dokumen BAK', ['timeOut' => 5000]);
        }
        else
        {
            if($bak && $bak->grant == 0)
            {
                toastr()->error('Dokumen bak belum di setujui', ['timeOut' => 5000]);
            }
            else
            {
                $barp = Meet::where(DB::raw('md5(head)'), $id)->first();
                $barp->sign = $request->sign;
                $barp->grant = 1;
                $barp->save();
                toastr()->success('Tanda tangan berhasil BAK', ['timeOut' => 5000]);
            }
        }

        return back();
    }

    public function baReject(Request $request, $id)
    {
        if($request->typer == 0)
        {
            $bak = News::where(DB::raw('md5(head)'), $id)->first();
            $bak->reason = $request->noted;
            $bak->save();            

            $bak->delete();
            Signed::where(DB::raw('md5(head)'),$id)->update(['bak' => null]);
        }
        else
        {
            $barp = Meet::where(DB::raw('md5(head)'), $id)->first();
            $barp->reason = $request->noted;
            $barp->save();

            $barp->delete();
            Signed::where(DB::raw('md5(head)'),$id)->update(['barp' => null]);
        }

        toastr()->success('Dokumen di tolak berhasil', ['timeOut' => 5000]);
        return redirect()->route('ba.verifikasi');
    }

    public function bak()
    {
        $val = News::where('status',1)->latest();
        $da = $val->get();
        $data = "Berita Acara Konsultasi";
        $ver = true;
        return view('document.bak.index',compact('da','data','ver'));
    }

    public function docBak($id)
    {
        $news = News::where(DB::raw('md5(id)'),$id)->first(); 
        $head = $news->doc;
        $data = compact('news','head');

        $pdf = PDF::loadView('document.bak.doc.index', $data)->setPaper('a4', 'potrait');    
        return $pdf->stream();

        return view('document.bak.doc.index',$data);    
    }

    public function approveBak(Request $request, $id)
    {
        $head = News::where(DB::raw('md5(id)'),$id)->first();   
        if($request->has('sign'))
        {
            $head->sign = $request->sign;
        }
        $head->grant = 1;
        $head->save();
        toastr()->success('Verifikasi Data berhasil', ['timeOut' => 5000]);
        return back();                
    }

    public function rejectBak(Request $request, $id)
    {
        $head = News::where(DB::raw('md5(id)'),$id)->first();   
        $head->reason = $request->noted;
        $head->save();

        $head->delete();
        toastr()->success('Dokumen di tolak berhasil', ['timeOut' => 5000]);
        return back();                
    }

    public function barp()
    {
        $val = Meet::where('status',1)->latest();
        $da = $val->get();
        $data = "Berita Acara Rapat Pleno";
        $ver = true;
        return view('document.barp.index',compact('da','data','ver'));
    }

    public function docBarp($id)
    {
        $meet = Meet::where(DB::raw('md5(id)'),$id)->first(); 
        $news = $meet->doc->bak;
        $head = $meet->doc;
        $data = compact('news','head','meet');

        $pdf = PDF::loadView('document.barp.doc.index', $data)->setPaper('a4', 'potrait');   
        // return view('document.barp.doc.index', $data);
        return $pdf->stream();    
    }

    public function approveBarp(Request $request, $id)
    {
        $head = Meet::where(DB::raw('md5(id)'),$id)->first();   
        if($request->has('sign'))
        {
            $head->sign = $request->sign;
        }
        $head->grant = 1;
        $head->save();
        toastr()->success('Verifikasi Data berhasil', ['timeOut' => 5000]);
        return back();                
    }

    public function rejctBarp(Request $request, $id)
    {
        $head = Meet::where(DB::raw('md5(id)'),$id)->first();   
        $head->reason = $request->noted;
        $head->save();

        $head->delete();
        toastr()->success('Dokumen di tolak berhasil', ['timeOut' => 5000]);      
        return back();        
    }
}
