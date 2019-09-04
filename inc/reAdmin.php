<?php
function remove_menus(){
    //remove_menu_page( 'index.php' );                  //Консоль
    remove_menu_page( 'edit.php' );                   //Записи
      remove_menu_page( 'upload.php' );                 //Медиафайлы
    //  remove_menu_page( 'edit.php?post_type=page' );    //Страницы
    remove_menu_page( 'edit-comments.php' );          //Комментарии
  //  remove_menu_page( 'themes.php' );                 //Внешний вид
  //  remove_menu_page( 'plugins.php' );                //Плагины
    //remove_menu_page( 'users.php' );                  //Пользователи
    //remove_menu_page( 'tools.php' );                  //Инструменты
    //remove_menu_page( 'options-general.php' );        //Настройки
}
add_action( 'admin_menu', 'remove_menus' );

add_filter( 'rest_authentication_errors', function( $result ){

    if( empty( $result ) && ! is_user_logged_in() ){
        return new WP_Error( 'rest_forbidden', 'You are not currently logged in.', array( 'status' => 401 ) );
    }

    return $result;
});

function pss_disable_emoji() {
    /*--- REMOVE GENERATOR META TAG ---*/
    remove_action( 'wp_head', 'feed_links', 2 ); // Удаляет ссылки RSS-лент записи и комментариев
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // Удаляет ссылки RSS-лент категорий и архивов
    remove_action( 'wp_head', 'rsd_link' ); // Удаляет RSD ссылку для удаленной публикации
    remove_action( 'wp_head', 'wlwmanifest_link' ); // Удаляет ссылку Windows для Live Writer
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0); // Удаляет короткую ссылку
    remove_action( 'wp_head', 'wp_generator' ); // Удаляет информацию о версии WordPress
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Удаляет ссылки на предыдущую и следующую статьи
// отключение WordPress REST API
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
   // remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'pss_disable_emoji' );

## Удаление виджета "Добро пожаловать"
remove_action( 'welcome_panel', 'wp_welcome_panel' );

function true_remove_default_widget() {
    unregister_widget('WP_Widget_Archives'); // Архивы
    unregister_widget('WP_Widget_Calendar'); // Календарь
    unregister_widget('WP_Widget_Categories'); // Рубрики
    unregister_widget('WP_Widget_Meta'); // Мета
    unregister_widget('WP_Widget_Pages'); // Страницы
    unregister_widget('WP_Widget_Recent_Comments'); // Свежие комментарии
    unregister_widget('WP_Widget_Recent_Posts'); // Свежие записи
    unregister_widget('WP_Widget_RSS'); // RSS
    unregister_widget('WP_Widget_Search'); // Поиск
    unregister_widget('WP_Widget_Tag_Cloud'); // Облако меток
    unregister_widget('WP_Widget_Text'); // Текст
    unregister_widget('WP_Nav_Menu_Widget'); // Произвольное меню
}
add_action( 'widgets_init', 'true_remove_default_widget', 20 );

function clear_wp_dash(){
    $dash_side   = & $GLOBALS['wp_meta_boxes']['dashboard']['side']['core'];
    $dash_normal = & $GLOBALS['wp_meta_boxes']['dashboard']['normal']['core'];

    unset( $dash_side['dashboard_quick_press'] );       // Быстрая публикация
    unset( $dash_side['dashboard_recent_drafts'] );     // Последние черновики
    unset( $dash_side['dashboard_primary'] );           // Блог WordPress
    unset( $dash_side['dashboard_secondary'] );         // Другие Новости WordPress

    unset( $dash_normal['dashboard_incoming_links'] );  // Входящие ссылки
    unset( $dash_normal['dashboard_right_now'] );       // Прямо сейчас
    unset( $dash_normal['dashboard_recent_comments'] ); // Последние комментарии
    unset( $dash_normal['dashboard_plugins'] );         // Последние Плагины

    unset( $dash_normal['dashboard_activity'] );        // Активность
}
add_action( 'wp_dashboard_setup', 'clear_wp_dash' );


//Определение директории поиска шаблонов
add_filter('page_template_hierarchy', function( $templates ){
    array_unshift( $templates, 'tpl/page/'. $templates[0] );
    return $templates;
});
add_filter('single_template_hierarchy', function( $templates ){
    array_unshift( $templates, 'tpl/single/'. $templates[1] );
    return $templates;
});
add_filter('archive_template_hierarchy', function( $templates ){
    array_unshift( $templates, 'tpl/archive/'. $templates[0] );
    return $templates;
});