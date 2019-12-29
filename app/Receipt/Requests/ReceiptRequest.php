<?php

namespace Receipt\Requests;

class ReceiptRequest
{
    /**
     * 获取原始数据
     * 
     * @param array $params
     */
    public function getReceiptByShop(array $params = [])
    {
        $filter = [];
        $filter['params'] = [
            'shop_id' => 16407439,
            'was_paid' => true,
            'limit' => $params['limit'] ?? 100
        ];

        if (isset($params['min_created'])) {
            $filter['params']['min_created'] = $params['min_created'] ?? '';
            $filter['params']['max_created'] = $params['max_created'] ?? '';
        }
        if (isset($params['page'])) {
            $filter['params']['page'] = $params['page'];
        }

        $filter['associations'] = [
            'Transactions' => ['associations' => ['MainImage']]
        ];

        $receipts = \Etsy::findAllShopReceipts($filter);

        return $receipts;
    }

    public function getReceiptById()
    {
        $receipts = \Etsy::getShop_Receipt2([
            'params' => [
                'receipt_id' => 1541388204
            ],
            'associations' => [
                'Transactions' => [
                    'associations' => [
                        'MainImage'
                    ]
                ]
            ]
        ]);
        return $receipts;
    }
}
