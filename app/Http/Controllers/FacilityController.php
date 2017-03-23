<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility as Facility;

class FacilityController extends Controller
{
    public function export(){
        $facilities =  Facility::where('province_id', '>=', '1')->where('municipality_id', '>=', '1')->get();
        return view('excel.export-facilities')->with(compact('facilities')); 
    }
    public function fetch(Request $request){
    	$search = $request->input('search');
        $province = $request->input('province');
        $city = $request->input('city');
        $resp = array();
        if ($search == '') {
            $resp = $this->filterPidCid($province, $city);
        }else {
            $resp = $this->advanceFilter($province, $city, $search);
        }
        return $resp;
    }
    private function advanceFilter($province, $city, $search){
        $resp = array();
        if ($province == 0 && $city == 0) {
            $resp = Facility::with(['province','municipality'])
              ->where('facility_description', 'like', '%'. $search .'%')
              ->orWhere('facility_category', 'like', '%'. $search .'%')
              ->orWhere('location', 'like', '%'. $search .'%')
              ->orWhere('total_facility', 'like', '%'. $search .'%')
              ->orWhere('person_responsible', 'like', '%'. $search .'%')
              ->orWhere('mobile_no', 'like', '%'. $search .'%')
              ->orWhere('landline_no', 'like', '%'. $search .'%')
              ->get();
        }elseif($province != 0 && $city == 0){
              $resp = Facility::with(['province','municipality'])
                    ->where('province_id', '=' , $province)
                    ->where(function($query) use ($search) {
                        return $query->where('facility_description', 'like', '%'. $search . '%')
                            ->orWhere('facility_category', 'like', '%'. $search .'%')
                            ->orWhere('location', 'like', '%'. $search .'%')
                            ->orWhere('total_facility', 'like', '%'. $search .'%')
                            ->orWhere('person_responsible', 'like', '%'. $search .'%')
                            ->orWhere('mobile_no', 'like', '%'. $search .'%')
                            ->orWhere('landline_no', 'like', '%'. $search .'%');
                    })
                    ->orderBy('id','desc')
                    ->get();
        }elseif($province == 0 && $city != 0){
             $resp = Facility::with(['province','municipality'])
                    ->where('municipality_id', '=' , $city)
                    ->where(function($query) use ($search) {
                        return $query->where('facility_description', 'like', '%'. $search . '%')
                            ->orWhere('facility_category', 'like', '%'. $search .'%')
                            ->orWhere('location', 'like', '%'. $search .'%')
                            ->orWhere('total_facility', 'like', '%'. $search .'%')
                            ->orWhere('person_responsible', 'like', '%'. $search .'%')
                            ->orWhere('mobile_no', 'like', '%'. $search .'%')
                            ->orWhere('landline_no', 'like', '%'. $search .'%');
                    })
                    ->orderBy('id','desc')
                    ->get();
        }elseif($province != 0 && $city != 0){
            $resp = Facility::with(['province','municipality'])
                    ->where('municipality_id', '=' , $city)
                    ->where('province_id', '=' , $province)
                    ->where(function($query) use ($search) {
                        return $query->where('facility_description', 'like', '%'. $search . '%')
                            ->orWhere('facility_category', 'like', '%'. $search .'%')
                            ->orWhere('location', 'like', '%'. $search .'%')
                            ->orWhere('total_facility', 'like', '%'. $search .'%')
                            ->orWhere('person_responsible', 'like', '%'. $search .'%')
                            ->orWhere('mobile_no', 'like', '%'. $search .'%')
                            ->orWhere('landline_no', 'like', '%'. $search .'%');
                    })
                    ->orderBy('id','desc')
                    ->get();
        }
        return $resp;
    }
    private function filterPidCid($province_id, $municipality_id){
        $resp = array();
        if ($province_id == 0 && $municipality_id == 0) {
            $resp = Facility::with(['province','municipality'])
            ->orderBy('id','desc')
            ->limit(100)
            ->get();
            // echo "hit";
        }else {
            if ($province_id == 0 && $municipality_id != 0) {
                $resp = Facility::with(['province','municipality'])
                ->where('municipality_id', $municipality_id)
                ->get();
            }elseif($province_id != 0 && $municipality_id == 0){
                $resp = Facility::with(['province','municipality'])
                ->where('province_id', $province_id)
                ->get();
            }elseif($province_id != 0 && $municipality_id != 0){
                $resp = Facility::with(['province','municipality'])
                ->where('province_id', $province_id)
                ->where('municipality_id', $municipality_id)
                ->get();
            }
        }
        return $resp;
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
