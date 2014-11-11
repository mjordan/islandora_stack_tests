<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

class IslandoraSolr extends PHPUnit_Framework_TestCase
{
    protected $ini;

    public function setUp()
    {
        $this->ini = parse_ini_file('tests.ini', TRUE);
    }

    public function testSolrIsReady()
    {
        $client = new Client();
        $response = $client->get($this->ini['Solr']['url']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testForSolrResponse()
    {
        $client = new Client();
        $response = $client->get($this->ini['Solr']['url']);
        $data = $response->json();
        $this->assertArrayHasKey('responseHeader', $data);
    }
}

