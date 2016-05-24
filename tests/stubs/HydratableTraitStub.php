<?php
require_once(__DIR__.'/../../src/HydratableTrait.php');
require_once(__DIR__.'/EmptyHydratable.php');

/**
 * Created by PhpStorm.
 * User: PBX_g33k
 * Date: 24-May-16
 * Time: 00:55
 */
class HydratableTraitStub
{
    use \Pbxg33k\Traits\HydratableTrait;

    /**
     * @var mixed
     */
    public $publicProperty;

    /**
     * @var mixed
     */
    protected $protectedProperty;

    /**
     * @var mixed
     */
    private $privateProperty;

    /**
     * @var string
     */
    private $stringProperty;

    /**
     * @var float
     */
    private $floatProperty;

    /**
     * @var boolean
     */
    private $booleanProperty;

    /**
     * @var null
     */
    private $nullProperty;

    /**
     * @var array
     */
    private $arrayProperty;

    /**
     * @var stdClass
     */
    private $classProperty;

    /**
     * @var DateTimeInterface
     */
    private $dateTimeInterfaceProperty;

    /**
     * @var DateTime
     */
    private $dateTimeProperty;

    /**
     * @var mixed
     */
    private $snake_case_property;

    /**
     * @var EmptyHydratable
     */
    private $iterableProperty;

    /**
     * @return mixed
     */
    public function getPublicProperty()
    {
        return $this->publicProperty;
    }

    /**
     * @param mixed $publicProperty
     * @return HydratableTraitStub
     */
    public function setPublicProperty($publicProperty)
    {
        $this->publicProperty = $publicProperty;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProtectedProperty()
    {
        return $this->protectedProperty;
    }

    /**
     * @param mixed $protectedProperty
     * @return HydratableTraitStub
     */
    public function setProtectedProperty($protectedProperty)
    {
        $this->protectedProperty = $protectedProperty;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }

    /**
     * @param mixed $privateProperty
     * @return HydratableTraitStub
     */
    public function setPrivateProperty($privateProperty)
    {
        $this->privateProperty = $privateProperty;

        return $this;
    }

    /**
     * @return string
     */
    public function getStringProperty()
    {
        return $this->stringProperty;
    }

    /**
     * @param string $stringProperty
     * @return HydratableTraitStub
     */
    public function setStringProperty($stringProperty)
    {
        $this->stringProperty = $stringProperty;

        return $this;
    }

    /**
     * @return float
     */
    public function getFloatProperty()
    {
        return $this->floatProperty;
    }

    /**
     * @param float $floatProperty
     * @return HydratableTraitStub
     */
    public function setFloatProperty($floatProperty)
    {
        $this->floatProperty = $floatProperty;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isBooleanProperty()
    {
        return $this->booleanProperty;
    }

    /**
     * @param boolean $booleanProperty
     * @return HydratableTraitStub
     */
    public function setBooleanProperty($booleanProperty)
    {
        $this->booleanProperty = $booleanProperty;

        return $this;
    }

    /**
     * @return null
     */
    public function getNullProperty()
    {
        return $this->nullProperty;
    }

    /**
     * @param null $nullProperty
     * @return HydratableTraitStub
     */
    public function setNullProperty($nullProperty)
    {
        $this->nullProperty = $nullProperty;

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayProperty()
    {
        return $this->arrayProperty;
    }

    /**
     * @param array $arrayProperty
     * @return HydratableTraitStub
     */
    public function setArrayProperty($arrayProperty)
    {
        $this->arrayProperty = $arrayProperty;

        return $this;
    }

    /**
     * @return stdClass
     */
    public function getClassProperty()
    {
        return $this->classProperty;
    }

    /**
     * @param stdClass $classProperty
     * @return HydratableTraitStub
     */
    public function setClassProperty($classProperty)
    {
        $this->classProperty = $classProperty;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateTimeInterfaceProperty()
    {
        return $this->dateTimeInterfaceProperty;
    }

    /**
     * @param DateTimeInterface $dateTimeInterfaceProperty
     * @return HydratableTraitStub
     */
    public function setDateTimeInterfaceProperty($dateTimeInterfaceProperty)
    {
        $this->dateTimeInterfaceProperty = $dateTimeInterfaceProperty;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateTimeProperty()
    {
        return $this->dateTimeProperty;
    }

    /**
     * @param DateTime $dateTimeProperty
     * @return HydratableTraitStub
     */
    public function setDateTimeProperty($dateTimeProperty)
    {
        $this->dateTimeProperty = $dateTimeProperty;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSnakeCaseProperty()
    {
        return $this->snake_case_property;
    }

    /**
     * @param mixed $snake_case_property
     * @return HydratableTraitStub
     */
    public function setSnakeCaseProperty($snake_case_property)
    {
        $this->snake_case_property = $snake_case_property;

        return $this;
    }

    /**
     * @return HydratableTraitStub
     */
    public function getIterableProperty()
    {
        return $this->iterableProperty;
    }

    /**
     * @param HydratableTraitStub $iterableProperty
     */
    public function setIterableProperty($iterableProperty)
    {
        $this->iterableProperty = $iterableProperty;

        return $this;
    }
}