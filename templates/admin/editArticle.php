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

    <form action="admin.php?action=<?php echo $results['articles'] -> ID ?>"></form>