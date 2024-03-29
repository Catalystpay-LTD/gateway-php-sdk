<?php

namespace CatalystPay\Traits\Client;

use CatalystPay\CatalystPayResponse;
use CatalystPay\Exceptions\CatalystPayException;

/**
 * Trait for handling HTTP GET requests.
 */
trait PerformsGET
{
    /**
     * Sends an HTTP GET request to the specified URL.
     *
     * @param string $url   The URL to send the request to.
     * @param bool   $isProduction  The mode to set if true in production.
     * @param string $token The Authorization token to send the request to.
     *
     * @return array The decoded JSON response.
     *
     * @throws \Exception If an error occurs during the request.
     */
    private static function doGET($url, $isProduction, $token)
    {
        // Initialize a new cURL session
        $ch = curl_init();

        // Set the URL to send the request to
        curl_setopt($ch, CURLOPT_URL, $url);

        // Return the response instead of outputting it directly
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set SSL verification based on the mode (true for production, false for testing)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $isProduction);

        // Set the Authorization header with the provided token
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token
        ]);

        // Execute the cURL session and store the response
        $response = curl_exec($ch);

        // Check if an error occurred during the request
        if ($response === false) {
            // Throw an exception with the error message
            throw new CatalystPayException(
                curl_error($ch),
                400
            );
        }

        // Close the cURL session
        curl_close($ch);

        // return $response;

        // Handle Response 
        $CatalystPayResponse = new CatalystPayResponse();
        $CatalystPayResponse->fromApiResponse($response);
        //print_r($CatalystPayResponse->getResultCode());
        // exit;
        return $CatalystPayResponse;
    }
}
