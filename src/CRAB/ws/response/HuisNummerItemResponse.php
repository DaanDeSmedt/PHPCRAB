<?php

namespace daandesmedt\CRAB\ws\response;


class HuisNummerItemResponse extends BeginItemResponse
{
    
    protected $straatnaamId;
    protected $huisnummerId;
    protected $huisnummer;

    public function __construct()
    {
    }

    public function populate($params) : void
    {
        parent::populate($params);
        $this->straatnaamId = $params->StraatnaamId ?? null;
        $this->huisnummerId = $params->HuisnummerId ?? null;
        $this->huisnummer = $params->Huisnummer ?? null;
    }

    public function getHuisnummerId()
    {
        return $this->huisnummerId;
    }

    public function getHuisnummer()
    {
        return $this->huisnummer;
    }

    public function getStraatnaamId()
    {
        return $this->straatnaamId;
    }

}