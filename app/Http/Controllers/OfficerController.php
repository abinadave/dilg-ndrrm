<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Officer as Officer;
use Illuminate\Support\Facades\Auth;
class OfficerController extends Controller
{
	public function filterBy($province_id){
		return response()->json([
			'officers' => Officer::where('province_id', $province_id)->get()
		]);
	}
	public function delete($id){
		$deleted = false;
		if (Auth::user()->admin == 1) {
			$officer = Officer::find($id);
			$deleted = $officer->delete();
		}
		return response()->json([
			'deleted' => $deleted
		]);
	}
	public function insert(Request $request){
		$this->validate($request, [
	        'drrm_officer' => 'required|unique:officers|max:100',
	        'province' => 'required',
	        'city_municipality' => 'required',
	        'mobile_no' => 'required',
	        'landline_no' => 'required',
	        'email_address' => 'required|email',
	        'radio_frequency' => 'required',
	        'call_sign' => 'required'
	    ]);
	    return $this->saveOfficer($request);
	}
	private function saveOfficer($request){
		$officer = new Officer;

		$province = \App\Province::findOrFail($request->input('province'));
		$cityMunicipality = \App\CityMunicipality::findOrFail($request->input('city_municipality'));

		$officer->region = 'REGION EIGHT';
		$officer->province = $province->name;
		$officer->city_municipality = $cityMunicipality->name;
		$officer->drrm_officer = $request->input('drrm_officer');
		$officer->province_id = $request->input('province');
		$officer->municipality_id = $request->input('city_municipality');
		$officer->mobile_no = $request->input('mobile_no');
		$officer->landline_no = $request->input('landline_no');
		$officer->emnail_address = $request->input('email_address');
		$officer->radio_frequency = $request->input('radio_frequency');
		$officer->call_sign = $request->input('call_sign');
		$officer->save();
		return $officer;
	}
    public function fetch(){
    	return response()->json([
    		'officers'=> Officer::orderBy('id','desc')->get()
    	]);
    }
}
