<?php

namespace Listing\Requests;

class ListingRequest
{
    /**
     * 获取原始数据
     *
     * @param array $params
     */
    public function getListingByShop(array $params = [])
    {
        $filter = [
            'shop_id' => $params['shop_id'] ?? '',
            'limit' => $params['limit'] ?? 25,
            'sort_on' => $params['sort_on'] ?? 'created',
            'sort_order' => $params['sort_order'] ?? 'down'
        ];

        if (isset($params['page'])) {
            $filter['page'] = $params['page'];
        }
        if (isset($params['min_price'])) {
            $filter['min_price'] = $params['min_price'] ?? '';
        }
        if (isset($params['max_price'])) {
            $filter['max_price'] = $params['max_price'] ?? '';
        }
        if (isset($params['keywords'])) {
            $filter['keywords'] = $params['keywords'] ?? '';
        }

        $associations = [
            'MainImage',
            'Inventory',
            'Images'
        ];

        $method = 'findAllShopListingsActive';
        $listings = \Etsy::$method([
            'params' => $filter,
            'associations' => $associations
        ]);

        return $listings;
    }
}
