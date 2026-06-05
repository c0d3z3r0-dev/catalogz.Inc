<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaynowService
{
    protected $integrationId;
    protected $integrationKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->integrationId = config('services.paynow.id');
        $this->integrationKey = config('services.paynow.key');
        $this->baseUrl = 'https://www.paynow.co.zw/interface/';
    }

    /**
     * Initiate a payment.
     *
     * @param float $amount
     * @param string $reference
     * @param string $customerPhone
     * @param string $returnUrl
     * @param string $resultUrl
     * @return array
     */
    public function initiate($amount, $reference, $customerPhone, $returnUrl, $resultUrl)
    {
        $response = Http::post($this->baseUrl . 'initiatetransaction', [
            'id' => $this->integrationId,
            'key' => $this->integrationKey,
            'amount' => $amount,
            'reference' => $reference,
            'returnurl' => $returnUrl,
            'resulturl' => $resultUrl,
            'mobile' => $customerPhone, // for USSD push
            'authemail' => '',
        ]);

        $data = $this->parseResponse($response->body());

        return $data;
    }

    /**
     * Parse Paynow response string.
     *
     * @param string $response
     * @return array
     */
    private function parseResponse($response)
    {
        $result = [];
        $lines = explode("\n", $response);
        foreach ($lines as $line) {
            $parts = explode('=', $line);
            if (count($parts) == 2) {
                $result[strtolower(trim($parts[0]))] = trim($parts[1]);
            }
        }
        return $result;
    }

    /**
     * Check payment status via poll URL.
     *
     * @param string $pollUrl
     * @return array
     */
    public function pollTransaction($pollUrl)
    {
        $response = Http::get($pollUrl);
        return $this->parseResponse($response->body());
    }
}
