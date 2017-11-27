<?php

namespace Shippinno\StringCookieJar;

use GuzzleHttp\Cookie\SetCookie;
use PHPUnit\Framework\TestCase;

class StringCookieJarTest extends TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testValidatesCookieFile()
    {
        new StringCookieJar('aaa');
    }

    public function testLoadsFromJsonString()
    {
        $jar = new StringCookieJar;
        $this->assertEquals([], $jar->getIterator()->getArrayCopy());
    }

    public function testPersistsToFile()
    {
        $jar = new StringCookieJar;
        $jar->setCookie(new SetCookie([
            'Name'    => 'foo',
            'Value'   => 'bar',
            'Domain'  => 'foo.com',
            'Expires' => time() + 1000
        ]));
        $jar->setCookie(new SetCookie([
            'Name'    => 'baz',
            'Value'   => 'bar',
            'Domain'  => 'foo.com',
            'Expires' => time() + 1000
        ]));
        $jar->setCookie(new SetCookie([
            'Name'    => 'boo',
            'Value'   => 'bar',
            'Domain'  => 'foo.com',
        ]));
        $this->assertEquals(3, count($jar));

        $this->assertNotEmpty($jar->getJson());
        $json = $jar->getJson();
        unset($jar);

        // Load the cookieJar from the file
        $jar = new StringCookieJar($json);
        $this->assertEquals(2, count($jar));
    }
}
