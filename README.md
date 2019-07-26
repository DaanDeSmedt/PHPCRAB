PHPCRAB
===============

The acronym "CRAB" stands for "Central Reference Directory." The CRAB is the authentic source for addresses in Flanders (Belgium). It contains all official addresses, and their geographical location. It is managed by the Flemish cities and municipalities. The use of the CRAB is free and is open to everyone.

The CRAB is included in the system of Flemish Basic Registers. In that context, the CRAB will evolve into the Address Register. This involves an adjustment of the data model and the construction of new services. We gradually phase out the existing services and services of the CRAB and replace them with the new global services for the building and address register. You can find more information about this on the product page of the building register.

`PHPCRAB` provides a simple usage helper class around the open [CRAB WS SOAP services](https://overheid.vlaanderen.be/CRAB-WS-CRAB) and the [CRAB Tools SOAP service](https://overheid.vlaanderen.be/CRAB-CRAB-Tools).



## CRAB WS and CRAB TOOLS 

WS-CRAB 

WS-CRAB discloses information from a subset of the CRAB entities ; offers three types of operations:

* List XXX: list entities based on zero or one parameter; list of domain values;
* Find XXX: search for entities based on one or more parameters that may contain wildcards;
* Get XXX: request details of a single entity.


CRAB Tools

The CRAB Tools service contains help methods that unlock transformation logic on top of the data contained in the CRAB. The service can be used to clean up your own address files and to enrich them with geographical information.


## Installation

Install the package through [composer](http://getcomposer.org):

```
composer require daandesmedt/phpcrab
```

Make sure, that you include the composer [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading) somewhere in your codebase.


## CRAB WS operations

WS-CRAB discloses information from a subset of the CRAB entities ; offers three types of operations:

* List XXX: list entities based on zero or one parameter; list of domain values;
* Find XXX: search for entities based on one or more parameters that may contain wildcards;
* Get XXX: request details of a single entity.


The WSCRAB (`daandesmedt\CRAB\ws\WSCRAB`) supports following specific opetations :

* `findGemeenten($gemeenteNaam, $gewestId)`
* `findGemeentenByPostkanton($postkantonCode)`
* `findHuisnummers($huisnummer, $straatnaamId)`
* `findHuisnummersWithStatus($huisnummer, $straatnaamId)`
* `findStraatnamen($straatnaam, $gemeenteId)`
* `findStraatnamenWithStatus($straatnaam, $gemeenteId)`
* `findSubadressen($subadres, $huisnummerId)`
* `findSubadressenWithStatus($subadres, $huisnummerId)`
* `getAdrespositieByAdrespositieId($adrespositieId)`
* `getGebouwByIdentificatorGebouw($identificatorGebouw)`
* `getGemeenteByGemeenteId($gemeenteId)`
* `getGemeenteByGemeenteNaam($gemeenteNaam, $gewestId)`
* `getGemeenteByNISGemeenteCode($NISGemeenteCode)`
* `getGewestByGewestIdAndTaalCode($gewestId, $taalCode)`
* `getHuisnummerByHuisnummer($huisnummer, $straatnaamId)`
* `getHuisnummerByHuisnummerId($huisnummerId)`
* `getHuisnummerWithStatusByHuisnummer($huisnummer, $straatnaamId)`
* `getHuisnummerWithStatusByHuisnummerId($huisnummerId)`
* `getPerceelByIdentificatorPerceel($identificatorPerceel)`
* `getPostadresByHuisnummerId($huisnummerId)`
* `getSubadresBySubadresId($subadresId)`
* `getSubadresWithStatusBySubadresId($subadresId)`
* `getTerreinobjectByIdentificatorTerreinobject($identificatorTerreinobject)`
* `getWegobjectByIdentificatorWegobject($identificatorWegobject)`
* `getWegsegmentByIdentificatorWegsegment($identificatorWegsegment)`
* `listAardAdressen`
* `listAardGebouwen()`
* `listAardSubAdressen()`
* `listAardTerreinobjecten()`
* `listAardWegobjecten()`
* `listAdrespositiesByHuisnummer($huisnummer, $straatnaamId)`
* `listAdrespositiesByHuisnummerId($huisnummerId)`
* `listAdrespositiesBySubadres($subadres, $huisnummerId)`
* `listAdrespositiesBySubadresId($subadresId)`
* `listBewerkingen()`
* `listGebouwenByHuisnummer($huisnummer, $straatnaamId)`
* `listGebouwenByHuisnummerId($huisnummerId)`
* `listGemeentenByGewestId($gewestId)`
* `listGeometriemethodeGebouwen()`
* `listGeometriemethodeWegsegmenten()`
* `listGewesten()`
* `listHerkomstAdresposities()`
* `listHuisnummersByIdentificatorTerreinobject($identificatorTerreinobject)`
* `listHuisnummersByStraatnaamId($straatnaamId)`
* `listHuisnummersWithStatusByIdentificatorGebouw($identificatorGebouw)`
* `listHuisnummersWithStatusByIdentificatorPerceel($identificatorPerceel)`
* `listHuisnummersWithStatusByIdentificatorTerreinobject($identificatorTerreinobject)`
* `listHuisnummersWithStatusByRijksregisterAdresId($rijksregisterAdresId)`
* `listHuisnummersWithStatusByStraatnaamId($straatnaamId)`
* `listOrganisaties()`
* `listPercelenByHuisnummer($huisnummer, $straatnaamId)`
* `listPercelenByHuisnummerId($huisnummerId)`
* `listPostadressenByStraatnaamId($straatnaamId)`
* `listPostkantonsByGemeenteId($gemeenteId)`
* `listRijksregisterAdresByHuisnummer($huisnummer, $straatnaamId)`
* `listRijksregisterAdresBySubadresId($subadresId)`
* `listRijksregisterStratenByStraatnaamId($straatnaamId)`
* `listStatusGebouwen()`
* `listStatusHuisnummers()`
* `listStatusStraatnamen()`
* `listStatusSubadressen()`
* `listStatusWegsegmenten()`
* `listStraatnamenByGemeenteId($gemeenteId)`
* `listStraatnamenByIdentificatorWegobject($identificatorWegobject)`
* `listStraatnamenWithStatusByGemeenteId($gemeenteId)`
* `listStraatnamenWithStatusByIdentificatorWegobject($identificatorWegobject)`
* `listStraatnamenWithStatusByIdentificatorWegsegment($identificatorWegsegment)`
* `listSubadressenByHuisnummerId($huisnummerId)`
* `listSubadressenWithStatusByHuisnummerId($huisnummerId)`
* `listSubadressenWithStatusByRijksregisterAdresId($rijksregisterAdresId)`
* `listTalen()`
* `listTerreinobjectenByHuisnummerId($huisnummerId)`
* `listWegobjectenByStraatnaamId($straatnaamId)`
* `listWegsegmentenByStraatnaamId($straatnaamId)`


Example :

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\CRAB\CRAB;
use daandesmedt\CRAB\ws\WSCRAB;

$wscrab = new WSCRAB();
$res = $wscrab->listAardAdressen();
var_dump($res);
```


## CRAB Tools operations

The CRAB Tools service contains help methods that unlock transformation logic on top of the data contained in the CRAB. The service can be used to clean up your own address files and to enrich them with geographical information.


The CRABTools (`daandesmedt\CRAB\tools\CRABTools`) supports following specific opetations :

* `getAddressLocation()` : look up the (known or calculated) terrain position of a CRAB address
* `getStreetLocation()` : look up the corresponding location of a CRAB street
* `getCRABMatch(boxNumber, cityName, houseNumber, nisCity, postalCode, rrStreetCode, streetName)` : look up the corresponding CRAB address for a given address

Example :

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\CRAB\tools\CRABTools;

$crabtools = new CRABTools();
$res = $crabtools->getAddressLocation(10);
var_dump($res);
```


## Handling CRAB service exceptions

CRAB WS Service exceptions (SOAP errors) result in a `CRABServiceException`.


```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\CRAB\CRAB;
use daandesmedt\CRAB\ws\WSCRAB;

$wscrab = new WSCRAB();
try {
    $res = $wscrab->getWegsegmentByIdentificatorWegsegment('124384');
} catch (CRABServiceException $e) {
    var_dump($e->getMessage());
}
```


## Working examples

Working examples can be found in the `examples` folder.