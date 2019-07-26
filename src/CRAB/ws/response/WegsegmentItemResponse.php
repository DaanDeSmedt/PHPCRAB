<?php

namespace daandesmedt\CRAB\ws\response;

use daandesmedt\PHPWKTAdapter\WKTAdapter;

class WegsegmentItemResponse extends BeginItemResponse
{

    protected $identificatorWegsegment;
    protected $statusWegsegment;
    protected $geometriemethodeWegsegment;
    protected $geometry;

    public function __construct(){}

    public function populate($params): void
    {       
        parent::populate($params);
        $this->identificatorWegsegment = $params->IdentificatorWegsegment ?? null;
        $this->statusWegsegment = $params->StatusWegsegment ?? null;
        $this->geometriemethodeWegsegment = $params->GeometriemethodeWegsegment ?? null;
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

    public function getIdentificatorWegsegment()
    {
        return $this->identificatorWegsegment;
    }

    public function getStatusWegsegment()
    {
        return $this->statusWegsegment;
    }

    public function getGeometriemethodeWegsegment()
    {
        return $this->geometriemethodeWegsegment;
    }

}