<?php

/**
 * TODO: example
 */

namespace BankID\v_6_0;

use BankID\Models\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Bankid_6_0_dev
{
    private Client $guzzleClient;
    private const API_BASE_URL = 'https://appapi2.test.bankid.com/rp/v6.0/';

    public function __construct(array $guzzleOptions = [])
    {
        $this->guzzleClient = new Client($guzzleOptions);
    }

    public function auth(array $authOptions)
    {
        return $this->request("auth", $authOptions);
    }

    public function collect(string $orderRef)
    {
        return $this->request("collect", ['orderRef' => $orderRef]);
    }

    public function cancel(string $orderRef)
    {
        return $this->request("cancel", ['orderRef' => $orderRef]);
    }

    private function request(string $method, array $parameters)
    {
        $guzzleOptions = [
            'body' => json_encode($parameters),
        ];

        try {
            $response = $this->guzzleClient->post(
                (self::API_BASE_URL . $method),
                $guzzleOptions
            );
        } catch (ClientException $e) {
            return new ErrorResponse($e->getResponse());
        }

        return new Response($response);
    }

    public function getQrCode(string $qrStartToken, int $elapsedTime, string $qrStartSecret): string
    {
        return sprintf(
            'bankid.%s.%d.%s',
            $qrStartToken,
            $elapsedTime,
            hash_hmac('sha256', $elapsedTime, $qrStartSecret)
        );
    }

    public function getAppLink(string $autostarttoken): string
    {
        return sprintf('bankid:///?autostarttoken=%s', $autostarttoken);
    }

}