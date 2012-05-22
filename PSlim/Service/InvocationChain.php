<?php
namespace PSlim;

use PSlim\StandardException\NoMethodInClass;

/**
 * Invocation chain implementation
 *
 * @author lex
 *
 */
class InvocationChain extends ServiceLocatorUser {

    public function __construct() {

    }

    public function invoke($instanceName, $method, array $args) {
        try {
            return $this->invokeOnFixture($instance, $method, $args);
        } catch (Exception $e) {
            // nothing to worry about, just continue to sut call
        }

        try {
            return $this->invokeOnSystemUnderTest($instance, $method, $args);
        } catch (Exception $e) {
            // nothing to worry about, just continue to library call
        }

        try {
            return $this->invokeOnLibrary($method, $args);
        } catch (Exception $e) {
            // well, method nof found
        }

        throw new NoMethodInClass(
            $method . ' ' .(is_object($))
        );
    }

    private function invokeOnFixture($instance, $method, array $args) {

    }

    private function invokeOnSystemUnderTest($instance, $method, array $args) {

    }

    private function invokeOnLibrary($method, array $args) {

    }

}