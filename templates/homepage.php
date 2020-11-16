<?php include "./include/header.php" ?>

    <ul id="headlines">
        <?php foreach ($results['articles'] as $article) { ?>
            <li>
                <h2>
                    <span class="pubDate">
                    
                        <?php echo date('j F', $article->date_of_publication)?>
                    
                    </span> <!--date of publication-->

                    <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>">
                    
                        <?php echo htmlspecialchars( $article->article_title )?>
                    
                    </a> <!--article title-->

                </h2>

                <p class="summary">
                    <?php echo htmlspecialchars($article->article_summary)?>
                </p>
            </li>
       <?php } ?>

    </ul>
    <p>
        <a href="./?action=archive">Saved Articles</a>
    </p>

    <?php include "templates/include/footer.php"?>