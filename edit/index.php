<!DOCTYPE html>
<html lang="en">
	<?php include '../head.php'; ?>
	<body>
		<?php include '../nav.php'; ?>
		<div class="container" style="margin-top: 5%;">
			<?php

                include '../funcs.php';
                include '../categories.php';

                if (isset($_GET['h']) && !empty($_GET['h']) && strlen($_GET['h']) == 40) {
                    $db_conn = \funcs\Functions::conn();

                    //var_dump($_POST);

                    if (isset($_POST['update']) && isset($_POST['thash'])) {
                        $updates = '';
                        if (isset($_POST['torrent_name']) && $_POST['torrent_name'] !== '') {
                            $updates .= "torrent_name='".mysqli_real_escape_string($db_conn, $_POST['torrent_name'])."', ";
                        }
                        if (isset($_POST['torrent_category']) && $_POST['torrent_category'] !== '') {
                            $updates .= 'category_id='.(int) mysqli_real_escape_string($db_conn, $_POST['torrent_category']).', ';
                        }
                        if (isset($_POST['torrent_download_url']) && $_POST['torrent_download_url'] !== '') {
                            $updates .= "torrent_download_url='".mysqli_real_escape_string($db_conn, $_POST['torrent_download_url'])."', ";
                        }
                        if (isset($_POST['torrent_info_url']) && $_POST['torrent_info_url'] !== '') {
                            $updates .= "torrent_info_url='".mysqli_real_escape_string($db_conn, $_POST['torrent_info_url'])."', ";
                        }
                        if (isset($_POST['verified'])) {
                            $updates .= 'verified='.(int) mysqli_real_escape_string($db_conn, $_POST['verified']).', ';
                        }
                        if (isset($_POST['size']) && $_POST['size'] !== 0) {
                            $updates .= 'size='.(int) mysqli_real_escape_string($db_conn, $_POST['size']).', ';
                        }
                        if (isset($_POST['description']) && $_POST['description'] !== 0) {
                            $updates .= 'description='.mysqli_real_escape_string($db_conn, $_POST['description']).', ';
                        }
                        if (substr($updates, -2, 2) == ', ') {
                            $updates = substr($updates, 0, -2).' ';
                        }
                        $sql = 'UPDATE t_collection SET '.$updates."WHERE torrent_info_hash='".mysqli_real_escape_string($db_conn, $_POST['thash'])."'";
                        //echo $sql;
                        $res = \funcs\Functions::query($db_conn, $sql);
                    }

                    $sql = "SELECT *, count(*) as cnt FROM t_collection WHERE torrent_info_hash='".mysqli_real_escape_string($db_conn, $_GET['h'])."'";
                    $res = \funcs\Functions::query($db_conn, $sql);

                    if ($res) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            if ($row['cnt'] < 1) {
                                echo '
								<div class="alert alert-danger">
									<h1>404</h1>
									<p>
										Torrent was not found.
									</p>
								</div>
								';
                                exit();
                            }
                            $data['torrent_info_hash'] = $row['torrent_info_hash'];
                            $data['torrent_name'] = $row['torrent_name'];
                            $data['category_id'] = $row['category_id'];
                            $data['verified'] = $row['verified'];
                            $data['torrent_info_url'] = $row['torrent_info_url'];
                            $data['torrent_download_url'] = $row['torrent_download_url'];
                            $data['files_count'] = $row['files_count'];
                            $data['category_id'] = $row['category_id'];
                            $data['size'] = $row['size'];
                            $data['description'] = $row['description'];
                        } ?>
						<h3><strong>Editing:</strong> <a href="/hidden/hash/?h=<?php echo $data['torrent_info_hash']; ?>"><?php echo $data['torrent_name']; ?></a></h3>
						<form action="" method="POST" enctype="multipart/form-data">
							<?php if ($data['torrent_name'] === '' || $data['torrent_name'] == $data['torrent_info_hash']) {
    ?>
							<div class="form-group">
								<label for="torrent_name">Torrent Name</label>
								<input type="text" class="form-control" name="torrent_name" placeholder="Torrent Name">
							</div>
							<?php
} ?>
							<?php if ($data['category_id'] == 55 || $data['category_id'] == null) {
    ?>
							<div class="form-group">
								<label for="torrent_category">Category ID</label>
								<select name="torrent_category" class="form-control">
									<?php
                                    echo '<option value="55">-DEFAULT CATEGORY-</option>';
    foreach ($categories as $categoryId => $category) {
        echo '<option value="'.$categoryId.'"';
        if (isset($_GET['c']) && (int) $_GET['c'] == $categoryId) {
            echo ' selected="selected"';
        }
        echo '>'.$category.'</option>';
    } ?>
								</select>
							</div>
							<?php
} ?>
							<?php if ($data['torrent_download_url'] == '') {
    ?>
							<div class="form-group">
								<label for="torrent_download_url">Torcache URL</label>
								<input type="text" class="form-control" name="torrent_download_url" placeholder="Torcache URL">
							</div>
							<?php
} ?>
							<?php if ($data['torrent_info_url'] == '') {
    ?>
							<div class="form-group">
								<label for="torrent_info_url">KAT URL</label>
								<input type="text" class="form-control" name="torrent_info_url" placeholder="KAT URL">
							</div>
							<?php
} ?>
							<?php if ($data['verified'] == 0) {
    ?>
							<div class="form-group">
								<label for="verified">Verified</label>
								<input type="number" class="form-control" name="verified" placeholder="Verified Status (1 or 0)">
							</div>
							<?php
} ?>
							<?php if ($data['size'] < 2 || $data['size'] == null) {
    ?>
							<div class="form-group">
								<label for="size">Size in Bytes</label>
								<input type="number" class="form-control" name="size" placeholder="Size (Bytes)">
							</div>
							<?php
} ?>
							<?php if ($data['description'] == '') {
    ?>
							<div class="form-group">
								<label for="description">Description (using HTML)</label>
								<textarea class="form-control" name="description" placeholder="Description in HTML format"></textarea>
							</div>
							<?php
} ?>
							<?php if (
                                    $data['torrent_name'] !== '' &&
                                    $data['size'] > 1 &&
                                    $data['torrent_info_url'] !== '' &&
                                    $data['torrent_info_url'] !== null &&
                                    $data['torrent_download_url'] !== '' &&
                                    $data['torrent_download_url'] !== null &&
                                    $data['category_id'] !== 55 &&
                                    $data['description'] !== '' &&
                                    $data['description'] !== null
                                ) {
    ?>
									<div class="alert alert-info">
										<p>All fields have been filled in already.</p>
									</div>
								<?php
} else {
    ?>
									<input type="text" name="thash" value="<?php echo $_GET['h']; ?>" hidden>
									<button type="submit" name="update" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Update</button>
								<?php

} ?>
						</form>
<?php

                    } else {
                        echo '
						<div class="alert alert-danger">
							<h1>404</h1>
							<p>
								Torrent was not found.
							</p>
						</div>
						';
                        exit();
                    }
                } else {
                    echo '
						<div class="alert alert-danger">
							<h1>No hash, or incorrect hash provided for editing.</h1>
							<p>
								Providing a hash can be done using the HTTP GET parameter of `h`.<br/>
								e.g. <strong>edit/?h=74C80815374F44702FFE1F25B10D1788B79282A4</strong>
							</p>
						</div>
						';
                    exit();
                }

                ?>
		</div>
	</body>
</html>
