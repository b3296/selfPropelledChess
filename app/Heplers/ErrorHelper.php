<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-26
 * Time: 13:41
 */

namespace App\Heplers;


use Illuminate\Support\Collection;

class ErrorHelper extends Collection
{
    public function msg(){
        return $this;
    }
}