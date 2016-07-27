<!DOCTYPE html>
<html lang="en">
	<?php include('head.php'); ?>
	<body>
		<?php include('nav.php'); ?>
		<div style="width: 70%; margin: auto; padding: auto; margin-top: 5%;">
			<?php
				if (extension_loaded('mysqli')) {
					require_once('funcs.php');
					$db_conn = @\funcs\Functions::conn();
					if (!$db_conn) { ?>
						<?php
							if (isset($_POST['changeDbDetails'])) {
								$ret = \funcs\Functions::changeDbDetails($_POST['mysql_host'], $_POST['mysql_username'], $_POST['mysql_password'], $_POST['mysql_dbname']);
								if ($ret) { ?>
									<div class="alert alert-success">
										<h2>Successfully changed the database settings, please click below to continue.</h2>
										<a href=""><button class="btn btn-primary">Continue</button></a>
									</div>
								<?php } else { ?>
									<div class="alert alert-danger">
										<h2>Failed to update database settings, please do this manually in funcs.php</h2>
									</div>
								<?php }
								exit();
							}
						?>
						<div class="alert alert-danger">
							<h2>Failed to connect to database.</h2>
							<h4>Please fill in the following details.</h4>
							<div class="well">
								<form action="" method="POST">
									<div class="form-group">
										<label for="mysql_host">MySQL Host</label>
										<input type="text" class="form-control" name="mysql_host" id="mysql_host" placeholder="MySQL Host IP (or localhost)" value="localhost">
									</div>
									<div class="form-group">
										<label for="mysql_username">Database User</label>
										<input type="text" class="form-control" name="mysql_username" id="mysql_username" placeholder="MySQL User">
									</div>
									<div class="form-group">
										<label for="mysql_password">Database Password</label>
										<input type="password" class="form-control" name="mysql_password" id="mysql_password" placeholder="MySQL Password">
									</div>
									<div class="form-group">
										<label for="mysql_dbname">Database Name</label>
										<input type="text" class="form-control" name="mysql_dbname" id="mysql_dbname" placeholder="Database Name">
									</div>
									<button class="btn btn-default" type="submit" name="changeDbDetails">Submit</button>
								</form>
							</div>
						</div>
					<?php
					exit();
					}
					$sql = "SELECT count(*) as count FROM t_collection";
					$total_torrents = \funcs\Functions::query($db_conn, $sql);
					if (mysqli_fetch_assoc($total_torrents)['count'] > 0) {
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
				}
				else { ?>
				<div class="alert alert-danger">
					<h2>KatRevive requires the MySQLi extension to be active.</h2>
					<h4>Please enable this in your PHP.</h4>
				</div>
				<?php }
			?>
		</div>
	</body>
</html>
