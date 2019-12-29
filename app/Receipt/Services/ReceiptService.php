<?php

namespace Receipt\Services;

use Listing\Entities\Sku;
use Receipt\Entties\Receipt;
use Receipt\Requests\ReceiptRequest;
use Receipt\Transforms\Transformer;

class ReceiptService
{
    protected $transformer;

    protected $receiptRequest;

    public function __construct(ReceiptRequest $receiptRequest)
    {
        $this->receiptRequest = $receiptRequest;
    }

    /**
     * 获取收据列表
     * 
     * @param array $params
     */
    public function lists($params = [])
    {
        // 格式化
        $receipts = $this->formation(
            $this->receiptRequest->getReceiptByShop($params)
        );

        // 转换
        $data = $this->transform($receipts);

        return $data;
    }

    /**
     * 格式化
     * 
     * @param array $params
     */
    protected function formation($receipts)
    {
        $receipts = array_column($receipts['results'], null, 'receipt_id');

        $receipt_ids = array_keys($receipts);
        // 筛选已入库数据
        $tmp = Receipt::whereIn('etsy_receipt_id', $receipt_ids)->pluck(
            'etsy_receipt_id'
        )->toArray();

        foreach ($receipt_ids as $id) {
            if (in_array($id, $tmp)) {
                echo '订单已存在 ' . $id . PHP_EOL;
                unset($receipts[$id]);
            }
        }

        return array_reverse($receipts);
    }

    /**
     * 数据转换
     * 
     * @param array $receipts
     * @return array
     */
    protected function transform($receipts)
    {
        // 为每组数据添加唯一编号
        $receipts = array_map(function ($receipt) {
            $receipt['receipt_sn'] = generate_unique_id();
            return $receipt;
        }, $receipts);

        $transformer = new Transformer();

        $data = [];
        // 注入转换器
        foreach (['receipt', 'consignee', 'transaction'] as $value) {
            $instance = $transformer::instance($value);

            $data[$value] = array_map(function ($receipt) use ($instance) {
                return $instance->transform($receipt);
            }, $receipts);
        }

        // 关联本地sku
        $data['transaction'] = $this->inventory($data['transaction']);

        return $data;
    }

    protected function inventory($transactions)
    {
        $data = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction as $value) {
                $data[] = $value;
            }
        }

        $inventories = Sku::with(['inventory' => function ($query) {
            return $query->select('sku', 'inventory_categorys_attributes_path');
        }])
        ->whereIn('listings_sku', array_column($data, 'etsy_sku'))
        ->get()
        ->keyBy('listings_sku');

        foreach ($data as $key => $transaction) {
            $inventory = $inventories[$transaction['etsy_sku']] ?? [];

            $attributes = '';
            if (!empty($inventory)) {
                $attributes = $inventory->inventory->inventory_categorys_attributes_path ?? '';
            }

            $data[$key]['local_sku'] = $inventory['inventory_sku'] ?? '';
            if (1 < strlen($attributes)) {
                $data[$key]['attributes'] = $attributes;
            }
            $data[$key]['title'] = 1 < strlen($attributes)
                ? implode('-', json_decode($attributes)) 
                : $transaction['title'];
        }

        return $data;
    }
}
