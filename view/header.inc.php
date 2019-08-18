
<?php
    global $jsFiles;
    global $cssFiles;
    global $tags;
    global $title;
    global $lang;
?>

<!DOCTYPE HTML>
<html lang="<?= $lang ?>">
    <head>
        <title><?= $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php foreach($tags as $tag): ?>
            <meta <?=$tag["attr"]?>="<?= $tag["name"] ?>" content="<?= $tag["content"] ?>"/>
        <?php endforeach ?>
        
        <?php foreach($jsFiles as $file): ?>
            <?php if (!empty($file["integrity"])): ?> 
                <script type="text/javascript" src="<?= $file["url"]; ?>" integrity="<?= $file["integrity"]; ?>" crossorigin="<?= $file["crossorigin"]; ?>"></script>
            <?php else: ?>
                <script type="text/javascript" src="<?= $file["url"]; ?>"></script>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <?php foreach($cssFiles as $file): ?>
            <?php if (!empty($file["integrity"])): ?> 
                <link rel="stylesheet" href="<?= $file["url"]; ?>" integrity="<?= $file["integrity"]; ?>" crossorigin="<?= $file["crossorigin"]; ?>">
            <?php else: ?>
            <link rel="stylesheet" href="<?= $file["url"]; ?>">
            <?php endif; ?>
        <?php endforeach; ?>        

        
    </head>
    <body>
        <div class="page-content">

        
