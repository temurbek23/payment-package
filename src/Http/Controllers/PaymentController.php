<?php

namespace Programmeruz\PaymentPackage\Http\Controller;

use App\Http\ValidatorResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @OA\Post (
     *      path="/api/payment",
     *      tags={"Payment"},
     *      operationId="pay",
     *      summary="Payment",
     *      security={{"bearerAuth":{}}},
     *      description="Payment",
     *      @OA\RequestBody(required=true,description="Create",
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object",
     *                  required={"token", "amount"},
     *                  @OA\Property(property="token", type="string", format="text", example="64e75b0cf9bc0a7975b80879_vHMdnszx5CpQO6quDtT2nIbx6ie1JgQIQAZbwQtUxdqbyYrXmtePX8q6dMRGSKueNupCMdrpmOISmrZM54d7rT0iutQq7hWRRJO2Q2ar2Ww4NYpr4S2EK3WhNqsQSkDUIsPHcSDvUPEYaJpbqYSZ75TqTkji3PbHMVphx4G0KtE2VKvVUAudOuoIq737BbZ8HjYwjJWP5rPjG4yab9wICS7bfFV8wu8mPXVvGg2xeS5YTNIZueCKQvwYyC1A6OTvq8CfEWvRrVUYH5hQHRHHjJuKfakSthIm126ISg8AVRUAk1mbhSXNnyW7p0aWuwzspXTithtYcXPdZOt4BHZrQGjwotY94OJ06Ya4UGyGodoBiHZuVa3THidmJaQgqatwzIGNJk"),
     *                  @OA\Property(property="amount", type="integer", format="int", example="50000"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=404,description="Error responses",
     *         @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */

    public function payment(Request $request)
    {
        $rules = [
            'amount' => 'required|integer',
            'token' => 'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json([
                'message' => $validator->response,
                'code' => 400
            ]);
        }

        $x_auth = env('PAYME_ID');
        $params = [
            'amount' => 5000
        ];
        $responseData = $this->getResponse($params, 'receipts.create', $x_auth);
        $responseData = json_decode($responseData->getBody(), true);
        $id = $responseData['result']['receipt']['_id'];
        $x_auth = env('PAYME_ID') . ":" . env('PAYME_KEY');
        $params = [
            "id" => $id,
            "token" => $request->token,
        ];
        $responseData = $this->getResponse($params, "receipts.pay", $x_auth);
        return $responseData->getBody();

    }


    public function getResponse($data, $method, $x_auth)
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
            'params' => $data,
        ];

        $client = new Client();
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);

        return $response;
    }
}
