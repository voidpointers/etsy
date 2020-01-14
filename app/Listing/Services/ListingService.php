<?php

namespace Listing\Services;

class ListingService
{
    protected $transformer;

    protected $receiptRequest;

    public function __construct(ReceiptRequest $receiptRequest)
    {
        $this->receiptRequest = $receiptRequest;
    }

    /**
     * 获取收据列表
     * 
     * @param array $params
     */
    public function lists($params = [])
    {
        // 格式化
        $receipts = $this->formation(
            $this->receiptRequest->getReceiptByShop($params)
        );

        // 转换
        $data = $this->transform($receipts);

        return $data;
    }
}
