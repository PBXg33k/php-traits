<?php
require_once('stubs/HydratableTraitStub.php');

class ReflectionTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetRelativeClassName()
    {
        $dockblock = <<<EOF
     /**
     * @var \ClassName
     */
EOF;
        $this->assertEquals('ClassName', HydratableTraitStub::getClassFromDocComment($dockblock, false));
    }
}
