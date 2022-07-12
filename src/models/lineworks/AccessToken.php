<?php

declare(strict_types=1);

namespace Models\lineworks;

require '../vendor/autoload.php';

use Models\Env;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * AccessToken class
 * LineWorksAPI2.0で使用するAccessTokenを取得するクラス
 * Firebase/php-jwtでJWT電子署名を作成し、GuzzleHttpでAccessTokenを取得する
 */
class AccessToken {
    private $currentTime;
    public function getAccessToken() {
        $this->currentTime = time();
        return $this->requestAccessToken();
    }
    private function requestAccessToken(): array {
        $signature = $this->generateSignature();
        $option = [
            "headers" => [
                "Content-Type" => "application/x-www-form-urlencoded"
            ],
            "form_params" => [
                "assertion" => $signature,
                "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
                "client_id" => Env::get("ClientID"),
                "client_secret" => Env::get("ClientSecret"),
                "scope" => "bot,user.read"
            ],
            "http_errors" => false,
            "verify" => false
        ];
        try {
            $client = new Client();
            $accessTokenUrl = "https://auth.worksmobile.com/oauth2/v2.0/token";
            $response = $client->request("POST", $accessTokenUrl, $option);
            if ($response->getStatusCode() === 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                return $result;
            }
        } catch (ClientException $e) {
            return $e;
        }
        return array();
    }
    private function generateSignature(): string {
        $privateKey = file_exists(Env::get("PrivateKeyPath")) ? file_get_contents(Env::get("PrivateKeyPath")) : null;
        $payload = [
            "iss" => Env::get("ClientID"),
            "sub" => Env::get("ServiceAccount"),
            "iat" => $this->currentTime,
            "exp" => $this->currentTime + 3600
        ];
        $signature = JWT::encode($payload, $privateKey, "RS256");
        return $signature;
    }
}
