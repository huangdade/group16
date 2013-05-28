<html>
<head>
	<title>search result</title>
</head>
<body>
<?php
try {
	$conn = new PDO("sqlsrv:server = tcp:jzcdokmf78.database.windows.net,1433; Database = goods_search_system", "common", "A0\/!a6609dsq");
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch ( PDOException $e ) {
	print( "Error connecting to SQL Server." );
	die(print_r($e));
}
$sql = "select * from shop";
?>
<table>
	<tr>
		<th>id</th>
		<th>name</th>
		<th>address</th>
	</tr>
	<?php
foreach($conn->query($sql) as $row)
{
	?>
	<tr>
		<td><?= $row['id'] ?></td>
		<td><?= $row['name'] ?></td>
		<td><?= $row['address'] ?></td>
	</tr>
	<?php
}

$conn = null;
?>
</body>
</html>
