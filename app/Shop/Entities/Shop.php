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
        $data = [];
        foreach ($params as $param) {
            $param['image'] = $param['image_url_760x100'];
            $param['username'] = $param['login_name'];
            $param['icon'] = $param['icon_url_fullxfull'];
            $param['status'] = 1;
            foreach ($this->fillable as $item) {
                $data[$item] = $param[$item] ?? '';
                $data['access_token'] = $credentials->getIdentifier();
                $data['access_secret'] = $credentials->getSecret();
            }
            self::updateOrCreate(
                ['shop_id' => $param['shop_id']],
                $data
            );
        }

        return $data;
    }
}
