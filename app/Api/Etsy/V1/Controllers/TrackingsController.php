<?php

namespace Api\Etsy\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Tracking\Requests\TrackingRequest;

class TrackingsController extends Controller
{
    protected $trackingRequest;

    /**
     * Constructor.
     */
    public function __construct(TrackingRequest $trackingRequest)
    {
        $this->trackingRequest = $trackingRequest;
    }

    /**
     * 提交发货信息
     * 
     * @return
     */
    public function create(Request $request)
    {
        $result = [];

        $receipt_ids = $request->input('receipt_id', []);
        foreach ($receipt_ids as $id) {
            $result[] = $this->trackingRequest->submit();
        }

        return $result;
    }
}
