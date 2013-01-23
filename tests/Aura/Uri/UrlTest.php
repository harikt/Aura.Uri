<?php
namespace Aura\Uri;

use Aura\Uri\Url\Factory as UrlFactory;
use Aura\Uri\Path;
use Aura\Uri\Query;
use Aura\Uri\Host;
use Aura\Uri\PublicSuffixList;

/**
 * Test class for Url.
 * Generated by PHPUnit on 2012-07-21 at 15:46:30.
 */
class UrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Url
     */
    protected $url;
    
    /**
     * @var string Url spec
     */
    protected $spec = 'http://anonymous:guest@example.com/path/to/index.php/foo/bar.xml?baz=dib#anchor';

    /**
     * @var PublicSuffixList Public Suffix List
     */
    protected $publicSuffixList;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->publicSuffixList = new PublicSuffixList(__DIR__ . '/../../_files/public-suffix-list.php');
        $factory = new UrlFactory([]);
        $this->url = $factory->newInstance($this->spec);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function test__construct()
    {
        $url = new Url(
            'http',
            'username',
            'password',
            new Host(
                $this->publicSuffixList,
                [
                'subdomain' => null, 
                'registerableDomain' => 'example.com', 
                'publicSuffix' => 'com'
                ]
            ),
            '80',
            new Path(['foo', 'bar']),
            new Query(['baz' => 'dib', 'zim' => 'gir']),
            'fragment'
        );
        
        $this->assertInstanceOf('Aura\Uri\Url', $url);
    }
    
    /**
     * @covers Aura\Uri\Url::__toString
     */
    public function test__toString()
    {
        $actual = $this->url->__toString();
        $this->assertSame($this->spec, $actual);
    }

    /**
     * @covers Aura\Uri\Url::__get
     */
    public function test__get()
    {
        $expected = [
            'scheme' => 'http',
            'user' => 'anonymous',
            'pass' => 'guest',
            'host' => 'example.com',
            'fragment' => 'anchor'
        ];
        $this->assertEquals($expected['scheme'], $this->url->scheme);
        $this->assertEquals($expected['user'], $this->url->user);
        $this->assertEquals($expected['pass'], $this->url->pass);
        $this->assertEquals($expected['host'], $this->url->host);
        $this->assertEquals($expected['fragment'], $this->url->fragment);
    }

    /**
     * @covers Aura\Uri\Url::get
     */
    public function testGet()
    {
        $actual = $this->url->get();
        $expected = '/path/to/index.php/foo/bar.xml?baz=dib#anchor';
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers Aura\Uri\Url::getFull
     */
    public function testGetFull()
    {
        $actual = $this->url->getFull();
        $this->assertSame($this->spec, $actual);
    }

    /**
     * @covers Aura\Uri\Url::setScheme
     */
    public function testSetScheme()
    {
        $scheme = 'https';
        $this->url->setScheme($scheme);
        $this->assertSame($scheme, $this->url->scheme);
    }

    /**
     * @covers Aura\Uri\Url::setUser
     */
    public function testSetUser()
    {
        $guest = 'guest';
        $this->url->setUser($guest);
        $this->assertSame($guest, $this->url->user);
    }

    /**
     * @covers Aura\Uri\Url::setPass
     */
    public function testSetPass()
    {
        $password = 'password';
        $this->url->setPass($password);
        $this->assertSame($password, $this->url->pass);
    }

    /**
     * @covers Aura\Uri\Url::setHost
     */
    public function testSetHost()
    {
        $host = new Host($this->publicSuffixList);
        $this->url->setHost($host);
        $this->assertSame($host, $this->url->host);
    }

    /**
     * @covers Aura\Uri\Url::setPort
     */
    public function testSetPort()
    {
        $port = '8000';
        $this->url->setPort($port);
        $this->assertSame($port, $this->url->port);
    }

    /**
     * @covers Aura\Uri\Url::setPath
     */
    public function testSetPath()
    {
        $path = new Path();
        $this->url->setPath($path);
        $this->assertSame($path, $this->url->path);
    }

    /**
     * @covers Aura\Uri\Url::setQuery
     */
    public function testSetQuery()
    {
        $query = new Query();
        $this->url->setQuery($query);
        $this->assertSame($query, $this->url->query);
    }

    /**
     * @covers Aura\Uri\Url::setFragment
     */
    public function testSetFragment()
    {
        $fragment = '#hello';
        $this->url->setFragment($fragment);
        $this->assertSame($fragment, $this->url->fragment);
    }
}
