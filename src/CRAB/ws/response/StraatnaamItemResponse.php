<?php

namespace daandesmedt\CRAB\ws\response;


class StraatnaamItemResponse extends BeginItemResponse
{

    protected $straatnaamId;
    protected $straatnaam;
    protected $straatnaamTweedeTaal;
    protected $taalCode;
    protected $taalCodeTweedeTaal;
    protected $straatnaamLabel;

    public function __construct(){}

    public function populate($params): void
    {       
        $this->straatnaamId = $params->StraatnaamId ?? null;
        $this->straatnaam = $params->Straatnaam ?? null;
        $this->straatnaamTweedeTaal = $params->StraatnaamTweedeTaal ?? null;
        $this->taalCode = $params->TaalCode ?? null;
        $this->taalCodeTweedeTaal = $params->TaalCodeTweedeTaal ?? null;
        $this->straatnaamLabel = $params->StraatnaamLabel ?? null;
    }

    public function getStraatnaamId()
    {
        return $this->straatnaamId;
    }

    public function getStraatnaam()
    {
        return $this->straatnaam;
    }

    public function getStraatnaamTweedeTaal()
    {
        return $this->straatnaamTweedeTaal;
    }

    public function getTaalCode()
    {
        return $this->taalCode;
    }

    public function getTaalCodeTweedeTaal()
    {
        return $this->taalCodeTweedeTaal;
    }

    public function getStraatnaamLabel()
    {
        return $this->straatnaamLabel;
    }

}