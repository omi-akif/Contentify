<?php 
    require("config.php"); //usage of require to get a error if the file not found.
    
    $action = isset($_GET['action']) ? $_GET['action'] : "";

    switch($action){
        case 'archive':
            archive();  // stored articles
            break;
        case 'viewArticle':
            viewArticle(); // view articles
            break;
        default:
            homepage(); // default load homepage
    }

    function archive(){
        $result = array(); //iniatilized array
        $data = article::getList();
        $results['articles'] = $data['results'];
        $results['toralRows'] = $data['totalRows'];
        $results['pageTitle'] = "Previous Articles";
        require(TEMPLAE_PATH . "/archive.php");
    }

    function viewArticle(){
        if(!isset($_GET["articleID"]) || !$_GET["articleID"]){
            homepage();
            return;
        }

        $results = array();
        $results['article'] = article::getElementByID((int)$_GET["articleId"]);
        $results['pageTitle'] = $results['article'] -> title . "Today's blog";
        
        require(TEMPLATE_PATH . "/viewArticle.php");
    }

    function homepage(){
        $results = array();
        $data = article::getList(HOMEPAGE_NUM_ARTICLES);
        
        $results['articles'] = $data['results'];
        $results['totalRows'] = $data['totalRows'];
        $results['pageTitle'] = "Welcome to your page!";
    }
?>