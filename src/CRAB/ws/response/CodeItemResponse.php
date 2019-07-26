<?php

namespace daandesmedt\CRAB\ws\response;


class CodeItemResponse implements CRABResponseInterface
{

    protected $code;
    protected $naam;
    protected $definitie;

    public function __construct(){}

    public function populate($params): void
    {       
        $this->code = $params->Code ?? null;
        $this->naam = $params->Naam ?? null;
        $this->definitie = $params->Definitie ?? null;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getNaam()
    {
        return $this->naam;
    }

    public function getDefinitie()
    {
        return $this->definitie;
    }

}