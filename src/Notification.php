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
    private $notificationBody ,$iv, $authTag,$keyFromConfiguration;
    
    /**
     * Initialize the object with notification body
     *
     * @param $body
     *
     */
    public function __construct($keyFromConfiguration,$body,$iv,$authTag)
    {
        if (!is_null($body)) {
            $this->keyFromConfiguration= $keyFromConfiguration;
            $this->notificationBody= $body;
            $this->iv= $iv;
            $this->authTag= $authTag;
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
        $iv_from_http_header =  $this->iv;
        $auth_tag_from_http_header =   $this->authTag;
        $http_body = $this->notificationBody;
        $key = hex2bin($this->keyFromConfiguration);
        $iv = hex2bin($iv_from_http_header);
        $auth_tag = hex2bin($auth_tag_from_http_header);
        $cipher_text = hex2bin($http_body);
        $response = openssl_decrypt($cipher_text, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $auth_tag);
        return $response;
    }
}
