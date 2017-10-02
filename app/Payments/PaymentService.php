<?php 

namespace App\Payments;

class PaymentService
{
    /**
     * Payment seevice gateway
     * 
     * @var App\Payments\Common\AbstractPaymentProviderGateway
     */
    protected $paymentProvider;

    public function __construct($paymentProviderRoute, $data)
    {
        if ($paymentProviderRoute == 'test1') {
            $this->paymentProvider = new PaymentProvider1Gateway($data);
        } elseif ($paymentProviderRoute == 'asdgOasds') {
            $this->paymentProvider = new PaymentProvider2Gateway($data);
        } else {
            throw new \Exception("Неизвестный провайдер");
        }
    }

    public function __call($name, $params) 
    {
        $usedParamsString =  $this->paramsToString($params);

        // \Log::useDailyFiles(storage_path().'/logs/payments.log');
        
        \Log::info('Вызван метод '. $name . ' с параметрами ' . $usedParamsString);

        return call_user_func_array(array($this->paymentProvider, $name), $params);
    }

    /**
     * Convert array of params to redable stirng  string
     * 
     * @param  array
     * @return string
     */
    private function paramsToString($params)
    {
        $usedParamsString = '';
        foreach ($params as $key => $value) {
            $usedParamsString .= $key . '=' . $value . ', ';
        }
        return $usedParamsString;
    }
}