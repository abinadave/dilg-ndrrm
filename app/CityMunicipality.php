<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityMunicipality extends Model
{
    public function rescues()
    {
        return $this->hasMany('App\Rescue');
    }
    public function officers()
    {
        return $this->hasMany('App\Officer');
    }
}
