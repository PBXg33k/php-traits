<?php
namespace Pbxg33k\Traits;

/**
 * Class ReflectionTrait
 *
 * This trait adds methods to retrieve properties easily using PHP Reflection
 *
 * @author  Oguzhan Uysal <development@oguzhanuysal.eu>
 * @package Pbxg33k\Traits
 */
trait ReflectionTrait
{
    /**
     * Tries to get the correct class name from the given docBlock for Reflection
     *
     * @param string $comment the docblock
     * @param bool $includeNamespaces
     * @param null|\ReflectionClass $reflectionClass
     *
     * @return bool|string
     */
    protected function getClassFromDocComment($comment, $includeNamespaces = true, $reflectionClass = null)
    {
        if (preg_match('~\@var[\s]+([A-Za-z0-9\\\\]+)~', $comment, $matches)) {
            if ($includeNamespaces) {
                if ($reflectionClass instanceof \ReflectionClass && !in_array($matches[1], $this->nonObjectTypes)) {
                    if($reflectionClass->getNamespaceName()) {
                        return sprintf('\%s\%s', $reflectionClass->getNamespaceName(), $matches[1]);
                    } else {
                        return sprintf('\%s', $matches[1]);
                    }
                } else {
                    return $matches[1];
                }
            } else {
                return join('', array_slice(explode('\\', $matches[1]), -1));
            }
        }

        return false;
    }
}