<?php

namespace daandesmedt\CRAB\ws\response;


class PerceelItemResponse extends CoordinateResponse
{

    protected $identificatorPerceel;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->identificatorPerceel = $params->IdentificatorPerceel ?? null;
    }

    public function getIdentificatorPerceel()
    {
        return $this->identificatorPerceel;
    }
    
}