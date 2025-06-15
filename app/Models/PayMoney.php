<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayMoney extends Model
{
    protected $guarded = ['id'];
    protected $table = "paymoneys";

    public function getProject()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
