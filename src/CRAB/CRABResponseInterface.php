<?php 
declare (strict_types = 1);

namespace daandesmedt\CRAB;

interface CRABResponseInterface
{
    public function populate($params) : void;
}
