<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace Swaggest\RestClient\Tests\Petstore\Pets\Operation;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Swaggest\JsonSchema\Exception;
use Swaggest\JsonSchema\InvalidValue;
use Swaggest\RestClient\AbstractOperation;
use Swaggest\RestClient\Http\Method;
use Swaggest\RestClient\Http\StatusCode;
use Swaggest\RestClient\RestException;
use Swaggest\RestClient\Tests\Petstore\Config;
use Swaggest\RestClient\Tests\Petstore\Pets\Definitions\Error;
use Swaggest\RestClient\Tests\Petstore\Pets\Definitions\Pet;
use Swaggest\RestClient\Tests\Petstore\Pets\Definitions\Pets;
use Swaggest\RestClient\Tests\Petstore\Pets\Request\GetPetsRequest;
use Swaggest\RestClient\Tests\Petstore\Pets\Response\GetPetsOKResponseHeaders;


/**
 * 
 * HTTP: GET /pets
 */
class GetPets extends AbstractOperation
{
    /**
     * @param ClientInterface $client
     * @param GetPetsRequest $request
     * @param Config $config
     * @throws InvalidValue
     * @throws RestException
     */
    public function __construct(ClientInterface $client, GetPetsRequest $request, Config $config)
    {
        $this->client = $client;
        $request->validate();
        $this->rawRequest = new Request(
            Method::GET,
            rtrim($config->getBaseUrl(), '/') . $request->makeUrl(),
            $request->makeHeaders(),
            $request->makeBody()
        );
    }

    /**
     * @return Pet[]|array|Error
     * @throws RestException
     * @throws InvalidValue
     * @throws Exception
     * @throws GuzzleException
     */
    public function getResponse()
    {
        $raw = $this->getRawResponse();
        $statusCode = $raw->getStatusCode();
        switch ($statusCode) {
            case StatusCode::OK: $result = Pets::import($this->getJsonResponse());break;
            default: $result = Error::import($this->getJsonResponse());break;
        }
        return $result;
    }

    /**
     * @return GetPetsOKResponseHeaders
     * @throws RestException
     * @throws GuzzleException
     */
    public function getResponseHeaders()
    {
        $raw = $this->getRawResponse();
        $statusCode = $raw->getStatusCode();
        switch ($statusCode) {
            case StatusCode::OK: $result = GetPetsOKResponseHeaders::read($raw);break;
            default: $result = null;break;
        }
        return $result;
    }
}