<?php

namespace Shippinno\InMemoryCookieJar;

use GuzzleHttp\Cookie\SetCookie;
use PHPUnit\Framework\TestCase;

class InMemoryCookieJarTest extends TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testValidatesCookieFile()
    {
        new InMemoryCookieJar('aaa');
    }

    public function testLoadsFromJsonString()
    {
        $jar = new InMemoryCookieJar;
        $this->assertEquals([], $jar->getIterator()->getArrayCopy());
    }

    public function testPersistsToFile()
    {
        $jar = new InMemoryCookieJar;
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
        $jar = new InMemoryCookieJar($json);
        $this->assertEquals(2, count($jar));
    }
}
