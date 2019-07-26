<?php

namespace daandesmedt\CRAB\ws\response;


class GewestItemResponse extends CoordinateResponse
{

    protected $gewestId;
    protected $gewestNaam;
    protected $taalCodeGewestNaam;

    public function __construct(){}

    public function populate($params): void
    {    
        parent::populate($params);
        $this->gewestId = $params->GewestId ?? null;
        $this->gewestNaam = $params->GewestNaam ?? null;
        $this->taalCodeGewestNaam = $params->TaalCodeGewestNaam ?? null;     
    }

    public function getGewestId()
    {
        return $this->gewestId;
    }

    public function getGewestNaam()
    {
        return $this->gewestNaam;
    }

    public function getTaalCodeGewestNaam()
    {
        return $this->taalCodeGewestNaam;
    }

}