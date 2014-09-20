<?php include 'init/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>New article</title>
</head>
<body>
	<a href="main.php">Home Page</a>
	<?php

		if(!empty($_POST)){

			try{
				Article::create($_POST['title'],$_POST['auther_name'], $_POST['content']);
				redirectTo('main.php');
			}catch(Exception $e){
				die($e->getMessage());
			}

		}

	?>

	<form action="" method="post">
		<input type="text" name="title" placeholder="Title">
		<br>
		<input type="text" name="auther_name" placeholder="aunter_name">
		<br>
		<textarea name="content" placeholder="content"></textarea>
		<br>
		<input type="submit">
	</form>

</body>
</html>