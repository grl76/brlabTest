</div>
<footer>
    <div class="container d-flex justify-content-between">
        <div class="logo">betsTest</div>
        <div class=""><nav>
                <?php $homeUrl = home_url() ?>
                <a href="<?= $homeUrl ?>">Главная</a>
                <a href="<?= $homeUrl ?>/bets">Ставки</a>
                <a href="<?= $homeUrl ?>/bets?user=me">Мои ставки</a>
            </nav>
        </div>
        <div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
