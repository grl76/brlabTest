<?php get_header(); ?>
<?php
$titlePage = 'Ставки';
if($_GET['user'] == 'me'){
    $titlePage = 'Мои ставки';
    $posts = query_posts( array(
        'author'        => $current_user->ID,
        'post_type'   => 'bets',
    ) );
}
?>
<div class="container">
        <div class="row flex-nowrap">
            <?php
            if  ( is_user_logged_in()  ) {
                get_sidebar();
            }
            ?>
            <div class="listBet w-100 d-flex flex-wrap">
                <h4><?= $titlePage ?></h4>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
        <article class="col-12">
            <a class="box" href="<?= get_permalink() ?>">
                <h3><?= the_title() ?><span></span></h3>
                <div class="description"><?= get_post_meta( $post->ID, 'description', true); ?></div>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <?php
                        $cur_terms = get_the_terms( $post->ID, 'typeBet' );
                        if( is_array( $cur_terms ) ):
                            ?>
                            <div class="type">
                                <?php
                                foreach( $cur_terms as $cur_term ){
                                    echo $cur_term->name;
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        $cur_terms = get_the_terms( $post->ID, 'statusBet' );
                        if( is_array( $cur_terms ) ):
                            ?>
                            <div class="status">
                                <?php
                                foreach( $cur_terms as $cur_term ){
                                    echo $cur_term->name;
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="author">
                            <?php
                            $user_info = get_userdata($post->post_author);
                            echo 'Автор: ' . $user_info->user_login . "\n";
                            ?>
                        </div>
                    </div>
                    <div class="button">Перейти ></div>
                </div>
            </a>
        </article>
<?php endwhile; ?>
<?php else: ?>
Ставок не найдено
<?php endif; ?>
        </div>
</div>
</div>


<?php get_footer(); ?>
