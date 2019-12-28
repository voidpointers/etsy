<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Receipt\Entities\Consignee;
use Receipt\Entities\Transaction;
use Receipt\Entties\Receipt;
use Receipt\Services\ReceiptService;
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

    protected $receiptService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ReceiptService $receiptService) 
    {
        $this->receiptService = $receiptService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->pull(1, 5);
    }

    protected function pull($page = 1, $limit = 10)
    {
        // 数据转换
        $data = $this->receiptService->lists(['limit' => 1]);
        if (empty($data)) {
            echo "订单列表为空" . PHP_EOL;
            return;
        }

        // 入库
        Receipt::insert($data['receipt']);
        Consignee::insert($data['consignee']);
        Transaction::insert($data['transaction']);

        echo '第' . $page . "页执行完毕" . PHP_EOL;
        usleep(100);
    }
}
