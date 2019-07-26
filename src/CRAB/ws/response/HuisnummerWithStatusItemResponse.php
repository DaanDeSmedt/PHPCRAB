<?php

namespace daandesmedt\CRAB\ws\response;


class HuisnummerWithStatusItemResponse extends HuisNummerItemResponse
{
    protected $statusHuisnummer;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->statusHuisnummer = $params->StatusHuisnummer ?? null;
    }
    
    public function getStatusHuisnummer()
    {
        return $this->statusHuisnummer;
    }

}