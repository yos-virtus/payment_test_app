<?php 

namespace App\Payments\Common;

interface PaymentProviderGatewayInterface
{
    /**
     * Initialize gateway with parameters
     */
    public function initialize(array $params);

    /**
     * Get pyment service display name
     */
    public function getProviderName();

    /**
     * Get payment service key
     */
    public function getProviderKey();

    /**
     * User id 
     * 
     * @return int
     */
    public function getUserId();

    /**
     * Aamount of funds to be recharged
     * 
     * @return float
     */
    public function getSumm();

    /**
     * Hash summ
     * 
     * @return string
     */
    public function getHash();

    /**
     * Hash summ
     * 
     * @return string
     */
    public function getResponseUrl();

    /**
     * Check hash summ
     * 
     * @return boolean
     */
    public function isCorrectHashSumm();

    /**
     * Check hash summ
     * 
     * @return boolean
     */
    public function check();

    /**
     * Response to provider server
     * 
     * @param  mixed
     */
    public function response($type);
}