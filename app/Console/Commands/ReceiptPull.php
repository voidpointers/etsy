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
        // for ($i = 91; $i > 0; $i--)
        // {
        //     $this->pull(['page' => $i, 'limit' => 100]);
        // }
        // 获取一小时内订单
        $cur = mktime(date("H"), 0, 0);

        $this->pull(['min_created' => $cur - 3600, 'max_created' => $cur]);
    }

    protected function pull($params)
    {
        // 数据转换
        $data = $this->receiptService->lists($params);
        if (empty($data)) {
            echo "订单列表为空" . PHP_EOL;
            return;
        }

        // 入库
        Receipt::insert($data['receipt']);
        Consignee::insert($data['consignee']);
        Transaction::insert($data['transaction']);

        // echo '第' . $params['page'] . "页执行完毕" . PHP_EOL;
        echo $params['min_created'] . '-' . $params['max_created'] . " 执行完毕" . PHP_EOL;
        usleep(100);
    }
}
