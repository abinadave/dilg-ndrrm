<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';
    protected $primaryKey = 'id';
    public function province(){
    	return $this->belongsTo('App\Province');
    }
    public function municipality(){
    	return $this->belongsTo('App\CityMunicipality');
    }
};
