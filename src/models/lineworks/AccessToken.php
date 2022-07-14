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
        $accessToken = [];
        if (isset($_SESSION["access_token"]) && isset($_SESSION["access_token_expires"])) {
            //access_tokenの有効期限内ならばアクセストークンを返す
            if ($_SESSION["access_token_expires"] > $this->currentTime) {
                return $_SESSION["access_token"];
            }
            $accessToken = $this->fetchRefreshToken();
        } else {
            $accessToken = $this->fetchAccessToken();
        }
        $_SESSION["access_token"] = $accessToken["access_token"];
        $_SESSION["refresh_token"] = $accessToken["refresh_token"];
        //Lineworksのaccess_tokenの有効期限は発行時点から24時間
        $_SESSION["access_token_expires"] = $this->currentTime + $accessToken["expires_in"];
        //Lineworksのrefresh_tokenの有効期限が発行時点から90日
        $_SESSION["refresh_token_expires"] = $this->currentTime + (3600 * 24 * 90);
        return $_SESSION["access_token"];
        return $this->fetchAccessToken()["access_token"];
    }
    /**
     * fetchAccessToken function
     * Lineworksのaccess-tokenを発行する
     * @return array
     */
    private function fetchAccessToken(): array {
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
    }
    /**
     * fetchRefreshToken function
     * Lineworksのアクセストークンをリフレッシュする
     * @return array
     */
    private function fetchRefreshToken(): array {
        $option = [
            "headers" => [
                "Content-Type" => "application/x-www-form-urlencoded"
            ],
            "form_params" => [
                "refresh_token" => $_SESSION["refresh_token"],
                "grant_type" => "refresh_token",
                "client_id" => Env::get("ClientID"),
                "client_secret" => Env::get("ClientSecret"),
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
