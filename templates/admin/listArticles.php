<?php include "templates/include/header.php"?>
<h2></h2>
<div id="adminHeader">
    <h2>Your Blog</h2>
    <p> 
        You are logged in as
        <b>
            <?php echo htmlspecialchars($_SESSION['username']) ?>.
        </b>

        <a href="admin.php?action=logout">Log out</a>
    </p>
</div>

<h1>All Articles</h1>

<?php if(isset($results['errorMessage'])) {  ?>
    <div class="errorMessage">
        <?php echo $results['errorMessage'] ?>
    </div>
<?php } ?>

<?php if(isset($results['statusMessage'])){ ?>
    <div class="statusMessage">
        <?php echo $results['statusMessage']?> 
    </div>
<?php } ?>

    <table>
        <tr>
            <th>Date</th>
            <th>Article</th>
        </tr>

<?php foreach($results['articles'] as $article) { ?>

    <tr onclick="location='admin.php?action=editArticle&amp;articleID'">
        <td>
            <?php echo date('j M Y', $article->date_of_publication)?>
        </td>
    </tr>
<?php } ?>

    </table>

    <p> 
        <?php echo $results['totalRows']?>
        article
        <?php echo($results['totalRows'] != 1) ? 's':''?> in total.
    </p>

    <p>
        <a href="admin.php?action=newArticle">Add a new Article</a>
    </p>

    <?php include "templates/include/footer.php"?>