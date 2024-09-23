<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use QrCode;
use Illuminate\Support\Facades\Crypt;

class Head extends Model
{
    protected $appends = ['verif','task','dokumen','qr'];

    use HasFactory, SoftDeletes;

    public function getverifAttribute()
    {                

       if($this->verifikator)
       {  
          $val = explode(",",$this->verifikator);
            
           foreach($val as $item)
            {
                $user = User::where('id',$item)->first();
                if($user)
                {
                    $name []= $user->name;
                }
            }
           
            return $name;
       } 
       else
       {
            return null;
       }
    }

    public function gettahapAttribute()
    {                

       if($this->step == 2)
       {  
            $val = explode(",",$this->verifikator);
            
           foreach($val as $item)
            {
                if(Auth::user()->id == $item)
                {
                    $user = User::where('id',$item)->first();
                    if($user)
                    {
                        $name = $user->roles->kode;
                        break;
                    }
                }
            }
           
            return $name;
       } 
       else
       {
            return null;
       }
    }

    public function gettaskAttribute()
    {                

       if($this->verifikator)
       {  
           $val = explode(",",$this->verifikator);       

           if(in_array(Auth::user()->id,$val))
           {
               return true;
           }
           else
           {
              return false;
           }
           
       } 
       else
       {
            return false;
       }
    }

    public function getDokumenAttribute()
    {
        $barp =  $this->barp()->exists();
        $bak  =  $this->bak()->exists();
        $kons =  $this->kons()->exists();

        if($this->do == 1)
        {
            $val = 'Selesai Verifikasi Kabid / Ketua TPA';
        }
        else if($this->do == 0 && $barp && $bak)
        {
            $val = 'Verifikasi Kabid / Ketua TPA';
        }
        else if($barp)
        {
            $val = 'Proses Pleno';
        }
        else if($bak)
        {
            $val = 'Proses Konsultasi';
        }
        else if($kons)
        {
            $val = 'Penjadwalan Konsultasi';
        }
        else
        {
            if($this->step == 2)
            {
                if($this->parents()->count() > 0 && $this->grant == 0 && $this->status == 5)
                {
                    $val = 'Verifikasi Ulang';
                }

                else if($this->status == 3)
                {
                    $val = 'Proses Verifikasi';
                }
                
                else if($this->status == 1 && $this->grant == 0)
                {
                    $val = 'Verifikasi Operator';
                }
    
                else if($this->status == 1 && $this->grant == 1)
                {
                    $val = 'Penugasan TPT/TPA';
                }
                else
                {
                    $val = 'Verifikasi Kelengkapan Dokumen';
                }
            }
            else
            {
                if($this->parents()->count() > 0 && $this->grant == 0 && $this->status != 1)
                {
                    $val = 'Verifikasi Ulang';
                }

                else if($this->status == 2)
                {
                    $val = 'Proses Verifikasi';
                }
                
                else if($this->status == 1 && $this->grant == 0)
                {
                    $val = 'Verifikasi Operator';
                }
    
                else if($this->status == 1 && $this->grant == 1)
                {
                    $val = 'Penugasan TPT/TPA';
                }
                else
                {
                    $val = 'Verifikasi Kelengkapan Dokumen';
                }

            }

        }
        return $val;
    }

    public function getnumberAttribute()
    {            
        $bak  =  $this->bak()->exists();
        $barp =  $this->barp()->exists();

        if($barp)
        {
            return str_replace('SPm','BARP',str_replace('600.1.15','600.1.15/PBLT',$this->nomor));
        }
        elseif($bak)
        {
            return str_replace('SPm','BAK',str_replace('600.1.15','600.1.15/PBLT',$this->nomor));
        }
        else
        {
            // return $this->nomor;
            return null;
        }
    }

    public function getqrAttribute()
    {            

        $val = route('dok',['id'=>base64_encode(md5($this->reg))]);
        return base64_encode(QrCode::format('png')->size(200)->generate($val));

    }

    public function region()
    {
        return $this->belongsTo(Village::class, 'village', 'id');
    }

    public function steps()
    {       
        return $this->HasMany(Step::class, 'head', 'id');
    }

    public function head()
    {        
        return $this->HasMany(Head::class, 'id', 'parent')->withTrashed();
    }

    public function old()
    {        
        return $this->HasOne(Head::class, 'id', 'parent')->withTrashed();
    }

    public function sign()
    {   
        return $this->HasMany(Signed::class, 'head', 'id');
    }

    public function tmp()
    {        
        return $this->HasMany(Head::class, 'head_id', 'id')->withTrashed();
    }

    public function parents()
    {        
        return $this->HasOne(Head::class, 'id', 'head_id')->withTrashed();
    }

    public function kons()
    {   
        return $this->HasOne(Consultation::class, 'head', 'id');
    }

    public function link()
    {   
        return $this->HasOne(Links::class, 'head', 'id');
    }

    public function links()
    {   
        return $this->HasMany(Links::class, 'head', 'id');
    }

    public function surat()
    {   
        return $this->HasOne(Schedule::class, 'head', 'id');
    }

    public function bak()
    {   
        return $this->HasOne(News::class, 'head', 'id');
    }

    public function bakTemp()
    {   
        return $this->HasMany(News::class, 'head', 'id')->latest()->withTrashed();
    }

    public function barp()
    {   
        return $this->HasOne(Meet::class, 'head', 'id');
    }

    public function barpTemp()
    {   
        return $this->HasMany(Meet::class, 'head', 'id')->latest()->withTrashed();
    }

    public function notulen()
    {   
        return $this->HasOne(Notulen::class, 'head', 'id');
    }

    public function attach()
    {   
        return $this->HasOne(Attach::class, 'head', 'id');
    }

    public function tax()
    {   
        return $this->HasOne(Tax::class, 'head', 'id');
    }
}
