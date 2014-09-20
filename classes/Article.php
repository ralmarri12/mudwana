<?php

class Article{
	
	// Data members: ================================s
	private $_id 			= 0;
	private $_title 		= 'empty';
	private $_author_name 	= 'unknown';
	private $_content 		= 'empty';
	private $_comments 		= array();

	// Methods: =====================================
	public function __construct($article_id = null){

		if($article_id != null){
			$this->_id = $article_id;

			try{
				$this->retrieve_from_db();
			}catch(Exception $e){
				die('<a href="main.php">Home Page</a> '.$e->getMessage());
			}
		}

	}

	public function get_id(){
		return $this->_id;
	}


	public function get_title(){
		return $this->_title;
	}

	public function set_title($title){
		$this->_title = $title;
	}

	public function get_author_name(){
		return $this->_author_name;
	}

	public function set_author_name($author_name){
		$this->_author_name = $author_name;
	}

	public function get_content(){
		return $this->_content;
	}

	public function set_content($content){
		$this->_content = $content;
	}


	public function get_comments(){
		return $this->_comments;
	}

	public function add_comment($author_name, $content){
		try{
			Comment::create($this->_id, $author_name, $content);
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

	private function retrieve_from_db(){
		global $connection;
		// Preparing the SQL statment:
		$statement = $connection->prepare('SELECT * FROM `articles` WHERE `article_id` = :article_id');

		// Initializing a value to the (:comment_id) parameter:
		$statement->bindParam(':article_id', $this->_id, PDO::PARAM_INT);

		// Executing the statement:
		if(!$statement->execute()){
			throw new Exception("Article: SQL Syntax error.");	
		}

		if($statement->rowCount() == 0){
			throw new Exception('Article: Wrong article id.');
		}

		// Getting the results from the previous statement:
		$results = $statement->fetch(PDO::FETCH_OBJ);

		// Re-store the	results:
		$this->_title 		= $results->article_title;
		$this->_author_name = $results->author_name;
		$this->_content 	= $results->article_content;
		

		// Getting all comments:
		
		// -- prepareing the SQL statement:
		$comments_statement = $connection->prepare('SELECT `comment_id` FROM `comments` WHERE `article_id` = :article_id ORDER BY `comment_id` DESC');

		// -- Binding a value to the SQL statement:
		$comments_statement->bindParam(':article_id', $this->_id, PDO::PARAM_INT);

		// -- Executing the statment:
		if(!$comments_statement->execute()){
			throw new Exception("Article-retieve: SQL Syntax error, could not retrieve article's comments");
		}

		if($comments_statement->rowCount() > 0){
			$comments_ids = $comments_statement->fetchAll(PDO::FETCH_OBJ);
			foreach ($comments_ids as $comment) {
				array_push($this->_comments, new Comment($comment->comment_id));
			}
		}

	}



	public static function get_all_articles(){
		global $connection;
		// Declare article array:
		$articles = array();

		// Executing the statment:
		$statement = $connection->query('SELECT `article_id` FROM `articles`');

		// Fetching the restults;
		$results_set = $statement->fetchAll(PDO::FETCH_OBJ);

		// Inserting values to the articles array:
		foreach ($results_set as $key) {
			array_push($articles, new Article($key->article_id));
		}

		// Returning the article set:
		return $articles;

	}

	public static function create($title, $author_name, $content){
		global $connection;
		// Preparing the SQL statment:
		$statement = $connection->prepare('INSERT INTO `articles` (`article_title`,`author_name`,`article_content`) VALUES (:title, :author_name, :content)');

		// Binding values to the SQL statement:
		$statement->bindParam(':title', $title, PDO::PARAM_STR);
		$statement->bindParam(':author_name', $author_name, PDO::PARAM_STR);
		$statement->bindParam(':content', $content, PDO::PARAM_STR);

		// Executing the statment:
		if(!$statement->execute()){
			print_r($connection->errorCode());
			throw new Exception("Article-create: SQL Syntax error.");
		}
			
	}

	
}


?>