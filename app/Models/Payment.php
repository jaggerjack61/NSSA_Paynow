<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function details():belongsTo
    {
        return $this->belongsTo(Detail::class,'details_id');
    }
    public function reg():belongsTo
    {
        return $this->belongsTo(Registration::class,'reference','phone');
    }
}
