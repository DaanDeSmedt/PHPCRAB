<?php

declare (strict_types = 1);


/**
 * CRAB TOOLS
 *
 * A PHP wrapper for the Flemisch WS-CRAB (Centraal Referentieadressenbestand) SOAP webservice (https://overheid.vlaanderen.be/CRAB-WS-CRAB).
 * 
 * @author  Daan De Smedt <daan.de.smedt@hotmail.com>
 * @license  MIT
 *
 */
namespace daandesmedt\CRAB\tools;

use SoapClient;
use SoapFault;
use ReflectionClass;

use daandesmedt\CRAB\CRABServiceException;
use daandesmedt\CRAB\CRABTools\response\CodeResponse;


/**
 * 
 * The CRAB Tools service contains help methods that unlock transformation logic on top of the data contained in the CRAB.
 * The service can be used to clean up your own address files and to enrich them with geographical information.
 *
 * GetCRABMatch 
 *      with this operation you can look up the corresponding CRAB address for a given address. 
 *      This operation is primarily intended for the conversion of addresses in national register format to the CRAB format, but can of course also be used for other formats.
 *  
 * GetAddressLocation
 *      with this operation you can get the (known or calculated) terrain position of a CRAB address.
 * 
 * GetStreetLocation
 *      with this operation you can get the location of a CRAB street.
 *
 * 
 * @package \daandesmedt\CRAB\tools
 * @author Daan De Smedt <daan.de.smedt@hotmail.com>
 * @see https://overheid.vlaanderen.be/CRAB-CRAB-Tools
 */

class CRABTools
{

    const CRAB_PROTOCOL = 'http';
    const CRAB_DOMAIN = 'crab.agiv.be';
    const CRAB_WSDL = '/toolsopen/crabtools.svc?wsdl';

    /**
     * @var SoapClient
     */
    protected $soapClient;

    /**
     * @var string CRAB SOAP service WSDL
     */
    protected $wsdl;


    /**
     * Gets the SOAP client for CRAB SOAP service.
     *
     * @return SoapClient
     */
    public function getSoapClient() : SoapClient
    {
        $this->soapClient = $this->soapClient ?? new SoapClient($this->getWsdl(), []);
        return $this->soapClient;
    }

    /**
     * Sets the SOAP client for CRAB TOOLS SOAP service (test / implementation purpose)
     *
     * @param SoapClient $soapClient
     * @return self
     */
    public function setSoapClient(SoapClient $soapClient) : self
    {
        $this->soapClient = $soapClient;
        return $this;
    }


    /**
     * Gets the location of the WSDL for the CRAB TOOLS SOAP service
     *
     * @return string
     */
    public function getWsdl() : string
    {
        $this->wsdl = $this->wsdl ?? sprintf('%s://%s%s', self::CRAB_PROTOCOL, self::CRAB_DOMAIN, self::CRAB_WSDL);
        return $this->wsdl;
    }

    /**
     * Sets the location of the WSDL for the CRAB SOAP Service
     * 
     * @param string $wsdl
     * @return self
     * @example http://crab.agiv.be/wscrab/wscrab.svc?wsdl
     */
    public function setWsdl(string $wsdl) : self
    {
        $this->wsdl = $wsdl;
        return $this;
    }


    /**
     * getCRABMatchResponse
     * with this operation you can look up the corresponding CRAB address for a given address; 
     * this operation is primarily intended for the conversion of addresses in national register format to the CRAB format, but can of course also be used for other formats;
     */
    public function getCRABMatch(
        $boxNumber,
        $cityName,
        $houseNumber,
        $nisCityCode,
        $postalCode,
        $rrStreetCode,
        $streetName
    ) {
        return $this->_doSoap(
            'GetCRABMatch',
            function ($result) {
                return $result->GetCRABMatchResult->AddressMatches ?? null;
            },
            'daandesmedt\CRAB\tools\response\CRABMatchResponse',
            [
                'address' => [
                    'BoxNumber' => $boxNumber ?? '',
                    'CityName' => $cityName ?? '',
                    'HouseNumber' => $houseNumber ?? '',
                    'NisCityCode' => $nisCityCode ?? '',
                    'PostalCode' => $postalCode ?? '',
                    'RrStreetCode' => $rrStreetCode ?? '',
                    'Streetname' => $streetName ?? ''
                ]
            ],
            true
        );
    }


    /**
     * getAddressLocation
     * with this operation you can get the (known or calculated) terrain position of a CRAB address
     * 
     * @param integer houseNumberId
     * @return AddressLocationResponse|null
     */
    public function getAddressLocation($houseNumberId)
    {
        return $this->_doSoap(
            'GetAddressLocation',
            function ($result) {
                return $result->GetAddressLocationResult ?? null;
            },
            'daandesmedt\CRAB\tools\response\AddressLocationResponse',
            [
                'houseNumberId' => $houseNumberId
            ]
        );
    }

    /**
     * getStreetLocation
     * with this operation you can look up the corresponding CRAB address for a given address; 
     * this operation is primarily intended for the conversion of addresses in national register format to the CRAB format, but can of course also be used for other formats;
     *
     * @param integer streetNameId
     * @return StreetLocationResponse|null
     */
    public function getStreetLocation($streetNameId)
    {
        return $this->_doSoap(
            'GetStreetLocation',
            function ($result) {
                return $result->GetStreetLocationResult ?? null;
            },
            'daandesmedt\CRAB\tools\response\StreetLocationResponse',
            [
                'streetNameId' => $streetNameId
            ]
        );
    }

    
    private function _doSoap($method, $parseCallaback = null, $class = null, $requestParams = array(), $collection = true)
    {
        try {
            $soapRes = $this->getSoapClient()->__soapCall($method, [$requestParams]);
            $result = $parseCallaback($soapRes);
            if (!$result) return null;

            $class = new ReflectionClass($class);
            $res = null;
            if (!is_array($result)) $result = [$result];
            foreach ($result as $row) {
                $instance = $class->newInstanceWithoutConstructor();
                $instance->populate($row);
                if ($collection) {
                    $res[] = $instance;
                } else {
                    return $instance;
                }
            }

            return $res;

        } catch (SoapFault $e) {
            $message = sprintf(
                'CRAB Tools "%s" operation cannot be completed at this at this moment. '
                    . 'The CRAB service operation responded with "%s". '
                    . 'Please try again later. This is probably something temporary.',
                $method,
                $e->getMessage()
            );
            throw new CRABServiceException($message, 0, $e);
        }
    }

}