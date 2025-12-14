<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\PricingPlanItem;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    //
    public function index()
    {
        $plans = PricingPlan::orderBy('amount','asc')->get();

        return view('pages.plans', compact('plans'));
    }

    public function store(Request $request)
    {
        $pricingPlan = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
        ]);

         PricingPlan::create($pricingPlan);

        return back()->with('success', 'Pricing plan created successfully.');
    }

    public function delete($id)
    {
        $pricingPlan = PricingPlan::find($id);
        $pricingPlan->delete();

        return back()->with('success', 'Pricing plan deleted successfully.');
    }

    public function update(Request $request)
    {
        $plan = PricingPlan::find($request->id);
        $pricingPlan = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
        ]);
//        dd($pricingPlan);
        $plan->name = $pricingPlan['name'];
        $plan->amount = $pricingPlan['amount'];
        $plan->save();


        return back()->with('success', 'Pricing plan edited successfully.');
    }
}
