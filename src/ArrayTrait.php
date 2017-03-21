<?php

namespace Pbxg33k\Traits;

trait ArrayTrait
{
    /**
     * Recusively implodes an array
     *
     * @param array $array
     * @param string $glue
     *
     * @return string
     */
    public function recusiveImplode(array $array, $glue = ',')
    {
        foreach($array as $key => $element) {
            if(is_array($element)) {
                $array[$key] = $this->recusiveImplode($element, $glue);
            }
        }

        return implode($glue, $array);
    }

    /**
     * Alias for recursiveImplode
     *
     * @param array $array
     * @param string $glue
     * @return string
     */
    public function recursiveJoin(array $array, $glue = ',')
    {
        return $this->recusiveImplode($array, $glue);
    }
}