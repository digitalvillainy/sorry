<?php


namespace Sorry;


class User
{
    const SESSION_NAME = 'user';
    private $id;
    private $email;
    private $name;
    private $joined;

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->joined = strtotime($row['joined']);
    }
}