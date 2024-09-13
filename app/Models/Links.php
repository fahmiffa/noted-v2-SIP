<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;
    protected $table = 'links';

    public function doc()
    {         
        return $this->belongsTo(Head::class, 'head', 'id'); 
    }
}
