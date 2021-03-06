<?php if (!defined('BASE_DIR')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= getPageDataHtml('title') ?></title>
    <meta name="description" content="<?= getPageDataHtml('description') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="generator" content="Albireo Framework (https://maxsite.org/albireo)">
    <link rel="stylesheet" href="<?= getConfig('assetsUrl') ?>css/berry.css">
    <link rel="shortcut icon" href="<?= getConfig('assetsUrl') ?>images/favicon.png" type="image/x-icon">
</head>
<body <?= getPageData('body') ?>>
    <?php require getVal('pageFile'); ?>
</body>
</html>