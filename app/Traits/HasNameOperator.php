<?php

namespace App\Traits;

trait HasNameOperator
{
    public function getOperatorName($name)
    {
        $mts = ['MTS.BY', 'MTS BY', 'МТС'];
        $a1 = ['A1.BY', 'A1 BY'];
        $life = ['life:) BY', 'life'];
        if(in_array($name, $mts)){
            $result = 'MTS.BY';
        }
        else if(in_array($name, $a1)){
            $result = 'A1 BY';
        }
        else if(in_array($name, $life)){
            $result = 'life:) BY';
        }
        else{
            abort(400);
        }
        return $result;
    }
}
