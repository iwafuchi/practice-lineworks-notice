<?php

declare(strict_types=1);

namespace Models\lineworks;

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
        return $this->currentTime;
    }
}
