<?php

namespace daandesmedt\CRAB\ws\response;

use daandesmedt\CRAB\CRABResponseInterface;



class BeginItemResponse implements CRABResponseInterface
{

    protected $beginDatum;
    protected $beginTijd;
    protected $beginBewerking;
    protected $beginOrganisatie;

    public function __construct()
    {
    }

    public function populate($params) : void
    {
        $this->beginDatum = $params->BeginDatum ? date('Y-m-d', strtotime($params->BeginDatum)) : null;
        $this->beginTijd = $params->BeginTijd ? date('Y-m-d h:m:s', strtotime($params->BeginTijd)) : null;
        $this->beginBewerking = $params->BeginBewerking ?? null;
        $this->beginOrganisatie = $params->BeginOrganisatie ?? null;
    }

    public function getBeginDatum()
    {
        return $this->beginDatum;
    }

    public function getBeginTijd()
    {
        return $this->beginTijd;
    }

    public function getBeginBewerking()
    {
        return $this->beginBewerking;
    }

    public function getBeginOrganisatie()
    {
        return $this->beginOrganisatie;
    }

}