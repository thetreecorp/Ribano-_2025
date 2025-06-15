<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendTokenLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function token()
    {
       return $this->belongsTo(ManagePlan::class, 'token_id');
    }
}
