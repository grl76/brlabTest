<?php get_header();


?>


    <div class="container">
        <div class="row flex-nowrap">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="col">
                        <div class="box">
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
                            </div>
                        </div>
                    </article>
                <?php if($post->post_author == $current_user->ID):?>
                    <article class="col-4">
                            <form class="box addBet" oninput="level.value = cost.valueAsNumber">
                                <h5>Сделать ставку</h5>
                                <label class="col">
                                    <input name="cost" type="range" id="flying" class="custom-range" value="200" min="100" max="1000" step="20">
                                    <output for="flying" name="level">200</output>
                                </label>
                                <input class="disabled" type="submit" id="addBet" value="Ставка пройдет!"/>
                            </form>
                    </article>
                <?php endif; ?>


                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

<?php get_footer(); ?>