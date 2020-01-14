<?php

namespace Package\Services;

use Illuminate\Support\Arr;
use Package\Entities\Item;
use Package\Entities\Package;

class PackageService
{
    /**
     * 打包
     */
    public function create($params)
    {
        $receipts = Arr::get($params, 'receipt', []);
        if (!$receipts) {
            return $this->response->error('参数错误', 500);
        }
        $transaction = Arr::pluck($params['transaction'], null, 'receipt_sn');

        // 生成包裹
        foreach ($receipts as $receipt) {
            $packages[] = [
                'package_sn' => $receipt['pacakge_sn'],
                'receipt_id' => $receipt['receipt_id'],
                'status' => 1,
                'create_time' => time(),
                'update_time' => time(),
            ];
        }
        foreach ($params['transaction'] as $transaction) {
            $items[] = [
                'package_sn' => $receipt['package_sn'],
                'receipt_sn' => $receipt['receipt_sn'],
                'receipt_id' => $receipt['receipt_id'],
                'transaction_id' => $transaction['transaction_id'],
                'title' => '桌游用品',
                'en' => 'Table Game',
                'price' => '1.98',
                'weight' => '0.198',
                'quantity' => $transaction['quantity'],
            ];
        }

        Package::insert($packages);
        Item::insert($items);

        return $this->response->array(['data' => $items]);
    }
}
