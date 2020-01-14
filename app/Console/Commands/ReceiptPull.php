<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Package\Services\PackageService;
use Receipt\Services\ReceiptService;
use Receipt\Transforms\ReceiptTransformer;

class ReceiptPull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receipt:pull {method} {--page=} {--limit=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拉取订单';

    protected $receiptService;

    protected $packageService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ReceiptService $receiptService,
        PackageService $packageService)
    {
        $this->receiptService = $receiptService;
        $this->packageService = $packageService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $method = $this->argument('method');
        $page = $this->option('page') ?? 1;
        $limit = $this->option('limit') ?? 5;

        if ('page' == $method) {
            for ($i = $page; $i > 0; $i--) {
                $this->pull(['page' => $i, 'limit' => $limit]);
            }
        } else {
            // 获取一小时内订单
            $cur = mktime(date("H"), 0, 0);
            $this->pull([
                'min_created' => $cur - 3600,
                'max_created' => $cur
            ]);
        }
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
        $this->receiptService->create($data);

        // 自动打包
        // $this->packageService->create($data);

        // echo '第' . $params['page'] . "页执行完毕" . PHP_EOL;
        echo json_encode($params) . " 执行完毕" . PHP_EOL;
        usleep(100);
    }
}
