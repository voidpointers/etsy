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
            'shop_id' => 16407439, 'was_paid' => true, 'limit' => $params['limit'] ?? 100
        ];

        if (isset($params['min_created'])) {
            $filter['min_created'] = $params['min_created'] ?? '';
            $filter['max_created'] = $params['max_created'] ?? '';
        }
        if (isset($params['page'])) {
            $filter['page'] = $params['page'];
        }

        $associations = [
            'Transactions' => ['associations' => ['MainImage']]
        ];

        $receipts = \Etsy::findAllListingActive([
            'params' => $filter,
            // 'associations' => $associations
        ]);

        return $receipts;
    }
}
