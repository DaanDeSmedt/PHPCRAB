<?php

namespace daandesmedt\CRAB\tools\response;

use daandesmedt\PHPWKTAdapter\WKTAdapter;
use daandesmedt\CRAB\CRABResponseInterface;

class LocationResponse implements CRABResponseInterface
{

    /**
     * @var array|null
     */
    protected $BBOX;

    /**
     * @var array|null
     */
    protected $centroid;

    /**
     * @var integer
     */
    protected $idExists;

    /**
     * @var string
     */
    protected $quality;

    public function __construct()
    {
    }

    /**
     * Populate response class
     * 
     * @param array $params
     */
    public function populate($params) : void
    {
        $this->idExists = $params->IdExists ?? null;
        $this->quality = $params->Quality ?? null;
        $this->setBBOX($params->Bbox ?? null);
        $this->setCentroid($params->Centroid ?? null);
    }

    /**
     * Set centroid
     * 
     * @param array centroid
     */
    private function setCentroid($centroid)
    {
        if ($centroid) {
            try {
                $adapter = new WKTAdapter();
                $this->centroid = $adapter->read("POINT(" . $centroid->X . " " . $centroid->Y . ")");
            } catch (\UnexpectedValueException $e) {
            }
        }
    }

    /**
     * Set BBOX
     * 
     * @param array bbox
     */
    private function setBBOX($bbox)
    {
        if ($bbox) {
            try {
                $adapter = new WKTAdapter();
                $this->BBOX = $adapter->read(
                    "POLYGON((" .
                        $bbox->MinX . " " . $bbox->MinY . "," .
                        $bbox->MinX . " " . $bbox->MaxY . "," .
                        $bbox->MaxX . " " . $bbox->MaxY . "," .
                        $bbox->MaxX . " " . $bbox->MinY . "," .
                        $bbox->MinX . " " . $bbox->MinY .
                    "))"
                );
            } catch (\UnexpectedValueException $e) {
            }
        }
    }

    /**
     * Get BBOX
     * 
     * @return array bbox
     */
    public function getBBOX()
    {
        return $this->BBOX;
    }

    /**
     * Get Centroid
     * 
     * @return array centroid
     */
    public function getCentroid()
    {
        return $this->centroid;
    }

    /**
     * Get Id exists
     * 
     * @return integer idExists
     */
    public function getIdExists()
    {
        return $this->idExists;
    }

    /**
     * Get quality
     * 
     * @return string quality
     */
    public function getQuality()
    {
        return $this->quality;
    }

}