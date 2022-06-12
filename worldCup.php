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
        public function getBoardList(string $type='live') :array
        {
            try {
                $sql = 'CALL get_board_list(:type)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':type',$type);
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

        public function InsertFinishTime(INT $id,$matchEndDate)
        {
            $sql = 'UPDATE `matches` SET `matchEndDate`=:matchEndDate WHERE `id` = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':matchEndDate',$matchEndDate);
            $stmt->execute();
            return true;
        }

        public function DeleteFromLiveBoard(INT $matchID )
        {
            $sql = 'DELETE FROM `live_score_board` WHERE 1=1 AND `matchID` = :matchID';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':matchID',$matchID);
            $stmt->execute();
            return true; 
        }

        public function InsertmatchFinalResults(INT $teamAscore = 0,INT $teamBscore = 0,INT $matchID ){
            $sql = 'INSERT INTO  `finish_score_board`(`matchID`, `teamAscore`, `teamBscore`) 
            SELECT :matchID, :teamAscore, :teamBscore WHERE NOT EXISTS (SELECT 1 FROM finish_score_board WHERE matchID = :matchID2)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':teamAscore',$teamAscore);
            $stmt->bindParam(':teamBscore',$teamBscore);
            $stmt->bindParam(':matchID',$matchID);
            $stmt->bindParam(':matchID2',$matchID);
            $res = $stmt->execute();
            if($res){
                $this->DeleteFromLiveBoard($matchID);
            }
            return true; 
        }
        
    }

?>