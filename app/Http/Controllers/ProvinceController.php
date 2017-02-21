<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Province as Province;
use App\CityMunicipality as City;

class ProvinceController extends Controller
{
    public function insert(Request $request){
    	$this->validate($request, [
	        'name' => 'required|unique:provinces|max:100'
	    ]);
    	$province = new Province;
    	$province->name = $request->input('name');
    	$province->save();
    	return $province;
    }
    public function fetchAdmin(){
    	return response()->json([
    		'provinces' => Province::orderBy('name')->get(),
            'city_municipalities' => City::orderBy('name')->get()
    	]);
    }
    public function fetchAlltabs($id){
        return response()->json([
            'province' => Province::where('id', $id)->first(),
            'officers' => \App\Officer::where('province_id', $id)->get(),
            'rescues' => \App\Rescue::where('province_id', $id)->get(),
            'evacuations' => \App\Evacuation::where('province_id', $id)->get(),
            'facilities' => \App\Facility::where('province_id', $id)->get(),

        ]);
    }
}
