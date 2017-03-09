<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evacuation as Evacuation;
use DB;

class EvacuationController extends Controller
{
    public function filter($pid, $cid){
        if ($pid == 0 && $cid != 0) {
            return response()->json([
                'evacuations' => Evacuation::where('municipality_id', $cid)->orderBy('id','desc')->get()
            ]);
        }elseif ($pid != 0 && $cid == 0) {
            return response()->json([
                'evacuations' => Evacuation::where('province_id', $pid)->orderBy('id','desc')->get()
            ]);
        }elseif($pid == 0 && $cid == 0){
            return response()->json([
                'evacuations' => Evacuation::orderBy('id','desc')->limit(100)->get()
            ]);
        }elseif($pid != 0 && $cid != 0){
            return response()->json([
                'evacuations' => Evacuation::where('province_id', $pid)->
                                 where('municipality_id', $cid)->orderBy('id','desc')->get()
            ]);
        }
    }

    public function fetch(Request $request){
    	return response()->json([
    		'evacuations' => Evacuation::orderBy('id','desc')->limit(100)->get()
    	]);
    }

    public function search(Request $request){
    	$keyword = $request->input('keyword');
        $evacations = array();
        if($keyword == ''){
            $evacations = Evacuation::orderBy('id','desc')->limit(100)->get();
        }else {
            $evacations = Evacuation::where('evacuation_center', 'like', '%'. $keyword .'%')
                      ->orWhere('location', 'like', '%'. $keyword .'%')
                      ->orWhere('floor_area', 'like', '%'. $keyword .'%')
                      ->orWhere('total_capacity', 'like', '%'. $keyword .'%')
                      ->orWhere('male', 'like', '%'. $keyword .'%')
                      ->orWhere('female', 'like', '%'. $keyword .'%')
                      ->orWhere('potable', 'like', '%'. $keyword .'%')
                      ->orWhere('non_potable', 'like', '%'. $keyword .'%')
                      ->get();
        }
    	
    	return $evacations;
    }
}
