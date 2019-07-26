<?php

namespace daandesmedt\CRAB\ws\response;


class WegobjectItemResponse extends CoordinateResponse
{

    protected $identificatorWegobject;
    protected $aardWegobject;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->identificatorWegobject = $params->IdentificatorWegobject ?? null;
        $this->aardWegobject = $params->AardWegobject ?? null;
    }

    public function getIdentificatorWegobject()
    {
        return $this->identificatorWegobject;
    }

    public function getAardWegobject()
    {
        return $this->aardWegobject;
    }

}