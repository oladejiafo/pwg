<?php

namespace App\Http\Controllers\Affiliate;

use App\Affiliate as AppAffiliate;
use App\Models\Affiliate;
use App\Models\Presentation;
use App\Models\News;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Applicant;
use App\Models\Referrer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Session;
use DB;
use Carbon\Carbon;

class AffiliatePartnerController extends Controller
{
    public function index()
    {

        if (Session::has('loginId')) {

            $my_id = Session::get('loginId');
            $mine = Affiliate::where('id', '=', $my_id)->first();
   
            $affiliates = Affiliate::where('refferer_code', '=', $mine->affiliate_code)->get();
            $clients = Applicant::where('refferer_code', '=', $mine->affiliate_code)->get();

            $tot_reff = $clients->count() + $affiliates->count();
            $cl_comm = 0;
            $tot_rev = 0;
            foreach($clients as $client)
            {
                $prod = DB::table('pricing_plans')
                ->where('destination_id', '=', $client->destination_id)
                ->first();

                $tot_rev = $tot_rev + $prod->total_price;
                
                $comm = DB::table('commission')
                ->where('product_id', '=', $client->destination_id)
                ->first();

                $cl_comm = $cl_comm + $comm->client_commission;
            }

            $aff_comm =0;
            foreach ($affiliates as $affiliate) 
            {
                $reffered = DB::table('applications')
                ->where('refferer_code', '=', $affiliate->affiliate_code)
                ->get();

                foreach($reffered as $reff)
                {
                    $comm_r = DB::table('commission')
                    ->where('product_id', '=', $reff->destination_id)
                    ->first();
                }

                if(isset($comm_r)){
                    $comm_aff = ($comm_r->affiliate_commission/100) * $comm_r->client_commission;
                    // $aff_rev = $comm_r->client_commission;
                } else {
                    $comm_aff = 0;
                }

                $cnt = $reffered->count();
                $name = $affiliate->first_name . ' ' . $affiliate->surname;
                $aff_comm = $aff_comm + ($cnt * $comm_aff);
            }
            $tot_comm = $cl_comm + $aff_comm;


            return view('affiliate.dashboard', compact('tot_reff', 'tot_rev', 'tot_comm'));
        } else {
            return view('affiliate.home');
        }
    }

    public function affiliateLogin()
    {
        if (Session::has('loginId')) {
            return view('affiliate.dashboard');
        } else {
            return view('affiliate.auth.login');
        }
    }

    public function affiliate_login(Request $request)
    {
        $request->validate(([
            'auth' => 'required|email',
            'password' => 'required|min:8'
        ]));

        $affiliated = Affiliate::where('email', '=', $request->auth)->first();

        if ($affiliated) {
            if (Hash::check($request->password, $affiliated->password)) {
                $request->session()->put('loginId', $affiliated->id);
                $request->session()->put('loginName', $affiliated->first_name);
                $request->session()->put('loginSName', $affiliated->surname);
                $request->session()->put('ref_code', $affiliated->affiliate_code);
                return redirect('affiliate');
            } else {
                return back()->with('failed', 'wrong password');
            }
        } else {
            return back()->with('failed', 'wrong email');
        }
    }

    public function forgotPassword()
    {
        return view('affiliate.auth.forgot-password');
    }

    public function resetPassword()
    {
        return view('affiliate.auth.reset-password');
    }

