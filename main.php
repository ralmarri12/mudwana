<?php require_once 'init/config.php';
	$articles = Article::get_all_articles();
?>

<a href="new_article.php">[New Article]</a><hr>

<?php foreach($articles as $article): ?>
<h1><a href="article.php?id=<?=$article->get_id()?>"><?=$article->get_title()?></a></h1>
<small>Written by: <?=$article->get_author_name()?></small>
<p><?=substr($article->get_content(), 0, 100)?>...<a href="article.php?id=<?=$article->get_id()?>">[Read more]</a></p>
<hr>
<?php endforeach;?>