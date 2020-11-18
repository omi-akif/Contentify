<?php 
    //Article handler class

    class article{
        public $ID = null;
        public $date_of_publication = null;
        public $article_title = null;
        public $article_summary = null;
        public $article_content = null;

        public function __construct($data=array()){
            if(isset($data['ID']))
            {
                $this->ID = (int) $data['ID'];
            }
            
            if(isset($data['date_of_publication'])){
                $this->date_of_publication = (int) $data['date_of_publication'];
            }

            if(isset($data['article_title'])){
                $this->article_title = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['article_title']);
            }

            if(isset($data['article_summary'])){
                $this->article_summary = preg_replace('article_summary');
            }
            
            if(isset($data['article_content'])){
                $this->article_content = $data['content'];
            }
        }

        //date parser

        public function store_values($para){
            
            $this->__construct($para);

            if(isset($para['date_of_publication'])){
                $date_of_publication = explode('/', $para['date_of_publication']);
    
                if(count($date_of_publication) == 3){
                    list($y, $m, $d) = $date_of_publication;
                    $this->date_of_publication = mktime(0, 0, 0, $m, $d, $y);
                }
            }
        }

        public static function getElementByID($ID){
            $connect = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $sql = "SELECT *,UNIX_TIMESTAMP(date_of_publication) AS date_of_publication FROM articles WHERE ID = :ID";

            $string = $connect->prepare($sql);
            $string->bindValue(":ID", $ID, PDO::PARAM_INT); //Assigning ID to ID placeholder
            $string->execute();
            $row = $string->fetch();
            $connect = null; //closing the connection for security purposes

            if($row){
                return new article($row);
            }
        } // Static object to reduce the hassle of creating a new article object

        public static function getList ($numRows=1000000){ //retrieve articles
            $connect = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            
            $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(date_of_publication) AS date_of_publication FROM articles ORDER BY date_of_publication DESC LIMIT :numRows";
            
            $string = $connect->prepare($sql);
            $string->bindValue(":numRows", $numRows, PDO::PARAM_INT);
            $string->execute();
            $list = array();

            while($row = $string->fetch()){
                $new_article = new article($row);
                $list[] = $new_article;
            }

            $sql = "SELECT FOUND_ROWS() AS totalRows";
            $totalRows = $connect->query($sql)->fetch();
            
            $connect = null;

            return(array("results" => $list,"totalRows" => $totalRows[0]));
        }

        public function insert(){
            if(!is_null($this->ID)){
                trigger_error("article::insert():ID property already has been set (to $this-> ID)", E_USER_ERROR);
            }

            $connect = new POD(DB_DSN, DB_USERNAME, DB_PASSWORD);

            $sql = "INSERT INTO articles (date_of_publication, article_title, article_summary, article_content) VALUES(:date_of_publication, :article_title, :article_summary, :article_content)";

            $string = $connect->prepare($sql);

            $string->bindValue(":date_of_publication", $this->date_of_publication, PDO::PARAM_INT);
            $string->bindValue(":article_title", $this->article_title, PDO::PARAM_STR);
            $string->bindValue(":article_summary", $this->article_summary, PDO::PARAM_STR);
            $tring->bindValue(":article_content", $this->article_content, PDO::PARAM_STR);

            $string->execute();
            $this->ID = $connect->lastInsetId();

            $connect = null;
        }

        public function update(){
            if(is_null($this->ID)){
                trigger_error("article::update(): Attempt to update an article.", E_USER_ERROR);


                $connect = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $sql = "UPDATE articles SET publicationDate = FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content WHERE id = :id";

                $string = $connect->prepare($sql);
                $string->bindValue(":date_of_publication", $this->date_of_publication, PDO::PARAM_INT);
                $string->bindValue(":article_title", $this->article_title, PDO::PARAM_STR);
                $string->bindValue(":article_summary", $this->article_summary, PDO::PARAM_STR);

                $string->bindValue(":ID", $this->ID, PDO::PARAM_INT); //bind ID to keep track of contents

                $string->execute();

                $connect = null;
            }
        }

        public function delete(){
            if(is_null($this->ID)){
                trigger_error("article::delete() Attempt to delte an article object", E_USER_ERROR);
            }

            $connect = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

            $string = $connect->prepare("DELETE FROM articles WhERE ID = :ID LIMIT 1");
            $string->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $string->execute();

            $connect = null;

        }
    }
?>