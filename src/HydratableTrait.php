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
     * @param  object|array $class class
     * @return object
     */
    public function hydrateClass($class)
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
                if ($propertyClassName = ReflectionTrait::getClassFromDocComment($reflectionProperty->getDocComment(), true,
                    $reflection)
                ) {

                    // Set argument for constructor (if any), in case we're dealing with an object (IE: DateTime)
                    $this->objectConstructorArguments = (in_array($propertyClassName, $this->giveDataInConstructor))
                        ? $itemValue : null;

                    if (in_array($propertyClassName, self::$nonObjectTypes)) {
                        $this->setPropertyValue($propertyName, $itemValue, true);
                    } elseif(interface_exists($propertyClassName)) {
                        // We cannot instantiate an interface, so we skip it
                        continue;
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