<?php

namespace Shop\Entities;

use App\Model;

class Shop extends Model
{
    protected $connection = 'system-db';

    protected $table = 'shops';

    protected $fillable = [
        'user_id', 'username', 'shop_id', 'shop_name', 'title', 'currency_code',
        'shop_name_zh', 'url', 'image', 'icon', 'consumer_key', 'consumer_secret',
        'access_token', 'access_secret', 'status'
    ];

    public function store($params)
    {
        $data = [];
        foreach ($params as $param) {
            dump($param);
            $param['image'] = $param['image_url_760x100'];
            $param['username'] = $param['login_name'];
            $param['icon'] = $param['icon_url_fullxfull'];
            foreach ($this->fillable as $item) {
                dump($param[$item]);
                $data[] = [
                    $item => $param[$item] ?? ''
                ];
            }
        }
        dd($data);
        return self::insert($data);
    }
}
