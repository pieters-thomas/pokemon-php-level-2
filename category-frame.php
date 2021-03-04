<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokédex</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="container">
    <form id="find" method="post" class="spaceHolder">

            <select id="find" form="find" name="type">
                <?php unfoldDropdown(); ?>
            </select>
        <input type="submit" id="search" class="case" value="">
    </form>
    <div class="buffer"></div>
    <div class="statCase">
        <div class="gridCase">
            <?php  unfoldGrid($start_from); ?>
        </div>
        <nav class="navBar">
            <?php  unfoldNav($totalPages,$page); ?>
        </nav>
    </div>
</div>

</body>
</html>
