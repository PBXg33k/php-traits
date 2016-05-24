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
     * Returns Class from the DockBlock above a property
     * @param $class
     * @param $property
     *
     * @throws \Exception
     */
    public function getClassFromClassProperty($class, $property)
    {
        if(!class_exists($class)) {
            throw new \Exception($class. ' not found or does not exist');
        }
        
        if(!property_exists($class, $property)) {
            throw new \Exception($class . ' has no property with the name ' . $property);
        }
    }
    
    /**
     * Tries to get the correct class name from the given docBlock for Reflection
     *
     * @param string $comment the docblock
     * @param bool $includeNamespaces
     * @param null|\ReflectionClass $reflectionClass
     *
     * @return bool|string
     */
    public static function getClassFromDocComment($comment, $includeNamespaces = true, $reflectionClass = null)
    {
        if (preg_match('~\@var[\s]+([A-Za-z0-9\\\\]+)~', $comment, $matches)) {
            if ($includeNamespaces) {
                if ($reflectionClass instanceof \ReflectionClass && !in_array($matches[1], HydratableTrait::$nonObjectTypes)) {
                    return ($reflectionClass->getNamespaceName()) ? sprintf('\%s\%s', $reflectionClass->getNamespaceName(), $matches[1]) :  sprintf('\%s', $matches[1]);
                }
                return $matches[1];
            }
            return join('', array_slice(explode('\\', $matches[1]), -1));
        }

        return false;
    }
}