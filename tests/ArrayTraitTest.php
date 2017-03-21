<?php
use Pbxg33k\Traits\ArrayTrait;

require_once('stubs/ArrayTraitClass.php');

class ArrayTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayTraitClass
     */
    protected $testClass;

    public function setUp()
    {
        $this->testClass = new ArrayTraitClass();
    }

    /**
     * @test
     */
    public function simpleImplodeReturnString()
    {
        $arr = [
            'testKey'  => 'testValue',
            'testKey2' => 'testValue2'
        ];

        $this->assertSame(implode(',', $arr), $this->testClass->recusiveImplode($arr, ','));
    }

    /**
     * @test
     */
    public function implodingMultiDimensionalArrayReturnsString()
    {
        $arr = [
            'testKey' => 'testValue',
            'testArr' => [
                'subKey' => 'subValue'
            ]
        ];

        $expectedOutput = "testValue,subValue";

        $this->assertSame($expectedOutput, $this->testClass->recusiveImplode($arr, ','));
    }

    /**
     * @test
     */
    public function joinIsAliasingImplode()
    {
        $arr = [
            'testKey'  => 'testValue',
            'testKey2' => 'testValue2'
        ];

        $this->assertSame(implode(',', $arr), $this->testClass->recursiveJoin($arr, ','));
    }
}
