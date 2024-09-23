<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\Head;
use App\Models\Role;
use App\Models\User;
use Mail;
use App\Mail\SipMail;
use App\Models\Schedule;
use PDF;
use Illuminate\Support\Facades\Storage;
use QrCode;
use Exception;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Fpdf;
use App\Models\Signed;
use App\Models\Links;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{

    public function __construct()
    {
        $this->middleware('IsPermission:master_formulir');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $val = Consultation::latest();
        $da = $val->get();
        $data = "Panugasan & Penjadwalan TPT/TPA";
        return view('konsultasi.index',compact('da','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = "Panugasan & Penjadwalan TPT TPA";
        $doc  = head::doesnthave('kons')->where('grant',1)->latest()->get();
        $user = Role::whereIn('kode',['TPT', 'TPA'])->get();       
        return view('konsultasi.create',compact('data','user','doc'));
    }


    public function store(Request $request)
    {

        $rule = [                   
            'doc' => 'required',       
            'notulen'=>'required',
            'konsultan'=> 'required',            
            'tanggal'   => 'required',   
            'timeStart' => 'required',  
            'timeEnd'      => 'required',   
            'date'      => 'required',   
            'jenis'      => 'required',   
            'place'     => 'required',                                           
            // 'place_des' => 'required',     
            'pile' => 'nullable|file|mimes:pdf|max:2048',                          
            ];
        
        $message = [
            'required'=>'Field ini harus diisi',
            'mimes' => 'Extension File invalid',
            'max' => 'File size max 2Mb',
            ];
        $request->validate($rule,$message);

        if(count($request->notulen) > 2)
        {
            toastr()->error('Notulen maksimal 2', ['timeOut' => 5000]);
            return back()->withInput();
        }
        
        $path = null;
        $kons = new Consultation;
        $kons->head = $request->doc;
        $kons->notulen = implode(",",$request->notulen);         
        $pile = $request->file('pile'); 
        if($pile)
        {
            $ext = $pile->getClientOriginalExtension();
            $path = $pile->storeAs(
                'assets/konsultasi/'.time().'_konsultasi.'.$ext, ['disk' => 'public']
            );           
        }         

        $kons->konsultan = implode(",",$request->konsultan);              
        $kons->save();        
        
        $ch             = new Schedule;
        $ch->head       = $request->doc;
        $ch->jenis      = $request->jenis;
        $ch->tanggal    = $request->tanggal;
        $ch->waktu      = $request->timeStart.'#'.$request->timeEnd.'#'.$request->date;
        $ch->tempat     = $request->place.'#'.$request->place_des;
        $ch->keterangan = $request->content;
        $ch->save();

        foreach($request->konsultan as $par)
        {
            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $par;
            $sign->task = $kons->id;
            $sign->type = 'member';
            $sign->save();
        }

        foreach($request->notulen as $var)
        {
            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $var;
            $sign->task = $kons->id;
            $sign->type = 'lead';
            $sign->save();
        }

        $merge = $this->genPDF($ch,$path);

        $kons->files = $merge;
        $kons->save();
        
        if(env('MAIL'))
        {
            $this->mail($request->konsultan,$kons->head);
        }

        toastr()->success('Tambah Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('consultation.index');
    }

    private function genPDF($schedule,$lamp)
    {
        $name = 'surat_'.$schedule->head.'.pdf';
        $dir = 'assets/data/';
        $path = $dir.$name;
        
        $link =  $this->links($schedule->head);

        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate(route('link',['id'=>$link->short])));
        $data = compact('schedule','qrCode');
        $pdf = PDF::loadView('schedule.letter', $data)->setPaper('f4', 'potrait');
        Storage::disk('public')->put($path, $pdf->output());   

        $pdf = new fpdi();
        if($lamp)
        {
            $files = [
                storage_path('app/public/'.$path),
                storage_path('app/public/'.$lamp)
            ];

            foreach ($files as $file) {
                $pageCount = $pdf->setSourceFile($file);
                for ($page = 1; $page <= $pageCount; $page++) {
                    $tplIdx = $pdf->importPage($page);
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx);
                }
            }

            $name = 'assets/surat_'.time().'.pdf';
            $outputPath = Storage::disk('public')->path($name);
            $pdf->Output($outputPath, 'F');

            $link->files = $name;
            $link->save();
            return $name;    
        }
        else
        {
            $link->files = $path;
            $link->save();
        }

    }

    private function links($head)
    {
        $shortUrl = Str::random(6);
        while (Links::where('short', $shortUrl)->exists()) {
            $shortUrl = Str::random(6);
        }

        $link = new Links;
        $link->head  = $head;
        $link->ket   = 'surat_undangan';
        $link->short = $shortUrl;
        $link->save();

        return $link;
    }

    private function mail($var,$head)
    {
        $doc  = head::where('id',$head)->first();

        $header = json_decode($doc->header);

        foreach ($var as $value) {
            $user = User::where('id',$value)->first();

            $mailData = [
                'title' => 'Yth. '.$user->name,
                'body' => 'Anda mendapatkan tugas untuk melakukan verifikasi terhadap permohonan PBG/SLF dengan Nomor Registrasi :'.$header[0],
                'par' => 'Terimakasih'
            ];

            Mail::to($user->email)->send(new SipMail($mailData));
        }
         
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultation $consultation)
    {
        $schedule  = Schedule::where('head',$consultation->head)->first();
        $data = "Edit Konsultasi";
        $doc  = head::where('grant',1)->latest()->get();
        $user = Role::whereIn('kode',['TPT', 'TPA'])->get();       
        return view('konsultasi.create',compact('data','user','doc','consultation','schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultation $consultation)
    {
        $rule = [                   
            'doc' => 'required',       
            'notulen'=>'required',
            'konsultan'=> 'required',            
            'tanggal'   => 'required',   
            'timeStart' => 'required',  
            'timeEnd'      => 'required',   
            'date'      => 'required',   
            'jenis'      => 'required',   
            'place'     => 'required',                                           
            'pile' => 'nullable|file|mimes:pdf|max:2048',                                       
            ];

            $message = [
                'required'=>'Field ini harus diisi',
                'mimes' => 'Extension File invalid',
                'max' => 'File size max 2Mb',
                ];
            $request->validate($rule,$message);

        $kons = $consultation;
        $pile = $request->file('pile'); 
        
        if($pile)
        {
            $ext = $pile->getClientOriginalExtension();
            $path = $pile->storeAs(
                'assets/konsultasi/'.time().'_konsultasi.'.$ext, ['disk' => 'public']
            );        
        }               
        $kons->notulen = implode(",",$request->notulen);   
        $kons->head = $request->doc;
        $kons->konsultan = implode(",",$request->konsultan);              
        $kons->save();

        $ch  = Schedule::where('head',$consultation->head)->first();
        $ch->head       = $request->doc;
        $ch->nomor      = $request->nomor;
        $ch->jenis      = $request->jenis;
        $ch->tanggal    = $request->tanggal;
        $ch->waktu      = $request->timeStart.'#'.$request->timeEnd.'#'.$request->date;
        $ch->tempat     = $request->place.'#'.$request->place_des;
        $ch->keterangan = $request->content;
        $ch->save();

        Signed::where('task',$consultation->id)->where('type','member')->delete();
        
        foreach($request->konsultan as $par)
        {
            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $par;
            $sign->task = $kons->id;
            $sign->type = 'member';
            $sign->save();
        }

        Signed::where('task',$consultation->id)->where('type','lead')->delete();

        foreach($request->notulen as $var)
        {

            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $var;
            $sign->task = $kons->id;
            $sign->type = 'lead';
            $sign->save();
        }

        if($pile)
        {
            $merge = $this->genPDF($ch,$path);
            $kons->files = $merge;
            $kons->save();
        }

        toastr()->success('Update Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('consultation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return back();
    }
}
