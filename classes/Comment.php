<?php

class Comment{
	
	// Data members: ================================
	private $_id 		     = 0;
	private $_author_name	 = 'unknown';
	private $_content		 = 'empty';

	// Methods: =====================================
	public function __construct($comm_id = null){

		if($comm_id != null){
			$this->_id = $comm_id;

			try{
				$this->retrieve_from_db();
			}catch(Exception $e){
				die($e->getMessage());
			}
		}

	}


	public function get_id(){
		return $this->_id;
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


	public function retrieve_from_db(){
		global $connection;

		// Preparing the SQL statment:
		$statement = $connection->prepare('SELECT * FROM `comments` WHERE `comment_id` = :comment_id');

		// Initializing a value to the (:comment_id) parameter:
		$statement->bindParam(':comment_id', $this->_id, PDO::PARAM_INT);

		// Executing the statement:
		if(!$statement->execute()){
			throw new Exception("Comment-retrieve: SQL Syntax error.");	
		}

		if($statement->rowCount() == 0){
			throw new Exception('Comment-retrieve: Wrong comment id.');
		}

		// Getting the results from the previous statement:
		$results = $statement->fetch(PDO::FETCH_OBJ);

		// Re-store the results:
		$this->_author_name 	=	$results->author_name;
		$this->_content 		=	$results->comment_content;
	}



	public static function create($article_id, $author_name, $content){
		global $connection;

		// Preparing the SQL statment:
		$statement = $connection->prepare('INSERT INTO `comments` (`article_id`, `author_name`, `comment_content`) VALUES (:article_id, :author_name, :content)');

		// Initializing a value to the (:comment_id) parameter:
		$statement->bindParam(':article_id', $article_id, PDO::PARAM_INT);
		$statement->bindParam(':author_name', $author_name, PDO::PARAM_STR);
		$statement->bindParam(':content', $content, PDO::PARAM_STR);

		// Executing the statement:
		if(!$statement->execute()){
			throw new Exception("Comment-create: SQL Syntax error.");	
		}

	}


}

?>