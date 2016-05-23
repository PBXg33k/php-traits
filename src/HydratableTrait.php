<?php
/**
 * Created by PhpStorm.
 * User: PBX_g33k
 * Date: 24-May-16
 * Time: 00:07
 */

namespace Pbxg33k\Traits;

/**
 * Class HydratableTrait
 *
 * This trait allows you to hydrate a class/object by passing an array or stdObj and let it hydrate itself by
 * calling either of the following methods:
 *  - hydrateClass($rawData)
 *
 * @package Pbxg33k\Traits
 */
trait HydratableTrait
{
    /**
     * List of types which are not used as objects
     *
     * @var array
     */
    protected $nonObjectTypes = ['string', 'int', 'integer', 'bool', 'boolean', 'array', 'float', 'mixed', 'null'];

    /**
     * List of classes which will take string arguments in constructor
     *
     * @var array
     */
    protected $giveDataInConstructor = ['\DateTime'];

    /**
     * Object constructor arguments to be passed when creating an object during conversion
     *
     * @var mixed
     */
    protected $objectConstructorArguments;

    /**
     * Converts a stdClass to models loaded in current context
     *
     * This method iterates over the passed $class
     * For each key, it looks for a setter and type.
     * If the value is an object, it initializes the object and assignes the initialized object.
     *
     * @param  object $class class
     * @return object
     */
    protected function hydrateClass($class)
    {
        $reflection = new \ReflectionClass($this);

        // Iterate over $class for properties
        foreach ($class as $itemKey => $itemValue) {
            // Check if key exists in $this

            // Convert key to a propertyname in $this
            $propertyName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $itemKey))));
            $propertyName = (property_exists($this, $propertyName)) ? $propertyName :
                (property_exists($this, lcfirst($propertyName)) ? lcfirst($propertyName) :
                    preg_replace_callback('/([A-Z])/', function ($match) {
                        return strtolower('_' . $match[1]);
                    }, lcfirst($propertyName))
                );

            // Check if property exists and assign a ReflectionProperty class to $reflectionProperty
            if (
                property_exists($this, $propertyName)
                && $reflectionProperty = $reflection->getProperty($propertyName)
            ) {
                // Get the expected property class from the property's DocBlock
                if ($propertyClassName = $this->getClassFromDocComment($reflectionProperty->getDocComment(), true,
                    $reflection)
                ) {

                    // Set argument for constructor (if any), in case we're dealing with an object (IE: DateTime)
                    $this->objectConstructorArguments = (in_array($propertyClassName, $this->giveDataInConstructor))
                        ? $itemValue : null;

                    if (in_array($propertyClassName, $this->nonObjectTypes)) {
                        $this->setPropertyValue($propertyName, $itemValue, true);
                    } else {
                        $object = new $propertyClassName($this->objectConstructorArguments);

                        // Check if $object has valid values
                        // IE: DateTime with a negative timestamp will cause a SQL Error
                        $this->checkObjectForErrors($object, true);

                        if ($object) {
                            if (
                                method_exists($object, 'hydrateClass') &&
                                (is_array($itemValue) || is_object($itemValue))
                            ) {
                                $object->fromClass($itemValue);
                            }
                            // We're done. Assign the result to the propery of $this
                            $this->setPropertyValue($propertyName, $object, true);
                        }
                    }
                    unset($object);
                }
            }
        }

        return $this;
    }

    /**
     * Sets the property value for the object
     *
     * @param string $key
     * @param mixed $value
     * @param bool $override
     * @param bool $isCollection Boolean to indicate Doctrine Collections
     * @return Object
     * @throws \Exception if setting value has failed
     */
    private function setPropertyValue($key, $value, $override = false, $isCollection = false)
    {
        // Replace empty strings with null
        if ($value === "") {
            $value = null;
        }

        // Convert key to method names
        $methodName = $this->getMethodName($key);

        if (!$override && method_exists($this, 'get' . $methodName)) {
            $currentValue = $this->{'get' . $methodName}();
            if ($currentValue === $value) {
                return $this;
            }
        }

        $setMethod = ($isCollection) ? 'add' : 'set';
        if (method_exists($this, $setMethod . $methodName)) {
            return $this->{$setMethod . $methodName}($value);
        } else {
            throw new \Exception(sprintf(
                'Unable to set value, method not found: %s%s in class: %s',
                $setMethod,
                $methodName,
                static::class
            ));
        }
    }

    /**
     * Converts snake_case to CamelCase to convert property names to getters
     *
     * @param  string $propertyKey
     * @return string
     */
    private function getMethodName($propertyKey)
    {
        return ucfirst(preg_replace_callback('/_([a-z])/', function ($match) {
            return strtoupper($match[1]);
        }, $propertyKey));
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
    private function getClassFromDocComment($comment, $includeNamespaces = true, $reflectionClass = null)
    {
        if (preg_match('~\@var[\s]+([A-Za-z0-9\\\\]+)~', $comment, $matches)) {
            if ($includeNamespaces) {
                if ($reflectionClass instanceof \ReflectionClass && !in_array($matches[1], $this->nonObjectTypes)) {
                    return '\\' . $reflectionClass->getNamespaceName() . '\\' . $matches[1];
                } else {
                    return $matches[1];
                }
            } else {
                return join('', array_slice(explode('\\', $matches[1]), -1));
            }
        }

        return false;
    }

    /**
     * Checks (and fixes) objects against known errors
     *
     * @param Object &$object
     * @param bool $fix Fix errors
     * @return void
     */
    private function checkObjectForErrors(&$object, $fix = false)
    {
        if ($object instanceof \DateTime) {
            // The constructor (passed from the API) is NULL, indicating an empty value
            // PHP DateTime's default value is now()
            if ($this->objectConstructorArguments == null) {
                $object = null;
            } else {
                if (!$object->getTimestamp()) {
                    // DateTime has a negative or false value
                    if ($fix) {
                        $object->setTimestamp(0);
                    }
                }
            }
        }
    }
}