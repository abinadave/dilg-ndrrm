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

    public function scroll(Request $request){
       $skip = $request->input('skip');
       $take = $request->input('take');
       return Evacuation::skip($skip)->take($take)->get();
    }

    public function search(Request $request){
    	$keyword = $request->input('keyword');
      $province = $request->input('province'); 
      $city = $request->input('city'); 
      $evacuations = array();
      if($keyword == ''){
          if ($province != 0 && $city == 0) {
              $evacuations = Evacuation::where('province_id', '=' , $province)->orderBy('id','desc')->get();
          }elseif($province == 0 && $city != 0){
              $evacuations = Evacuation::where('municipality_id', '=' , $city)->orderBy('id','desc')->get();
          }elseif($province != 0 && $city != 0){
              $evacuations = Evacuation::where('province_id', '=' , $province)
                    ->where('municipality_id', '=' , $city)->orderBy('id','desc')->get();
          }else {
              $evacuations = Evacuation::orderBy('id','desc')->limit(100)->get();
          }
      }else {
          $evacuations = $this->advanceFilter($province, $city, $keyword);
      }
    	return $evacuations;
    }
    private function advanceFilter($province, $city, $keyword){
        $evacuations = array();
        if ($province == 0 && $city == 0) {
              $evacuations = Evacuation::where('evacuation_center', 'like', '%'. $keyword .'%')
                    ->orWhere('location', 'like', '%'. $keyword .'%')
                    ->orWhere('floor_area', 'like', '%'. $keyword .'%')
                    ->orWhere('total_capacity', 'like', '%'. $keyword .'%')
                    ->orWhere('male', 'like', '%'. $keyword .'%')
                    ->orWhere('female', 'like', '%'. $keyword .'%')
                    ->orWhere('potable', 'like', '%'. $keyword .'%')
                    ->orWhere('non_potable', 'like', '%'. $keyword .'%')
                    ->orderBy('id','desc')
                    ->get();
          }elseif($province != 0 && $city == 0){
              $evacuations = Evacuation::
                     where('evacuation_center', 'like', '%'. $keyword . '%')
                    ->where('location', 'like', '%'. $keyword . '%')
                    ->where('province_id', '=' , $province)
                    ->orderBy('id','desc')
                    ->get();
          }elseif($province == 0 && $city != 0){
              $evacuations = Evacuation::where('municipality_id', '=' , $city)
                    ->where(function($query) use ($keyword) {
                        return $query->where('evacuation_center', 'like', '%'. $keyword . '%')
                            ->orWhere('location', 'like', '%'. $keyword . '%');
                    })
                    ->orderBy('id','desc')
                    ->get();
          }elseif($province != 0 && $city != 0){
            /* ok na */
              $evacuations = Evacuation::where('province_id', '=' , $province)
                    ->where('municipality_id', '=' , $city)
                    ->where(function($query) use ($keyword) {
                        return $query->where('evacuation_center', 'like', '%'. $keyword . '%')
                            ->orWhere('location', 'like', '%'. $keyword . '%');
                    })
                    ->orderBy('id','desc')
                    ->get();
          }
        return $evacuations;
    }
}
