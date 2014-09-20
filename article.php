<?php
	require_once 'init/config.php';
	if(!empty($_GET['id'])):

		$article = new Article($_GET['id']);
		$comments = $article->get_comments();
?>

<a href="main.php">Home Page</a>

<section>
	<article>
		<h1><?=$article->get_title()?></h1>
		<p><?=$article->get_content()?></p>
	</article>
	<hr>
</section>

<section>
	<h3>Comment</h3>

	<?php
		if(!empty($_POST)){
			$article->add_comment($_POST['visitor_name'], $_POST['content']);
			echo 'Your comment has been sucessfully added';
			redirectTo('article.php?id='.$_GET['id'], 2);
		}
	?>

	<form action="" method="post">
		<input type="text" name="visitor_name" placeholder="your name">
		<br>
		<textarea name="content" placeholder="Content"></textarea>
		<br>
		<input type="submit">
	</form>
	<hr>
</section>

<section>
	<h3>comments</h3>
	<?php 
	if(empty($comments)):
		echo 'No comments.';
	else:
	foreach($comments as $comment): ?>
	<?=$comment->get_author_name()?> said: <?=$comment->get_content()?><hr>
	<?php endforeach; endif;?>

</section>

<?php else: ?>
<h1>Invalid request</h1>
<?php endif;?>