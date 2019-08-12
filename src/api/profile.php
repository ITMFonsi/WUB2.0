<?php
	// Content Type JSON
	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');
	
    // Database connection
    $host       = "db774155523.hosting-data.io";
    $username   = "dbo774155523";
    $password   = "Amilo1994!";
    $dbname     = "db774155523";
    $dsn        = "mysql:host=$host;dbname=$dbname;charset=UTF8";
    $options    = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );


	$conn = new PDO($dsn, $username, $password, $options);	
	if ($conn->connect_error) {
		die("Database connection failed!");
	}
	$res = array('error' => false);
	// Read data from database
	$action = 'read';
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
	}
	if ($action == 'read') {
        $sql = "SELECT * FROM `user`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
	}
	// Update data
	if ($action == 'update') {
        $name = $_POST['name'];
		$address = $_POST['address'];
		$country = $_POST['country'];
        $city = $_POST['city'];
        $zip = $_POST['zip'];
		$mail    = $_POST['mail'];
		$phone  = $_POST['phone'];
		$result = $conn->query("UPDATE `user` SET `name`='$name', `mail`='$mail', `phone`='$phone', `address`='$address', `city`='$city', `zip`='$zip', `country`='$country' WHERE `name`='$name'");
		if ($result) {
			$res['message'] = "User updated successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "User update failed!";
 		}
	}

	// Close database connection
	//$conn->close();
	// print json encoded data
	echo json_encode($res);
	die();
?>