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
        $this->generateSignature();
        return $this->currentTime;
    }
    private function requestAccessToken(): array {
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
