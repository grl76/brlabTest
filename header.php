<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body>
<header>
    <div class="container">
            <div class="logo">betsTest</div>
            <div class=""><nav>
                    <?php $homeUrl = home_url() ?>
                    <a href="<?= $homeUrl ?>">Главная</a>
                    <a href="<?= $homeUrl ?>/bets">Ставки</a>
                    <a href="<?= $homeUrl ?>/bets?user=me">Мои ставки</a>
                </nav></div>
            <div class="">
                <div>
                    <a class="button" href="<?= $homeUrl ?>/wp-login.php">Вход</a>
                </div>
            </div>

    </div>
</header>
<div class="wrapper">
<?php
