<?php

namespace TY\Afterbuy;

class AfterbuyAPI
{

    const API_URL = 'https://api.afterbuy.de/afterbuy/ABInterface.aspx';

    protected $auth     = null;

    protected $template = null;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
        $this->template = new Template(__DIR__ . '/../views/');
    }

    public function createRequest($callName, $data = array(), $detailLevel = 0)
    {
        return new Request($this, $callName, $data, $detailLevel);
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getApiUrl()
    {
        return self::API_URL;
    }

}