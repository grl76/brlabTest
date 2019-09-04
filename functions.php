<?php

require_once( __DIR__ . '/inc/inc.php' );

show_admin_bar(false);

add_action('init', 'modify_jquery');
function modify_jquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'http://code.jquery.com/jquery-latest.min.js', array(), false, false);
        wp_enqueue_script('jquery');
    }
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
function enqueue_styles() {
    /** REGISTER css **/
    wp_register_style( 'bootstrap-style', THEME_DIR_URI . '/css/bootstrap.min.css', array(), '4', 'all' );
    wp_enqueue_style( 'bootstrap-style' );
    wp_register_style( 'screen-style', THEME_DIR_URI . '/style.css?', array(), filemtime(THEME_DIR . '/style.css'), 'all' );
    wp_enqueue_style( 'screen-style' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
function enqueue_scripts() {
    /** REGISTER Script **/
    wp_register_script( 'bets', THEME_DIR_URI . '/js/betsTest.js', array( 'jquery' ), filemtime(THEME_DIR . '/js/betsTest.js'), true );
    wp_enqueue_script( 'bets' );

    $arr = array(
        'root'  => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    );

    if(is_archive()){
        $statusTerm = get_term_by('slug', 'active', 'statusBet');
        $arr['statusTerm'] = $statusTerm->term_id;
    }

    if(is_single()){
        $arr['idSingle'] = get_the_ID() ;
    }

    wp_localize_script( 'bets', 'REST_API_data',  $arr);
}


// Удаляем роль при деактивации нашей темы
add_action( 'switch_theme', 'deactivate_my_theme' );
function deactivate_my_theme() {
    remove_role( 'kapper' );
}

// Добавляем роль при активации нашей темы
add_action( 'after_switch_theme', 'activate_my_theme' );
function activate_my_theme() {
    // Получим объект данных роли именно "Автор" для работы rest api
    $author = get_role( 'author' );
    $editor = get_role( 'editor' );
// Создадим новую роль и наделим её правами "Автора"
    add_role( 'kapper', 'Каппер', $author->capabilities );
    add_role( 'moder', 'Модератор', $editor->capabilities );

}
