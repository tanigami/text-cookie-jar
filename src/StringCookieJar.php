<?php

namespace Shippinno\StringCookieJar;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use RuntimeException;

class StringCookieJar extends CookieJar
{

    public function __construct($cookieJson = '', $storeSessionCookies = false)
    {
        parent::__construct();
        $this->storeSessionCookies = $storeSessionCookies;
        $this->load($cookieJson);
    }

    public function getJson()
    {
        $json = [];
        foreach ($this as $cookie) {
            /** @var SetCookie $cookie */
            if (CookieJar::shouldPersist($cookie)) {
                $json[] = $cookie->toArray();
            }
        }

        return \GuzzleHttp\json_encode($json);
    }

    /**
     * @param string $json
     */
    public function load(string $json): void
    {
        if ($json === '') {
            return;
        }
        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new \RuntimeException(sprintf("Invalid cookie JSON: %s", $json));
        }
        foreach ($data as $cookie) {
            $this->setCookie(new SetCookie($cookie));
        }
    }
}
