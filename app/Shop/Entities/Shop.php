<?php

namespace Shop\Entities;

use App\Model;

class Shop extends Model
{
    protected $connection = 'system-db';

    protected $table = 'shops';

    protected $fillable = [
        'user_id', 'username', 'shop_name', 'title', 'currency_code',
        'shop_name_zh', 'url', 'image', 'icon', 'consumer_key', 'consumer_secret',
        'access_token', 'access_secret', 'status'
    ];

    public function store($params, $credentials)
    {
        dd($credentials, $credentials->identifier);
        $data = [];
        foreach ($params as $key => $param) {
            $param['image'] = $param['image_url_760x100'];
            $param['username'] = $param['login_name'];
            $param['icon'] = $param['icon_url_fullxfull'];
            $param['status'] = 1;
            foreach ($this->fillable as $item) {
                $data[$key][$item] = $param[$item] ?? '';
                $data[$key]['access_token'] = $credentials->identifier;
                $data[$key]['access_secret'] = $credentials->secret;
            }
        }
        return self::updateOrCreate(
            ['shop_id' => $data['shop_id']],
            $data
        );
    }
}
