<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dedit extends Model
{
    public function credit()
    {
        return $this->hasMany('\App\Credit','refno','refno');
    }
}
