<!DOCTYPE html>
<html lang="en">
	<head itemscope itemtype="http://schema.org/WebSite">
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0,width=device-width">
		<meta name="HandheldFriendly" content="true"/>
		<title>KatRevive</title>
		<link rel="shortcut icon" href="favicon.png">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<script async src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
		<script async src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<body>
		<?php include('nav.php'); ?>
		<div style="width: 70%; margin: auto; padding: auto; margin-top: 5%;">
			<?php
				include('funcs.php');
				$db_conn = \funcs\Functions::conn();
				$sql = "SELECT count(*) FROM t_collection";
				$total_torrents = \funcs\Functions::query($db_conn, $sql);
				if ($total_torrents) {
					?>
						<div class="alert alert-success">
							<p>
								Database is already set up, and torrents have been imported successfully.
								<br/>
								<a href="index.php" class="alert-link">Go to Index</a>
							</p>
						</div>
					<?php
				}
				else {
					?>
						<div class="alert alert-danger">
							<h2>Data not available. Please import a datadump.</h2>
						</div>
						<div>
							<form action="import_db_list.php" method="post">
								<div class="form-group">
									<select class="form-control" name="dbtype">
										<option value="hourly">import_lists/hourlydump.txt</option>
										<option value="daily">import_lists/dailydump.txt</option>
									</select>
								</div>
								<input type="submit" value="Import" class="btn btn-default">
							</form>
						</div>
					<?php
				}
			?>
		</div>
	</body>
</html>
