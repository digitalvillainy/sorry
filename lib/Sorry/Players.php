<?php


namespace Sorry;


class Players extends Table {
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "player");
    }

    /**
     * Get a player based on the id
     * @param $id ID of the player
     * @return User object if successful, null otherwise.
     */
    public function get($id) {
        $sql = <<<SQL
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

    public function update(Player $player) {

    }

    //Get all players associated with a specific game
    public function getPlayers(Game $game) {
        //Get game id
        //Get all players with that game id
    }

    public function add(User $user) {
        //Get user id
        //Get game id (or create a game?)
        //Assign a color
        //Add
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
}