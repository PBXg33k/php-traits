<?php
require_once(__DIR__.'/stubs/ReflectionStub.php');

class ReflectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ReflectionStub
     */
    protected $testClass;

    public function setUp()
    {
        $this->testClass = new ReflectionStub();
    }

    public function testExceptionOnClassNotFound()
    {
        $className = "thisClassDoesNotExist";

        $this->expectExceptionMessage(sprintf("%s not found or does not exist", $className));

        $this->testClass->getClassFromClassProperty($className, 'foo');
    }

    public function testExceptionOnPropertyNotFound()
    {
        $propertyName = "NonExistingProperty";
        $className = ReflectionStub::class;

        $this->expectExceptionMessage(sprintf("%s has no property with the name %s", $className, $propertyName));

        $this->testClass->getClassFromClassProperty($className, $propertyName);
    }

    //public function testGetClassNameWithoutNamespaceFromComment()
    //{
    //
    //}
}
