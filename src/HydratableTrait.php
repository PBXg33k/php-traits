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
 * @author  Oguzhan Uysal <development@oguzhanuysal.eu>
 * @package Pbxg33k\Traits
 */
trait HydratableTrait
{
    use PropertyTrait;
    use ReflectionTrait;

    /**
     * List of types which are not used as objects
     *
     * @var array
     */
    public static $nonObjectTypes = ['string', 'int', 'integer', 'bool', 'boolean', 'array', 'float', 'mixed', 'null'];

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
     * @param  object|array $class       class
     * @param  boolean      $failOnError Throw Exception if any error(s) occur
     *
     * @return object
     *
     * @throws \Exception if hydration failes AND $failOnError is true
     */
    public function hydrateClass($class, $failOnError = false)
    {
        $reflection = new \ReflectionClass($this);

        // Iterate over $class for properties
        foreach ($class as $itemKey => $itemValue) {
            // Convert key to a propertyname in $this
            try {
                $this->hydrateProperty($itemKey, $itemValue, $reflection);
            } catch (\Exception $e) {
                if ($failOnError) {
                    throw $e;
                }
            }
        }

        return $this;
    }

    /**
     * Hydrates property with value.
     * Value can be anything. If the property is supposed to be a Class of anykind we will try to instantiate it
     * and assign the class to the property
     *
     * @param                  $key
     * @param                  $value
     * @param \ReflectionClass $reflection
     *
     * @throws \Exception
     */
    protected function hydrateProperty($key, $value, \ReflectionClass $reflection)
    {
        $propertyName = $this->resolvePropertyName($key);

        try {
            // Check if property exists and assign a ReflectionProperty class to $reflectionProperty
            $reflectionProperty = $reflection->getProperty($propertyName);
            // Get the expected property class from the property's DocBlock
            $propertyClassName = ReflectionTrait::getClassFromDocComment($reflectionProperty->getDocComment(), true, $reflection);
            // Set argument for constructor (if any), in case we're dealing with an object (IE: DateTime)
            $this->objectConstructorArguments = (in_array($propertyClassName, $this->giveDataInConstructor)) ? $value : null;

            if (!in_array($propertyClassName, self::$nonObjectTypes) && class_exists($propertyClassName)) {
                $object = new $propertyClassName($this->objectConstructorArguments);
                $this->checkObjectForErrors($object, true);

                if (method_exists($object, 'hydrateClass') && $this->isHydratableValue($value)) {
                    $object->hydrateClass($value);
                }
                $value = $object;
            }

            $this->setPropertyValue($propertyName, $value, true);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Resolves and returns propertyname
     *
     * @param $key
     *
     * @return mixed|string
     */
    private function resolvePropertyName($key)
    {
        $propertyName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

        return (property_exists($this, $propertyName)) ? $propertyName :
            (property_exists($this, lcfirst($propertyName)) ? lcfirst($propertyName) :
                preg_replace_callback('/([A-Z])/', function($match) {
                    return strtolower('_' . $match[1]);
                }, lcfirst($propertyName))
            );
    }

    /**
     * Checks if the value can be hydrated for iteration
     *
     * @param $value
     *
     * @return bool
     */
    private function isHydratableValue($value)
    {
        return (is_array($value) || is_object($value));
    }

    /**
     * Checks (and fixes) objects against known errors
     *
     * @param Object &$object
     * @param bool   $fix Fix errors
     *
     * @return void
     *
     * @throws \Exception
     */
    private function checkObjectForErrors(&$object, $fix = false)
    {
        if ($object instanceof \DateTime) {
            if ($this->objectConstructorArguments == null) {
                $object = null;
            }
        }
    }
}