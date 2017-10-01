<?php 

namespace App\Payments;

use Illuminate\Http\Request;
use App\Payments\Common\DataIntegrityCheckerTrait;
use App\Payments\Common\AbstractPaymentProviderGateway;

class PaymentProvider2Gateway extends AbstractPaymentProviderGateway
{
    use DataIntegrityCheckerTrait;

    /**
     * Secret key
     * 
     * @var string
     */
    protected $providerKey = "SomeRandomKeyForProvider2";

    /**
     * Payment service provider name
     * 
     * @var string
     */
    protected $name = 'Provider 2 Payment Service';

    /**
     * Response url 
     * 
     * @var string
     */
    protected $url = 'https://provider2.dev';

    /**
     * Valid get request fields
     * 
     * @var 
     */
    protected $validProviderDataKeys = ['x', 'y', 'md5'];

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

        $this->userId = $data['x'];
        $this->summ = $data['y'];
        $this->hashSumm = $data['md5'];

        return $this;
    }

    public function response($type)
    {
        if ($type === "Success") {
            $answerText = 'Ok';
        }

        if ($type === "Error") {
            $answerText = 'Error';
        }

        $this->httpClient->request( 'POST', 
            $this->getResponseUrl(),
            ['Content-Type' => 'text/plain; charset=UTF8'],
            $answerText);
    }
}