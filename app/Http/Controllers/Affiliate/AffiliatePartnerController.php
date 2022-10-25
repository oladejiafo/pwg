<?php

namespace App\Http\Controllers\Affiliate;

use App\Affiliate as AppAffiliate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\News;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;
use Carbon\Carbon;

class AffiliatePartnerController extends Controller
{
    public function index()
    {

        if (Session::has('loginId')) {

            return view('affiliate.dashboard');
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

    public function news()
    {
        $news = News::where('active', 1)->latest()->take(3)->get();

        $oldNews = News::where('active', 1)->latest()->skip(3)->take(5)->get();
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
}
