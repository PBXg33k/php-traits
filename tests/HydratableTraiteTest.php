<?php
require_once('stubs/HydratableTraitStub.php');

/**
 * Created by PhpStorm.
 * User: PBX_g33k
 * Date: 24-May-16
 * Time: 00:31
 */
class HydratableTraiteTest extends PHPUnit_Framework_TestCase
{
    const VAL_PUBLIC_PROPERTY       = 'public propety value';
    const VAL_PROTECTED_PROPERTY    = 'protected property value';
    const VAL_PRIVATE_PROPERTY      = 'private property value';
    const VAL_STRING_PROPERTY       = 'string';
    const VAL_FLOAT_PROPERTY        = 3.9;
    const VAL_INTEGER_PROPERTY      = 39;
    const VAL_BOOLEAN_PROPERTY      = true;
    const VAL_NULL_PROPERTY         = null;
    const VAL_ARRAY_PROPERTY        = [ 0 => 'zero', 1 => 1, 'b', 'c' => 39];
    const VAL_SNAKE_PROPERTY        = 'snake_case_property';
    const VAL_DATETIME_PROPERTY     = '2016/05/24T01:03:00';

    /**
     * @var HydratableTraitStub
     */
    protected $testClass;

    protected $dateTimeClass;

    protected $seed = [
        'publicProperty'            => self::VAL_PUBLIC_PROPERTY,
        'protectedProperty'         => self::VAL_PROTECTED_PROPERTY,
        'privateProperty'           => self::VAL_PRIVATE_PROPERTY,
        'stringProperty'            => self::VAL_STRING_PROPERTY,
        'floatProperty'             => self::VAL_FLOAT_PROPERTY,
        'booleanProperty'           => self::VAL_BOOLEAN_PROPERTY,
        'nullProperty'              => self::VAL_NULL_PROPERTY,
        'arrayProperty'             => self::VAL_ARRAY_PROPERTY,
        'classProperty'             => 'initialize_me',
        'dateTimeProperty'          => self::VAL_DATETIME_PROPERTY,
        'snake_case_property'       => self::VAL_SNAKE_PROPERTY,
        'iterableProperty'          => [
            'nonExistingClass'      => '',
            'nonExistingProperty'   => '',
            'date'                  => null,
        ]
    ];

    public function setUp()
    {
        $this->testClass = new HydratableTraitStub;
        $this->seed['classProperty'] = new \stdClass();

        $this->testClass->hydrateClass($this->seed);
    }

    public function testPublicProperty()
    {
        $this->assertEquals(self::VAL_PUBLIC_PROPERTY, $this->testClass->getPublicProperty());
    }

    public function testProtectedProperty()
    {
        $this->assertEquals(self::VAL_PROTECTED_PROPERTY, $this->testClass->getProtectedProperty());
    }

    public function testPrivateProperty()
    {
        $this->assertEquals(self::VAL_PRIVATE_PROPERTY, $this->testClass->getPrivateProperty());
    }

    public function testDateTimeProperty()
    {
        $this->assertInstanceOf(\DateTime::class, $this->testClass->getDateTimeProperty());
        $this->assertEquals('2016', $this->testClass->getDateTimeProperty()->format('Y'));
        $this->assertEquals('05', $this->testClass->getDateTimeProperty()->format('m'));
        $this->assertEquals('24', $this->testClass->getDateTimeProperty()->format('d'));
    }
}
