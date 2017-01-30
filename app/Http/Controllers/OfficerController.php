<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Officer as Officer;
class OfficerController extends Controller
{
    public function fetch(){
    	return response()->json([
    		'officers'=> Officer::all()
    	]);
    }
}
