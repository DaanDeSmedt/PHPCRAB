<?php

namespace daandesmedt\CRAB\ws\response;

use daandesmedt\PHPWKTAdapter\WKTAdapter;


class GebouwItemResponse extends BeginItemResponse
{

    protected $identificatorGebouw;
    protected $aardGebouw;
    protected $statusGebouw;
    protected $geometriemethodeGebouw;
    protected $geometry;

    public function __construct()
    {
    }

    public function populate($params) : void
    {
        parent::populate($params);
        $this->identificatorGebouw = $params->IdentificatorGebouw ?? null;
        $this->aardGebouw = $params->AardGebouw ?? null;
        $this->statusGebouw = $params->StatusGebouw ?? null;
        $this->geometriemethodeGebouw = $params->GeometriemethodeGebouw ?? null;
        $this->setGeometry($params->Geometrie ?? null);
    }

    private function setGeometry($geometrie)
    {
        if (isset($geometrie)) {
            try {
                $adapter = new WKTAdapter();
                $this->geometry = $adapter->read($geometrie);
            } catch (\UnexpectedValueException $e) {
            }
        }
    }

    public function getIdentificatorGebouw()
    {
        return $this->identificatorGebouw;
    }

    public function getAardGebouw()
    {
        return $this->aardGebouw;
    }

    public function getStatusGebouw()
    {
        return $this->statusGebouw;
    }

    public function getGeometriemethodeGebouw()
    {
        return $this->geometriemethodeGebouw;
    }

}