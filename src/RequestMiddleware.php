<?php

namespace Swaggest\RestClient;

use Psr\Http\Message\RequestInterface;

interface RequestMiddleware
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function prepareRequest(RequestInterface $request);

}