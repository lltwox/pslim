<?php
namespace PSlim;

use PSlim\Instruction\Item ;
use PSlim\Instruction\Decoder;
use PSlim\Instruction\Collection;

class Instruction {

    /**
     * String from server, that indicates, that slim server can shut down
     *
     */
    const BYE = 'bye';

    /**
     * Decode input to get list of instructions
     *
     * @param string $input
     * @return Instruction\Collection
     */
    public static function decode($input) {
        $collection = new Collection();
        $decoder = new Decoder();
        $elements = $decoder->decode($input);
        foreach ($elements as $element) {
            $collection->add(self::create($element));
        }

        return $collection;
    }

    /**
     * Create appropriate instruction
     *
     * @param array $items
     */
    public static function create(array $items) {

    }

}