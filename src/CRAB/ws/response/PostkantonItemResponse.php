<?php

namespace daandesmedt\CRAB\ws\response;


class PostkantonItemResponse implements CRABResponseInterface
{

    protected $postkantonCode;

    public function __construct(){}

    public function populate($params): void
    {       
        $this->postkantonCode = $params->PostkantonCode ?? null;
    }

    public function getPostkantonCode()
    {
        return $this->postkantonCode;
    }
    
}