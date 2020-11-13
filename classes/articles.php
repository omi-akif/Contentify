<?php 
    //Article handler class

    class articles{
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
    }
?>