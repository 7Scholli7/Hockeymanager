<?php
include_once 'config/config.php';
include 'content/session.php';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// form response

// change user team
if(isset($_POST["team_id"])) {
	$stmt = $con->prepare('UPDATE User SET dream_team_id = ? WHERE id = ?');
	$stmt->bind_param('ii', $_POST['team_id'], $_SESSION['id']);
	$stmt->execute();

    header('Location: home.php');
}

// get data from database

// get all teams from database
$stmt = $con->prepare('SELECT * FROM Team');
$stmt->execute();
$result = $stmt->get_result();
while($team = $result->fetch_array()) {
	$teams[] = $team;
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Team selection</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="register">
			<h1>Choose your dream team</h1>
			<form method="POST" action="">
                <select name="team_id" onchange="this.form.submit()">
                    <?php foreach($teams as $team) {?>
                        <option value="<?=$team['id']?>"><?=$team['name']?></option>
                    <?php } ?>
                </select>
            </form>
		</div>
	</body>
</html>