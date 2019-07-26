<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\CRAB\CRAB;
use daandesmedt\CRAB\ws\WSCRAB;


$wscrab = new WSCRAB();
try {

    // LIST OPERATIONS
    // $res = $wscrab->listAardAdressen();
    // $res = $wscrab->listAardGebouwen();
    // $res = $wscrab->listAardSubAdressen();
    // $res = $wscrab->listAardTerreinobjecten();
    // $res = $wscrab->listAardWegobjecten();
    // $res = $wscrab->listAdrespositiesByHuisnummer(10,10);
    // $res = $wscrab->listAdrespositiesByHuisnummerId(10);
    // $res = $wscrab->listAdrespositiesBySubadres('1989478',10);
    // $res = $wscrab->listAdrespositiesBySubadresId(10);
    // $res = $wscrab->listBewerkingen();
    // $res = $wscrab->listGebouwenByHuisnummer(1,10);
    // $res = $wscrab->listGebouwenByHuisnummerId(1);
    // $res = $wscrab->listGemeentenByGewestId(1);
    // $res = $wscrab->listGeometriemethodeGebouwen();
    // $res = $wscrab->listGeometriemethodeWegsegmenten();
    // $res = $wscrab->listGewesten();
    // $res = $wscrab->listHerkomstAdresposities();
    // $res = $wscrab->listHuisnummersByIdentificatorTerreinobject('11372_D_0003_N_000_00');
    // $res = $wscrab->listHuisnummersByStraatnaamId('1');
    // $res = $wscrab->listHuisnummersWithStatusByIdentificatorGebouw('1');
    // $res = $wscrab->listHuisnummersWithStatusByIdentificatorPerceel('44028C0135/00G002');
    // $res = $wscrab->listHuisnummersWithStatusByIdentificatorTerreinobject('11372_D_0003_N_000_00');
    // $res = $wscrab->listHuisnummersWithStatusByRijksregisterAdresId('4140840');
    // $res = $wscrab->listHuisnummersWithStatusByStraatnaamId(12);
    // $res = $wscrab->listOrganisaties();
    // $res = $wscrab->listPercelenByHuisnummer(1,1);
    // $res = $wscrab->listPercelenByHuisnummerId(5);
    // $res = $wscrab->listPostadressenByStraatnaamId(4);
    // $res = $wscrab->listPostkantonsByGemeenteId(4);
    // $res = $wscrab->listRijksregisterAdresByHuisnummer(1,22);
    // $res = $wscrab->listRijksregisterAdresByHuisnummerId(1);
    // $res = $wscrab->listRijksregisterAdresBySubadresId(1989478);
    // $res = $wscrab->listRijksregisterStratenByStraatnaamId(5);
    // $res = $wscrab->listStatusGebouwen();
    // $res = $wscrab->listStatusHuisnummers();
    // $res = $wscrab->listStatusStraatnamen();
    // $res = $wscrab->listStatusSubadressen();
    // $res = $wscrab->listStatusWegsegmenten();
    // $res = $wscrab->listStraatnamenByGemeenteId(78);
    // $res = $wscrab->listStraatnamenByIdentificatorWegobject(53839893);
    // $res = $wscrab->listStraatnamenWithStatusByGemeenteId(5);
    // $res = $wscrab->listStraatnamenWithStatusByIdentificatorWegobject(53839893);
    // $res = $wscrab->listStraatnamenWithStatusByIdentificatorWegsegment(124384);
    // $res = $wscrab->listSubadressenByHuisnummerID(14);
    // $res = $wscrab->listSubadressenWithStatusByHuisnummerId(14);
    // $res = $wscrab->listSubadressenWithStatusByRijksregisterAdresId(14);
    // $res = $wscrab->listTalen();
    // $res = $wscrab->listTerreinobjectenByHuisnummerId(122);
    // $res = $wscrab->ListWegobjectenByStraatnaamId(12);
    // $res = $wscrab->listWegsegmentenByStraatnaamId(11);
   
    // FIND OPERATIONS
    // $res = $wscrab->findGemeenten('Ste%', 2);
    // $res = $wscrab->findGemeentenByPostkanton('91%');
    // $res = $wscrab->findHuisnummers('17', 2);
    // $res = $wscrab->findHuisnummersWithStatus('17', 2);
    // $res = $wscrab->findStraatnamen('Station%', 309);
    // $res = $wscrab->findStraatnamenWithStatus('Station%', 309);
    // $res = $wscrab->findSubadressen('%', 4);
    // $res = $wscrab->findSubadressenWithStatus('%', 4);

    // GET OPERATIONS
    // $res = $wscrab->getAdrespositieByAdrespositieId('829354');
    // $res = $wscrab->getGebouwByIdentificatorGebouw('1');
    // $res = $wscrab->getGemeenteByGemeenteId('1');
    // $res = $wscrab->getGemeenteByGemeenteNaam('a%', 1);
    // $res = $wscrab->getGemeenteByGemeenteNaam('a%', 1);
    // $res = $wscrab->getGemeenteByNISGemeenteCode(21001);
    // $res = $wscrab->getGewestByGewestIdAndTaalCode(2, 'nl');
    // $res = $wscrab->getHuisnummerByHuisnummer('1', 555);
    // $res = $wscrab->getHuisnummerByHuisnummerId(1959211);
    // $res = $wscrab->getHuisnummerWithStatusByHuisnummer('1', 555);
    // $res = $wscrab->getHuisnummerWithStatusByHuisnummerId(1);
    // $res = $wscrab->getPerceelByIdentificatorPerceel('44028C0135/00G002');
    // $res = $wscrab->getPostadresByHuisnummerId('44028C0135/00G002');
    // $res = $wscrab->getSubadresBySubadresId(1989478);
    // $res = $wscrab->getSubadresWithStatusBySubadresId(1989478);
    // $res = $wscrab->getTerreinobjectByIdentificatorTerreinobject('11372_D_0003_N_000_00');
    // $res = $wscrab->getWegobjectByIdentificatorWegobject('53839893');
    $res = $wscrab->getWegsegmentByIdentificatorWegsegment('124384');
    
    var_dump($res);

} catch (CRABServiceException $e) {
    var_dump($e->getMessage());
}