<?php

namespace daandesmedt\CRAB\ws\response;


class RijksregisterAdresItemResponse implements CRABResponseInterface
{

    protected $rijksregisterAdresId;
    protected $huisnummer;
    protected $index;
    protected $straatCode;
    protected $subkantonCode;

    public function __construct(){}

    public function populate($params): void
    {       
        $this->rijksregisterAdresId = $params->RijksregisterAdresId ?? null;
        $this->huisnummer = $params->Huisnummer ?? null;
        $this->index = $params->Index ?? null;     
        $this->straatCode = $params->StraatCode ?? null;     
        $this->subkantonCode = $params->SubkantonCode ?? null;     
    }

    public function getRijksregisterAdresId()
    {
        return $this->rijksregisterAdresId;
    }

    public function getHuisnummer()
    {
        return $this->huisnummer;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getStraatCode()
    {
        return $this->straatCode;
    }

    public function getSubkantonCode()
    {
        return $this->subkantonCode;
    }
}