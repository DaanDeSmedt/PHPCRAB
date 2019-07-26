<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\CRAB\tools\CRABTools;

$crabtools = new CRABTools();
try {
    // $res = $crabtools->getAddressLocation(10);
    // $res = $crabtools->getStreetLocation(10);
    $res = $crabtools->getCRABMatch(
        '',
        'Stekene',
        '17a',
        '',
        '9190',
        '',
        'Hinnenstraat'
    );
    //
    var_dump($res);
} catch (CRABServiceException $e) {
    var_dump($e->getMessage());
}