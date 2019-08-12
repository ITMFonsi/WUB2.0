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
        $sql = "SELECT * FROM `invoice`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
	}
	// Insert data into database
	if ($action == 'create') {
        $invoice_nr = $_POST['invoice_nr'];
		$customer = $_POST['customer'];
		$customerID = $_POST['customerID'];
        $date = $_POST['date'];
        $open = $_POST['open'];
		$total    = $_POST['total'];
        $product1   = $_POST['product1'];
        $product2   = $_POST['product2'];
        $product3   = $_POST['product3'];
        $product4   = $_POST['product4'];
        $product5   = $_POST['product5'];
        $product6   = $_POST['product6'];
        $product7   = $_POST['product7'];
        $product8   = $_POST['product8'];
        $product9   = $_POST['product9'];
        $product10   = $_POST['product10'];

        $result = $conn->query("INSERT INTO `invoice` (`invoice_nr`, `customer`, `customerID`, `date`,`open`, `total`, `product1`, `product2`, `product3`, `product4`, `product5`, `product6`, `product7`, `product8`, `product9`, `product10`) VALUES('$invoice_nr', '$customer', '$customerID', '$date', '$open', '$total', '$product1', '$product2', '$product3', '$product4', '$product5', '$product6', '$product7', '$product8', '$product9', '$product10')");
		if ($result) {
			$res['message'] = "Invoice added successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Invoice insert failed!";
		}
	}
	// Update data
	if ($action == 'update') {
		$id       = $_POST['id'];
        $invoice_nr = $_POST['invoice_nr'];
		$customer = $_POST['customer'];
		$customerID = $_POST['customerID'];
        $date = $_POST['date'];
        $open = $_POST['open'];
		$total    = $_POST['total'];
        $product1   = $_POST['product1'];
        $product2   = $_POST['product2'];
        $product3   = $_POST['product3'];
        $product4   = $_POST['product4'];
        $product5   = $_POST['product5'];
        $product6   = $_POST['product6'];
        $product7   = $_POST['product7'];
        $product8   = $_POST['product8'];
        $product9   = $_POST['product9'];
        $product10   = $_POST['product10'];

		$result = $conn->query("UPDATE `invoice` SET `invoice_nr`='$invoice_nr', `customer`='$customer', `customerID`='$customerID', `date`='$date', `open`='$open', `total`='$total', `product1`='$product1', `product2`='$product2', `product3`='$product3', `product4`='$product4', `product5`='$product5', `product6`='$product6', `product7`='$product7', `product8`='$product8', `product9`='$product9', `product10`='$product10' WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "Invoice updated successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Invoice update failed!";
 		}
	}
	// Delete data
	if ($action == 'delete') {
		$id = $_POST['id'];
		$result = $conn->query("DELETE FROM `invoice` WHERE `id`='$id'");
		if ($result) {
			$res['message'] = "Invoice deleted successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Invoice deletion failed!";
		}
    }
    	// Delete data
	if ($action == 'customerByRevenue') {
        $sql = "SELECT * FROM `invoice` order by total desc limit 5";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
    }
        	// Delete data
	if ($action == 'sumRevenue') {
        $sql = "SELECT sum(total) FROM `invoice`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
    }        	
    // Delete data
	if ($action == 'invoicesByDate') {
        $sql = "SELECT * FROM `invoice` order by date desc limit 5";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
	}
	    // Delete data
		if ($action == 'yearlyRevenue') {
			$sql = "select 
			sum(CASE WHEN date like '%%%%-01-%%' THEN `total` ELSE 0 END) as jan,
			sum(CASE WHEN date like '%%%%-02-%%' THEN `total` ELSE 0 END) as feb,
			sum(CASE WHEN date like '%%%%-03-%%' THEN `total` ELSE 0 END) as mar,
			sum(CASE WHEN date like '%%%%-04-%%' THEN `total` ELSE 0 END) as apr,
			sum(CASE WHEN date like '%%%%-05-%%' THEN `total` ELSE 0 END) as may,
			sum(CASE WHEN date like '%%%%-06-%%' THEN `total` ELSE 0 END) as jun,
			sum(CASE WHEN date like '%%%%-07-%%' THEN `total` ELSE 0 END) as jul,
			sum(CASE WHEN date like '%%%%-08-%%' THEN `total` ELSE 0 END) as aug,
			sum(CASE WHEN date like '%%%%-09-%%' THEN `total` ELSE 0 END) as sep,
			sum(CASE WHEN date like '%%%%-10-%%' THEN `total` ELSE 0 END) as oct,
			sum(CASE WHEN date like '%%%%-11-%%' THEN `total` ELSE 0 END) as nov,
			sum(CASE WHEN date like '%%%%-12-%%' THEN `total` ELSE 0 END) as dez
			from invoice";
			$statement = $conn->prepare($sql);
			$statement->execute();
			$res = $statement->fetchAll();
		}
	// Close database connection
	//$conn->close();
	// print json encoded data
	echo json_encode($res);
	die();
?>