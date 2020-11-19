<?php

/**
 * Class to handle articles
 */

class article
{
  // Properties

  /**
  * @var int The article ID from the database
  */
  public $ID = null;

  /**
  * @var int When the article is to be / was first published
  */
  public $date_of_publication = null;

  /**
  * @var string Full title of the article
  */
  public $article_title = null;

  /**
  * @var string A short article_summary of the article
  */
  public $article_summary = null;

  /**
  * @var string The HTML article_content of the article
  */
  public $article_content = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if (isset( $data['ID'])) 
    {
      $this->ID = (int) $data['ID'];
    }
    if (isset( $data['date_of_publication'])) {
      
      $this->date_of_publication = (int) $data['date_of_publication'];

    }

    if (isset($data['title'])) {
      
      $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );

    }

    if (isset($data['article_summary'])) {
      
      $this->article_summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['article_summary'] );
    
    }
    
    if (isset($data['article_content'] )) {
      
      $this->article_content = $data['article_content'];
    
    }
  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the publication date
    if ( isset($params['date_of_publication']) ) {
      $date_of_publication = explode ( '-', $params['date_of_publication'] );

      if ( count($date_of_publication) == 3 ) {
        list ( $y, $m, $d ) = $date_of_publication;
        $this->date_of_publication = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }


  /**
  * Returns an article object matching the given article ID
  *
  * @param int The article ID
  * @return article|false The article object, or false if the record was not found or there was a problem
  */

  public static function getElementByID($ID) {
    $connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(date_of_publication) AS date_of_publication FROM articles WHERE ID = :ID";
    $string = $connection->prepare( $sql );
    $string->bindValue( ":ID", $ID, PDO::PARAM_INT );
    $string->execute();
    $row = $string->fetch();
    $connection = null;
    if ( $row ) return new article($row);
  }


  /**
  * Returns all (or a range of) article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @return Array|false A two-element array : results => array, a list of article objects; totalRows => Total number of articles
  */

  public static function getList($numRows=1000000) {
    $connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(date_of_publication) AS date_of_publication FROM articles
            ORDER BY date_of_publication DESC LIMIT :numRows";

    $string = $connection->prepare($sql);
    $string->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $string->execute();
    $list = array();

    while ( $row = $string->fetch() ) {
      $article = new article($row);
      $list[] = $article;
    }

    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $connection->query($sql)->fetch();
    $connection = null;
    return (array("results" => $list, "totalRows" => $totalRows[0]));
  }


  /**
  * Inserts the current article object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the article object already have an ID?
    if ( !is_null( $this->ID ) ) trigger_error ( "article::insert(): Attempt to insert an article object that already has its ID property set (to $this->ID).", E_USER_ERROR );

    // Insert the article
    $connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "INSERT INTO articles ( date_of_publication, title, article_summary, article_content ) VALUES ( FROM_UNIXTIME(:date_of_publication), :title, :article_summary, :article_content )";
    $string = $connection->prepare ($sql);
    $string->bindValue( ":date_of_publication", $this->date_of_publication, PDO::PARAM_INT );
    $string->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $string->bindValue( ":article_summary", $this->article_summary, PDO::PARAM_STR );
    $string->bindValue( ":article_content", $this->article_content, PDO::PARAM_STR );
    $string->execute();
    $this->ID = $connection->lastInsertId();
    $connection = null;
  }


  /**
  * Updates the current article object in the database.
  */

  public function update() {

    // Does the article object have an ID?
    if ( is_null($this->ID) ) trigger_error ( "article::update(): Attempt to update an article object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the article
    $connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE articles SET date_of_publication=FROM_UNIXTIME(:date_of_publication), title=:title, article_summary=:article_summary, article_content=:article_content WHERE ID = :ID";
    $string = $connection->prepare ( $sql );
    $string->bindValue( ":date_of_publication", $this->date_of_publication, PDO::PARAM_INT );
    $string->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $string->bindValue( ":article_summary", $this->article_summary, PDO::PARAM_STR );
    $string->bindValue( ":article_content", $this->article_content, PDO::PARAM_STR );
    $string->bindValue( ":ID", $this->ID, PDO::PARAM_INT );
    $string->execute();
    $connection = null;
  }


  /**
  * Deletes the current article object from the database.
  */

  public function delete() {

    // Does the article object have an ID?
    if ( is_null( $this->ID ) ) trigger_error ( "article::delete(): Attempt to delete an article object that does not have its ID property set.", E_USER_ERROR );

    // Delete the article
    $connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $string = $connection->prepare ( "DELETE FROM articles WHERE ID = :ID LIMIT 1" );
    $string->bindValue( ":ID", $this->ID, PDO::PARAM_INT );
    $string->execute();
    $connection = null;
  }

}

?>
