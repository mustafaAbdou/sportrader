<?php require_once'worldCup.php';?>
<?php

$obj = new worldCup();
$matchList = $obj->liveBoardView();

for ($i=0; $i <count($matchList) ; $i++) { 
    $matchListNewArray[$matchList[$i]['matchStartDate']][]  = $matchList[$i];
}


$keys = array_keys($matchListNewArray);
print_r($matchListNewArray);
print_r($keys);
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bootstrap demo</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
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
                <div class="col-md-12">
                    <?php for ($i=0; $i <count($keys) ; $i++) { ?>
                        <table class="table">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th colspan="6">
                                        <?=$keys[$i];?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>matchID</th>
                                    <th>teamA</th>
                                    <th>teamB</th>
                                    <th>matchResault</th>
                                    <th>matchStartDate</th>
                                    <th>Aktion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td><?=$matchListNewArray[$keys[$i]][$i]['matchID']?></td>
                                <td><?=$matchListNewArray[$keys[$i]][$i]['teamA']?></td>
                                <td><?=$matchListNewArray[$keys[$i]][$i]['teamB']?></td>
                                <td><?=$matchListNewArray[$keys[$i]][$i]['matchResault']?></td>
                                <td><?=$matchListNewArray[$keys[$i]][$i]['matchStartDate']?></td>
                                <td>24</td>
                                </tr>
                            </tbody>
                        </table>
                    <?php }?>
			    </div>
            </div> <!--  row -->
        </div><!--  container -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
	</script>
</body>

</html>