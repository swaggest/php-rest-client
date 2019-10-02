<?php

namespace Swaggest\RestClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

abstract class AbstractOperation
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
     * @return int
     * @throws GuzzleException
     * @throws RestException
     */
    public function getResponseStatus()
    {
        return $this->getRawResponse()->getStatusCode();
    }

    private $jsonResponseReady = false;
    private $jsonResponse;

    /**
     * @return stdClass
     * @throws GuzzleException
     * @throws RestException
     */
    public function getJsonResponse()
    {
        if (!$this->jsonResponseReady) {
            $this->jsonResponseReady = true;
            $this->jsonResponse = \GuzzleHttp\json_decode($this->getRawResponse()->getBody()->getContents());
        }
        return $this->jsonResponse;
    }

    /**
     * Reading body of raw response is not idempotent, therefore getJsonResponse will fail if the body was already read.
     *
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws RestException
     */
    public function getRawResponse()
    {
        if (null === $this->rawResponse) {
            if (null === $this->promise) {
                $this->rawResponse = $this->client->send($this->rawRequest, ['http_errors' => false]);
            } else {
                throw new RestException('Request already sent in async mode', RestException::ALREADY_SENT);
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
                $this->promise = $this->client->sendAsync($this->rawRequest, ['http_errors' => false])
                    ->then(function ($response) {
                        $this->rawResponse = $response;
                    });
            }
        }
        return $this->promise;
    }

    /**
     * @param string[][] $securityGroups
     * @param AbstractConfig $config
     * @throws RestException
     */
    protected function applySecurity($securityGroups, AbstractConfig $config)
    {
        foreach ($securityGroups as $securityGroup) {
            $applicators = array();
            $found = true;
            foreach ($securityGroup as $securityName) {
                if (null !== $applicator = $config->security($securityName)) {
                    $applicators[] = $applicator;
                } else {
                    $found = false;
                    break;
                }
            }

            if ($found) {
                foreach ($applicators as $applicator) {
                    $this->rawRequest = $applicator->secureRequest($this->rawRequest);
                }
                return;
            }
        }

        throw new RestException('Missing required security: ' . json_encode($securityGroups), RestException::MISSING_SECURITY);
    }

}