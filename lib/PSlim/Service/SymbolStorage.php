<?php
namespace PSlim\Service;

use PSlim\Exception;

use PSlim\ServiceLocatorUser;
use PSlim\StandardException;

/**
 * Symbol storage implementation.
 * A container for all symbol values, that were created by 'callAndAssign'
 * instruction.
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class SymbolStorage extends ServiceLocatorUser {

    /**
     * Storage array
     *
     * @var array
     */
    public $storage = array();

    /**
     * Store value under a name
     *
     * @param string $name
     * @param object $value
     */
    public function store($name, $value) {
        $this->checkIsSymbolName($name);
        $this->storage[$name] = $value;
    }

    /**
     * Clear value, stored under a name
     *
     * @param $name string
     */
    public function remove($name) {
        unset($this->storage[$name]);
    }

    /**
     * Replace symbol in prvided string
     *
     * @param mixed $string
     */
    public function replaceSymbols($string) {
        if ($this->isSymbol($string)) {
            return $this->get($string);
        } else {
            return $this->replaceSymbolsInString($string);
        }
    }

    /**
     * Check if given string is a complete symbol name
     *
     * @param string $name
     * @return boolean
     */
    public function isSymbol($name) {
        return array_key_exists($name, $this->storage);
    }

    /**
     * Get value for provided symbol name
     *
     * @param string $name
     * @return mixed
     */
    public function get($name) {
        if (!isset($this->storage[$name])) {
            throw new StandardException('No symbol found for name ' . $name);
        }

        return $this->storage[$name];
    }

    /**
     * Replace all symbols in string
     *
     * @param string $string
     * @return string
     */
    private function replaceSymbolsInString($string) {
        return str_replace(
            $this->getAllSymbols(),
            $this->getAllSymbolsStringValues(),
            $string
        );
    }

    /**
     * Get list of all registered symbol names
     *
     * @return array
     */
    private function getAllSymbols() {
        return array_keys($this->storage);
    }

    /**
     * Get string representation for all stored symbols values
     *
     * @return array
     */
    private function getAllSymbolsStringValues() {
        $result = array();
        $converter = $this->getServiceLocator()->getTypeConverter();
        foreach ($this->storage as $object) {
            $result = $converter->toString($object);
        }

        return $result;
    }

    /**
     * Prepend a dollar sign to a string to form a symbol name
     *
     * @param string $string
     * @return string
     */
    private function checkIsSymbolName($name) {
        if (mb_substr($name, 0, 1) !== '$') {
            throw new StandardException('Invalid symbol name: ' . $name);
        }
    }

}