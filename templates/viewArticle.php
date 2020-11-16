<?php include "templates/include/header.php"?>

<h1 style="width: 75%">
    <?php echo htmlspecialchars($results['article']->article_title)?>
</h1>

<div style="width: 75%;"> 
    <?php echo htmlspecialchars($results['article']->article_summary) ?>
</div>

<div style="width: 75%;"> 
    <?php echo $results['article']->article_content?>
</div>

<p class="pubDate"> 
    Published on <?php echo date('j F Y', $results['article']->date_of_publication) ?>
</p>

<p>
    <a href="./">Home</a>
</p>

<?php include "templates/include/footer.php"?>

