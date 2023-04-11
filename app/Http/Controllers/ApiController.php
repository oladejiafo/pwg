<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Timer;
use App\Helpers\users as UserHelper;
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
        return UserHelper::getGeneralPricingPlan();
    }

    public function applyNow($destinationName, $productId, $pakcageType = null)
    {
        Session::forget('packageTypeOpted');
        Session::put('myproduct_id', $productId);
        Session::forget('payall');
        if($pakcageType == "individual"){
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
            Session::put('packageTypeOpted', "BLUE_COLLAR");
            Session::put('pricingPlanId', $pricingPlanId);

        } else if($pakcageType == "family"){
            $pricingPlanId = DB::table('pricing_plans')
            ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
            ->where('destination_id', $productId)
            ->where('pricing_plans.status', 'CURRENT')
            ->where(function ($pricingPlanId) {
                $pricingPlanId->where('no_of_parent', '=', 1);
            })
            ->where(function ($pricingPlanId) {
                $pricingPlanId->where('no_of_children', '=', 1);
            })
            ->orderBy('pricing_plans.id', 'DESC')
            ->pluck('pricing_plans.id')
            ->first();
            Session::put('packageTypeOpted', "FAMILY_PACKAGE");
            Session::put('pricingPlanId', $pricingPlanId);
        }
        if(Auth::id()){
            $pays = DB::table('applications')
                ->select('applications.pricing_plan_id', 'applications.total_price', 'applications.total_paid', 'applications.first_payment_status', 'applications.submission_payment_status', 'applications.second_payment_status', 'first_payment_price', 'first_payment_paid', 'first_payment_remaining', 'is_first_payment_partially_paid', 'submission_payment_price', 'submission_payment_paid', 'submission_payment_remaining', 'second_payment_price', 'second_payment_paid', 'second_payment_remaining', 'first_payment_verified_by_cfo', 'contract_1st_signature_status')
                ->where('applications.client_id', '=', Auth::id())
                ->orderBy('applications.id', 'desc')
                ->limit(1)
                ->first();
            if($pays) { 
                return \Redirect::route('myapplication');
            } else {
                return Redirect::to('payment_form/'.$productId);
            } 
        } else {
            Session::put('prod_id', $productId);
            return Redirect::to('/register');
        }
    }
}
