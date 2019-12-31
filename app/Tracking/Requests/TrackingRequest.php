<?php

namespace Tracking\Requests;

class TrackingRequest
{
    /**
     * 提交追踪码
     * 
     * @param array $params
     * @return array
     */
    public function submit(array $params = [])
    {
        $request = [
            'params' => [
                'shop_id' => $params['shop_id'],
                'receipt_id' => $params['receipt_id'],
            ],
            'data' => [
                'tracking_code' => $params['tracking_code'],
                'carrier_name' => 'usps',
                'send_bcc' => true
            ]
        ];

        return \Etsy::submitTracking($request);
    }
}
