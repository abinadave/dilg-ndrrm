<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evacuation as Evacuation;
use DB;

class EvacuationController extends Controller
{
    public function fetch(Request $request){
    	return response()->json([
    		'evacuations' => Evacuation::orderBy('id','desc')->get()
    	]);
    }

    public function search(Request $request){
    	$keyword = $request->input('keyword');
    	$evacations = Evacuation::where('evacuation_center', 'like', '%'. $keyword .'%')
    				  ->orWhere('location', 'like', '%'. $keyword .'%')
    				  ->orWhere('floor_area', 'like', '%'. $keyword .'%')
    				  ->orWhere('total_capacity', 'like', '%'. $keyword .'%')
    				  ->orWhere('male', 'like', '%'. $keyword .'%')
    				  ->orWhere('female', 'like', '%'. $keyword .'%')
    				  ->orWhere('potable', 'like', '%'. $keyword .'%')
    				  ->orWhere('non_potable', 'like', '%'. $keyword .'%')
    				  ->get();
    	return $evacations;
    }
}
