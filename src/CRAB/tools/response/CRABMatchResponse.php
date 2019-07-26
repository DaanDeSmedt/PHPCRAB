<?php

namespace daandesmedt\CRAB\tools\response;

use daandesmedt\PHPWKTAdapter\WKTAdapter;
use daandesmedt\CRAB\CRABResponseInterface;

class CRABMatchResponse implements CRABResponseInterface
{
    
    /**
     * @var string
     */
    protected $houseNumber;

    /**
     * @var string
     */
    protected $zipCode;


    public function __construct()
    {
    }

    /**
     * Populate response class
     * 
     * @param array $CRABAddress
     */
    public function populate($CRABAddress) : void
    {
        $this->houseNumber = $CRABAddress->CRABAddress->HouseNumberDetail->HouseNumber ?? null;
        $this->zipCode = $CRABAddress->CRABAddress->HouseNumberDetail->ZipCode ?? null;
    }

    /**
     * Get houseNumber
     * 
     * @return string houseNumber
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Get zipCode
     * 
     * @return string zipCode
     */
    public function getZipCode()
    {
        return $this->ZipCode;
    }

}