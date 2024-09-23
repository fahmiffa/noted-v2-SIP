<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Head;
use App\Models\Role;
use PDF;
use QrCode;
use Exception;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Links;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('IsPermission:master_surat');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $val = Schedule::latest();
        $da = $val->paginate(10);
        $data = "Jadwal Surat";
        return view('schedule.index',compact('da','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = "Tambah Jadwal";
        $doc  = head::doesnthave('surat')->where('grant',1)->latest()->get();
        $user = Role::whereIn('kode',['TPT', 'TPA'])->get();       
        return view('schedule.create',compact('data','user','doc'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [                   
            'doc'       => 'required',       
            'nomor'     =>'required',
            'tanggal'   => 'required',   
            'timeStart'      => 'required',  
            'timeEnd'      => 'required',   
            'date'      => 'required',   
            'jenis'      => 'required',   
            'place'     => 'required',                                           
            'place_des' => 'required',                                           
            ];
        $message = ['required'=>'Field ini harus diisi'];
        $request->validate($rule,$message);

        $ch             = new Schedule;
        $ch->head       = $request->doc;
        $ch->nomor      = $request->nomor;
        $ch->jenis      = $request->jenis;
        $ch->tanggal    = $request->tanggal;
        $ch->waktu      = $request->timeStart.'#'.$request->timeEnd.'#'.$request->date;
        $ch->tempat     = $request->place.'#'.$request->place_des;
        $ch->keterangan = $request->content;
        $ch->save();

        toastr()->success('Tambah Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('schedule.index');
    }

    public function send(Request $request, $id)
    {
        $da = Schedule::where(DB::raw('md5(id)'),$id)->first();
        // echo $data = Crypt::encrypt($id);        
        // dd($da);
        toastr()->success('Send Data berhasil', ['timeOut' => 5000]);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        $link = Links::where('head', $schedule->head)->where('ket','surat_undangan')->first();
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate(route('link',['id'=>$link->short])));
        $data = compact('schedule','qrCode');
        $pdf = PDF::loadView('schedule.letter', $data)->setPaper('a4', 'potrait');    
        return $pdf->stream();
        return view('schedule.letter',$data); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $data = "Edit Jadwal";
        $doc  = head::where('grant',1)->latest()->get();
        $user = Role::whereIn('kode',['TPT', 'TPA'])->get();       
        return view('schedule.create',compact('data','user','doc','schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $rule = [                   
            'doc'       => 'required',       
            'nomor'     =>'required',
            'tanggal'   => 'required',   
            'time'      => 'required',   
            'date'      => 'required',   
            'jenis'      => 'required',   
            'place'     => 'required',                                           
            'place_des' => 'required',                                           
            ];
        $message = ['required'=>'Field ini harus diisi'];
        $request->validate($rule,$message);

        $ch             = $schedule;
        $ch->head       = $request->doc;
        $ch->nomor      = $request->nomor;
        $ch->jenis      = $request->jenis;
        $ch->tanggal    = $request->tanggal;
        $ch->waktu      = $request->time.'#'.$request->date;
        $ch->tempat     = $request->place.'#'.$request->place_des;
        $ch->keterangan = $request->content;
        $ch->save();

        toastr()->success('Update Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        toastr()->success('Delete Data berhasil', ['timeOut' => 5000]);
        return back();
    }
}
