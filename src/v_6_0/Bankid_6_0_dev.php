<?php

/**
 * TODO: example
 */

namespace BankID\v_6_0;

use BankID\Models\ErrorResponse;
use BankID\Models\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Bankid_6_0_dev
{
    private $guzzleClient;
    private const API_BASE_URL = 'https://appapi2.test.bankid.com/rp/v6.0/';

    public function __construct(array $guzzleOptions = [])
    {
        $this->guzzleClient = new Client($guzzleOptions);
    }

    /**
     * @param array $authParameters [ 'endUserIp' => "127.0.0.1" ]
     * @return ErrorResponse|Response
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/graenssnittsbeskrivning/auth
     */
    public function auth(array $authParameters)
    {
        return $this->request("auth", $authParameters);
    }

    /**
     * @param array $signParameters
     * [ 'endUserIp' => "127.0.0.1", 'userVisibleData' => base64_encode("hello") ]
     * @return ErrorResponse|Response
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/graenssnittsbeskrivning/sign
     */
    public function sign(array $signParameters)
    {
        return $this->request("sign", $signParameters);
    }

    /**
     * @param array $phoneAuthParameters
     * [ 'personalNumber' => "199603235789", "callInitiator" => "user"]
     * @return ErrorResponse|Response
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/graenssnittsbeskrivning/phone-auth
     */
    public function phoneAuth(array $phoneAuthParameters)
    {
        return $this->request("phone/auth", $phoneAuthParameters);
    }

    /**
     * @param array $phoneSignParameters
     * [ 'personalNumber' => "199605245894", "userVisibleData" => base64_encode("hello"), "callInitiator" => "user"]
     * @return ErrorResponse|Response
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/graenssnittsbeskrivning/phone-sign
     */
    public function phoneSign(array $phoneSignParameters)
    {
        return $this->request("phone/sign", $phoneSignParameters);
    }

    /**
     * @param string $orderRef
     * @return ErrorResponse|Response
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/graenssnittsbeskrivning/collect
     */
    public function collect(string $orderRef)
    {
        return $this->request("collect", ['orderRef' => $orderRef]);
    }

    /**
     * @param string $orderRef
     * @return ErrorResponse|Response
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/graenssnittsbeskrivning/cancel
     */
    public function cancel(string $orderRef)
    {
        return $this->request("cancel", ['orderRef' => $orderRef]);
    }

    /**
     * @param string $bankidMethod
     * @param array $parameters
     * @return ErrorResponse|Response
     */
    private function request(string $bankidMethod, array $parameters)
    {
        $guzzleOptions = [
            'body' => json_encode($parameters),
        ];

        try {
            $response = $this->guzzleClient->post(
                (self::API_BASE_URL . $bankidMethod),
                $guzzleOptions
            );
        } catch (ClientException $e) {
            return new ErrorResponse($e->getResponse());
        }

        return new Response($response);
    }

    /**
     * @param string $qrStartToken
     * @param int $elapsedTime
     * @param string $qrStartSecret
     * @return string
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/qrkoder
     */
    public function getQrCode(string $qrStartToken, int $elapsedTime, string $qrStartSecret): string
    {
        return sprintf(
            'bankid.%s.%d.%s',
            $qrStartToken,
            $elapsedTime,
            hash_hmac('sha256', $elapsedTime, $qrStartSecret)
        );
    }

    /**
     * @param string $autostarttoken
     * @return string
     * @link https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/programstart
     */
    public function getAppLink(string $autostarttoken): string
    {
        return sprintf('bankid:///?autostarttoken=%s', $autostarttoken);
    }

}