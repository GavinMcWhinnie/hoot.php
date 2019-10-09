<!DOCTYPE html>
<html>
	<head>
		<title>hoot.php</title>
		<style type="text/css">
			body { margin: 40px; background: linear-gradient(45deg, #660000, #000066); background-size: 100px 100px; height: calc(100vh - 80px); font-size: 0; }
			body * { font-family: Verdana, sans-serif; line-height: 15px; font-size: 15px; }
			.half { width: 50%; height: 100%; position: relative;}
			#left { float: left; }
			#right { float: right; }
			#hoot { background-color: white; padding: 10px; position: absolute; width: calc(90% - 20px);}
			#hoot * { display: inline; }
			#hoot img { max-width: 50px; vertical-align: bottom;}

			#explorer { max-height: 400px; overflow-y: scroll; padding: 20px; background-color: white; margin-top: 20px; position: absolute; top: 60px; width: calc(90% - 40px); }
			.folder, .file { background-color: white; border: none; }
			#upload { position: absolute; background-color: white; margin-top: 20px; width: calc(90% - 20px); padding: 10px; bottom: 0px;}
			#preview { background-color: white; padding: 20px; margin-bottom: 10px;}
			#display { background-color: white; overflow-y: scroll; max-height: 510px; padding: 20px;}
		</style>
	</head>
	<body style='display:
	<?php 

	//pwd = 1234
	$hash = '$2y$10$FRv52Yl7avlQW.nDG3r5euFcJf2iPBRi4y08mlV6BSYI/CSF5yrKW';

	session_start();
	if (isset($_SESSION['logged_on'])) {
		if (isset($_GET['logout'])) {
			echo 'none';
			session_destroy();
			header('Location: index.php');
		} else {
			echo 'block';
		}
	} else {
		if (isset($_POST['password'])) {
			if (password_verify($_POST['password'], $hash)) {
				echo 'block';
				$_SESSION['logged_on'] = 1;
			} else {
				echo 'none';
				header('Location: index.php');
			}
		} else {
			echo 'none';
			header('Location: index.php');
		}
	}

	?>

	;'>
		<div class="half" id="left">
			
			<div id='hoot'>
				<img src='hoot.png'/>
				<h1>Hoot.php</h1>
				<p>A php file explorer</p>
				<form action='' method="get">
					<input type='hidden' name='logout' value='true'>
					<input type='submit' value="logout">
				</form>
			</div>
			
			<div id='explorer'>
				<?php
					if (isset($_GET['cwd'])) {
						$cwd = $_GET['cwd'];
					} else {
						$cwd = getcwd();
					}
					chdir($cwd);
					echo "<p>current directory: " . $cwd . "</p>";
					$current_files = scandir($cwd);
					foreach ($current_files as $file) {
						if ($file != '.') {
							if ($file == '..') {
								echo "<form action='' method='get'>
								<img src='back.png' style='max-width: 20px; vertical-align: middle;'/>
								<input type='hidden' name='cwd' value='".dirname($cwd)."'>
								<input class='folder' type='submit'value='Back'>
								</form>";
							} else {
								if (is_dir($file)) {
									echo "<form action='' method='get'>
									<img src='folder.jpg' style='max-width: 20px; vertical-align: middle;'/>
									<input type='hidden' name='cwd' value='".$cwd."\\".$file."'>
									<input class='folder' type='submit' value='".$file."'>
									</form>";
								} else {
									echo "<form action='' method='get'>
									<img src='file.jpg' style='max-width: 15px; vertical-align: middle; margin-left: 3px;'/>
									<input type='hidden' name='cwd' value='".$cwd."'>
									<input type='hidden' name='display' value='".$file."'>
									<input class='file' type='submit' value='".$file."'>
									</form>";
								}
							}
						}
					}
				?>
			</div>
			<div id='upload'>
				<?php
				if (isset($_FILES['file'])) {
					echo $_FILES["file"]["name"].'<br>';
					echo $_FILES["file"]["tmp_name"].'<br>';
					$target_file = $cwd . "\\" . basename($_FILES["file"]["name"]);
					echo $target_file.'<br>';

					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						echo "it worked";
						header('Location: hoot.php?cwd='.$cwd);
					}
				}

				?>
				<p>Choose a file to upload here:</p>
				<form action="" method="post"  enctype="multipart/form-data">
					<input type="file" name="file">
					<input type="submit" value="submit">
				</form>
			</div>
		</div>
		<div class="half" id="right">
			<div id='preview'>
				Preview:
			</div>
			<div id='display'>
				<?php

				if (isset($_GET['display'])) {
					$file_to_display = $cwd . "\\" . $_GET['display'];
					echo $file_to_display.'<br><br>';
					$file = fopen($file_to_display,"r");
					$yeet = htmlspecialchars(fread($file,"10000"));
					fclose($file);
					echo $yeet;
				}
				
				?>
			</div>
		</div>
	</body>
</html>