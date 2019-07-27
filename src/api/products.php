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
        $sql = "SELECT * FROM `products`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
	}
	// Insert data into database
	if ($action == 'create') {
        $product_nr = $_POST['product_nr'];
        $name = $_POST['name'];
		$price = $_POST['price'];
        $description = $_POST['description'];
        
		$result = $conn->query("INSERT INTO `products` (`product_nr`, `name`, `price`, `description`) VALUES('$product_nr', '$name', '$price', '$description')");
		if ($result) {
			$res['message'] = "Product added successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Product insert failed!";
		}
	}
	// Update data
	if ($action == 'update') {
		$id       = $_POST['id'];
        $product_nr = $_POST['product_nr'];
        $name = $_POST['name'];
		$price = $_POST['price'];
        $description = $_POST['description'];

		$result = $conn->query("UPDATE `products` SET `product_nr`='$product_nr', `name`='$name', `price`='$price', `description`='$description' WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "Product updated successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Product update failed!";
 		}
	}
	// Delete data
	if ($action == 'delete') {
		$id = $_POST['id'];
		$result = $conn->query("DELETE FROM `products` WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "Product deleted successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Product deletion failed!";
		}
	}
	// Close database connection
	//$conn->close();
	// print json encoded data
	echo json_encode($res);
	die();
?>