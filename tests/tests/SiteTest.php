<?php


class SiteTest extends \PHPUnit\Framework\TestCase
{
    public function test_getSetEmail() {
        $site = new Sorry\Site();
        $site->setEmail("paulBlart@hotmail.com");
        self::assertEquals("paulBlart@hotmail.com", $site->getEmail());
    }

    public function test_getSetRoot() {
        $site = new Sorry\Site();
        $site->setRoot("rootLoops/");
        self::assertEquals("rootLoops/", $site->getRoot());
    }

    public function test_getTablePrefix() {
        $site = new \Sorry\Site();
        $site->dbConfigure("Daedalus", "jcd", "bionicman", "unatco");
        self::assertEquals("unatco", $site->getTablePrefix());
    }

    public function test_localize() {
        $site = new Sorry\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize($site);
        }
        $this->assertEquals('testp2_', $site->getTablePrefix());
    }
}