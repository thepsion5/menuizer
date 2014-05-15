<?php
require_once('setup.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menuizer Demo</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <ul class="nav navbar-nav">
            <?= $menuizer->render('primary'); ?>
        </ul>
    </div>
</header>

<div class="container">
    <div class="starter-template">
        <h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br>
            All you get is this text and a mostly barebones HTML document.
        </p>
    </div>
</div>

<footer>
    <ul class="nav nav-pills">
    <?= $menuizer->render('secondary'); ?>
    </ul>
</footer>

</body>
</html>
