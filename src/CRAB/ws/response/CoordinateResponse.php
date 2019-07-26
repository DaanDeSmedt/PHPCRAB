<?php

namespace daandesmedt\CRAB\ws\response;


class CoordinateResponse extends BeginItemResponse
{
    
    protected $CenterX;
    protected $CenterY;
    protected $MinimumX;
    protected $MinimumY;
    protected $MaximumX;
    protected $MaximumY;

   
    public function __construct(){}

    public function populate($params): void
    {
        parent::populate($params);
        $this->CenterX = $params->CenterX ?? null;        
        $this->CenterY = $params->CenterY ?? null;        
        $this->MinimumX = $params->MinimumX ?? null;        
        $this->MinimumY = $params->MinimumY ?? null;        
        $this->MaximumX = $params->MaximumX ?? null;        
        $this->MaximumY = $params->MaximumY ?? null;   
    }

    public function getCenterX()
    {
        return $this->centerX;
    }

}