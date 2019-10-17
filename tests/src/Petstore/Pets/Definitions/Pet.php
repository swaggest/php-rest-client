<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace Swaggest\RestClient\Tests\Petstore\Pets\Definitions;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Built from #/definitions/Pet
 */
class Pet extends ClassStructure
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $tag;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->id = Schema::integer();
        $properties->id->format = "int64";
        $properties->name = Schema::string();
        $properties->tag = Schema::string();
        $ownerSchema->required = array(
            self::names()->id,
            self::names()->name,
        );
        $ownerSchema->setFromRef('#/definitions/Pet');
    }
}