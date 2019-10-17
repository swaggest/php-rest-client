<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace Swaggest\RestClient\Tests\Petstore\Pets\Request;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


class GetPetsType2Request extends ClassStructure
{
    /**
     * @var string The id of the pet to retrieve
     * In: path, Name: petId
     */
    public $petId;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->petId = Schema::string();
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->required = array(
            self::names()->petId,
        );
    }

    public function makeUrl()
    {
        $url = '/pets/' . urlencode($this->petId);
        return $url;
    }

    public function makeHeaders()
    {
        $headers = array();
        return $headers;
    }

    public function makeBody()
    {
        return null;
    }
}