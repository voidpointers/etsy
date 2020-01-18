<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Package\Entities\Logistics;
use Receipt\Entties\Receipt;
use Receipt\Requests\ReceiptRequest;

class Tracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步物流';

    protected $receiptRequest;

    public function __construct(ReceiptRequest $receiptRequest)
    {
        parent::__construct();
        $this->receiptRequest = $receiptRequest;
    }

    public function handle()
    {
        $logistics = Logistics::where(['status' => 1])->with('packages')->get();

        // 发送
        foreach ($logistics as $value) {
            $tracking = $this->receiptRequest->submitTracking($value->toArray());
            if (!$tracking) {
                continue;
            }

            $shipments = $tracking['results'][0]['shipments'][0];
            Logistics::where(['package_sn' => $value->packages->package_sn])->update([
                'shipping_id' => $shipments['receipt_shipping_id'],
                'status' => 8,
                'notification_time' => $shipments['mailing_date']
            ]);

            echo '包裹 ' . $value->package_sn . " 推送成功" . PHP_EOL;
        }
    }
}
