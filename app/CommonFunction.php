<?php

namespace App;

use App\Models\AddressBook;
use App\Models\CartItem;
use App\Models\Website;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

    public function getAddressByID($id)
    {
        return AddressBook::where('id', $id)->first();
    }

    public function getWebsiteData()
    {
        return Website::first();
    }

    public function encryptData($str_enc, $key='ecart_online')
    {
        $method = 'aes-128-cbc'; // Use AES-128 instead of AES-256
        $iv = random_bytes(openssl_cipher_iv_length($method));
    
        $encrypted = openssl_encrypt($str_enc, $method, $key, 0, $iv);
    
        // Base64 encode the result to make it a shorter string
        return base64_encode($encrypted . '::' . $iv);
    }

    public function decryptData($str_enc, $key='ecart_online')
    {
        try{
            $method = 'aes-128-cbc'; // Use AES-128 instead of AES-256
            list($encryptedData, $iv) = explode('::', base64_decode($str_enc), 2);
            
            return openssl_decrypt($encryptedData, $method, $key, 0, $iv);
        }catch(\Exception $e){
            return 'invalid';
        }
    }

    public function resultMap($mapList, $enc_column=array(), $slug_column=array())
    {
        return $mapList->map(function($mapValue)use ($enc_column, $slug_column) {
            foreach($enc_column as $key=>$val){
                $mapValue->$key = $this->encryptData($mapValue->$val);
            }
            foreach($slug_column as $key=>$val){
                $mapValue->$key = Str::slug($mapValue->$val);
            }
            return $mapValue;
        });
    }
}
