<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\CartMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->back()->with('error', 'Please provide valid credentials');
        // dd(Redirect::getIntendedUrl());
        return redirect()->intended(URL::previous());
        // return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function customLogin(Request $request): RedirectResponse
    {
        $input = $request->all();
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $cart_master_data = CartMaster::where('session_id',Session::getId())->where('cart_status',1)->first();
        // check if the given user exists in db
        if(Auth::attempt(['email'=> $input['email'], 'password'=> $input['password']])){
            // DB::enableQueryLog();
            if($cart_master_data != null){
                CartMaster::where('session_id',$cart_master_data->session_id)->where('cart_status',1)->update(['user_id'=>Auth::user()->id]);
            }
            // $daaa = DB::getquerylog();
            // dd($daaa);
            // check the user role
            // dd($getid." get id .....tGTWaqZsJWk0bZRC9aVCIvhnrnTlasAqG4tNWDVO old id ".Session::getId(). "new session id");
            if (Auth::user()->type == 'admin') {
                return redirect()->route('adminDashboardShow');
            }
            else{
                return redirect()->intended(URL::previous());
            }
        }
        else{
            return redirect()->route('login')->with('error', "Wrong credentials");
        }
        
    }
}
