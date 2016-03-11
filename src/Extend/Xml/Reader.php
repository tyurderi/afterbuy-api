<?php

namespace WCKZ\Afterbuy\Extend\Xml;

class Reader extends \Sabre\Xml\Reader
{

    function getClark()
    {
        if(!$this->localName)
        {
            return null;
        }

        return $this->localName;
    }

}