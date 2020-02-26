<?php

namespace Shop\Requests;

class ShopRequest
{
    public function getShop($shop_id)
    {
        $filter = [
            'shop_id' => $shop_id
        ];

        $associations = [
            'User' => ['associations' => ['User']]
        ];

        $shops = \Etsy::getShop([
            'params' => $filter,
            'associations' => $associations
        ]);

        return $shops;
    }
    
    public function updateShop(array $params)
    {
        return \Etsy::updateShop([
            'params' => $params
        ]);
    }
}
