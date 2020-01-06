<?php

namespace Receipt\Transforms;

use Receipt\Contracts\TransformerInterface;

class ReceiptTransformer implements TransformerInterface
{
    public function transform($receipt)
    {
        return [
            'etsy_receipt_id' => $receipt['receipt_id'],
            'receipt_sn' => $receipt['receipt_sn'] ?? '',
            'type' => $receipt['receipt_type'],
            'order_id' => $receipt['order_id'],
            'seller_user_id' => $receipt['seller_user_id'],
            'buyer_user_id' => $receipt['buyer_user_id'],
            'buyer_email' => $receipt['buyer_email'],
            'payment_method' => $receipt['payment_method'],
            'status' => $receipt['was_shipped'] ? 8 : 1,
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
            'complete_time' => $receipt['was_shipped'] ?? $receipt['last_modified_tsz'],
        ];
    }
}
