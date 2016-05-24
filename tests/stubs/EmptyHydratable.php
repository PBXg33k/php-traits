<?php
require_once(__DIR__.'/../../src/HydratableTrait.php');

class EmptyHydratable
{
    use \Pbxg33k\Traits\HydratableTrait;

    /**
     * There is no class in this block. Intentionally
     */
    public $nonExistingClass;

    /**
     * @var DateTime
     */
    public $date;

    /**
     * @return mixed
     */
    public function getNonExistingClass()
    {
        return $this->nonExistingClass;
    }

    /**
     * @param mixed $nonExistingClass
     *
     * @return EmptyHydratable
     */
    public function setNonExistingClass($nonExistingClass)
    {
        $this->nonExistingClass = $nonExistingClass;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     *
     * @return EmptyHydratable
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}