<?php

namespace Swaggest\RestClient;

use Psr\Http\Message\RequestInterface;

interface SecurityApplicator
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function secureRequest(RequestInterface $request);
}