<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function rescues()
    {
        return $this->hasMany('App\Rescue');
    }
}
