<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace Swaggest\RestClient\Tests\Petstore\Pets\Response;

use Psr\Http\Message\ResponseInterface;
use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


class GetPetsOKResponseHeaders extends ClassStructure
{
    /** @var string A link to the next page of responses */
    public $xNext;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->xNext = Schema::string();
        $ownerSchema->addPropertyMapping('x-next', self::names()->xNext);
        $ownerSchema->type = Schema::OBJECT;
    }

    /**
     * @param ResponseInterface $raw
     * @return static
     */
    public static function read(ResponseInterface $raw)
    {
        $data = array();
        $data['x-next'] = $raw->getHeaderLine('x-next');
        $options = new Context();
        $options->tolerateStrings = true;
        return self::import((object)$data, $options);
    }
}