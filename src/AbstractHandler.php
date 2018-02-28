<?php

namespace Swaggest\RestClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

abstract class AbstractHandler
{
    /** @var ClientInterface */
    protected $client;

    /** @var RequestInterface */
    protected $rawRequest;

    /** @var ResponseInterface */
    protected $rawResponse;

    /** @var PromiseInterface */
    private $promise;

    /**
     * @return RequestInterface
     */
    abstract function getRequest();

    /**
     * @return int
     * @throws GuzzleException
     * @throws Exception
     */
    public function getResponseStatus()
    {
        return $this->getRawResponse()->getStatusCode();
    }

    /**
     * @return stdClass
     * @throws GuzzleException
     * @throws Exception
     */
    public function getJsonResponse()
    {
        return \GuzzleHttp\json_decode($this->getRawResponse()->getBody()->getContents());
    }

    /**
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws Exception
     */
    public function getRawResponse()
    {
        if (null === $this->rawResponse) {
            if (null === $this->promise) {
                $this->rawResponse = $this->client->send($this->getRequest());
            } else {
                throw new Exception('Request already sent in async mode', Exception::ALREADY_SENT);
            }
        }
        return $this->rawResponse;
    }

    /**
     * @return PromiseInterface
     */
    public function sendAsync()
    {
        if (null === $this->rawResponse) {
            if (null === $this->promise) {
                $this->promise = $this->client->sendAsync($this->getRequest())
                    ->then(function ($response) {
                        $this->rawResponse = $response;
                    });
            }
        }
        return $this->promise;
    }

}