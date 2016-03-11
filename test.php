<?php
/**
 * Created by PhpStorm.
 * User: tm-rm
 * Date: 11.03.16
 * Time: 11:25
 */

require_once __DIR__ . '/vendor/autoload.php';

$authentication = WCKZ\Afterbuy\Authentication::fromYAML('config.yaml');
$afterbuy       = new WCKZ\Afterbuy\AfterbuyAPI($authentication);

$request = $afterbuy->createRequest('GetShopProducts', array(
    'maxShopItems'      => 1,
    'paginationEnabled' => 1,
    'pageNumber'        => 1
));

