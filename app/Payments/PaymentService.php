<?php 

namespace App\Payments;

class PaymentService
{
    /**
     * Payment seevice gateway
     * 
     * @var [type]
     */
    protected $paymentProvider;

    public function __construct($paymentProviderRoute, $request)
    {
        $data = $request->all();
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
        
        \Log::info('Вызван метод '. $name . ' с параметрами ' . $usedParamsString);

        return call_user_func_array(array($this->paymentProvider, $name), $params);
    }

    private function paramsToString($params)
    {
        $usedParamsString = '';
        foreach ($params as $key => $value) {
            $usedParamsString .= $key . '=' . $value . ', ';
        }
        return $usedParamsString;
    }
    
}