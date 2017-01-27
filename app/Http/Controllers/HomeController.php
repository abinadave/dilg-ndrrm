<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function migrate(){
        $directory = 'ndrrm-files/biliran';
        // $files = Storage::allFiles($directory);
        // foreach ($files as $dirOfFile) {
        //      $info = pathinfo($dirOfFile);
        //      Storage::copy($dirOfFile, 'ndrrm-csv/biliran/' .$info['filename'] . '.csv');
        // }
        echo "Coming soon";
    }
}
