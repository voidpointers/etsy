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

        $receipts = \Etsy::findAllShopReceipts([
            'params' => $filter,
            'associations' => $associations
        ]);

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
