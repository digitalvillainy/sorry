<?php

class EmailMock extends Sorry\Email {
    public function mail($to, $subject, $message, $headers)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public $to;
    public $subject;
    public $message;
    public $headers;
}

class UsersTest extends \PHPUnit\Framework\TestCase
{
    private static $site;

    public static function setUpBeforeClass()
    {
        self::$site = new Sorry\Site();
        $localize = require 'localize.inc.php';
        if (is_callable($localize)) {
            $localize(self::$site);
        }
    }



    protected function setUp()
    {
        $users = new Sorry\Users(self::$site);
        $tableName = $users->getTableName();

        //Delete from the test table and insert new data.
        $sql = <<<SQL
delete from $tableName;
SQL;

        self::$site->pdo()->query($sql);
        $sql = <<<SQL
delete from $tableName;
insert into $tableName(id, email,  password, joined, salt, name)
values (7, "dudess@dude.com", "87654321", "2015-01-22 23:50:26", 
         "Nohp6^v\$m(`qm#\$o", "Dudess, The"),(8, "cbowen@cse.msu.edu", "super477","2015-01-01 23:50:26","aeLWK6k`jzPpgZMi","Owen, Charles" )
SQL;

        self::$site->pdo()->query($sql);
    }
    public function test_construct() {
        $session = array();	// Fake session
        $root = self::$site->getRoot();

        // Valid staff login
        $controller = new Sorry\LoginController(self::$site, $session,
            array("email" => "cbowen@cse.msu.edu", "password" => "super477"));

        $this->assertEquals("Owen, Charles", $session[Sorry\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/openingScreen.php", $controller->getRedirect());

        /*// Valid client login
        $controller = new Sorry\LoginController(self::$site, $session,
            array("email" => "bart@bartman.com", "password" => "bart477"));

        $this->assertEquals("Simpson, Bart", $session[Sorry\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/openingScreen.php", $controller->getRedirect());

        // Invalid login
        $controller = new Sorry\LoginController(self::$site, $session,
            array("email" => "bart@bartman.com", "password" => "wrongpassword"));

        $this->assertNull($session[Sorry\User::SESSION_NAME]);
        $this->assertEquals("$root/login.php?e", $controller->getRedirect());*/
    }

}
