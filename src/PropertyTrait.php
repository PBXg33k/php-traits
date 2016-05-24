<?php
/**
 * Created by PhpStorm.
 * User: PBX_g33k
 * Date: 24-May-16
 * Time: 13:02
 */

namespace Pbxg33k\Traits;

/**
 * Class PropertyTrait
 *
 * This trait adds helpers for getters and setters by automatically trying
 * to set properties using various methods while respecting property visibility.
 *
 * @author  Oguzhan uysal <development@oguzhanuysal.eu>
 * @package Pbxg33k\Traits
 */
trait PropertyTrait
{
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
    public function setPropertyValue($key, $value, $override = false, $isCollection = false)
    {
        // Replace empty strings with null
        $value = ($value === "") ? null : $value;

        // Convert key to method names
        $methodName = $this->getMethodName($key);

        if (!$override && $this->getPropertyValue($key) === $value) {
            return $this;
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
     * Get property value
     *
     * @param $key
     * @return mixed
     */
    public function getPropertyValue($key) {
        $methodName = 'get' . $this->getMethodName($key);
        if(method_exists($this, $methodName)) {
            return $this->{$methodName}();
        }
        return false;
    }

    /**
     * Converts snake_case to CamelCase to convert property names to getters
     *
     * @param  string $propertyKey
     * @return string
     */
    protected function getMethodName($propertyKey)
    {
        return ucfirst(preg_replace_callback('/_([a-z])/', function ($match) {
            return strtoupper($match[1]);
        }, $propertyKey));
    }
}