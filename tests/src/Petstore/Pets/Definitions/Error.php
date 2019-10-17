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
 * Built from #/definitions/Error
 */
class Error extends ClassStructure
{
    /** @var int */
    public $code;

    /** @var string */
    public $message;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->code = Schema::integer();
        $properties->code->format = "int32";
        $properties->message = Schema::string();
        $ownerSchema->required = array(
            self::names()->code,
            self::names()->message,
        );
        $ownerSchema->setFromRef('#/definitions/Error');
    }
}