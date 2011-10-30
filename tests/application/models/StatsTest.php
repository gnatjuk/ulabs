<?php

/**
 * Description of Stats
 *
 * @author Slavik
 */
require_once '../application/models/Stats.php';

class StatsTest extends ControllerTestCase {

    protected $stats;

    public function setUp() {
        parent::setUp();

        $this->stats = new Stats();
    }

    public function testCanDoUnitTest() {
        $this->assertTrue(true);
    }

    public function testCanAddCountry() {
        $testCountry = 'Canada';
        $this->stats->addCountry($testCountry);
        $this->assertEquals(1, count($this->stats->getCountries()));

        foreach ($this->stats->getCountries() as $country) {
            if ($country == $testCountry) {
                $this->assertEquals($country, $testCountry);
            }
        }
        $this->assertEquals(1, count($this->stats->getCountries()));
    }

}

?>
