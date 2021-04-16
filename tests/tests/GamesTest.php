<?php


class GamesTest extends \PHPUnit\Framework\TestCase
{
    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Sorry\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    protected function setUp() {
        $games = new Sorry\Games(self::$site);
        $gamesTable = $games->getTableName();

        $players = new Sorry\Players(self::$site);
        $usersTable = $players->getTableName();

        //Clear then fill table with test data
        $sql = <<<SQL
delete from $gamesTable;
SQL;

        self::$site->pdo()->query($sql);
    }
}