<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AffiliatePartnerController extends Controller
{
    public function index()
    {
        return view('affiliate.home');
    }
}
