<?php
namespace PSlim\LengthFormat;

/**
 * Class, decoding length-encoded data of lists and strings
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class Decoder {

    /**
     * Number of digits in length specification
     *
     */
    const LENGTH_DIGITS = 6;

    /**
     * Length of used delimiter, which is a ':' sign
     *
     */
    const DELIMITER_LENGTH = 1;

    /**
     * Decode input
     *
     * @param string $input
     * @return array
     */
    public function decode($input) {
        if ($this->isList($input)) {
            return $this->decodeList($input);
        } else {
            return $input;
        }
    }

    /**
     * Decode an entry, assuming it is a list
     *
     * @param string $input
     * @return array
     */
    private function decodeList($input) {
        $list = array();

        $contents = mb_substr($input, 1, -1);
        $numberOfElements = intval(
            mb_substr($contents, 0, self::LENGTH_DIGITS)
        );
        $contents = mb_substr(
            $contents, self::LENGTH_DIGITS + self::DELIMITER_LENGTH
        );

        for ($i = 0; $i < $numberOfElements; $i++) {
            $elementInput = $this->getListElement($contents);
            $list[] = $this->decode($elementInput);
            $contents = mb_substr(
                $contents,
                self::LENGTH_DIGITS + self::DELIMITER_LENGTH
                    + mb_strlen($elementInput) + self::DELIMITER_LENGTH
            );
        }

        if (!empty($contents)) {
            throw new Exception('Invalid list given: ' . $input);
        }

        return $list;
    }

    /**
     * Get first element content of the list from
     *
     * @param string $input
     * @return string
     */
    private function getListElement($input) {
        $length = intval(mb_substr($input, 0, self::LENGTH_DIGITS));
        return mb_substr(
            $input, self::LENGTH_DIGITS + self::DELIMITER_LENGTH, $length
        );
    }

    /**
     * Check if provided input is a list
     *
     * @param unknown_type $input
     * @return boolean
     */
    private function isList($input) {
        return (
            mb_substr($input, 0, 1) === '['
            && mb_substr($input, -1) === ']'
            && mb_substr(
                $input,
                1 + self::LENGTH_DIGITS,
                self::DELIMITER_LENGTH
            ) === ':'
        );
    }

}