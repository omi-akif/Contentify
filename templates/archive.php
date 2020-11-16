<?php include "template/include/header.php"?>

<ul id="headlines">

    <?php foreach ($results['articles'] as $article) { ?>
        <li>
            <h2>
                <span class="pubDate">
                    <?php echo date(' j F Y', $article->date_of_publication)?>
                </span>

                <a href=".?action=viewArticle&amp;articleId=<?php echo $article->ID?>">
                    
                    <?php echo htmlspecialchars($article->title)?>

                </a>

                <p class="summary">
                    <?php echo htmlspecialchars($article->article_summary)?>
                </p>
            </h2>
        </li>
  <?php } ?>

</ul>