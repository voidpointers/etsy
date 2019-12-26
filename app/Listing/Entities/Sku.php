<?php

namespace Listing\Entities;

use App\Model;

class Sku extends Model
{
    protected $connection = 'mysql-ce';

    protected $table = 'etsy_listings_sku';

    public function inventory()
    {
        return $this->hasOne('Inventory\Entities\Inventory', 'sku', 'inventory_sku');
    }
}
