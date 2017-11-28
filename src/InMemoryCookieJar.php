<?php

namespace Shippinno\InMemoryCookieJar;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use InvalidArgumentException;

class InMemoryCookieJar extends CookieJar
{
    /**
     * @param string[]|SetCookie[] $cookieArray
     */
    public function __construct(array $cookieArray = [])
    {
        foreach ($cookieArray as $i => $cookie) {
            if (is_string($cookie)) {
                $cookieArray[$i] = SetCookie::fromString($cookie);
            }
            if (!($cookieArray[$i] instanceof SetCookie)) {
                throw new InvalidArgumentException('Cookies must be string or SetCookie');
            }
        }
        parent::__construct(true, $cookieArray);
    }
}
