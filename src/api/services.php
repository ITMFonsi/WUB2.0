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
        $sql = "SELECT * FROM `services`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
	}
	// Insert data into database
	if ($action == 'create') {
        $id = $_POST['id'];
        $service = $_POST['service'];
		$amount = $_POST['amount'];
        $date = $_POST['date'];
        $price = $_POST['price'];
		$result = $conn->query("INSERT INTO `services` (`service`, `amount`, `date`, `price`) VALUES('$service', '$amount', '$date', '$price')");
		if ($result) {
			$res['message'] = "Service added successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Service insert failed!";
		}
	}
	// Update data
	if ($action == 'update') {
        $id = $_POST['id'];
        $service = $_POST['service'];
		$amount = $_POST['amount'];
        $date = $_POST['date'];
        $price = $_POST['price'];
		$result = $conn->query("UPDATE `services` SET `service`='$service', `amount`='$amount', `date`='$date', `price`='$price' WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "Service updated successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Service update failed!";
 		}
	}
	// Delete data
	if ($action == 'delete') {
		$id = $_POST['id'];
		$result = $conn->query("DELETE FROM `services` WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "Service deleted successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Service deletion failed!";
		}
	}
	// Close database connection
	//$conn->close();
	// print json encoded data
	echo json_encode($res);
	die();
?>