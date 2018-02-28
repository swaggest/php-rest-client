<?php

namespace Swaggest\RestClient;

use Psr\Http\Message\RequestInterface;

abstract class AbstractConfig
{
    /** @var string */
    protected $baseUrl;

    /** @var RequestMiddleware[] */
    protected $requestMiddlewares = array();

    /** @var RequestMiddleware[] */
    protected $securityMiddlewares = array();

    /**
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    /** @codeCoverageIgnoreEnd */

    /**
     * @param string $baseUrl
     * @return $this
     * @codeCoverageIgnoreStart
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }
    /** @codeCoverageIgnoreEnd */

    public function addRequestMiddleware(RequestMiddleware $middleware)
    {
        $this->requestMiddlewares[] = $middleware;
        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function prepareRequest(RequestInterface $request)
    {
        foreach ($this->requestMiddlewares as $middleware) {
            $request = $middleware->prepareRequest($request);
        }
        return $request;
    }

    // [[a,b],[c,d]] string[][]

    /**
     * @param RequestInterface $request
     * @param string[][] $securityGroups
     * @throws \Exception
     */
    public function applySecurity(RequestInterface $request, $securityGroups)
    {
        $found = false;
        /** @var RequestMiddleware[] $middlewares */
        $middlewares = array();

        foreach ($securityGroups as $securityGroup) {
            $middlewares = array();
            $found = true;
            foreach ($securityGroup as $securityName) {
                if (isset($this->securityMiddlewares[$securityName])){
                    $middlewares[] = $this->securityMiddlewares[$securityName];
                } else {
                    $found = false;
                    break;
                }
            }
        }

        if ($found) {
            foreach ($middlewares as $middleware) {
                $request = $middleware->prepareRequest($request);
            }
        } else {
            throw new \Exception('Missing required security: ' . json_encode($securityGroups));
        }


    }
}