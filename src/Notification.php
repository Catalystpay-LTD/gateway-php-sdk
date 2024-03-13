<?php

namespace CatalystPay;

 
use CatalystPay\Traits\Client\PerformsGET;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Notification - process/validate incoming Async notifications
 * This trait provides different types of Notification using our server-to-server REST .
 */
class Notification
{
    use PerformsPOST, PerformsGET;
 
    /**
     * Store the incoming notification as an data
     *
     */
    private $notificationData;

    /**
     * Initialize the object with notification data
     *
     * @param $data
     *
     */
    public function __construct($data = null)
    {
        if (!is_null($data)) {
            $this->notificationData= $data;
        }
    }

    /**
     * Get the decrypted essage.
     *
     * @param string $data The message data.
     * @return string The response.
     */
    public function getDecryptedMessage()
    {
        $key_from_configuration = "000102030405060708090a0b0c0d0e0f000102030405060708090a0b0c0d0e0f";
        $iv_from_http_header = "000000000000000000000000";
        $auth_tag_from_http_header = "CE573FB7A41AB78E743180DC83FF09BD";
        // $http_body = "0A3471C72D9BE49A8520F79C66BBD9A12FF9";
        $http_body = $this->notificationData;
        $key = hex2bin($key_from_configuration);
        $iv = hex2bin($iv_from_http_header);
        $auth_tag = hex2bin($auth_tag_from_http_header);
        $cipher_text = hex2bin($http_body);
        $response = openssl_decrypt($cipher_text, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $auth_tag);
        return $response;
    }
}
