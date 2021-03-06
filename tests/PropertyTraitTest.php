<?php
require_once('stubs/HydratableTraitStub.php');

class PropertyTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \HydratableTraitStub
     */
    protected $testClass;

    public function setUp()
    {
        $this->testClass = new HydratableTraitStub;
    }

    /**
     * @test
     */
    public function willReturnSelfIfOverrideIsFalseAndPropertyValueIsSame()
    {
        $this->testClass->setPropertyValue('stringProperty', 'string');
        $value = $this->testClass->setPropertyValue('stringProperty', 'string');

        $this->assertSame($this->testClass, $value);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function willThrowExceptionIfNoSettersAreFound()
    {
        $this->testClass->setPropertyValue('nonExistingProperty', 'test');
    }

    /**
     * @test
     */
    public function willReturnPropertyValue()
    {
        $expectedValue = 'testValue';

        $this->testClass->setPropertyValue('stringProperty', $expectedValue, true);

        $this->assertSame($expectedValue, $this->testClass->getPropertyValue('stringProperty'));
    }

    /**
     * @test
     */
    public function willReturnEmptyValueAsNull()
    {
        $this->assertSame(null, $this->testClass->getPropertyValue('stringProperty'));
    }
}
