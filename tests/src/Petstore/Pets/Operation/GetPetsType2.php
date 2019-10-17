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
use Swaggest\RestClient\Tests\Petstore\Pets\Request\GetPetsType2Request;


/**
 * 
 * HTTP: GET /pets/{petId}
 */
class GetPetsType2 extends AbstractOperation
{
    /**
     * @param ClientInterface $client
     * @param GetPetsType2Request $request
     * @param Config $config
     * @throws InvalidValue
     * @throws RestException
     */
    public function __construct(ClientInterface $client, GetPetsType2Request $request, Config $config)
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
}