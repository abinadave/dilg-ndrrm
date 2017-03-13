<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rescue as Rescue;

class RescueController extends Controller
{
    public function fetch(){
    	return response()->json([
    		'rescues' => Rescue::orderBy('id','desc')->take(50)->get()
    	]);
    }
    public function filter(Request $request){
        $pid = $request->input('province');
        $cid = $request->input('city');
        if ($pid == 0 && $cid != 0) {
            return response()->json([
                'rescues' => Rescue::where('municipality_id', $cid)->orderBy('id','desc')->get()
            ]);
        }elseif ($pid != 0 && $cid == 0) {
            return response()->json([
                'rescues' => Rescue::where('province_id', $pid)->orderBy('id','desc')->get()
            ]);
        }elseif($pid == 0 && $cid == 0){
            return response()->json([
                'rescues' => Rescue::orderBy('id','desc')->limit(100)->get()
            ]);
        }elseif($pid != 0 && $cid != 0){
            return response()->json([
                'rescues' => Rescue::where('province_id', $pid)->
                                 where('municipality_id', $cid)->orderBy('id','desc')->get()
            ]);
        }
    }
    public function searchOnly(Request $request){
    	$rescues = array();
    	$keyword = $request->input('keyword');
    	$province = $request->input('province');
    	$city = $request->input('city');

    	if ($keyword == '') {
    		
    	}else {
    		$rescues = Rescue::where('rescue_team', 'like', '%'. $keyword .'%')
	            ->orWhere('hotline_no', 'like', '%'. $keyword .'%')
	            ->orWhere('team_leader', 'like', '%'. $keyword .'%')
	            ->orWhere('man_power', 'like', '%'. $keyword .'%')
	            ->orderBy('id','desc')
	            ->get();
    	}

    	return $rescues;
    }
}
