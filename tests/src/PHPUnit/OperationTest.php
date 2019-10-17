<?php

namespace Swaggest\RestClient\Tests\PHPUnit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Swaggest\RestClient\Tests\Petstore\Config;
use Swaggest\RestClient\Tests\Petstore\Pets\Operation\GetPets;
use Swaggest\RestClient\Tests\Petstore\Pets\Request\GetPetsRequest;

class OperationTest extends TestCase
{
    function testOperation()
    {
        $body = <<<'JSON'
[{"id":1, "name": "Tom"},{"id":2, "name":"Jerry"}]
JSON;

        $handler = new MockHandler();
        $handler->append(
            new Response(200, ['x-next' => 'the-next-val'], $body),
            );

        $client = new Client(['handler' => $handler]);
        $request = new GetPetsRequest();
        $request->limit = 10;
        $config = new Config();

        $op = new GetPets($client, $request, $config);
        $op->sendAsync();

        $resp = $op->getResponse();
        $this->assertSame('Tom', $resp[0]->name);
        $this->assertSame(2, $resp[1]->id);
        $this->assertSame('the-next-val', $op->getResponseHeaders()->xNext);
        $this->assertSame(200, $op->getResponseStatus());
        $this->assertEquals(json_decode($body), $op->getJsonResponse());
    }
}