<?php

namespace Listing\Services;

use Listing\Requests\ListingRequest;

class ListingService
{
    protected $transformer;

    protected $listingRequest;

    public function __construct(ListingRequest $listingRequest)
    {
        $this->listingRequest = $listingRequest;
    }

    /**
     * 获取收据列表
     *
     * @param array $params
     */
    public function lists($params = [])
    {
        $data = $this->listingRequest->getListingByShop($params);
        return $data;
    }
}
