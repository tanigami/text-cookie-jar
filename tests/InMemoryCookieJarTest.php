<?php

namespace Shippinno\InMemoryCookieJar;

use GuzzleHttp\Cookie\SetCookie;
use PHPUnit\Framework\TestCase;

class InMemoryCookieJarTest extends TestCase
{
    public function testRawCookiesAreSet()
    {
        $jar = new InMemoryCookieJar([
            "sessionid=38afes7a8; HttpOnly; Domain=example.com; Path=/",
            "id=a3fWa; Domain=example.com; Expires=Wed, 21 Oct 2015 07:28:00 GMT; Secure; HttpOnly",
        ]);
        $this->assertCount(2, $jar);
        $this->assertSame("sessionid=38afes7a8; Domain=example.com; Path=/; HttpOnly", $jar->getIterator()[0]->__toString());
        $this->assertSame("id=a3fWa; Domain=example.com; Path=/; Expires=Wed, 21 Oct 2015 07:28:00 GMT; Secure; HttpOnly", $jar->getIterator()[1]->__toString());
    }

    public function testGuzzleSetCookiesAreSet()
    {
        $jar = new InMemoryCookieJar([
            SetCookie::fromString("sessionid=38afes7a8; HttpOnly; Domain=example.com; Path=/"),
            SetCookie::fromString("id=a3fWa; Domain=example.com; Expires=Wed, 21 Oct 2015 07:28:00 GMT; Secure; HttpOnly"),
        ]);
        $this->assertCount(2, $jar);
        $this->assertSame("sessionid=38afes7a8; Domain=example.com; Path=/; HttpOnly", $jar->getIterator()[0]->__toString());
        $this->assertSame("id=a3fWa; Domain=example.com; Path=/; Expires=Wed, 21 Oct 2015 07:28:00 GMT; Secure; HttpOnly", $jar->getIterator()[1]->__toString());
    }
}
