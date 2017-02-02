<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evacuation as Evacuation;
use DB;

class EvacuationController extends Controller
{
    public function fetch(Request $request){
    	$pagination = $request->input('pagination');
    	$count = DB::table("evacuations")->count();
    	$data = DB::select("SELECT * FROM evacuations ORDER BY id DESC limit ?, ?", 
    	[
    		$pagination['to'],
    		$pagination['per_page']
    	]);
    	return response()->json([
    		'data' => $data,
    		'per_page' => $pagination['per_page'],
    		'to' => $pagination['to'] + 50,
    		'total' => $count
    	]);
    }

}
