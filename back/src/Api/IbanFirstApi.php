<?php

namespace App\Api;

use App\Exception\IbanFirstApiException;
use App\Utils\FilterArrayTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class IbanFirstApi
{ 
    use FilterArrayTrait;

    private $client;
    private $apiIbanFirstUrl;
    private $headerAuthentification;

    public function __construct(
        string $apiIbanFirstUrl,
        string $apiIbanFirsLogin,
        string $apiIbanFirstPass,
        HttpClientInterface $client
    )
    {
        $this->client = $client;
        $this->apiIbanFirstUrl = $apiIbanFirstUrl;
        $this->headerAuthentification($apiIbanFirsLogin, $apiIbanFirstPass);
    }

    public function wallets() : array
    {
        $response = $this->client->request(
            'GET',
            $this->apiIbanFirstUrl . '/wallets/',
            $this->headerAuthentification
        );

        $this->validatorResponse($response);

        return $response->toArray();
    }

    public function financialMovements(string $walletId) : array
    {
        $financialMovements = $this->requestFinancialMovement();
        $walletFinancialMovements = $this->filterFinancialMovementsByWallet($financialMovements, $walletId);

        return $walletFinancialMovements;
    }

    /**
     * @Cache(expires="tomorrow", public=true)
     */
    private function requestFinancialMovement()
    {
        $response = $this->client->request(
            'GET',
            $this->apiIbanFirstUrl . '/financialMovements/',
            $this->headerAuthentification,
        );

        $this->validatorResponse($response);
        return $response->toArray()['financialMovements'];
    }

    /**
     * check if no error api
     *
     * @param [type] $response
     * @throw  IbanFirstApiException
     * @return boolean true if succes
     */
    private function validatorResponse($response) : bool
    {
        if(!$response)
            throw new IbanFirstApiException('Problem for get wallets with oban first api', 400);
        return true;
    }

    private function headerAuthentification(string $username, string $password) : array
    {
        $nonce = '';
        $chars = "0123456789abcdef";
        for ($i = 0; $i < 32; $i++) {
            $nonce .= $chars[rand(0, 15)];
        }
        $nonce64 = base64_encode($nonce) ;

        // Getting the date at the right format (e.g. YYYY-MM-DDTHH:MM:SSZ)
        $date = gmdate('c');
        $date = substr($date,0,19)."Z" ;

        // Getting the password digest
        $digest = base64_encode(sha1($nonce.$date.$password, true));

        // Getting the X-WSSE header to put in your request
        $this->headerAuthentification['headers']['X-WSSE'] = sprintf('UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',$username, $digest, $nonce64, $date);
        return $this->headerAuthentification;
    }
}