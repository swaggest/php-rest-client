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

    /** @var AbstractConfig */
    protected $config;

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

    /**
     * @return stdClass
     * @throws GuzzleException
     * @throws RestException
     */
    public function getJsonResponse()
    {
        return \GuzzleHttp\json_decode($this->getRawResponse()->getBody()->getContents());
    }

    /**
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
     * @throws RestException
     */
    protected function applySecurity($securityGroups)
    {
        foreach ($securityGroups as $securityGroup) {
            $applicators = array();
            $found = true;
            foreach ($securityGroup as $securityName) {
                if (null !== $applicator = $this->config->security($securityName)) {
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