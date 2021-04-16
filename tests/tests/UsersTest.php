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

    public function test_pdo()
    {
        $users = new Sorry\Users(self::$site);
        $this->assertInstanceOf('\PDO', $users->pdo());
    }

    protected function setUp()
    {

        $users = new Sorry\Users(self::$site);
        $tableName = $users->getTableName();

        $sql = <<<SQL
delete from $tableName;
insert into $tableName(id, email, password, joined, salt, name)
values (7, "dudess@dude.com", 
        "7d1e8f00c0720e0df4432d4f799663b5cba14ed9b6f99e5a2d3a6894ac590dd4", 
        "2015-01-22 23:50:26",  "`FBqrfBP@(nQ~W^!", "Dudess, The"),
        (8, "cbowen@cse.msu.edu", 
        "14831e3f21b423a557a0aa99a391a57a2400ef0fdade328890c9048ad3a8ab6a", 
        "2015-01-01 23:50:26", "aeLWK6k`jzPpgZMi", "Owen, Charles")
SQL;

        self::$site->pdo()->query($sql);
    }

    public function test_login() {
        $users = new Sorry\Users(self::$site);

        // Test a valid login based on email address
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertInstanceOf('Sorry\User', $user);



        // Test a failed login
        $user = $users->login("dudess@dude.com", "wrongpw");
        $this->assertNull($user);
    }
    public function test_exists() {
        $users = new Sorry\Users(self::$site);

        $this->assertTrue($users->exists("dudess@dude.com"));
        $this->assertFalse($users->exists("dudess"));
        $this->assertFalse($users->exists("cbowen"));
        $this->assertTrue($users->exists("cbowen@cse.msu.edu"));
        $this->assertFalse($users->exists("nobody"));
        $this->assertFalse($users->exists("7"));
    }
}
