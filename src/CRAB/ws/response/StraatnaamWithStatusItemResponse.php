<?php

namespace daandesmedt\CRAB\ws\response;


class StraatnaamWithStatusItemResponse extends StraatnaamItemResponse
{

    protected $statusStraatnaam;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->statusStraatnaam = $params->StatusStraatnaam ?? null;
    }
    
    public function getStatusStraatnaam()
    {
        return $this->statusStraatnaam;
    }

}