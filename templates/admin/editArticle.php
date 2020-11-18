<?php include "template/include/header.php" ?>

    <div id="adminHeader">
        <h2>
            Your Blog
        </h2>
        <p>
            You are logged in as

            <b>
                <?php echo htmlspecialchars(['username']) ?>
            </b>

            <a href="admin.php?action=logout">
                Log out
            </a>
        </p>
    </div>

    <h1>
        <?php echo $results['pageTitle'] ?>
    </h1>

    <form action="admin.php?action=<?php echo $results['articles']->ID ?>">

<?php if(isset($results['errorMessage'])) { ?>

    <div class="errorMessage">
        <?php echo $results['errorMessage'] ?>
    </div>

<?php } ?>

    <ul>
        <li>
           <label for="article_title">Article Title</label> 
           <input type="text" name="Title" id="article_title" placeholder="Name of the article" required autofocus maxlength="255" value="<?php echo htmlspecialchars($results['article']->article_title)?>">
        </li>

        <li>
            <label for="article_summary">Article Summary</label>
            <textarea name="Summary" id="article_summary" placeholder="Brief Description" required maxlength="1000" style="height: 5em;">
            
            <?php echo htmlspecialchars($results['article']->article_summary)?>
            </textarea>
        </li>

        <li>
            <label for="article_content">Article Content</label>
            <textarea name="Content" id="article_content" placeholder="Your Content" required maxlength="100000" style="height: 30em;">

            <?php echo htmlspecialchars($results['article']->article_content)?>

            </textarea>
        </li>

        <li>
            <label for="date_of_publication">Date</label>

            <input type="date" name="Date" id="date_of_publication" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['article']->publicationDate ? date( "Y-m-d", $results['article']->publicationDate ) : "" ?>">
        </li>
    </ul>

    <div class="buttons">
        <input type="submit" name="saveChanges" value="Save Changes">
        <input type="submit" formnovaludate name="cancel" value="Cancel">
    </div>

    </form>

<?php if ($results['article']->ID) { ?>
    <p>
    <a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->ID ?>" onclick="return confirm('Delete This Article?')">Delete This Article</a>
    </p>
<?php } ?>

<?php include "templates/include/footer.php" ?>