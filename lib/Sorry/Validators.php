<?php


namespace Sorry;


class Validators extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "validator");
    }

    /**
     * Create a new validator and add it to the table.
     * @param $userid User this validator is for.
     * @return The new validator.
     */
    public function newValidator($userid) {
        $validator = $this->createValidator();

        $sql = <<<SQL
insert into $this->tableName(userid, validator, date)
values(?, ?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute([$userid, $validator, date("Y-m-d H:i:s")]
                ) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $validator;
    }

    /**
     * Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @return Validator string
     */
    public function createValidator($len = 32) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }

    /**
     * Determine if a validator is valid. If it is,
     * return the user ID for that validator.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     */
    public function get($validator) {
        $users = new Users($this->site);

        $sql = <<<SQL
SELECT userid, validator
from $this->tableName
where validator=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));
        if($statement->rowCount() === 0) {
            return null;
        }
        $statementData = $statement->fetch(\PDO::FETCH_ASSOC);
        return $statementData['userid'];
    }

    /**
     * Remove any validators for this user ID.
     * @param $userid The USER ID we are clearing validators for.
     */
    public function remove($userid) {
        $sql = <<<SQL
DELETE FROM $this->tableName
where userid=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute(array($userid));
            if ($ret === false) {
                return false;
            }
        } catch(\PDOException $e) {
            return false;
        }
        //This occurs when there is no record to modify
        if ($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }
}