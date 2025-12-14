<?php

namespace App\Http\Controllers;

use App\Models\PricingPlanItem;
use Illuminate\Http\Request;

class PricingPlanItemController extends Controller
{
    //
    public function store(Request $request)
    {

        $pricingPlanItem = $request->validate([
            'name' => 'required|string',
            'pricing_plan_id' => 'required|string',
        ]);
//        dd('here');
        PricingPlanItem::create($pricingPlanItem);

        return back()->with('success', 'Pricing plan item created successfully.');
    }

    public function delete($id)
    {
        $pricingPlanItem = PricingPlanItem::find($id);
        $pricingPlanItem->delete();

        return back()->with('success', 'Pricing plan item deleted successfully.');
    }
}
