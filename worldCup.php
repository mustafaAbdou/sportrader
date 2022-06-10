<?php

    class worldCup
    {
        private $servername = "localhost";
        private $username   = "root";
        private $password   = "";
        private $database   = "football_word_cup";
        public  $conn;


        // // ============================Database Connection ==========================
        public function __construct()
        {

            try {

                $this->conn = new PDO("mysql:host=$this->servername;dbname=".$this->database, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch(PDOException $e) {

                echo "Connection failed: " . $e->getMessage();
            }
        }
        // ============================fetching live score==========================
        public function liveBoardView() :array
        {
            try {
                $sql = 'SELECT
                live_score_board.matchID,
                lega_stage.scope,
                (SELECT name FROM teams WHERE 1=1 AND teams.id = matches.teamA) AS teamA,
                (SELECT name FROM teams WHERE 1=1 AND teams.id = matches.teamB) AS teamB,
                live_score_board.teamAscore,
                live_score_board.teamBscore,
                live_score_board.matchResault,
                matches.matchStartDate,
                matches.matchEndDate
            FROM
                `live_score_board`
            INNER JOIN matches ON matches.id = live_score_board.matchID
            INNER JOIN lega_stage ON matches.scopeLegaStage = lega_stage.id
            WHERE
                1=1 ORDER BY matches.matchStartDate';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                // set the resulting array to associative
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return (array) $result;

              } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
              }
              $conn = null;
              echo "</table>";
        }
    }

?>