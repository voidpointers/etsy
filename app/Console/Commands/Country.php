<?php

namespace App\Console\Commands;

use Country\Entities\Country as EntitiesCountry;
use Illuminate\Console\Command;
use System\Entities\Country as SystemEntitiesCountry;

class Country extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拉取国家列表';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countries = \Etsy::findAllCountry();

        $data = [];
        foreach ($countries['results'] as $country) {
            $data[] = [
                'id' => $country['country_id'],
                'code' => $country['iso_country_code'],
                'name' => '',
                'en' => $country['name'],
            ];
        }

        SystemEntitiesCountry::truncate();

        SystemEntitiesCountry::insert($data);
    }
}