    public function PasswordRequest(Request $request)
    {
        $user = DB::table('affiliate')->where('email', '=', $request->email)
            ->first();

        //Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        } else {
            $token = rand(100000, 999999);
            $email = $request->email;

            DB::table('affiliate')
                ->where('email', $request->email)
                ->update(
                    [
                        'otp' => $token,
                        'updated_at' => Carbon::now()
                    ]
                );

            Session::put('email', $email);
            Mail::to($request->email)->send(new ResetPassword($token));

            // return view('affiliate..auth.reset-password', compact('email'));
            return redirect()->route('affiliate.reset-password')->with('success', trans('A reset link has been sent to your email address.'));
            // ->with('success', trans('A reset link has been sent to your email address.'));
        }
    }

    public function passwordUpdate(Request $request)
    {
        $user = Affiliate::where('email', '=', $request->email)->first();

        $validator = \Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ])->after(function ($validator) use ($user, $request) {
            if (!isset($request['current_password']) || !Hash::check($request['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        });
        DB::table('affiliate')
            ->where('email', $request->email)
            ->update(
                [
                    'password' => Hash::make($request->password)
                ]
            );
        return redirect()->route('affiliate.login')->with('success', trans('Password reset successfully.'));
    }

    public function affiliateLogout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
            Session::pull('loginName');
            Session::pull('loginSName');
            Session::pull('ref_code');
            return redirect('affiliate');
        }
    }

    public function affiliateRegister()
    {
        if (!Session::has('loginId')) {
            return view('affiliate.auth.register');
        } else {
            return back();
        }
    }

    public function affiliate_register(Request $request)
    {
        $request->validate(([
            'name' => 'required',
            'surname' => 'required',
            'phone_number' => 'required',
            'terms' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]));

        $check = Affiliate::where('email', '=', $request->email)->first();

        if ($check === null) {
            $affiliate = new Affiliate();
            $affiliate->first_name = $request->name;
            $affiliate->surname = $request->surname;
            $affiliate->email = $request->email;
            $affiliate->refferer_code = $request->refferer;
            $affiliate->phone_number = $request->phone_number;
            $affiliate->password = Hash::make($request->password);
            $res = $affiliate->save();

            if ($res) {

                $affiliated = Affiliate::where('email', '=', $request->email)->first();
                $request->session()->put('loginId', $affiliated->id);
                $request->session()->put('loginName', $affiliated->first_name);
                $request->session()->put('loginSName', $affiliated->surname);

                DB::table('affiliate')
                    ->where('email', $request->email)
                    ->update(
                        [
                            'affiliate_code' => substr(Session::get('loginName'), 0, 1) . substr(Session::get('loginSName'), 0, 1) . sprintf("%04d", Session::get('loginId')) . strtoupper(substr(md5(microtime()), rand(0, 26), 4))
                        ]
                    );

                $affiliated = Affiliate::where('email', '=', $request->email)->first();
                $request->session()->put('ref_code', $affiliated->affiliate_code);

                return redirect('affiliate');
            } else {
                return back();
            }
        } else {
            return back()->with('failed', 'This record exists already');
        }
    }

    public function reffered_client($aff_id){        
        if(Session::has('loginId')){
           $mine = Affiliate::where('id', '=', $aff_id)->first();
   
           $clients = Applicant::where('refferer_code', '=', $mine->affiliate_code)->get();
           $affiliates = Affiliate::where('refferer_code', '=', $mine->affiliate_code)->get();
           // dd($clients->count());
           return view('affiliate.refferals', compact('affiliates','clients','mine'));
        } else {
           return back();
        }
    }
   
    public function transfer($id){
        if(Session::has('loginId')){
           $mine = Affiliate::where('id', '=', $id)->first();
           $acct = DB::Table('affiliate_transactions')
                ->where('affiliate_id', '=', $mine->id)
                ->orderBy('transaction_date','desc')
                ->first();

           return view('affiliate.transfer', compact('mine','acct'));
        } else {
            return back();
        }
    }

    public function news()
    {
        $news = News::where('active', 1)->orderBy('id', 'DESC')->take(3)->get();

        $oldNews = News::where('active', 1)->orderBy('id', 'DESC')->skip(3)->take(5)->get();
        return view('affiliate.news', compact('news', 'oldNews'));
    }

    public function newsBrief($id)
    {
        $news = News::find($id);
        return view('affiliate.news-details', compact('news'));
    }

    public function aboutUs()
    {
        return view('affiliate.about-us');
    }

    public function toolBox()
    {
        $presents = Presentation::where('active', 1)->orderBy('id', 'DESC')->take(3)->get();
        return view('affiliate.toolbox', compact('presents'));
    }

    public function toolBoLoadxMore(Request $request)
    {
        $presents = Presentation::where('active', 1)
                        ->where('id', '<', $request->lastid)
                        ->orderBy('id', 'DESC')
                        ->take(3)
                        ->get()
                        ->toArray();
        foreach($presents as $present){
            // dd(storage_path('presentation/' . $present['image_url']));
            $present['image_url'] =  Storage::path('presentation/' . $present['image_url']);
            dd($present);
        }
        return $presents;
    }
}
