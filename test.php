<?php
/**
 * Created by PhpStorm.
 * User: tm-rm
 * Date: 11.03.16
 * Time: 11:25
 */

require_once __DIR__ . '/vendor/autoload.php';

$authentication = new WCKZ\Afterbuy\Authentication('', '', '', '');
$afterbuy       = new WCKZ\Afterbuy\AfterbuyAPI($authentication);

$request = $afterbuy->createRequest('GetShopProducts', array(
    'maxShopItems'      => 1,
    'paginationEnabled' => 1,
    'pageNumber'        => 1
));

if($request->send())
{
    echo sizeof($request->getResponse()), PHP_EOL;
}
else
{
    echo $request->getError(), PHP_EOL;
}