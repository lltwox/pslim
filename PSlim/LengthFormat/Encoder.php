<?php
namespace PSlim\LengthFormat;

/**
 * Class, encoding array of strings to length-encoded string
 *
 * @author lex
 *
 */
class Encoder {

    /**
     * Delimiter of values
     *
     */
    const DELIMITER = ':';

    /**
     * Encode data
     *
     * @param array $data
     * @return string
     */
    public function encode($data) {
        if (is_array($data)) {
            return $this->encodeArray($data);
        } else {
            return $data;
        }
    }

    /**
     * Encode array
     *
     * @param array $data
     * @return string
     */
    private function encodeArray(array $data) {
        $encodedElements = $this->encodeArrayElements($data);
        $elementsNumber = count($data);

        return
            '['
            . $this->getFormattedLength($elementsNumber)
            . self::DELIMITER
            . implode('', $encodedElements)
            . ']'
        ;
    }

    /**
     * Encode each of array's elements
     *
     * @param array $data
     * @return array
     */
    private function encodeArrayElements(array $data) {
        $result = array();
        foreach ($data as $element) {
            $encodedElement = $this->encode($element);
            $elementLength = mb_strlen($encodedElement);

            $result[]
                = $this->getFormattedLength($elementLength)
                . self::DELIMITER
                . $encodedElement
                . self::DELIMITER
            ;
        }

        return $result;
    }

    /**
     * Prepend length value with zeros for correct format
     *
     * @param integer $length
     * @return string
     */
    private function getFormattedLength($length) {
        return sprintf('%06d', $length);
    }

}