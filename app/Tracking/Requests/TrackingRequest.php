<?php

namespace Tracking\Requests;

class TrackingRequest
{
    public function submit(array $params = [])
    {
        return \Etsy::submitTracking(['params' => $params]);
    }
}
