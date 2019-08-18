<?php

namespace Jip\Library;

class CsrfToken {

    private $token;

    private $remoteAddr;

    public function getToken() {
        return $this->token;
    }

    public function getRemoteAddr() {
        return $this->remoteAddr;
    }

    public static function create($remoteAddr = null) {
        if (is_null($remoteAddr))
            $remoteAddr = $_SERVER["REMOTE_ADDR"];

        return new CsrfToken($remoteAddr, bin2hex(random_bytes(32)));
    }

    private function __construct($remoteAddr, $token) {
        $this->token = $token;
        $this->remoteAddr = $remoteAddr;
    }

    public function check($token) {
        return ($this->token == $token);
    }
}

?>