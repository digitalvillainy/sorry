<?php


class UserTest extends \PHPUnit\Framework\TestCase
{
    public function test_construct()
    {
        $row = array('id' => 12,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26'
        );
    }
}