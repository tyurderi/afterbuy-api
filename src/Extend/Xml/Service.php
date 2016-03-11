<?php

namespace WCKZ\Afterbuy\Extend\Xml;

class Service extends \Sabre\Xml\Service
{

    public function getReader()
    {
        $reader = new Reader();
        $reader->elementMap = $this->elementMap;

        return $reader;
    }

}