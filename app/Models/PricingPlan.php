<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingPlan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function items(): hasMany
    {
        return $this->hasMany(PricingPlanItem::class, 'pricing_plan_id');
    }
}
