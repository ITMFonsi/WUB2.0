<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>WUBS - Christoph Wüstenhagen</title>
		<link rel="stylesheet" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link rel="license" href="http://www.opensource.org/licenses/mit-license/">
		<script src="script.js"></script>
	</head>
	<body>
		<header>
		<img alt="" width="175" height="75" src="logo.jpg">
			<address>
				<p>Christoph Wüstenhagen</p>
				<p>Austraße 27<br>6800 Feldkirch, Österreich</p>
				<p>+43 699 103 698 84</p>
			</address>
		</header>
		<article>
			<h1>Recipient</h1>
			<address contenteditable>
			<?php foreach ($result as $row) { ?>
				<p><?php echo $row['firstname'] ?> <?php echo $row['lastname'] ?></p>
				<p><?php echo $row['address'] ?></p>
				<p><?php echo $row['zip'] ?> <?php echo $row['city'] ?></p>
				<p><?php echo $row['country'] ?></p>
			<?php } ?>
			</address>
			<table class="meta">
				<tr>
					<th><span>Rechnungsnr.</span></th>
					<td><span contenteditable><?php echo $_GET["invoice_nr"]; ?></span></td>
				</tr>
				<tr>
					<th><span>Rechnungsdatum</span></th>
					<td><span contenteditable><?php echo $today; ?></span></td>
				</tr>
				<tr>
					<th><span>Fälligkeitsdatum</span></th>
					<td><span id="prefix" contenteditable><?php echo $dateInTwoWeeks; ?></span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span>Beschreibung</span></th>
						<th><span>Anzahl</span></th>
						<th><span>Einzelpreis (Netto)</span></th>
						<th><span>Rabatt %</span></th>
						<th><span>Summe</span></th>
					</tr>
				</thead>
				<tbody id="table">
				<?php foreach ($product_arr as $arr) { ?>
					<tr>
						<td><?php echo $arr[0]; ?></span></td>
						<td><?php echo $arr[1]; ?> Stück</span></td>
						<td></span></td>
						<td><?php echo $arr[2]; ?> %</td>
						<td><?php echo $arr[3]; ?> €</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th>Zwischensumme</th>
					<td><?php echo $total; ?> €</td>
				</tr>
				<tr>
					<th>USt. (20%)</th>
					<td><?php echo $differenceUST; ?> €</td>
				</tr>
				<tr>
					<th>Bruttosumme in Euro</th>
					<td><?php echo $total_with_tax; ?> €</td>
				</tr>
			</table>
		</article>
		<aside>
			<h1>Zahlungsinformationen</h1>	
			<address contenteditable>
				<p>Kontoinhaber: Christoph Wüstenhagen</p>
				<p>Bank: Sparkasse der Stadt Feldkirch</p> 
				<p>IBAN-Nummer: AT20 2060 4031 0184 3260</p> 
				<p>BIC Code: SPFKAT2BXXX</p> 
				<p>Verwendungszweck: Rechnungsnummer <?php echo $_GET["invoice_nr"]; ?></p> 
			</address>
			<p align="right">Vielen Dank für Ihren Einkauf!</p>
			<p align="right">Christoph Wüstenhagen</p>
		</aside>
	</body>
</html>
