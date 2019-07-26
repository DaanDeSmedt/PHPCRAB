<?php

declare (strict_types = 1);


/**
 * 
 * WS-CRAB discloses information from a subset of the CRAB entities. 
 * The figure below gives an overview of the entities and their mutual coherence.
 * The entry X, Y in the upper right of an entity indicates that this object has simple geometric attributes (such as a centroid and enveloping rectangle). 
 * The entities marked with a * have a complete geometric component.
 * 
 * Figure : https://overheid.vlaanderen.be/sites/default/files/media/Digitale%20overheid/CRAB/wscrabmodel.png
 * 
 * @author  Daan De Smedt <daan.de.smedt@hotmail.com>
 * @license  MIT
 * @see https://overheid.vlaanderen.be/CRAB-WS-CRAB
 *
 */
namespace daandesmedt\CRAB\ws;

use SoapClient;
use SoapFault;
use ReflectionClass;

use daandesmedt\CRAB\CRABServiceException;


/**
 * Class WSCRAB
 *
 * CRAB class provided the SOAP client with SOAP operations
 *
 * @package \daandesmedt\CRAB\ws
 * @author Daan De Smedt <daan.de.smedt@hotmail.com>
 * @see https://overheid.vlaanderen.be/CRAB-WS-CRAB
 */
class WSCRAB
{

    const CRAB_PROTOCOL = 'http';
    const CRAB_DOMAIN = 'crab.agiv.be';
    const CRAB_WSDL = '/wscrab/wscrab.svc?wsdl';

    /**
     * @var SoapClient
     */
    protected $soapClient;

    /**
     * @var string WS CRAB SOAP service WSDL
     */
    protected $wsdl;


    /**
     * Gets the SOAP client for WS CRAB SOAP service.
     *
     * @return SoapClient
     */
    public function getSoapClient() : SoapClient
    {
        $this->soapClient = $this->soapClient ?? new SoapClient($this->getWsdl(), []);
        return $this->soapClient;
    }

    /**
     * Sets the SOAP client for WS CRAB SOAP service (test / implementation purpose)
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
     * Gets the location of the WSDL for the WS CRAB SOAP service
     *
     * @return string
     */
    public function getWsdl() : string
    {
        $this->wsdl = $this->wsdl ?? sprintf('%s://%s%s', self::CRAB_PROTOCOL, self::CRAB_DOMAIN, self::CRAB_WSDL);
        return $this->wsdl;
    }

    /**
     * Sets the location of the WSDL for the WS CRAB SOAP Service
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
     * Find operations give the user information about a list of 'objects', but the
     * input for this function is a search term that must contain all elements from the list
     * reply. There is an operation for searching for a municipality, street name and
     * House number. The search term is considered a pattern that may contain wildcards
     * and is not case sensitive.     
     *
     * Supported wildcards 
     * -----------------------------------------------------------------------------------
     *  %               :   A random string that consists of 0 or more characters.
     *  _ (underscore)  :   A single character. 
     *  []              :   A single character that occurs in the set or range between the lines crochet.
     *  [ ^ ]           :   A single character that does not occur in the set or range between the lines crochet.
     */


