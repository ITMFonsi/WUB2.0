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
        $sql = "SELECT * FROM `customers`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
	}
	// Insert data into database
	if ($action == 'create') {
        $name = $_POST['name'];
		$address = $_POST['address'];
		$country = $_POST['country'];
        $city = $_POST['city'];
        $zip = $_POST['zip'];
		$mail    = $_POST['mail'];
		$phone1   = $_POST['phone1'];
		$result = $conn->query("INSERT INTO `customers` (`name`, `mail`, `phone1`, `address`,`zip`, `city`, `country`) VALUES('$name', '$mail', '$phone1', '$address', '$zip', '$city', '$country')");
		if ($result) {
			$res['message'] = "Customer added successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Customer insert failed!";
		}
	}
	// Update data
	if ($action == 'update') {
		$id       = $_POST['id'];
        $name = $_POST['name'];
		$address = $_POST['address'];
		$country = $_POST['country'];
        $city = $_POST['city'];
        $zip = $_POST['zip'];
		$mail    = $_POST['mail'];
		$phone1   = $_POST['phone1'];
		$result = $conn->query("UPDATE `customers` SET `name`='$name', `mail`='$mail', `phone1`='$phone1', `address`='$address', `city`='$city', `zip`='$zip', `country`='$country' WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "Customer updated successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Customer update failed!";
 		}
	}
	// Delete data
	if ($action == 'delete') {
		$id = $_POST['id'];
		$result = $conn->query("DELETE FROM `customers` WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "User deleted successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "User deletion failed!";
		}
	}
	// Close database connection
	//$conn->close();
	// print json encoded data
	echo json_encode($res);
	die();
?>