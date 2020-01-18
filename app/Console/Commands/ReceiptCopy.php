<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Receipt\Entities\Transaction;
use Receipt\Entties\Receipt;

class ReceiptCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receipt:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量复制订单';

    public function handle()
    {
        $receipts = DB::select('SELECT MAX(id),etsy_receipt_id, count(id)
            FROM `ce`.`etsy_receipt`
            GROUP BY `etsy_receipt_id`
            HAVING count(id) > 1;'
        );
        $ids = implode(',', array_column($receipts, 'MAX(id)'));
        $transactions = DB::select("SELECT *
            FROM `ce`.`etsy_receipt_transations`
            WHERE `receipt_id`
            IN ($ids)
       ");
        $receipt_ids = array_column($receipts, 'etsy_receipt_id');
        
        $transaction_ids = array_column($transactions, 'transaction_id');
        dd($transaction_ids);

        // 复制订单
        $copy = Receipt::whereIn('receipt_id', $receipt_ids)->get();

        foreach ($copy as $key => $value) {
            unset($copy[$key]['id']);
        }
        // $insert = Receipt::insert($copy);

        // 复制订单产品列表
        $trans = Transaction::whereIn('transaction_id', $transaction_ids)->get();
        dd($trans);
    }
}
