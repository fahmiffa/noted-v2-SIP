<?php

namespace App\Http\Controllers;

use App\Models\Head as Verifikasi;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Formulir;
use App\Models\Village;
use App\Models\Role;
use App\Models\User;
use App\Models\District;
use PDF;
use QrCode;
use Exception;

class HeadController extends Controller
{

    public function __construct()
    {
        $this->middleware('IsPermission:master_formulir');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)    
    {
        $val = verifikasi::latest();
        // dd($val->get());
        $key = $request->get('key');
        $opsi = $request->get('opsi');
        if($key)
        {
            $val = $val->where($opsi,$key);
        }        
        $da = $val->get();
        $data = "Verifikasi";
        return view('document.index',compact('da','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = "Tambah Verifikasi";
        $dis  = District::all();
        $user = Role::whereIn('kode',['VL1', 'VL2', 'VL3'])->get(); 
        return view('document.create',compact('data','user','dis'));
    }

    public function approve(Request $request, $id)
    {
        $head = Verifikasi::where(DB::raw('md5(id)'),$id)->first();   
        $head->grant = 1;
        $head->tang = date('Y-m-d H:i:s');
        $head->save();
        genPDF($head->id,'verifikasi');
        toastr()->success('Verifikasi Data berhasil', ['timeOut' => 5000]);
        return back();                
    }


    public function reject(Request $request, $id)
    {
        $old = Verifikasi::where(DB::raw('md5(id)'),$id)->first(); 
        $old->note = $request->noted;       
        $old->save(); 
        
        $head = new Verifikasi;
        $head->parent = $old->id;
        $head->head_id = ($old->parents) ? $old->parents->id : $old->id;
        $head->village = $old->village;
        $head->header = $old->header;
        $head->nomor = $old->nomor;
        $head->type = $old->type;
        $head->reg = $old->reg;
        $head->status = 5;
        $head->verifikator = $old->verifikator;
        $head->step = $old->step;
        $head->sekretariat = Auth::user()->id;
        $head->save();

        $old->delete();

        toastr()->success('Verifikasi Data berhasil', ['timeOut' => 5000]);
        return back();     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [                               
            'type'=> 'required',
            'verifikator'=>'required',
            'namaPemohon' => 'required',           
            'alamatPemohon'=> 'required',                                    
            'namaBangunan'=> 'required',                                    
            'alamatBangunan'=> 'required', 
            'pengajuan'=> 'required', 
            'fungsi'=> 'required', 
            'noreg'=> 'required|unique:heads,reg', 
            'email'=> 'required|unique:heads,reg', 
            'dis'=> 'required', 
            'des'=> 'required', 
            'hp'=> 'required',                                           
            ];
        $message = ['required'=>'Field ini harus diisi','unique'=>'Field ini sudah ada'];
        $request->validate($rule,$message);

        // validasi tahap
        if(count($request->verifikator) > 2)
        {
            toastr()->error('Verifikator maksimal 2', ['timeOut' => 5000]);
            return back()->withInput();
        }

        $header = [$request->noreg, $request->pengajuan, $request->namaPemohon, $request->hp, $request->alamatPemohon, $request->namaBangunan, $request->fungsi, $request->alamatBangunan];                

        $head = new Verifikasi;
        $head->village = $request->des;
        $head->header = json_encode($header);
        $head->nomor = nomor();
        $head->reg = $request->noreg;
        $head->type = $request->type;
        $head->email = $request->email;
        $head->status = 5;
        $head->verifikator = implode(",",$request->verifikator);
        $head->step = $request->task;
        $head->sekretariat = Auth::user()->id;
        $head->save();

        toastr()->success('Tambah Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('verifikasi.index');
    }

    public function village(Request $request)
    {
        $da = Village::where('districts_id',$request->id)->pluck('name', 'id');
        return response()->json($da);
    }

    public function task(Request $request)
    {
        $val = $request->id == 1 ? ['VL1'] : ['VL2', 'VL3'];

        if($request->id == 1)
        {
            $one = User::whereIn('role',Role::whereIn('kode',$val)->pluck('id')->toArray())->pluck('name','id');        
            $da = ['satu'=>$one];
            return response()->json($da);

        }
        else
        {
            $one = User::whereIn('role',Role::whereIn('kode',['VL2'])->pluck('id')->toArray())->pluck('name','id'); 
            $two = User::whereIn('role',Role::whereIn('kode',['VL3'])->pluck('id')->toArray())->pluck('name','id');        
            $da = ['satu'=>$one,'dua'=>$two];
            return response()->json($da);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Verifikasi $verifikasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Verifikasi $verifikasi)
    {
        $user = Role::whereIn('kode',['VL1', 'VL2', 'VL3'])->get(); 
        $dis  = District::all();
        $data = "Edit Verifikasi";
        return view('document.create',compact('data','verifikasi','user','dis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Verifikasi $verifikasi)
    {
        $rule = [                            
            'type'=> 'required',
            'verifikator'=>'required',
            'namaPemohon' => 'required',           
            'alamatPemohon'=> 'required',                                    
            'namaBangunan'=> 'required',                                    
            'alamatBangunan'=> 'required', 
            'pengajuan'=> 'required', 
            'fungsi'=> 'required', 
            'noreg'=> 'required|unique:heads,reg,'.$verifikasi->id, 
            'email'=> 'required|unique:heads,email,'.$verifikasi->id,             
            'dis'=> 'required', 
            'des'=> 'required', 
            'hp'=> 'required',                                           
            ];
        $message = ['required'=>'Field ini harus diisi','unique'=>'Field ini sudah ada'];
        $request->validate($rule,$message);

        // validasi tahap
        if(count($request->verifikator) > 2)
        {
            toastr()->error('Verifikator maksimal 2', ['timeOut' => 5000]);
            return back()->withInput();
        }

        $ver = $request->verifikator;

        // validasi 2 tahap
        if(count($ver) > 1)
        {
            // case 1
            $VL2 = User::where('id',$ver[0])->where('role',Role::select('id')->where('kode','VL2')->pluck('id'))->exists();              
            $VL3 = User::where('id',$ver[1])->where('role',Role::select('id')->where('kode','VL3')->pluck('id'))->exists();  
            $case1 = ($VL2 && $VL3) ? true : false;
            // case 2
            $VL2s = User::where('id',$ver[1])->where('role',Role::select('id')->where('kode','VL2')->pluck('id'))->exists();              
            $VL3s = User::where('id',$ver[0])->where('role',Role::select('id')->where('kode','VL3')->pluck('id'))->exists();  
            $case2 = ($VL2s && $VL3s) ? true : false;

            if(!$case1 && !$case2)
            {
                toastr()->error('Invalid verifikator', ['timeOut' => 5000]);
                return back()->withInput();
            } 

        }
        // verifikator 1 tahap
        else
        {
            $VL1 = User::where('id',$ver)->where('role',Role::select('id')->where('kode','VL1')->pluck('id'))->exists();  
            if(!$VL1)
            {
                toastr()->error('Invalid verifikator', ['timeOut' => 5000]);
                return back()->withInput();
            }                 
        }


        $header= [$request->noreg, $request->pengajuan, $request->namaPemohon, $request->hp, $request->alamatPemohon, $request->namaBangunan, $request->fungsi, $request->alamatBangunan];                
        $verifikasi->village = $request->des;
        $verifikasi->header = json_encode($header);     
        $verifikasi->type = $request->type;
        $verifikasi->reg = $request->noreg;
        $verifikasi->email = $request->email;
        $verifikasi->verifikator = implode(",",$request->verifikator);
        $verifikasi->step = count($request->verifikator);
        $verifikasi->save();

        toastr()->success('Update Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('verifikasi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Verifikasi $verifikasi)
    {
        $verifikasi->delete();
        toastr()->success('Delete Data berhasil', ['timeOut' => 5000]);
        return back();
    }
}
