<?php

namespace WCKZ\Afterbuy;

class Authentication
{

    protected $userId          = '';

    protected $userPassword    = '';

    protected $partnerId       = '';

    protected $partnerPassword = '';

    public function __construct($userId, $userPassword, $partnerId, $partnerPassword)
    {
        $this->userId          = $userId;
        $this->userPassword    = $userPassword;
        $this->partnerId       = $partnerId;
        $this->partnerPassword = $partnerPassword;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getUserPassword()
    {
        return $this->userPassword;
    }

    public function getPartnerId()
    {
        return $this->partnerId;
    }

    public function getPartnerPassword()
    {
        return $this->partnerPassword;
    }

}