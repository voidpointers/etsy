<?php

namespace Api\Etsy\V1\Controllers;

use Api\Controller;
use Illuminate\Support\Facades\DB;
use Receipt\Entities\Consignee;
use Receipt\Entities\Transaction;
use Receipt\Entties\Receipt;
use Receipt\Repositories\ConsigneeRepository;
use Receipt\Repositories\ReceiptRepository;
use Receipt\Repositories\TransactionRepository;
use Receipt\Transforms\ReceiptTransformer;

/**
 * 收据控制器
 */
class ReceiptsController extends Controller
{
    protected $receiptRepository;

    protected $receiptTransformer;

    protected $consigneeRepository;

    protected $transactionRepository;

    /**
     * Constructor.
     */
    public function __construct(
        ReceiptRepository $receiptRepository,
        ConsigneeRepository $consigneeRepository,
        TransactionRepository $transactionRepository,
        ReceiptTransformer $receiptTransformer)
    {
        $this->receiptRepository = $receiptRepository;       
        $this->consigneeRepository = $consigneeRepository;
        $this->transactionRepository = $transactionRepository;
        $this->receiptTransformer = $receiptTransformer;
    }

    /**
     * 拉取Etsy订单
     * 
     * @return
     */
    public function pull()
    {
        $receipts = \Etsy::findAllShopReceipts([
            'params' => [
                'shop_id' => 16407439,
                'page' => 1,
                'limit' => 5,
                'was_paid' => true,
            ],
            'associations' => [
                'Transactions' => [
                    'associations' => [
                        'MainImage'
                    ]
                ]
            ]
        ]);

        // 数据转换
        $data = $this->receiptTransformer->transform($receipts);

        // 入库
        Receipt::insert($data['receipt']);
        Consignee::insert($data['consignee']);
        Transaction::insert($data['transaction']);

        return ['msg' => 'success'];
    }
}
