<?php

namespace daandesmedt\CRAB\ws\response;


class SubadresItemWithStatusResponse extends SubadresItemResponse
{

    protected $statusSubadres;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->statusSubadres = $params->StatusSubadres ?? null;
    }
    
    public function getStatusSubadres()
    {
        return $this->statusSubadres;
    }

}