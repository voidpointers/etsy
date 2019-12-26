<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Receipt\Entities\Consignee;
use Receipt\Entities\Transaction;
use Receipt\Entties\Receipt;
use Receipt\Transforms\ReceiptTransformer;

class ReceiptPull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receipt:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拉取订单';

    protected $receiptTransformer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ReceiptTransformer $receiptTransformer)
    {
        $this->receiptTransformer = $receiptTransformer;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i = 89; $i > 0; $i--) {
            $this->pull($i);
        }
    }

    protected function pull($page = 1)
    {
        $receipts = \Etsy::findAllShopReceipts([
            'params' => [
                'shop_id' => 16407439,
                'page' => 89,
                'limit' => 10,
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

        echo '第' . $page . "页执行完毕" . PHP_EOL;
        usleep(100);
    }
}
