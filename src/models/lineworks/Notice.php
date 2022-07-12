<?php

declare(strict_types=1);

namespace Models\lineworks;

use Models\lineworks\AccessToken;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Notice class
 */
class Notice {
    /**
     * notifyMessage function
     * 引数で受け取ったuseIdに対しメッセージを送信する
     * @param [string] $userId
     * @param [string] $message
     * @return void
     */
    public function notifyMessage($userId, $message) {
        $accessToken = (function () {
            $accessToken = new AccessToken();
            return $accessToken->getAccessToken();
        })();
        if (!$accessToken) {
            return "Invalid Access Token";
        }
        return $this->fetchMessage($accessToken, $userId, $message);
    }
    /**
     * fetchMessage function
     * メッセージをBOTへ通知する
     * @param [array] $accessToken
     * @param [string] $userId
     * @param [string] $message
     * @return void
     */
    private function fetchMessage($accessToken, $userId, $message) {
        $botId = "3817986";
        $userMessageApi = "https://www.worksapis.com/v1.0/bots/${botId}/users/${userId}/messages";
        $headers = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . $accessToken['access_token'],
        ];
        $palyload = [
            "content" => [
                "type" => "text",
                "text" => $message
            ]
        ];
        try {
            $client = new Client();
            $response = $client->request("POST", $userMessageApi, [
                "headers" => $headers,
                "json" => $palyload,
                "http_errors" => false,
                "verify" => false,
            ]);
            if ($response->getStatusCode() === 201) {
                http_response_code($response->getStatusCode());
                return "success";
            } else {
                http_response_code($response->getStatusCode());
                return $response->getBody()->getContents();
            }
        } catch (ClientException $e) {
            return $e;
        }
    }
}
