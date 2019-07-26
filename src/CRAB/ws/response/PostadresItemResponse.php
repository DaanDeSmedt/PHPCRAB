<?php

namespace daandesmedt\CRAB\ws\response;


class PostadresItemResponse implements CRABResponseInterface
{

    protected $postadres;

    public function __construct(){}

    public function populate($params): void
    {       
        $this->postadres = $params->Postadres ?? null;
    }

    public function getPostadres()
    {
        return $this->postadres;
    }
    
}