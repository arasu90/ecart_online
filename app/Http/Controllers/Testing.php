<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Testing extends Controller
{
    public function index()
    {
        $product = Str::slug('3gb samaung note book pro');

        echo $product;

        // return 'test controller';
    }
}
