<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public function doc()
    {         
        return $this->belongsTo(Head::class, 'head', 'id'); 
    }
}
