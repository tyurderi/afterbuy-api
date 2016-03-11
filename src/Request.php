<?php

namespace WCKZ\Afterbuy;

class Request
{

    protected $api         = null;

    protected $callName    = '';

    protected $data        = array();

    protected $detailLevel = 0;

    protected $error       = '';

    protected $result      = '';

    public function __construct(AfterbuyAPI $api, $callName, $data = array(), $detailLevel = 0)
    {
        $this->api         = $api;
        $this->callName    = $callName;
        $this->data        = $data;
        $this->detailLevel = $detailLevel;
    }

    public function clear()
    {
        $this->data = array();
    }

    public function update($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function send()
    {
        $this->result   = array();
        $requestContent = $this->getRequestContent();
        if(!$requestContent)
        {
            return false;
        }

        $response = \Requests::post($this->api->getApiUrl(), array(), $requestContent);

        if(!$response)
        {
            $this->error = sprintf('Request failed');
            return false;
        }

        $parser = new \Nathanmac\Utilities\Parser\Parser();
        $xml    = $parser->xml($response->body);

        if(!$this->requestSucceed($xml))
        {
            $this->error = sprintf('The xml request returned an invalid call status.');
            return false;
        }

        $this->result = $xml;

        return true;
    }

    protected function getRequestContent()
    {
        $requestBody = $this->getRequestBody($this->callName, $this->data);
        if(!$requestBody)
        {
            $this->error = sprintf('CallName %s not found.', $this->callName);
            return false;
        }

        $templateVariables = array(
            'userId'            => $this->api->getAuth()->getUserId(),
            'userPassword'      => $this->api->getAuth()->getUserPassword(),
            'partnerId'         => $this->api->getAuth()->getPartnerId(),
            'partnerPassword'   => $this->api->getAuth()->getPartnerPassword(),

            'callName'          => $this->callName,
            'detailLevel'       => $this->detailLevel,
            'requestBody'       => $requestBody
        );

        return $this->api->getTemplate()->render('header.twig', $templateVariables);
    }

    protected function requestSucceed($xml)
    {
        return $xml['CallStatus'] === 'Success';
    }

    protected function getRequestBody($callName, $data = array())
    {
        $templateName = 'functions/' . $callName . '.twig';
        if($this->api->getTemplate()->exists($templateName))
        {
            return $this->api->getTemplate()->render($templateName, $data);
        }

        return false;
    }

    public function getError()
    {
        return $this->error;
    }

    public function hasError()
    {
        return !empty($this->error);
    }

    public function getResponse()
    {
        return $this->result;
    }

    public function success()
    {
        return empty($this->error) && !empty($this->result);
    }

}