<html>
<head>
	<title>search result</title>
</head>
<body>
<?php

$key = $_POST['key'];
/*init all sqls*/
$goods_kinds[0] = "cooltea";
$goods_kinds[1] = "haircut";
$sqls_id[$goods_kinds[0]] = "select t.id from cooltea t where t.name like N'%" . $key . "%' or t.branch like N'%" . $key . "%' or t.description like N'" . $key . "%';";
$sqls_id[$goods_kinds[1]] = "select h.id from haircut h where h.type like N'%" . $key . "%';";

/* to add more ... */

?>
<?php
/* connect to database */
try {
	$conn = new PDO("sqlsrv:server = tcp:jzcdokmf78.database.windows.net,1433; Database = goods_search_system", "common", "A0\/!a6609dsq");
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch ( PDOException $e ) {
	print( "Error connecting to SQL Server." );
	die(print_r($e));
}
/* end of connection */

/* get id of goods and shop */
foreach($goods_kinds as $goods_kind)
{
	



/* display result in table */
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
