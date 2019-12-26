<?php

namespace Receipt\Transforms;

use Listing\Entities\Sku;

class ReceiptTransformer
{
    public function transform($receipts)
    {
        $data = [];

        $transaction = [];
        foreach ($receipts['results'] as $receipt) {
            $receipt['receipt_sn'] = generate_unique_id();
            $data['receipt'][] = $this->receipt($receipt);
            $data['consignee'][] = $this->consignee($receipt);
            $transaction[] = $this->transaction($receipt);
        }
        foreach ($transaction as $value) {
            foreach ($value as $val) {
                $data['transaction'][] = $val;
            }
        }

        $sku = array_column($data['transaction'], 'etsy_sku');
        $inventories = Sku::with(['inventory' => function ($query) {
            return $query->select(
                'sku',
                'inventory_categorys_attributes_path'
            );
        }])
        ->whereIn('listings_sku', $sku)
        ->get()
        ->keyBy('listings_sku');

        foreach ($data['transaction'] as $key => $transaction) {
            $inventory = $inventories[$transaction['etsy_sku']] ?? [];

            $attributes = '';
            if (!empty($inventory)) {
                $attributes = $inventory->inventory->inventory_categorys_attributes_path ?? '';
            }

            $data['transaction'][$key]['local_sku'] = $inventory['inventory_sku'] ?? '';
            $data['transaction'][$key]['attributes'] = $attributes;
            $data['transaction'][$key]['title'] = 1 < strlen($attributes)
                ? implode('-', json_decode($attributes)) 
                : $transaction['title'];
        }

        return array_reverse($data);
    }

    protected function receipt($receipt)
    {
        return [
            'etsy_receipt_id' => $receipt['receipt_id'],
            'receipt_sn' => $receipt['receipt_sn'],
            'type' => $receipt['receipt_type'],
            'order_id' => $receipt['order_id'],
            'seller_user_id' => $receipt['seller_user_id'],
            'buyer_user_id' => $receipt['buyer_user_id'],
            'buyer_email' => $receipt['buyer_email'],
            'payment_method' => $receipt['payment_method'],
            'was_paid' => $receipt['was_paid'],
            'was_shipped' => $receipt['was_shipped'],
            'currency_code' => $receipt['currency_code'],
            'total_price' => $receipt['total_price'],
            'subtotal' => $receipt['subtotal'],
            'grandtotal' => $receipt['grandtotal'],
            'adjusted_grandtotal' => $receipt['adjusted_grandtotal'],
            'total_tax_cost' => $receipt['total_tax_cost'],
            'total_vat_cost' => $receipt['total_vat_cost'],
            'total_shipping_cost' => $receipt['total_shipping_cost'],
            'seller_msg' => $receipt['message_from_seller'] ?? '',
            'buyer_msg' => $receipt['message_from_buyer'] ?? '',
            'buyer_msg_zh' => '',
            'creation_tsz' => $receipt['creation_tsz'] ?? 0,
            'modified_tsz' => $receipt['last_modified_tsz'] ?? 0,
            'create_time' => time(),
            'update_time' => time(),
        ];
    }

    protected function consignee($receipt)
    {
        return [
            'etsy_receipt_id' => $receipt['receipt_id'],
            'receipt_sn' => $receipt['receipt_sn'],
            'country_id' => $receipt['country_id'],
            'name' => $receipt['name'] ?? '',
            'state' => $receipt['state'] ?? '',
            'city' => $receipt['city'] ?? '',
            'zip' => $receipt['zip'] ?? '',
            'first_line' => $receipt['first_line'] ?? '',
            'second_line' => $receipt['second_line'] ?? '',
            'formatted_address' => $receipt['formatted_address'] ?? '',
        ];
    }

    protected function transaction($receipt)
    {
        $data = [];
        foreach ($receipt['Transactions'] as $value) {
            $data[] = [
                'title' => $value['title'],
                'etsy_receipt_id' => $receipt['receipt_id'],
                'receipt_sn' => $receipt['receipt_sn'],
                'transaction_id' => $value['transaction_id'],
                'listing_id' => $value['listing_id'],
                'etsy_sku' => $value['product_data']['sku'],
                'image_id' => $value['MainImage']['listing_image_id'],
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'attributes' => '',
                'paid_tsz' => $value['paid_tsz'] ?? 0,
                'shipped_tsz' => $value['shipped_tsz'] ?? 0
            ];
        }
        return $data;
    }
}
