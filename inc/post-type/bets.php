<?php

add_action( 'init', 'bets_taxonomy' );
function bets_taxonomy(){



    register_taxonomy('typeBet', array('bets'), array(
        'hierarchical'  => true,
        'public'        => true,
        'labels'        => array(
            'name'              => __( 'Тип'),
            'singular_name'     => __( 'Тип ставки'),
            'search_items'      => __( 'Найти' ),
            'all_items'         => __( 'Тип' ),
            'edit_item'         => __( 'Редактировать тип' ),
            'update_item'       => __( 'Изменить тип' ),
            'add_new_item'      => __( 'Добавить новый тип' ),
            'new_item_name'     => __( 'Новый тип ставки' ),
            'menu_name'         => __( 'Тип ставки' ),
        ),
        'show_ui'       => true,
        'show_in_rest'  => true,
        'query_var'     => true,
        //'rewrite'       => array('slug'=>'bets', 'hierarchical'=>false, 'with_front'=>false ),
        //'rewrite'       => array( 'slug' => 'the_genre' ), // свой слаг в URL
    ));

    register_taxonomy('statusBet', array('bets'), array(
        'hierarchical'  => true,
        'public'        => true,
        'labels'        => array(
            'name'              => __( 'Статус'),
            'singular_name'     => __( 'Статус'),
            'search_items'      => __( 'Найти' ),
            'all_items'         => __( 'Статус' ),
            'edit_item'         => __( 'Редактировать статус' ),
            'update_item'       => __( 'Изменить статус' ),
            'add_new_item'      => __( 'Добавить новый статус' ),
            'new_item_name'     => __( 'Новый статус' ),
            'menu_name'         => __( 'Статусы' ),
        ),
        'show_ui'       => true,
        'show_in_rest'  => true,
        'query_var'     => true,
       // 'rewrite'       => array('slug'=>'bets', 'hierarchical'=>false, 'with_front'=>false ),
        //'rewrite'       => array( 'slug' => 'the_genre' ), // свой слаг в URL
    ));

}

add_action('init', 'bets_init');
function bets_init(){

    register_post_type('bets', array(
        'labels'             => array(
            'name'               => 'Ставки', // Основное название типа записи
            'singular_name'      => 'Ставка', // отдельное название записи типа Book
            'add_new'            => 'Добавить',
            'add_new_item'       => 'Добавить новую ставку',
            'edit_item'          => 'Редактировать ставку',
            'new_item'           => 'Новая',
            'view_item'          => 'Посмотреть',
            'search_items'       => 'Найти',
            'not_found'          => 'Ставки не найдены',
            'not_found_in_trash' => 'В корзине не найдены',
            'parent_item_colon'  => '',
            'menu_name'          => 'Ставки'
        ),
        'taxonomies'=>array(
            'typeBet',
            'statusBet'
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
       // 'rewrite'            => array( 'slug'=>'bets', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 70,
        'supports'           => array( 'title', 'thumbnail', 'custom-fields' )
    ) );

    $meta_args = array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
    );
    register_post_meta( 'bets', 'description', $meta_args );

    $meta_args = array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
    );
    register_post_meta( 'bets', 'bet_vote', $meta_args );
}

add_action('after_switch_theme', 'activate_theme_addTermBets' );
function activate_theme_addTermBets( $new_name )
{
    $insertTerm = [
        (object)[
            'name' => 'Ординар',
            'tax' => 'typeBet',
            'description' => 'Выигрыш по одиночной ставке равен произведению поставленной суммы на коэффициент.',
            'slug' => 'single'
        ],
        (object)[
            'name' => 'Экспресс',
            'tax' => 'typeBet',
            'description' => 'Экспресс побеждает только тогда, когда все исходы в нем побеждают, а если проиграет хотя бы один исход, то проигрывает весь экспресс.',
            'slug' => 'express'
        ],

        (object)[
            'name' => 'Выигрыш',
            'tax' => 'statusBet',
            'slug' => 'victory'
        ],
        (object)[
            'name' => 'Проигрыш',
            'tax' => 'statusBet',
            'slug' => 'losing'
        ],
        (object)[
            'name' => 'Возврат',
            'tax' => 'statusBet',
            'slug' => 'return'
        ],
        (object)[
            'name' => 'Активная',
            'tax' => 'statusBet',
            'slug' => 'active'
        ],
    ];
    foreach ($insertTerm as $term) {
        wp_insert_term(
            $term->name,  // новый термин
            $term->tax, // таксономия
            array(
                'description' => $term->description,
                'slug' => $term->slug
            )
        );
    }
}

//add_filter('post_type_link', 'city_permalink', 1, 2);
function city_permalink( $permalink, $post ){
    $typePerm = strpos($permalink, '%type%') === FALSE;
    //if( $cityPerm and $typePerm )
     //   return $permalink;


    if(!$typePerm){
        $terms = get_the_terms($post, 'type');
        if( ! is_wp_error($terms) && !empty($terms) && is_object($terms[0]) )
            $taxonomy_slug = $terms[0]->slug.'/';
        else
            $taxonomy_slug = '';
        $permalink = str_replace('%type%/', $taxonomy_slug, $permalink );
    }
    return $permalink;
}