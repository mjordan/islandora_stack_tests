<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

class IslandoraDrupal extends PHPUnit_Framework_TestCase
{
    protected $ini;

    public function setUp()
    {
        $this->ini = parse_ini_file('tests.ini', TRUE);
    }

    public function testDrupalIsReady()
    {
        $client = new Client();
        $response = $client->get($this->ini['Drupal']['host']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testForStringInFrontPage()
    {
        $client = new Client();
        $response = $client->get($this->ini['Drupal']['host']);
        $this->assertRegExp('/Audio/', (string) $response->getBody());
    }
}

