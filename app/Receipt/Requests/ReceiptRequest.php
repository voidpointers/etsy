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
        $receipts = \Etsy::findAllShopReceipts([
            'params' => [
                // 'min_created' => $params['min_created'] ?? '',
                // 'max_created' => $params['max_created'] ?? '',
                'was_paid' => true,
                'shop_id' => 16407439,
                'page' => $params['page'] ?? 1,
                'limit' => $params['limit'] ?? 10,
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
