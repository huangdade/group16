<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>search result</title>
	<meta http-equiv="charset" content="utf-8"/>
	<link rel="stylesheet" type="text/css" href="css/search.css" />
</head>
<body>
<?php
/* get key word */
$key = $_POST['key'];
?>
<form action="search.php" method="POST">
	<input type="text" name="key" value="<?= $key ?>"/>
	<input type="submit" value="search" />
</form>
<hr />
<?php
function searchcooltea($conn, $key)
{
	$sql = "select c.name as name, c.branch as branch, sh.name as shop, sh.address as address, s.price as price, s.unit as unit
		from store s
			left join cooltea c on s.goods = c.id
			left join shop sh on s.shop = sh.id
		where c.name like N'%" . $key . "%' or
			c.branch like N'%" . $key . "%' or
			c.description like N'%" . $key . "%';";
	return $conn->query($sql);
}

function searchhaircut($conn, $key)
{
	$sql = "select h.type as name, sh.name as shop, sh.address as address, s.price as price
		from store s
			left join haircut h on s.goods = h.id
			left join shop sh on s.shop = sh.id
		where h.type like N'%" . $key . "%';";
	return $conn->query($sql);
}

function dispcooltea($rows)
{
	?>
	<h2>凉茶</h2>
	<?php
	if (empty($rows))
	{
		?>
		<p>没有找到相关记录</p>
		<?php
	}
	else
	{
		?>
		<table>
			<tr>
				<th>名称</th>
				<th>品牌</th>
				<th>商店</th>
				<th>价格</th>
				<th>地址</th>
			</tr>
		<?php
		foreach ($rows as $row)
		{
			?>
			<tr>
				<td><?= $row['name'] ?></td>
				<td><?= $row['branch'] ?></td>
				<td><?= $row['shop'] ?></td>
			<?php
			if (empty($row['unit']))
			{
				?>
				<td><?= $row['price'] ?>元</td>
				<?php
			}
			else
			{
				?>
				<td><?= $row['price'] ?>元/<?= $row['unit'] ?></td>
				<?php
			}
				?>
				<td><?= $row['address'] ?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
}

function disphaircut($rows)
{
	?>
	<h2>理发</h2>
	<?php
	if (empty($rows))
	{
		?>
		<p>没有找到相关记录</p>
		<?php
	}
	else
	{
		?>
		<table>
			<tr>
				<th>名称</th>
				<th>商店</th>
				<th>价格</th>
				<th>地址</th>
			</tr>
		<?php
		foreach($rows as $row)
		{
			?>
			<tr>
				<td><?= $row['name'] ?></td>
				<td><?= $row['shop'] ?></td>
				<td><?= $row['price'] ?></td>
				<td><?= $row['address'] ?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
}
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

/* search database */
$result['cooltea'] = searchcooltea($conn, $key)->fetchAll();
$result['haircut'] = searchhaircut($conn, $key)->fetchAll();
/* end of search */

/* display result in table */
dispcooltea($result['cooltea']);
disphaircut($result['haircut']);
/* end of display */


$conn = null;
?>
</body>
</html>
