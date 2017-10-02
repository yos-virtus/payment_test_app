<?php

namespace App\Payments\Common;

use App\Exceptions\IncorrectHashSummException;
use App\User;

abstract class AbstractPaymentProviderGateway
{
    /**
     * Secret key
     * 
     * @var string
     */
    protected $providerKey;

    /**
     * Payment service provider name
     * 
     * @var string
     */
    protected $name;

    /**
     * Response url 
     * 
     * @var string
     */
    protected $url;

    /**
     * Valid get request fields
     * 
     * @var 
     */
    protected $validProviderDataKeys;

    /**
     * 
     */
    protected $isTestMode = false;

    /**
     * Get provider name
     * 
     * @return string
     */
    public function getProviderName()
    {
        return $this->name;
    }

    /**
     * Get provider name
     * 
     * @return string
     */
    public function getProviderKey()
    {
        return $this->providerKey;
    }

    /**
     * Get user id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get amount of funds to recharge
     * 
     * @return float
     */
    public function getSumm()
    {
        return $this->summ;
    }

    /**
     * Get hash summ
     * 
     * @return string
     */
    public function getHash()
    {
        return $this->hashSumm;
    }

    /**
     * Rsponse url
     * 
     * @return string
     */
    public function getResponseUrl()
    {
        return $this->isTestMode ? 'http://httpbin.org/post' : $this->url;
    }

    /**
     * Rsponse url
     * 
     * @return string
     */
    public function setTestMode()
    {
        $this->isTestMode = true;
    }

    /**
     * Rsponse url
     * 
     * @return string
     */
    public function setProductionMode()
    {
        $this->isTestMode = false;
    }

    /**
     * Check hash summ
     * 
     * @return boolean
     */
    public function isCorrectHashSumm()
    {
        return $this->hashSumm === md5($this->getUserId() . $this->getSumm() . $this->getProviderKey());
    }

    /**
     * Check recived data for recharging a balance
     * 
     * @return 
     */
    public function check()
    {
        if (! $this->isCorrectHashSumm()) {
            throw new IncorrectHashSummException("Некорректная хеш сумма!");
        }

        return $this;
    }

    /**
     * Update user balance
     *
     * @return void
     */
    public function updateUserBalance()
    {
        $user = User::find($this->getUserId())
            ->updateBalance($this->getSumm());

        return $this;
    }

    /**
     * Response to provider server
     * 
     * @param  mixed
     */
    abstract public function response($type);

    abstract public function initialize(array $data);
}