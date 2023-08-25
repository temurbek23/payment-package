<?php

namespace ProgrammeruzPayme\PaymentPackage;

use GuzzleHttp\Client;

class Payment
{

    public function pay($amount, $token)
    {
        if(!$amount){
            return response()->json([
               'message' => "Amount not found",
                'code' => 404
            ]);
        }
        if(!$token){
            return response()->json([
                'message' => "Token not found",
                'code' => 404
            ]);
        }
        $x_auth = env('PAYME_ID');
        $params = [
            'amount' => intval($amount) * 100
        ];
        $responseData = $this->getResponse($params, 'receipts.create', $x_auth);
        $responseData = json_decode($responseData->getBody(), true);
        $id = $responseData['result']['receipt']['_id'];
        $x_auth = env('PAYME_ID') . ":" . env('PAYME_KEY');
        $params = [
            "id" => $id,
            "token" => $token,
        ];
        $responseData = $this->getResponse($params, "receipts.pay", $x_auth);
        return $responseData->getBody();
    }


    public function getResponse($params, $method, $x_auth)
    {
        $url = env('PAYME_URL');

        $headers = [
            'Host' => env('PAYME_HOST'),
            'X-Auth' => $x_auth,
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache',
        ];

        $data = [
            'method' => $method,
            'params' => $params
        ];

        $client = new Client();
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);

        return $response;
    }
}
