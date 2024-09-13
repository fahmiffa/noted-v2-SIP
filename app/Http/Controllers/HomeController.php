<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Head;
use App\Models\Links;
use Auth;
use App\Models\Consultation;
use App\Models\Verifikator;
use App\Models\Notulen;
use DB;
use PDF;
use App\Models\Schedule;
use QrCode;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class HomeController extends Controller
{
    public function index()
    {        

        // admin, sekretariat
        if(Auth::user()->ijin('master_formulir'))
        {
            $head  = Head::all();        
            $verif = Head::doesnthave('kons')->get()->count();     
            $kons  = Head::has('kons')->get()->count();     
    
            $bak  = Head::whereHas('bak',function($q){
                $q->where('grant',1);
            })->get()->count(); 
            
            $barp  = Head::whereHas('barp',function($q){
                $q->where('grant',1);
            })->get()->count(); 
    
            return view('home',compact('head','verif','kons','bak','barp'));
        }  

        // notulen (teknis)
        if(Auth::user()->ijin('bak'))
        {      
            $comp  = head::where('do',1)->whereHas('notulen',function($q){
                $q->where('users',Auth::user()->id);
            })->count();     

            $task  = head::where('do',0)->whereHas('notulen',function($q){
                $q->where('users',Auth::user()->id);
            })->count();   
            
            // $comp  = head::has('tax')->count();     
            // $task  = head::doesntHave('tax')->count();    
            return view('main',compact('task','comp'));
        }     

        // verifikator
        if(Auth::user()->ijin('doc_formulir'))
        {      
            $comp  = Verifikator::where('verifikator',Auth::user()->id)
                                ->whereHas('doc',function($q){
                                    $q->where('grant',1);    
                                })->count();
            $task  = Verifikator::where('verifikator',Auth::user()->id)
                                ->whereHas('doc',function($q){
                                    $q->where('grant',0);    
                                })->count();
            return view('main',compact('task','comp'));
        }

        // kabid
        if(Auth::user()->ijin('verifikasi_bak'))
        {
            $task  = head::whereHas('bak',function($q){$q->where('grant',0);})->count(); 
            $comp  = head::whereHas('bak',function($q){$q->where('grant',1);})->count();         
            return view('general',compact('task','comp'));
        }
    
    }

    public function link($id)
    {
        $link = Links::where('short',$id)->first();

        if($link)
        {
            $single = true;
            $public = true;
            $title = strtoupper(str_replace('_',' ',$link->ket));
            return view('embed',compact('single','link','public','title'));
        }
        else
        {
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
        if($head)
        {
            return back()->with('res',$head)->withInput();  
        }
        else
        {
            toastr()->error('Dokumen tidak ditemukan', ['timeOut' => 5000]);
            return back();
        }

    }

    public function home()
    {
        return view('welcome');
    }
}
