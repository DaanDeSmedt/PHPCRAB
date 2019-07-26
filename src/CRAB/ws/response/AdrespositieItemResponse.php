<?php

namespace daandesmedt\CRAB\ws\response;

use daandesmedt\PHPWKTAdapter\WKTAdapter;

class AdrespositieItemResponse extends BeginItemResponse
{

    protected $adrespositieId;
    protected $herkomstAdrespositie;

    protected $aardAdres;
    protected $adresId;
    protected $geometry;

    public function __construct()
    {
    }

    public function populate($params) : void
    {
        parent::populate($params);
        $this->adrespositieId = $params->AdrespositieId ?? null;
        $this->herkomstAdrespositie = $params->HerkomstAdrespositie ?? null;
        $this->aardAdres = $params->AardAdres ?? null;
        $this->adresId = $params->AdresId ?? null;
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

    public function getGeometry()
    {
        return $this->geometry;
    }

    public function getAdrespositieId()
    {
        return $this->adrespositieId;
    }

    public function getHerkomstAdrespositie()
    {
        return $this->herkomstAdrespositie;
    }

    public function getGeometrie()
    {
        return $this->geometrie;
    }

    public function getAardAdres()
    {
        return $this->aardAdres;
    }

    public function getAdresId()
    {
        return $this->adresId;
    }

}