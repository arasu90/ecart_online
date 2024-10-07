<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\CartItem;
use App\Models\CartMaster;
use Faker\Provider\Uuid;
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
        
        // check if the given user exists in db
        if(Auth::attempt(['email'=> $input['email'], 'password'=> $input['password']])){
            // DB::enableQueryLog();
            
            if (isset($_COOKIE['shopping_cart'])) {
                $cartItems = json_decode($_COOKIE['shopping_cart'], true);

                foreach($cartItems as $items){
                    $cart_master = CartMaster::where('user_id', Auth::user()->id)->where('cart_status', 1)->first();
                    if ($cart_master ==  null) {
                        $cart_master =  new CartMaster;
                        $cart_master->user_id = Auth::user()->id;
                        $cart_master->session_id = Session::getId();
                        $cart_master->cart_master_id = Uuid::randomNumber();
                        $cart_master->cart_status = 1;
                        $cart_master->save();
                    }

                    $cart_item = CartItem::where('cart_id', $cart_master->id)->where('product_id', $items['item_id'])->first();
                    if ($cart_item == null) {
                        $cart_item =  new CartItem;
                        $cart_item->cart_id = $cart_master->id;
                        $cart_item->product_id = $items['item_id'];
                        $cart_item->product_qty = $items['quantity'];
                        $cart_item->cart_master_id = $cart_master->cart_master_id;
                        $cart_item->save();
                    }else{
                        CartItem::where('cart_id', $cart_master->id)->where('product_id', $items['item_id'])->update(['product_qty'=>$items['quantity']]);
                    }

                }
                setcookie("shopping_cart","",time()-3600);
                // unset($_COOKIE['shopping_cart']);
            }

            if (Auth::user()->type == 'admin') {
                return redirect()->route('adminDashboardShow');
            }
            else{
                return redirect()->intended(URL::previous());
            }
        }
        else{
            return redirect()->route('login')->with('error', "Invalid Email & Password");
        }
        
    }
}
