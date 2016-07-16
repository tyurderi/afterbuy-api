<?php

require_once __DIR__ . '/vendor/autoload.php';

$authentication = TY\Afterbuy\Authentication::fromYAML('config.yaml');
$afterbuy       = new TY\Afterbuy\AfterbuyAPI($authentication);

$request = $afterbuy->createRequest('GetShopProducts', array(
    'maxShopItems'      => 1,
    'paginationEnabled' => 1,
    'pageNumber'        => 1
));

$request->send();
$productCount = (int) $request->getResponse()['Result']['PaginationResult']['TotalNumberOfEntries'];
$pageNumber   = 1;
$products     = array();

Console()->out('Found %d products.', $productCount);
$request->update('maxShopItems', 100);

while($productCount > 0)
{
    Console()->out('Requesting products...');
    $request->update('pageNumber', ++$pageNumber);
    $request->send();

    if($request->hasError())
    {
        Console()->out('Request failed... aborting');
        return;
    }

    $newProducts   = $request->getResponse()['Result']['Products']['Product'];
    $products      = array_merge($newProducts, $products);
    $productCount -= count($newProducts);

    Console()->out('Got %d products. (%d left)', count($newProducts), $productCount);
}

Console()->out('Fetched %d products.', count($products));