<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CityMunicipality as City;
use App\Province as Province;
class CityMunicipalityController extends Controller
{
    public function insert(Request $request){
    	$this->validate($request, [
	        'province' => 'required',
	        'name' => 'required|unique:city_municipalities',
	    ]);
    	$city = new City;
    	$city->province_id = $request->input('province');
    	$city->name = $request->input('name');
    	$city->save();
    	return $city;
    }
    public function fetch(){
        return response()->json([
            'provinces' => Province::orderBy('id','desc')->get(),
            'city_municipalities' => City::orderBy('name')->get()
        ]);
    }
}
