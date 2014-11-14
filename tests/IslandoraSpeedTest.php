<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

class IslandoraSpeed extends PHPUnit_Framework_TestCase
{
    protected $ini;
    protected $speed_ini;

    public function setUp()
    {
        $this->ini = parse_ini_file('tests.ini', TRUE);
        // We use a test-specific .ini file here in addition to the general one.
        $this->speed_ini = parse_ini_file('speedtest.ini', TRUE);
    }

    /*
     * If testForFedoraRindexResponse fails, there's no point in running this one.
     * @depends testForFedoraRindexResponse
     */
    public function testTimeToDownloadCollectionPages()
    {
        $client = new Client();
        $ri_response = $client->get($this->ini['Fedora']['rindex_url']);
        // Get the response body, which should contain a list of collection PIDs
        // beginning with 'info:'.
        $collection_pids = preg_split('/$\R?^/m', (string) $ri_response->getBody());
        $total_time = 0;
        // Loop through the collection PIDs and time how long it takes to download
        // the collection page.
        foreach ($collection_pids as $pid) {
          if (preg_match('/^info:/', $pid)) {
            $pid = preg_replace('/info:fedora\//', '', trim($pid));
            // Construct the URL to the collection identified by the current $pid.
            $collection_url = $this->ini['Drupal']['host'] .'/islandora/object/' . $pid;
            $time_start = microtime(true);
            $collection_response = $client->get($collection_url);
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            // Add the time taken to download the current page to the running total.
            $total_time = $total_time + $time;
          }
        }
        // Fail if $total_time is greater than the baseline time (i.e., performance is
        // worse than baseline).
        $this->assertLessThanOrEqual($this->speed_ini['Timer']['baseline'], $total_time);
    }
}

