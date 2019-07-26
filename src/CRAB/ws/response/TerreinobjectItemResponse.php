<?php

namespace daandesmedt\CRAB\ws\response;


class TerreinobjectItemResponse extends CoordinateResponse
{

    protected $identificatorTerreinobject;
    protected $aardTerreinobject;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->identificatorTerreinobject = $params->IdentificatorTerreinobject ?? null;
        $this->aardTerreinobject = $params->AardTerreinobject ?? null;
    }

    public function getIdentificatorTerreinObject()
    {
        return $this->identificatorTerreinObject;
    }

    public function getAardTerreinobject()
    {
        return $this->aardTerreinobject;
    }

}