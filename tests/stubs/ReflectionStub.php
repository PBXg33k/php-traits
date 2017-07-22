<?php
require_once(__DIR__.'/../../src/ReflectionTrait.php');


class ReflectionStub
{
    use \Pbxg33k\Traits\ReflectionTrait;

    /**
     * @var Exclude\Namespace
     */
    public $nonNamespacedClass;

    /**
     * @var ThisClassDoesNotExist
     */
    public $thisClassDoesNotExist;
}