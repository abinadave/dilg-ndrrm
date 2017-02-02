<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rescue as Rescue;

class RescueController extends Controller
{
    public function fetch(){
    	return response()->json([
    		'rescues' => Rescue::all()
    	]);
    }
}
