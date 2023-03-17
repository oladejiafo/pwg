<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Timer;
use App\Constant;
use Session;
use DB;

class ApiController extends Controller
{
    public function getFooterTimer()
    {
        $date =  Timer::first()->date;
        return response()->json(['date' => $date]);
    }

    public function getPricingPlan()
    {
        $response = [];
        $pricingPlans = DB::table('pricing_plans')
                    ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
                    ->where('pricing_plans.status', 'CURRENT')
                    ->select('pricing_plans.*', 'destinations.name')
                    ->get();

        foreach($pricingPlans as $plan) {
            if(($plan->no_of_parent == 0 || $plan->no_of_parent == null) && ($plan->no_of_children == 0 || $plan->no_of_children == null) && ($plan->name == 'Poland')){
                $response['poland_indi'] = $plan;
            } 
            if (($plan->no_of_parent == 1 && $plan->no_of_children == 1) && ($plan->name == 'Poland')){
                $response['poland_family'] = $plan;
            } 
            if(($plan->no_of_parent == 0 || $plan->no_of_parent == null) && ($plan->no_of_children == 0 || $plan->no_of_children == null) && ($plan->name == 'Canada')) {
                $response['canada_indi'] = $plan;
            }
            if(($plan->no_of_parent == 0 || $plan->no_of_parent == null) && ($plan->no_of_children == 0 || $plan->no_of_children == null) && ($plan->name == 'Germany')) {
                $response['germany_indi'] = $plan;
            }
            if(($plan->no_of_parent == 0 || $plan->no_of_parent == null) && ($plan->no_of_children == 0 || $plan->no_of_children == null) && ($plan->name == 'Malta')) {
                $response['malta_indi'] = $plan;
            }
            if(($plan->no_of_parent == 0 || $plan->no_of_parent == null) && ($plan->no_of_children == 0 || $plan->no_of_children == null) && ($plan->name == 'Czech')) {
                $response['czech_indi'] = $plan;
            }
        }
        return $response;
    }

public function applyNow($destinationName, $productId, $pakcageType = null)
    {
        if(Auth::id()){
            Session::put('myproduct_id', $productId);
            $pays = DB::table('applications')
                ->select('applications.pricing_plan_id', 'applications.total_price', 'applications.total_paid', 'applications.first_payment_status', 'applications.submission_payment_status', 'applications.second_payment_status', 'first_payment_price', 'first_payment_paid', 'first_payment_remaining', 'is_first_payment_partially_paid', 'submission_payment_price', 'submission_payment_paid', 'submission_payment_remaining', 'second_payment_price', 'second_payment_paid', 'second_payment_remaining', 'first_payment_verified_by_cfo', 'contract_1st_signature_status')
                ->where('applications.client_id', '=', Auth::id())
                ->where('applications.destination_id', '=', $productId)
                ->orderBy('applications.id', 'desc')
                ->limit(1)
                ->first();
            if($pays) { 
                return \Redirect::route('myapplication');
            } else if($pakcageType == "individual"){
                $pricingPlanId = DB::table('pricing_plans')
                    ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
                    ->where('destination_id', $productId)
                    ->where('pricing_plans.status', 'CURRENT')
                    ->where(function ($pricingPlanId) {
                        $pricingPlanId->where('no_of_parent', '=', 0)
                            ->orWhereNull('no_of_parent');
                    })
                    ->where(function ($pricingPlanId) {
                        $pricingPlanId->where('no_of_children', '=', 0)
                            ->orWhereNull('no_of_children');
                    })
                    ->orderBy('pricing_plans.id', 'DESC')
                    ->pluck('pricing_plans.id')
                    ->first();
                Session::put('packageType', "BLUE_COLLAR");
                Session::put('pricingPlanId', $pricingPlanId);

                return Redirect::to('payment_form/'.$productId);
            } else if($pakcageType == "family"){
                $pricingPlanId = DB::table('pricing_plans')
                ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
                ->where('destination_id', $productId)
                ->where('pricing_plans.status', 'CURRENT')
                ->where(function ($pricingPlanId) {
                    $pricingPlanId->where('no_of_parent', '=', 1)
                        ->orWhereNull('no_of_parent');
                })
                ->where(function ($pricingPlanId) {
                    $pricingPlanId->where('no_of_children', '=', 1)
                        ->orWhereNull('no_of_children');
                })
                ->orderBy('pricing_plans.id', 'DESC')
                ->pluck('pricing_plans.id')
                ->first();
            Session::put('packageType', "FAMILY_PACKAGE");
            Session::put('pricingPlanId', $pricingPlanId);
                return Redirect::to('payment_form/'.$productId);
            } else {
                return \Redirect::route('myapplication');
            }
        } else {
            Session::put('prod_id', $productId);
            return Redirect::to('/register');
        }
    }
}
