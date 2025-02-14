<?php

namespace App\Http\Controllers;

use App\CommonFunction;
use App\Models\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressBookController extends Controller
{
    public function myaddress()
    {
        $myaddress_list = AddressBook::where('user_id', Auth::id())->where('address_status',1)->get();
        return view('myaddress', compact('myaddress_list'));
    }
    
    public function addAddress(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required'
        ]);

        if($request->input('is_default')){
            AddressBook::where('address_status',1)->where('user_id',Auth::id())->update(['is_default'=>0]);
        }
        $address = new AddressBook();
        $address->user_id = Auth::id();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->landmark = $request->landmark;
        $address->is_default = ($request->input('is_default')) ? 1 : 0;
        $address->address_status = 1;
        $address->created_at = now();
        $address->updated_at = now();
        $address->save();

        return redirect()->route('address.list')->with('success', 'Address added successfully');
    }

    public function deleteAddress($delid)
    {
        $address = AddressBook::find($delid);
        try{
            if(!$address){
                throw new \Exception('Invalid address ID');
            }

            $address->delete();
            return redirect()->route('address.list')->with('success', 'Address deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
