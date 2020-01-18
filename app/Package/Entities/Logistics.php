<?php

namespace Package\Entities;

use App\Model;

class Logistics extends Model
{
    protected $table = 'package_logistics';

    public function packages()
    {
        return $this->belongsTo(Package::class, 'package_sn', 'package_sn');
    }
}
