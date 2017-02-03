<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function fetch(){
    	return response()->json([
    		'facilities' => \App\Facility::orderBy('id','desc')->get()
    	]);
    }

    public function search(Request $request){
    	$keyword = $request->input('keyword');
    	$data = \App\Facility::orderBy('id','desc')->where('facility_category', 'like', '%'. $keyword .'%')
    				  ->orWhere('facility_description', 'like', '%'. $keyword .'%')
    				  ->orWhere('location', 'like', '%'. $keyword .'%')
    				  ->orWhere('total_facility', 'like', '%'. $keyword .'%')
    				  ->orWhere('person_responsible', 'like', '%'. $keyword .'%')
    				  ->orWhere('mobile_no', 'like', '%'. $keyword .'%')
    				  ->orWhere('landline_no', 'like', '%'. $keyword .'%')
    				  ->get();
    	return $data;
    }
}
