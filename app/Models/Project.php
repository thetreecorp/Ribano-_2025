<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
    // use SoftDeletes;
    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function token()
    {
        return $this->HasOne(ManagePlan::class);
    }
    public function xeedwallet()
    {
        return $this->belongsTo(UserXeedwallet::class, 'user_xeedwallet_id');
    }

    public function get_stage()
    {
        return $this->belongsTo(ProjectStage::class, 'stage');
    }
    
    public function get_industry1()
    {
        return $this->belongsTo(IndustryCategory::class, 'industry_1');
    }
    public function get_industry2()
    {
        return $this->belongsTo(IndustryCategory::class, 'industry_2');
    }


}
