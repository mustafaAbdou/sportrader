<?php require_once'worldCup.php';?>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// ====================================create an object================================================= 
$obj = new worldCup();



    if  (isset($_GET['board'])) {

        if  ($_GET['board'] !== 'live') {

            $matchList = $obj->getBoardList('finished');

        }else{

            $matchList = $obj->getBoardList('live');
        }
    }else{

        header('location: index.php?board=live');
    }

    for ($i=0; $i <count($matchList) ; $i++) {
            // ============================================ change datetime format =====================================================
        $timeStamp = strtotime($matchList[$i]['matchStartDate']);
        $datetime = date("Y-m-d", $timeStamp);
        $matchListNewArray[$datetime][]  = $matchList[$i];
    }
       // ============================================Get winner =====================================================
    function getWinner($myarray, $mykey) {

        foreach ($myarray as $key => $value) {

            if (is_array($value)) {

                getWinner($value, $mykey);

            }else {
                
                if ($key === $mykey) {
                    return $value.' WON';
                }
            }
        }

};
if (isset($_POST['update'])) {
    $obj->InsertFinishTime($_POST['matchID'],$_POST['matchEndDate']);
    $obj->InsertmatchFinalResults($_POST['teamAscore'],$_POST['teamBscore'],$_POST['matchID']);
    header('location: index.php?board=finished');
}
if (isset($_GET['gamestatus']) && $_GET['gamestatus'] =='finished') {
    $obj->InsertFinishTime($_GET['matchID'],$_GET['finishedate']);
    $obj->InsertmatchFinalResults($_GET['teamAscore'],$_GET['teamBscore'],$_GET['matchID']);
    header('location: index.php?board=finished');
}

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>world Cup</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Hello, world Cup 2022!</h1>
			</div>
            <div class="col-md-12">
				<hr>
			</div>
                    <!-- show and hide boards -->
            <div class="col-md-12" align="center">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="Live" id="btnradio1" autocomplete="off" <?=($_GET['board']=='live')?'checked':'unchecked';?>>
                        <a href="index.php?board=live" class="btn btn-outline-primary" for="btnradio1">Live</a>

                        <input type="radio" class="btn-check" name="finished" id="btnradio2" autocomplete="off" <?=($_GET['board']=='finished')?'checked':'unchecked';?>>
                        <a href="index.php?board=finished" class="btn btn-outline-primary" for="btnradio2">finished</a>
                    </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
                <div class="col-md-12" align="center">
                    <?php if(count($matchList)>0) { ?>
                        <?php foreach ($matchListNewArray as $key => $value) { ?>
                            <table class="table">
                                <thead class="thead-light">
                                    <tr align="center">
                                        <th colspan="8">
                                            <?=$key;?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>matchID</th>
                                        <th>teamA</th>
                                        <th>teamB</th>
                                        <th>matchResault</th>
                                        <th>matchStartDate</th>
                                        <th>Stage</th>
                                        <th>status</th>
                                        <th>Aktion</th>
                                    </tr>
                                </thead>
                                <?php foreach ($value as $k => $v) { 
                                    
                                    if(empty(getWinner($v, $v['matchResault']))){    

                                        $winner = $v['matchResault'];

                                    }else{
                                        $winner = getWinner($v, $v['matchResault']);   
                                        
                                    }
                                    
                                    
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?=$v['matchID']?></td>
                                            <td><?=$v['teamA']?>
                                            <td><?=$v['teamB']?></td>
                                            <?php if (!is_null($v['matchEndDate'])) { ?>
                                    
                                                <td>
                                                    <b class="text-success">
                                                        <?= $winner;?>  
                                                    </b>
                                                </td>
                                            <?php }else{ ?>
                                                <td>
                                                    <b class="text-dark">
                                                        <?= $v['teamAscore']?>  - <?= $v['teamBscore']?>  
                                                    </b>
                                                </td>

                                            <?php }?>

                                            <td><?=$v['matchStartDate']?></td>
                                            <td><?=$v['scope']?></td>
                                            <td><?= $v['game_status']?></td>
                                            <td>
                                                <!-- ---------------------------------------------show more btn------------------------------- -->
                                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample<?=$v['matchID']?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                                <!-- ---------------------------------------------Edit btn------------------------------- -->
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?=$v['matchID']?>" <?= ($_GET['board']=='live')?'':"disabled"?>>
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <!-------------------------------- modal -------------------------------------------->
                                                <div class="modal fade" id="staticBackdrop<?=$v['matchID']?>" data-bs-backdrop="static" data-bs-keyboard="false"
                                                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">matchID <?=$v['matchID']?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" align="center">
                                                                <h3>Changing match score</h3>
                                                                <form class="row" action="index.php?board=finished" method="POST">
                                                                    <div class="col-md-6">
                                                                        <label for="teamA" class="form-label"><?=$v['teamA']?> score</label>
                                                                        <input type="text" class="form-control" name="teamAscore" id="teamAscore" value="<?= $v['teamAscore']?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="teamB" class="form-label"><?=$v['teamB']?> score</label>
                                                                        <input type="text" class="form-control" name="teamBscore" id="teamBscore" value="<?= $v['teamBscore']?>">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="matchEndDate" class="form-label">MatchEndDate</label>
                                                                        <input type="text" class="form-control" name="matchEndDate" id="matchEndDate" value="<?=date("Y-m-d H:i:s")?>">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <hr>
                                                                        <input type="hidden" class="form-control" id="matchID" name="matchID" value="<?=$v['matchID']?>">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                                                                        <input type="submit" name="update" class="btn btn-primary" value="Save changes">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                            <!-- ---------------------------------------------finishe match without changing------------------------------- -->
                                            <a title="finish" href="index.php?board=finished&gamestatus=finished&finishedate=<?= date("Y-m-d H:i:s")?>&matchID=<?=$v['matchID']?>&teamAscore=<?=$v['teamAscore']?>&teamBscore=<?=$v['teamBscore']?>">
                                            <button type="button" class="btn btn-success" <?= ($_GET['board']=='live')?'':"disabled"?> > <i class="bi bi-alarm"></i></button>
                                            </a>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td></td>
                                            <td colspan="6" >
                                                <div class="collapse ml-20" id="collapseExample<?=$v['matchID']?>" >
                                                    <table class="table">
                                                        <thead>
                                                            <tr align="center">
                                                            <th colspan="4">Home Team - Away Team</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr align="center">
                                                                <td colspan="4"><?=$v['teamA']?> - <?=$v['teamB']?></td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td colspan="4"><?=$v['teamAscore']?> - <?=$v['teamBscore']?></td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td colspan="4"><?=$v['place']?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                <?php  } ?>
                            </table>
                        <?php  } ?>
                <?php  }else{ ?>
                    <div class="col-md-12">
                        <hr>
                       No match found
                    </div>
                <?php } ?>
			    </div>
            </div> <!--  row -->
        </div><!--  container -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
	</script>
</body>

</html>