    /**
     * findGemeenten
     * 
     * @param string gemeenteNaam (wildcard supported)
     * @param integer gewestId
     * @return GemeenteItemResponse[]
     * @throws CRABServiceException
     */
    public function findGemeenten($gemeenteNaam, $gewestId)
    {
        return $this->_doSoap(
            'FindGemeenten',
            function ($result) {
                return $result->FindGemeentenResult->GemeenteItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\GemeenteItemResponse',
            [
                'GemeenteNaam' => $gemeenteNaam,
                'GewestId' => $gewestId
            ]
        );
    }

    /**
     * findGemeentenByPostkanton
     * 
     * @param string postkantonCode (wildcard supported)
     * @return GemeenteItemResponse[]
     * @throws CRABServiceException
     */
    public function findGemeentenByPostkanton($postkantonCode)
    {
        return $this->_doSoap(
            'findGemeentenByPostkanton',
            function ($result) {
                return $result->FindGemeentenByPostkantonResult->GemeenteItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\GemeenteItemResponse',
            [
                'PostkantonCode' => $postkantonCode
            ]
        );
    }

    /**
     * findHuisnummers
     * 
     * @param string huisnummer (wildcard supported)
     * @param integer straatnaamId
     * @return HuisnummerItemResponse[]
     * @throws CRABServiceException
     */
    public function findHuisnummers($huisnummer, $straatnaamId)
    {
        return $this->_doSoap(
            'findHuisnummers',
            function ($result) {
                return $result->FindHuisnummersResult->HuisnummerItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId,
            ]
        );
    }

    /**
     * findHuisnummersWithStatus
     * 
     * @param string huisnummer (wildcard supported)
     * @param integer straatnaamId
     * @return HuisnummerWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function findHuisnummersWithStatus($huisnummer, $straatnaamId)
    {
        return $this->_doSoap(
            'findHuisnummersWithStatus',
            function ($result) {
                return $result->FindHuisnummersWithStatusResult->HuisnummerWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId,
            ]
        );
    }

    /**
     * findStraatnamen
     * 
     * @param string straatnaam (wildcard supported)
     * @param integer gemeenteId
     * @return StraatnaamItemResponse[]
     * @throws CRABServiceException
     */
    public function findStraatnamen($straatnaam, $gemeenteId)
    {
        return $this->_doSoap(
            'findStraatnamen',
            function ($result) {
                return $result->FindStraatnamenResult->StraatnaamItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\StraatnaamItemResponse',
            [
                'Straatnaam' => $straatnaam,
                'GemeenteId' => $gemeenteId,
            ]
        );
    }

    /**
     * findStraatnamenWithStatus
     * 
     * @param string straatnaam (wildcard supported)
     * @param integer gemeenteId
     * @return StraatnaamItemResponse[]
     * @throws CRABServiceException
     */
    public function findStraatnamenWithStatus($straatnaam, $gemeenteId)
    {
        return $this->_doSoap(
            'findStraatnamenWithStatus',
            function ($result) {
                return $result->FindStraatnamenWithStatusResult->StraatnaamWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\StraatnaamWithStatusItemResponse',
            [
                'Straatnaam' => $straatnaam,
                'GemeenteId' => $gemeenteId,
            ]
        );
    }

    /**
     * findSubadressen
     * 
     * @param string subadres (wildcard supported)
     * @param integer huisnummerId
     * @return StraatnaamItemResponse[]
     * @throws CRABServiceException
     */
    public function findSubadressen($subadres, $huisnummerId)
    {
        return $this->_doSoap(
            'findSubadressen',
            function ($result) {
                return $result->FindSubadressenResult->SubadresItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\SubadresItemResponse',
            [
                'Subadres' => $subadres,
                'HuisnummerId' => $huisnummerId,
            ]
        );
    }

    /**
     * findSubadressenWithStatus
     * 
     * @param string subadres (wildcard supported)
     * @param integer huisnummerId
     * @return StraatnaamItemResponse[]
     * @throws CRABServiceException
     */
    public function findSubadressenWithStatus($subadres, $huisnummerId)
    {
        return $this->_doSoap(
            'findSubadressen',
            function ($result) {
                return $result->FindSubadressenResult->SubadresItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\SubadresItemResponse',
            [
                'Subadres' => $subadres,
                'HuisnummerId' => $huisnummerId,
            ]
        );
    }

    
    /**
     * getAdrespositieByAdrespositieId
     * 
     * @param integer adrespositieId
     * @return StraatnaamItemResponse
     * @throws CRABServiceException
     */
    public function getAdrespositieByAdrespositieId($adrespositieId)
    {
        return $this->_doSoap(
            'getAdrespositieByAdrespositieId',
            function ($result) {
                return $result->GetAdrespositieByAdrespositieIdResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\AdrespositieItemResponse',
            [
                'AdrespositieId' => $adrespositieId
            ],
            false
        );
    }

    /**
     * getGebouwByIdentificatorGebouw
     * 
     * @param string identificatorGebouw
     * @return GebouwItemResponse
     * @throws CRABServiceException
     */
    public function getGebouwByIdentificatorGebouw($identificatorGebouw)
    {        
        return $this->_doSoap(
            'GetGebouwByIdentificatorGebouw',
            function ($result) {
                return $result->GetGebouwByIdentificatorGebouwResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\GebouwItemResponse',
            [
                'IdentificatorGebouw' => $identificatorGebouw
            ],
            false
        );
    }

    /**
     * getGemeenteByGemeenteId
     * 
     * @param string gemeenteId
     * @return GemeenteItemResponse
     * @throws CRABServiceException
     */
    public function getGemeenteByGemeenteId($gemeenteId)
    {        
        return $this->_doSoap(
            'GetGemeenteByGemeenteId',
            function ($result) {
                return $result->GetGemeenteByGemeenteIdResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\GemeenteItemResponse',
            [
                'GemeenteId' => $gemeenteId
            ],
            false
        );
    }

    /**
     * getGemeenteByGemeenteNaam
     * 
     * @param string gemeenteNaam
     * @param string gewestId
     * @return GemeenteItemResponse
     * @throws CRABServiceException
     */
    public function getGemeenteByGemeenteNaam($gemeenteNaam, $gewestId)
    {        
        return $this->_doSoap(
            'GetGemeenteByGemeenteNaam',
            function ($result) {
                return $result->GetGemeenteByGemeenteNaamResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\GemeenteItemResponse',
            [
                'GemeenteNaam' => $gemeenteNaam,
                'GewestId' => $gewestId
            ],
            false
        );
    }    

    /**
     * getGemeenteByNISGemeenteCode
     * 
     * @param integer NISGemeenteCode
     * @return GemeenteItemResponse
     * @throws CRABServiceException
     */
    public function getGemeenteByNISGemeenteCode($NISGemeenteCode)
    {        
        return $this->_doSoap(
            'GetGemeenteByNISGemeenteCode',
            function ($result) {
                return $result->GetGemeenteByNISGemeenteCodeResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\GemeenteItemResponse',
            [
                'NISGemeenteCode' => $NISGemeenteCode
            ],
            false
        );
    }
        
    /**
     * getGewestByGewestIdAndTaalCode
     * 
     * @param integer gewestId
     * @param string taalCode
     * @return GewestItemResponse
     * @throws CRABServiceException
     */
    public function getGewestByGewestIdAndTaalCode($gewestId, $taalCode)
    {        
        return $this->_doSoap(
            'GetGewestByGewestIdAndTaalCode',
            function ($result) {
                return $result->GetGewestByGewestIdAndTaalCodeResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\GewestItemResponse',
            [
                'GewestId' => $gewestId,
                'TaalCode' => $taalCode
            ],
            false
        );
    }

    /**
     * getHuisnummerByHuisnummer
     * 
     * @param string huisnummer
     * @param integer straatnaamId
     * @return HuisNummerItemResponse
     * @throws CRABServiceException
     */
    public function getHuisnummerByHuisnummer($huisnummer, $straatnaamId)
    {        
        return $this->_doSoap(
            'GetHuisnummerByHuisnummer',
            function ($result) {
                return $result->GetHuisnummerByHuisnummerResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisNummerItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId
            ],
            false
        );
    }

    /**
     * getHuisnummerByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return HuisNummerItemResponse
     * @throws CRABServiceException
     */
    public function getHuisnummerByHuisnummerId($huisnummerId)
    {        
        return $this->_doSoap(
            'GetHuisnummerByHuisnummerId',
            function ($result) {
                return $result->GetHuisnummerByHuisnummerIdResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisNummerItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ],
            false
        );
    }

    /**
     * getHuisnummerWithStatusByHuisnummer
     * 
     * @param string huisnummer
     * @param integer straatnaamId
     * @return HuisnummerWithStatusItemResponse
     * @throws CRABServiceException
     */
    public function getHuisnummerWithStatusByHuisnummer($huisnummer, $straatnaamId)
    {        
        return $this->_doSoap(
            'GetHuisnummerWithStatusByHuisnummer',
            function ($result) {
                return $result->GetHuisnummerWithStatusByHuisnummerResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId
            ],
            false
        );
    }

    /**
     * getHuisnummerWithStatusByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return HuisnummerWithStatusItemResponse
     * @throws CRABServiceException
     */
    public function getHuisnummerWithStatusByHuisnummerId($huisnummerId)
    {        
        return $this->_doSoap(
            'GetHuisnummerWithStatusByHuisnummerId',
            function ($result) {
                return $result->GetHuisnummerWithStatusByHuisnummerIdResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ],
            false
        );
    }

    /**
     * getPerceelByIdentificatorPerceel
     * 
     * @param integer identificatorPerceel
     * @return PerceelItemResponse
     * @throws CRABServiceException
     */
    public function getPerceelByIdentificatorPerceel($identificatorPerceel)
    {        
        return $this->_doSoap(
            'GetPerceelByIdentificatorPerceel',
            function ($result) {
                return $result->GetPerceelByIdentificatorPerceelResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\PerceelItemResponse',
            [
                'IdentificatorPerceel' => $identificatorPerceel
            ],
            false
        );
    }

    /**
     * getPostadresByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return PostadresItemResponse
     * @throws CRABServiceException
     */
    public function getPostadresByHuisnummerId($huisnummerId)
    {
        return $this->_doSoap(
            'GetPostadresByHuisnummerId',
            function ($result) {
                return $result->GetPostadresByHuisnummerIdResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\PostadresItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ],
            false
        );
    }
    
    /**
     * getSubadresBySubadresId
     * 
     * @param integer subadresId
     * @return SubadresItemResponse
     * @throws CRABServiceException
     */
    public function getSubadresBySubadresId($subadresId)
    {
        return $this->_doSoap(
            'GetSubadresBySubadresId',
            function ($result) {
                return $result->GetSubadresBySubadresIdResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\SubadresItemResponse',
            [
                'SubadresId' => $subadresId
            ],
            false
        );
    }

    /**
     * getSubadresWithStatusBySubadresId
     * 
     * @param integer subadresId
     * @return SubadresItemWithStatusResponse
     * @throws CRABServiceException
     */
    public function getSubadresWithStatusBySubadresId($subadresId)
    {
        return $this->_doSoap(
            'GetSubadresWithStatusBySubadresId',
            function ($result) {
                return $result->GetSubadresWithStatusBySubadresIdResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\SubadresItemWithStatusResponse',
            [
                'SubadresId' => $subadresId
            ],
            false
        );
    }

    /**
     * getTerreinobjectByIdentificatorTerreinobject
     * 
     * @param integer identificatorTerreinobject
     * @return TerreinobjectItemResponse
     * @throws CRABServiceException
     */
    public function getTerreinobjectByIdentificatorTerreinobject($identificatorTerreinobject)
    {
        return $this->_doSoap(
            'GetTerreinobjectByIdentificatorTerreinobject',
            function ($result) {
                return $result->GetTerreinobjectByIdentificatorTerreinobjectResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\TerreinobjectItemResponse',
            [
                'IdentificatorTerreinobject' => $identificatorTerreinobject
            ],
            false
        );
    }

    /**
     * getWegobjectByIdentificatorWegobject
     * 
     * @param integer identificatorWegobject
     * @return WegobjectItemResponse
     * @throws CRABServiceException
     */
    public function getWegobjectByIdentificatorWegobject($identificatorWegobject)
    {
        return $this->_doSoap(
            'GetWegobjectByIdentificatorWegobject',
            function ($result) {
                return $result->GetWegobjectByIdentificatorWegobjectResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\WegobjectItemResponse',
            [
                'IdentificatorWegobject' => $identificatorWegobject
            ],
            false
        );
    }

    /**
     * getWegsegmentByIdentificatorWegsegment
     * 
     * @param integer identificatorWegsegment
     * @return WegsegmentItemResponse
     * @throws CRABServiceException
     */
    public function getWegsegmentByIdentificatorWegsegment($identificatorWegsegment)
    {
        return $this->_doSoap(
            'GetWegsegmentByIdentificatorWegsegment',
            function ($result) {
                return $result->GetWegsegmentByIdentificatorWegsegmentResult ?? null;
            },
            'daandesmedt\CRAB\ws\response\WegsegmentItemResponse',
            [
                'IdentificatorWegsegment' => $identificatorWegsegment
            ],
            false
        );
    }


    /**
     * listAardAdressen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listAardAdressen()
    {
        return $this->_doSoap(
            'ListAardAdressen',
            function ($result) {
                return $result->ListAardAdressenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listAardGebouwen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listAardGebouwen()
    {
        return $this->_doSoap(
            'ListAardGebouwen',
            function ($result) {
                return $result->ListAardGebouwenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listAardSubadressen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listAardSubadressen()
    {
        return $this->_doSoap(
            'listAardSubadressen',
            function ($result) {
                return $result->ListAardSubadressenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listAardTerreinobjecten
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listAardTerreinobjecten()
    {
        return $this->_doSoap(
            'listAardTerreinobjecten',
            function ($result) {
                return $result->ListAardTerreinobjectenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listAardWegobjecten
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listAardWegobjecten()
    {
        return $this->_doSoap(
            'listAardWegobjecten',
            function ($result) {
                return $result->ListAardWegobjectenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listAdrespositiesByHuisnummer
     * 
     * @param integer huisnummer
     * @param integer straatnaamId
     * @return AdrespositieItemResponse[]
     * @throws CRABServiceException
     */
    public function listAdrespositiesByHuisnummer($huisnummer, $straatnaamId)
    {
        return $this->_doSoap(
            'listAdrespositiesByHuisnummer',
            function ($result) {
                return $result->ListAdrespositiesByHuisnummerResult->AdrespositieItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\AdrespositieItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listAdrespositiesByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return AdrespositieItemResponse[]
     * @throws CRABServiceException
     */
    public function listAdrespositiesByHuisnummerId($huisnummerId)
    {
        return $this->_doSoap(
            'listAdrespositiesByHuisnummerId',
            function ($result) {
                return $result->ListAdrespositiesByHuisnummerIdResult->AdrespositieItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\AdrespositieItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ]
        );
    }

    /**
     * listAdrespositiesByHuisnummerId
     * 
     * @param string subadres
     * @param integer huisnummerId
     * @return AdrespositieItemResponse[]
     * @throws CRABServiceException
     */
    public function listAdrespositiesBySubadres($subadres, $huisnummerId)
    {
        return $this->_doSoap(
            'listAdrespositiesBySubadres',
            function ($result) {
                return $result->ListAdrespositiesBySubadresResult->AdrespositieItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\AdrespositieItemResponse',
            [
                'Subadres' => $subadres,
                'HuisnummerId' => $huisnummerId
            ]
        );
    }

    /**
     * listAdrespositiesBySubadresId
     * 
     * @param integer subadresId
     * @return AdrespositieItemResponse[]
     * @throws CRABServiceException
     */
    public function listAdrespositiesBySubadresId($subadresId)
    {
        return $this->_doSoap(
            'listAdrespositiesBySubadresId',
            function ($result) {
                return $result->ListAdrespositiesBySubadresResult->AdrespositieItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\AdrespositieItemResponse',
            [
                'SubadresId' => $subadresId
            ]
        );
    }

    /**
     * listBewerkingen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listBewerkingen()
    {
        return $this->_doSoap(
            'listBewerkingen',
            function ($result) {
                return $result->ListBewerkingenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listGebouwenByHuisnummer
     * 
     * @param integer huisnummer
     * @param integer straatnaamId
     * @return GebouwItemResponse[]
     * @throws CRABServiceException
     */
    public function listGebouwenByHuisnummer($huisnummer, $straatnaamId)
    {
        return $this->_doSoap(
            'listGebouwenByHuisnummer',
            function ($result) {
                return $result->ListGebouwenByHuisnummerResult->GebouwItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\GebouwItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listGebouwenByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return GebouwItemResponse[]
     * @throws CRABServiceException
     */
    public function listGebouwenByHuisnummerId($huisnummerId)
    {
        return $this->_doSoap(
            'listGebouwenByHuisnummerId',
            function ($result) {
                return $result->ListGebouwenByHuisnummerIdResult->GebouwItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\GebouwItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ]
        );
    }

    /**
     * listGemeentenByGewestId
     * 
     * @param integer gewestId
     * @return GemeenteItemResponse[]
     * @throws CRABServiceException
     */
    public function listGemeentenByGewestId($gewestId)
    {
        return $this->_doSoap(
            'listGemeentenByGewestId',
            function ($result) {
                return $result->ListGemeentenByGewestIdResult->GemeenteItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\GemeenteItemResponse',
            [
                'GewestId' => $gewestId
            ]
        );
    }

    /**
     * listGeometriemethodeGebouwen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listGeometriemethodeGebouwen()
    {
        return $this->_doSoap(
            'listGeometriemethodeGebouwen',
            function ($result) {
                return $result->ListGeometriemethodeGebouwenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listGeometriemethodeWegsegmenten
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listGeometriemethodeWegsegmenten()
    {
        return $this->_doSoap(
            'listGeometriemethodeWegsegmenten',
            function ($result) {
                return $result->ListGeometriemethodeWegsegmentenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listGewesten
     * 
     * @return GewestItemResponse[]
     * @throws CRABServiceException
     */
    public function listGewesten()
    {
        return $this->_doSoap(
            'listGewesten',
            function ($result) {
                return $result->ListGewestenResult->GewestItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\GewestItemResponse'
        );
    }

    /**
     * listHerkomstAdresposities
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listHerkomstAdresposities()
    {
        return $this->_doSoap(
            'listHerkomstAdresposities',
            function ($result) {
                return $result->ListHerkomstAdrespositiesResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listHuisnummersByIdentificatorTerreinobject
     * 
     * @param integer identificatorTerreinobject
     * @return HuisNummerItemResponse[]
     * @throws CRABServiceException
     */
    public function listHuisnummersByIdentificatorTerreinobject($identificatorTerreinobject)
    {
        return $this->_doSoap(
            'ListHuisnummersByIdentificatorTerreinobject',
            function ($result) {
                return $result->ListHuisnummersByIdentificatorTerreinobjectResult->HuisnummerItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisNummerItemResponse',
            [
                'IdentificatorTerreinobject' => $identificatorTerreinobject
            ]
        );
    }

    /**
     * listHuisnummersByStraatnaamId
     * 
     * @param integer straatnaamId
     * @return HuisNummerItemResponse[]
     * @throws CRABServiceException
     */
    public function listHuisnummersByStraatnaamId($straatnaamId)
    {
        return $this->_doSoap(
            'ListHuisnummersByStraatnaamId',
            function ($result) {
                return $result->ListHuisnummersByStraatnaamIdResult->HuisnummerItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisNummerItemResponse',
            [
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listHuisnummersWithStatusByIdentificatorGebouw
     * 
     * @param string identificatorGebouw
     * @return HuisnummerWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listHuisnummersWithStatusByIdentificatorGebouw($identificatorGebouw)
    {
        return $this->_doSoap(
            'ListHuisnummersWithStatusByIdentificatorGebouw',
            function ($result) {
                return $result->ListHuisnummersWithStatusByIdentificatorGebouwResult->HuisnummerWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'IdentificatorGebouw' => $identificatorGebouw
            ]
        );
    }

    /**
     * listHuisnummersWithStatusByIdentificatorPerceel
     * 
     * @param string identificatorPerceel
     * @return HuisnummerWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listHuisnummersWithStatusByIdentificatorPerceel($identificatorPerceel)
    {
        return $this->_doSoap(
            'ListHuisnummersWithStatusByIdentificatorPerceel',
            function ($result) {
                return $result->ListHuisnummersWithStatusByIdentificatorPerceelResult->HuisnummerWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'IdentificatorPerceel' => $identificatorPerceel
            ]
        );
    }

    /**
     * listHuisnummersWithStatusByIdentificatorTerreinobject
     * 
     * @param string identificatorTerreinobject
     * @return HuisnummerWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listHuisnummersWithStatusByIdentificatorTerreinobject($identificatorTerreinobject)
    {
        return $this->_doSoap(
            'listHuisnummersWithStatusByIdentificatorTerreinobject',
            function ($result) {
                return $result->ListHuisnummersWithStatusByIdentificatorTerreinobjectResult->HuisnummerWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'IdentificatorTerreinobject' => $identificatorTerreinobject
            ]
        );
    }

    /**
     * listHuisnummersWithStatusByRijksregisterAdresId
     * 
     * @param integer rijksregisterAdresId
     * @return HuisnummerWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listHuisnummersWithStatusByRijksregisterAdresId($rijksregisterAdresId)
    {
        return $this->_doSoap(
            'listHuisnummersWithStatusByRijksregisterAdresId',
            function ($result) {
                return $result->ListHuisnummersWithStatusByRijksregisterAdresIdResult->HuisnummerWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'RijksregisterAdresId' => $rijksregisterAdresId
            ]
        );
    }

    /**
     * listHuisnummersWithStatusByStraatnaamId
     * 
     * @param integer straatnaamId
     * @return HuisnummerWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listHuisnummersWithStatusByStraatnaamId($straatnaamId)
    {
        return $this->_doSoap(
            'listHuisnummersWithStatusByStraatnaamId',
            function ($result) {
                return $result->ListHuisnummersWithStatusByStraatnaamIdResult->HuisnummerWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\HuisnummerWithStatusItemResponse',
            [
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listOrganisaties
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listOrganisaties()
    {
        return $this->_doSoap(
            'listOrganisaties',
            function ($result) {
                return $result->ListOrganisatiesResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listPercelenByHuisnummer
     * 
     * @param string huisnummer
     * @param integer straatnaamId
     * @return PerceelItemResponse[]
     * @throws CRABServiceException
     */
    public function listPercelenByHuisnummer($huisnummer, $straatnaamId)
    {
        return $this->_doSoap(
            'listPercelenByHuisnummer',
            function ($result) {
                return $result->ListPercelenByHuisnummerResult->PerceelItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\PerceelItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listPercelenByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return PerceelItemResponse[]
     * @throws CRABServiceException
     */
    public function listPercelenByHuisnummerId($huisnummerId)
    {
        return $this->_doSoap(
            'listPercelenByHuisnummerId',
            function ($result) {
                return $result->ListPercelenByHuisnummerIdResult->PerceelItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\PerceelItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ]
        );
    }

    /**
     * listPostadressenByStraatnaamId
     * 
     * @param integer straatnaamId
     * @return PostadresItemResponse[]
     * @throws CRABServiceException
     */
    public function listPostadressenByStraatnaamId($straatnaamId)
    {
        return $this->_doSoap(
            'ListPostadressenByStraatnaamId',
            function ($result) {
                return $result->ListPostadressenByStraatnaamIdResult->PostadresItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\PostadresItemResponse',
            [
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listPostkantonsByGemeenteId
     * 
     * @param integer gemeenteId
     * @return PostkantonItemResponse[]
     * @throws CRABServiceException
     */
    public function listPostkantonsByGemeenteId($gemeenteId)
    {
        return $this->_doSoap(
            'listPostkantonsByGemeenteId',
            function ($result) {
                return $result->ListPostkantonsByGemeenteIdResult->PostkantonItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\PostkantonItemResponse',
            [
                'GemeenteId' => $gemeenteId
            ]
        );
    }

    /**
     * listRijksregisterAdresByHuisnummer
     * 
     * @param string huisnummer
     * @param integer straatnaamId
     * @return RijksregisterAdresItemResponse[]
     * @throws CRABServiceException
     */
    public function listRijksregisterAdresByHuisnummer($huisnummer, $straatnaamId)
    {
        return $this->_doSoap(
            'listRijksregisterAdresByHuisnummer',
            function ($result) {
                return $result->ListRijksregisterAdresByHuisnummerResult->RijksregisterAdresItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\RijksregisterAdresItemResponse',
            [
                'Huisnummer' => $huisnummer,
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listRijksregisterAdresBySubadresId
     * 
     * @param integer subadresId
     * @return RijksregisterAdresItemResponse[]
     * @throws CRABServiceException
     */
    public function listRijksregisterAdresBySubadresId($subadresId)
    {
        return $this->_doSoap(
            'listRijksregisterAdresBySubadresId',
            function ($result) {
                return $result->ListRijksregisterAdresBySubadresIdResult->RijksregisterAdresItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\RijksregisterAdresItemResponse',
            [
                'SubadresId' => $subadresId
            ]
        );
    }

    /**
     * listRijksregisterStratenByStraatnaamId
     * 
     * @param integer straatnaamId
     * @return RijksregisterAdresItemResponse[]
     * @throws CRABServiceException
     */
    public function listRijksregisterStratenByStraatnaamId($straatnaamId)
    {
        return $this->_doSoap(
            'listRijksregisterStratenByStraatnaamId',
            function ($result) {
                return $result->ListRijksregisterStratenByStraatnaamIdResult->RijksregisterstraatItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\RijksregisterAdresItemResponse',
            [
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listStatusGebouwen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listStatusGebouwen()
    {
        return $this->_doSoap(
            'ListStatusGebouwen',
            function ($result) {
                return $result->ListStatusGebouwenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listStatusHuisnummers
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listStatusHuisnummers()
    {
        return $this->_doSoap(
            'ListStatusHuisnummers',
            function ($result) {
                return $result->ListStatusHuisnummersResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listStatusStraatnamen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listStatusStraatnamen()
    {
        return $this->_doSoap(
            'ListStatusStraatnamen',
            function ($result) {
                return $result->ListStatusStraatnamenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listStatusSubadressen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listStatusSubadressen()
    {
        return $this->_doSoap(
            'ListStatusSubadressen',
            function ($result) {
                return $result->ListStatusSubadressenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listStatusWegsegmenten
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listStatusWegsegmenten()
    {
        return $this->_doSoap(
            'ListStatusWegsegmenten',
            function ($result) {
                return $result->ListStatusWegsegmentenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listStraatnamenByGemeenteId
     * 
     * @param integer gemeenteId
     * @return StraatnaamItemResponse[]
     * @throws CRABServiceException
     */
    public function listStraatnamenByGemeenteId($gemeenteId)
    {
        return $this->_doSoap(
            'ListStraatnamenByGemeenteId',
            function ($result) {
                return $result->ListStraatnamenByGemeenteIdResult->StraatnaamItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\StraatnaamItemResponse',
            [
                'GemeenteId' => $gemeenteId
            ]
        );
    }

    /**
     * listStraatnamenByIdentificatorWegobject
     * 
     * @param integer identificatorWegobject
     * @return StraatnaamItemResponse[]
     * @throws CRABServiceException
     */
    public function listStraatnamenByIdentificatorWegobject($identificatorWegobject)
    {
        return $this->_doSoap(
            'ListStraatnamenByIdentificatorWegobject',
            function ($result) {
                return $result->ListStraatnamenByIdentificatorWegobjectResult->StraatnaamItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\StraatnaamItemResponse',
            [
                'IdentificatorWegobject' => $identificatorWegobject
            ]
        );
    }

    /**
     * listStraatnamenWithStatusByGemeenteId
     * 
     * @param integer gemeenteId
     * @return StraatnaamWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listStraatnamenWithStatusByGemeenteId($gemeenteId)
    {
        return $this->_doSoap(
            'ListStraatnamenWithStatusByGemeenteId',
            function ($result) {
                return $result->ListStraatnamenWithStatusByGemeenteIdResult->StraatnaamWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\StraatnaamWithStatusItemResponse',
            [
                'GemeenteId' => $gemeenteId
            ]
        );
    }

    /**
     * listStraatnamenWithStatusByIdentificatorWegobject
     * 
     * @param string identificatorWegobject
     * @return StraatnaamWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listStraatnamenWithStatusByIdentificatorWegobject($identificatorWegobject)
    {
        return $this->_doSoap(
            'ListStraatnamenWithStatusByIdentificatorWegobject',
            function ($result) {
                return $result->ListStraatnamenWithStatusByIdentificatorWegobjectResult->StraatnaamWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\StraatnaamWithStatusItemResponse',
            [
                'IdentificatorWegobject' => $identificatorWegobject
            ]
        );
    }

    /**
     * listStraatnamenWithStatusByIdentificatorWegsegment
     * 
     * @param string identificatorWegsegment
     * @return StraatnaamWithStatusItemResponse[]
     * @throws CRABServiceException
     */
    public function listStraatnamenWithStatusByIdentificatorWegsegment($identificatorWegsegment)
    {
        return $this->_doSoap(
            'ListStraatnamenWithStatusByIdentificatorWegsegment',
            function ($result) {
                return $result->ListStraatnamenWithStatusByIdentificatorWegsegmentResult->StraatnaamWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\StraatnaamWithStatusItemResponse',
            [
                'IdentificatorWegsegment' => $identificatorWegsegment
            ]
        );
    }

    /**
     * listSubadressenByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return SubadresItemResponse[]
     * @throws CRABServiceException
     */
    public function listSubadressenByHuisnummerId($huisnummerId)
    {
        return $this->_doSoap(
            'listSubadressenByHuisnummerId',
            function ($result) {
                return $result->ListSubadressenByHuisnummerIdResult->SubadresItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\SubadresItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ]
        );
    }

    /**
     * listSubadressenWithStatusByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return SubadresItemWithStatusResponse[]
     * @throws CRABServiceException
     */
    public function listSubadressenWithStatusByHuisnummerId($huisnummerId)
    {
        return $this->_doSoap(
            'listSubadressenWithStatusByHuisnummerId',
            function ($result) {
                return $result->ListSubadressenWithStatusByHuisnummerIdResult->SubadresWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\SubadresItemWithStatusResponse',
            [
                'HuisnummerId' => $huisnummerId
            ]
        );
    }

    /**
     * listSubadressenWithStatusByRijksregisterAdresId
     * 
     * @param integer rijksregisterAdresId
     * @return SubadresItemWithStatusResponse[]
     * @throws CRABServiceException
     */
    public function listSubadressenWithStatusByRijksregisterAdresId($rijksregisterAdresId)
    {
        return $this->_doSoap(
            'ListSubadressenWithStatusByRijksregisterAdresId',
            function ($result) {
                return $result->ListSubadressenWithStatusByRijksregisterAdresIdResult->SubadresWithStatusItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\SubadresItemWithStatusResponse',
            [
                'RijksregisterAdresId' => $rijksregisterAdresId
            ]
        );
    }

    /**
     * listTalen
     * 
     * @return CodeItemResponse[]
     * @throws CRABServiceException
     */
    public function listTalen()
    {
        return $this->_doSoap(
            'ListTalen',
            function ($result) {
                return $result->ListTalenResult->CodeItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\CodeItemResponse'
        );
    }

    /**
     * listTerreinobjectenByHuisnummerId
     * 
     * @param integer huisnummerId
     * @return TerreinobjectItemResponse[]
     * @throws CRABServiceException
     */
    public function listTerreinobjectenByHuisnummerId($huisnummerId)
    {
        return $this->_doSoap(
            'ListTerreinobjectenByHuisnummerId',
            function ($result) {
                return $result->ListTerreinobjectenByHuisnummerIdResult->TerreinobjectItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\TerreinobjectItemResponse',
            [
                'HuisnummerId' => $huisnummerId
            ]
        );
    }

    /**
     * ListWegobjectenByStraatnaamId
     * 
     * @param integer straatnaamId
     * @return WegobjectItemResponse[]
     * @throws CRABServiceException
     */
    public function listWegobjectenByStraatnaamId($straatnaamId)
    {
        return $this->_doSoap(
            'ListWegobjectenByStraatnaamId',
            function ($result) {
                return $result->ListWegobjectenByStraatnaamIdResult->WegobjectItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\WegobjectItemResponse',
            [
                'StraatnaamId' => $straatnaamId
            ]
        );
    }

    /**
     * listWegsegmentenByStraatnaamId
     * 
     * @param integer straatnaamId
     * @return WegsegmentItemResponse[]
     * @throws CRABServiceException
     */
    public function listWegsegmentenByStraatnaamId($straatnaamId)
    {
        return $this->_doSoap(
            'listWegsegmentenByStraatnaamId',
            function ($result) {
                return $result->ListWegsegmentenByStraatnaamIdResult->WegsegmentItem ?? null;
            },
            'daandesmedt\CRAB\ws\response\WegsegmentItemResponse',
            [
                'StraatnaamId' => $straatnaamId
            ]
        );
    }


    private function _doSoap($method, $parseCallaback = null, $class = null, $requestParams = array(), $collection = true)
    {
        try {
            
            $requestParams['SorteerVeld'] = 0;

            $soapRes = $this->getSoapClient()->__soapCall($method, [$requestParams]);
            $result = $parseCallaback($soapRes);
            if (!$result) return [];

            $class = new ReflectionClass($class);
            $res = array();
            if (!is_array($result)) $result = [$result];
            foreach ($result as $row) {
                $instance = $class->newInstanceWithoutConstructor();
                $instance->populate($row);
                if($collection) {
                    $res[] = $instance;
                }  else {
                    return $instance;
                }
            }

            return $res;

        } catch (SoapFault $e) {
            $message = sprintf(
                'WS CRAB "%s" operation cannot be completed at this at this moment. '
                    . 'The WS CRAB service operation responded with "%s". '
                    . 'Please try again later. This is probably something temporary.',
                $method,
                $e->getMessage()
            );
            throw new CRABServiceException($message, 0, $e);
        }
    }

}