<?php

namespace daandesmedt\CRAB\ws\response;


class GemeenteItemResponse extends CoordinateResponse
{

    protected $gemeenteId;
    protected $gemeenteNaam;
    protected $taalCodeGemeenteNaam;
    protected $taalCode;
    protected $taalCodeTweedeTaal;
    protected $NisGemeenteCode;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->gemeenteId = $params->GemeenteId ?? null;
        $this->gemeenteNaam = $params->GemeenteNaam ?? null;
        $this->taalCodeGemeenteNaam = $params->TaalCodeGemeenteNaam ?? null;        
        $this->taalCode = $params->TaalCode ?? null;
        $this->taalCodeTweedeTaal = $params->TaalCodeTweedeTaal ?? null;
        $this->NisGemeenteCode = $params->NisGemeenteCode ?? null;  
    }

    public function getGemeenteId()
    {
        return $this->gemeenteId;
    }

    public function getGemeenteNaam()
    {
        return $this->gemeenteNaam;
    }

    public function getTaalCodeGemeenteNaam()
    {
        return $this->taalCodeGemeenteNaam;
    }

    public function getTaalCode()
    {
        return $this->taalCode;
    }

    public function getTaalCodeTweedeTaal()
    {
        return $this->taalCodeTweedeTaal;
    }

    public function getNISGemeenteCode()
    {
        return $this->NISGemeenteCode;
    }

}