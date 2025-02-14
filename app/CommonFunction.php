<?php

namespace App;

use App\Models\AddressBook;
use App\Models\CartItem;
use App\Models\Website;
use Illuminate\Support\Facades\Auth;

trait CommonFunction
{
    public $country=['USA','Japan','Italy'];
    
    public function exclusiveProductPrice($product_price, $tax_per)
    {
        return ($product_price * (100/(100+($tax_per))));
    }

    public function getCartCount()
    {
        return CartItem::where('user_id', Auth::id())->where('order_id', '0')->whereIn('cart_status', [1,2])->count();
    }

    public function getAddressByID($id){
        return AddressBook::where('id', $id)->first();
    }

    public function getWebsiteData()
    {
        return Website::first();
    }
}
