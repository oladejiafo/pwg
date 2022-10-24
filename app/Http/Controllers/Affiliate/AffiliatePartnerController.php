<?php

namespace App\Http\Controllers\Affiliate;

use App\Affiliate as AppAffiliate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Affiliate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class AffiliatePartnerController extends Controller
{
    public function index()
    {
        return view('affiliate.home');
    }

    public function affiliateLogin()
    {
        if (!Session::has('loginId')) {
            return view('affiliate.auth.login');
        } else {
            return back();
        }
    }

    public function affiliate_login(Request $request)
    {
        $request->validate(([
            'auth' => 'required|email',
            'password' => 'required|min:8'
        ]));

        $affiliated = Affiliate::where('email', '=', $request->auth)->first();
        // dd($affiliated);
        if ($affiliated) {
            if (Hash::check($request->password, $affiliated->password)) {
                $request->session()->put('loginId', $affiliated->id);
                $request->session()->put('loginName', $affiliated->first_name);
                return redirect('affiliate');
            } else {
                return back()->with('failed', 'wrong password');
            }
        } else {
            return back()->with('failed', 'wrong email');
        }
    }

    public function affiliateLogout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
            return redirect('affiliate');
        }
    }

    public function affiliateRegister()
    {
        //
    }

    public function news()
    {
        return view('affiliate.news');
    }
}
