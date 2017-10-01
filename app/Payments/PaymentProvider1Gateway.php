<?php 

namespace App\Payments;

use Illuminate\Http\Request;
use App\Payments\Common\DataIntegrityCheckerTrait;
use App\Payments\Common\AbstractPaymentProviderGateway;

class PaymentProvider1Gateway extends AbstractPaymentProviderGateway 
{
    use DataIntegrityCheckerTrait;

    /**
     * Secret key
     * 
     * @var string
     */
    protected $providerKey = "SomeRandomKeyForProvider1";

    /**
     * Payment service provider name
     * 
     * @var string
     */
    protected $name = 'Provider 1 Payment Service';

    /**
     * Response url 
     * 
     * @var string
     */
    protected $url = 'http://payment.dev:85/provider1';

    /**
     * Valid get request fields
     * 
     * @var 
     */
    protected $validProviderDataKeys = ['a', 'b', 'md5'];

    /**
     * Create a new gateway instance
     *
     * @param Client          $httpClient  A HTTP client to make API calls with
     * @param HttpRequest     $httpRequest A Symfony HTTP request object
     */
    public function __construct(array $data = [])
    {
        $this->httpClient = new \GuzzleHttp\Client();

        if (! empty($data)) {
            $this->initialize($data);
        }
    }

    /**
     * Initialize recieved  user/payment data
     * 
     * @param  array
     * @return App\Payments\PaymentProvider1Gateway
     */
    public function initialize(array $data)
    {
        $this->checkDataForIntegrity($data);

        $this->userId = $data['a'];
        $this->summ = $data['b'];
        $this->hashSumm = $data['md5'];

        return $this;
    }

    public function response($type)
    {
        $xmlString = "<?xml version='1.0' standalone='yes'?>";

        if ($type === "Success") {
            
            $xmlString .= "<answer>1</answer>";
            $answerXml = simplexml_load_string($xmlString);
        }

        if ($type === "Error") {
            $xmlString .= "<answer>0</answer>";
            $answerXml = simplexml_load_string($xmlString);
        }

        $this->httpClient->request( 'POST', 
            $this->getResponseUrl(),
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $answerXml);
    }
}