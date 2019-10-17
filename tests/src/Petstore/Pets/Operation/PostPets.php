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
use Swaggest\RestClient\Tests\Petstore\Pets\Request\PostPetsRequest;


/**
 * 
 * HTTP: POST /pets
 */
class PostPets extends AbstractOperation
{
    /**
     * @param ClientInterface $client
     * @param PostPetsRequest $request
     * @param Config $config
     * @throws InvalidValue
     * @throws RestException
     */
    public function __construct(ClientInterface $client, PostPetsRequest $request, Config $config)
    {
        $this->client = $client;
        $request->validate();
        $this->rawRequest = new Request(
            Method::POST,
            rtrim($config->getBaseUrl(), '/') . $request->makeUrl(),
            $request->makeHeaders(),
            $request->makeBody()
        );
    }

    /**
     * @return Error
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
            case StatusCode::CREATED: $result = null;break;
            default: $result = Error::import($this->getJsonResponse());break;
        }
        return $result;
    }
}