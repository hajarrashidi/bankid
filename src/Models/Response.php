<?php

namespace BankID\Models;

use Psr\Http\Message\ResponseInterface;

class Response
{
    public function __construct(ResponseInterface $response = null)
    {
        $this->hydrate($response);
    }

    /**
     * Populate the object with data from HTTP ResponseInterface->getBody()->getContents()
     *
     * @param ResponseInterface|null $response
     * @return void
     */
    public function hydrate(?ResponseInterface $response): void
    {
        if ($response) {
            $responseBody = $response->getBody()->getContents();
            $responseArray = json_decode($responseBody, true);

            foreach ($responseArray as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}