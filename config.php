<?php 
    ini_set("display_errors", true);
    date_default_timezone_get("Asia/Dhaka");

    define("DB_DSN", "mysql:host=localhost;dbname=content");

    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("CLASS_PATH", "classes");
    define("TEMPLATE_PATH", "templates");
    define("HOMEPAGE_NUM_ARTICLES", 5);
    define("ADMIN_USERNAME", "root");
    define("ADMIN_PASSWORD", "root");
    
    require(CLASS_PATH  . "/articles.php");

    function handleException($exception){
        echo "Sorry, a problem occured. Please try later.";
        error_log($exception->getMessage());
    }

    set_exception_handler('handleException');
?>