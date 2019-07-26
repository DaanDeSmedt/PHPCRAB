<?php

namespace daandesmedt\CRAB\ws\response;


class SubadresItemResponse extends BeginItemResponse
{

    protected $subadresId;
    protected $subadres;
    protected $huisnummerId;
    protected $aardSubadres;


    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->subadresId = $params->SubadresId ?? null;
        $this->subadres = $params->Subadres ?? null;
        $this->huisnummerId = $params->HuisnummerId ?? null;
        $this->aardSubadres = $params->AardSubadres ?? null;
    }

    public function getSubadresId()
    {
        return $this->subadresId;
    }

    public function getSubadres()
    {
        return $this->subadres;
    }

    public function getHuisnummerId()
    {
        return $this->huisnummerId;
    }

    public function getAardSubadres()
    {
        return $this->aardSubadres;
    }

}