<?php

namespace Api\Etsy\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Listing\Services\ListingService;

/**
 * 产品控制器
 */
class ListingsController extends Controller
{
    protected $listingService;

    /**
     * Constructor.
     */
    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    /**
     * 拉取Etsy产品
     *
     * @return
     */
    public function index($shop_id, Request $request)
    {
        $request->offsetSet('shop_id', $shop_id);
        $data = $this->listingService->lists($request->all());
        return $this->response->array($data);
    }
}
