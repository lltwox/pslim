<?php
namespace PSlim\Service\AliasRegistry;

/**
 * Method alias loader. Uses reflection to look for method aliases in
 * all of class' methods.
 *
 * @author lex
 *
 */
class MethodLoader {

    /**
     * Pattern to match alias
     *
     */
    const ALIAS_TAG_PATTERN = '/@alias\s(.+)$/m';

    /**
     * Get map of method aliases for provided class
     *
     * @param string $className
     * @return array
     */
    public function load($className) {
        $result = array();

        $methodsInClass = $this->getMethodsInClass($className);
        /* @var $method ReflectionMethod */
        foreach ($methodsInClass as $method) {
            $alias = $this->getAliasForMethod($method);
            if (!empty($alias)) {
                $result[$alias] = $method->getName();
            }
        }

        return $result;
    }

    /**
     * Get list of methods as a reflection objects for class
     *
     * @param string $className
     * @return array
     */
    private function getMethodsInClass($className) {
        try {
            $reflectionClass = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            return array();
        }

        return $reflectionClass->getMethods(
            \ReflectionMethod::IS_STATIC | \ReflectionMethod::IS_PUBLIC
        );
    }

    /**
     * Get alias for method from it's doc comment
     *
     * @param \ReflectionMethod $method
     * @return string
     */
    private function getAliasForMethod(\ReflectionMethod $method) {
        $comment = $method->getDocComment();
        if (empty($comment)) {
            return null;
        }

        $matches = array();
        $result = preg_match_all(self::ALIAS_TAG_PATTERN, $comment, $matches);
        if (!$result) {
            return null;
        }
        $lastMatchedAlias = array_pop($matches[1]);

        return $lastMatchedAlias;
    }

}