<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    public function dedit()
    {
        return $this->hasMany('\App\Dedit','refno','refno');
    }
}
