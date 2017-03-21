<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $table = 'officers';
    protected $primaryKey = 'id';
    public function province(){
    	return $this->belongsTo('App\Province');
    }
    public function municipality(){
    	return $this->belongsTo('App\CityMunicipality');
    }
}
