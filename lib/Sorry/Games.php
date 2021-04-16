<?php


namespace Sorry;


class Games extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "game");
    }

    /**
     * Gets a game by id
     * @param $id int The game id
     * @return Game The game that matches the id
     */
    public function get($id) {
        //Get players attached to the game
        //Get the game by its id.
        //Return a game object using the discovered data.
    }

    /**
     * Function to insert a new game
     * @param $state The JSON of the game state
     * @param $status char The status of the game. 'O' for ongoing, 'C' for closed
     * @return null
     */
    public function insert($state, $status) {
        $sql = <<<SQL
insert into $this->tableName(state, status)
values(?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            //Start the status out as 'O' by default
            if($statement->execute([$state, $status]) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    /**
     * Get all games and their associated players
     */
    public function getGames() {
        //Get the players table
        //Run the SQL between the two tables to get the data
        $games = [];
        //Return the games
    }

    public function update(Game $game) {
        //NOTE: We'll need to add some db stuff
        //to the game class for this to work

        //Update the game in the database using SQL
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