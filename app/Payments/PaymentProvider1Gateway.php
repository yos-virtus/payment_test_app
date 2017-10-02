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
    protected $url = 'http://httpbin.kkorg/post';

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

        $this->initialize($data);
    }

    /**
     * Initialize recieved  user/payment data
     * 
     * @param  array
     * @return App\Payments\PaymentProvider1Gateway
     */
    public function initialize(array $data)
    {
        if (! empty($data)) {
            $this->checkDataForIntegrity($data);
        }

        $this->userId = $data['a'] ?? null;
        $this->summ = $data['b'] ?? null;
        $this->hashSumm = $data['md5'] ?? null;

        return $this;
    }

    /**
     * Response to provider server
     * 
     * @param  string
     * @return Guzzle\HttpResponse
     */
    public function response($type)
    {
        $xml = new \SimpleXMLElement("<answer></answer>");

        if ($type === "Success") {
            $xml[0] = 1;
        }

        if ($type === "Error") {
            $xml[0] = 0;
        }

        return $this->httpClient->request( 'POST', 
            $this->getResponseUrl(),
            [
                'Content-Type' => 'text/xml; charset=UTF8',
                'body' => $xml->asXml()
            ]);
    }
}