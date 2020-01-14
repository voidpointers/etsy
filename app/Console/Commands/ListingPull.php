<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListingPull extends Command
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

    public function handle()
    {
        $params = [];
        $data = $this->listingService->lists($params);
    }
}
