<?php
/**
 * Created by PhpStorm.
 * User: tm-rm
 * Date: 11.03.16
 * Time: 11:25
 */

use WCKZ\Console\Console as Console;

require_once __DIR__ . '/vendor/autoload.php';

$authentication = WCKZ\Afterbuy\Authentication::fromYAML('config.yaml');
$afterbuy       = new WCKZ\Afterbuy\AfterbuyAPI($authentication);

$request = $afterbuy->createRequest('GetShopProducts', array(
    'maxShopItems'      => 1,
    'paginationEnabled' => 1,
    'pageNumber'        => 1
));

$request->send();
$productCount = (int) $request->getResponse()['Result']['PaginationResult']['TotalNumberOfEntries'];
$pageNumber   = 1;
$products     = array();

Console::writeLine('Found %d products.', $productCount);
$request->update('maxShopItems', 100);

while($productCount > 0)
{
    Console::writeLine('Requesting products...');
    $request->update('pageNumber', ++$pageNumber);
    $request->send();

    if($request->hasError())
    {
        Console::writeLine('Request failed... aborting');
        Console::stop();
    }

    $newProducts   = $request->getResponse()['Result']['Products']['Product'];
    $products      = array_merge($newProducts, $products);
    $productCount -= count($newProducts);

    Console::writeLine('Got %d products. (%d left)', count($newProducts), $productCount);
}

Console::writeLine('Fetched %d products.', count($products));