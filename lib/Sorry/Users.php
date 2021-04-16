<?php


namespace Sorry;


use Sorry\User;

class Users extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "user");
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @return User object if successful, null otherwise.
     */
    public function get($id) {
        $sql =<<<SQL
SELECT * FROM $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function getUsers() {
        $sql =<<<SQL
SELECT id, email, name, role from $this->tableName
ORDER BY name, role
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @return true if $email is an existing email address
     */
    public function exists($email) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }

    public function delete($id) {
        $sql = <<<SQL
DELETE FROM $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute(array($id));
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
    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @return User object if successful, null otherwise.
     */
    public function login($email, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute([$email]);
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }
        return new User($row);
    }


}