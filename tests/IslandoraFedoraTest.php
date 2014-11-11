<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

class IslandoraFedora extends PHPUnit_Framework_TestCase
{
    protected $ini;

    public function setUp()
    {
        $this->ini = parse_ini_file('tests.ini', TRUE);
    }

    public function testFedoraIsReady()
    {
        $client = new Client();
        $response = $client->get($this->ini['Fedora']['url']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testForFedoraResponse()
    {
        $client = new Client();
        $response = $client->get($this->ini['Fedora']['url']);
        // Returned web page's title is "Object Methods HTML Presentation".
        $this->assertRegExp('/Object\sMethods\sHTML\sPresentation/', (string) $response->getBody());
    }
}

