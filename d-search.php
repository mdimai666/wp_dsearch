<?php
/*
Plugin Name: Поиск Дмитрия
Plugin URI: http://amai-lab.com
Description: Предоставляет список постов; /wp-json/dsearch/v1/posts?search=a&posts_per_page=20&exact=1&categories=33
Version: 0.5
Author: mdimai666
Author URI: http://amai-lab.com
*/

add_action( 'rest_api_init', function () {
    // register_rest_route( 'dsearch/v1', '/posts/(?P<id>\d+)', array(
    //   'methods' => 'GET',
    //   'callback' => 'd_ajax_search',
    // ));
    register_rest_route( 'dsearch/v1', '/posts/', array(
      'methods' => ['GET'],
      'callback' => 'd_ajax_search',
    ));
});

function d_ajax_search(){
    
    global $post;

    $search_text = $_GET['search'];
    $posts_per_page = $_GET['posts_per_page'];

    $categories = isset($_GET['categories'])?$_GET['categories']:'';
    $exact = isset($_GET['exact'])?$_GET['exact']:0;
    $lang = isset($_GET['lang'])?$_GET['lang']:'';

    $response = [];

    if(!empty($categories))
        $response['categories'] = $categories;

    $response['search'] = $search_text;

    query_posts("s=$search_text&post_type=post&posts_per_page=$posts_per_page&post_status=publish&cat=$categories&exact=$exact&lang=$lang");
    
    $m_posts = [];

    $props = ['ID', 'post_title', 'post_date', 'post_name', 'post_parent', 'guid'];

    if(have_posts()) {
        while(have_posts()){
            the_post();

            $m_posts[] = [
                'ID' => $post->ID,
                'post_title' => $post->post_title,
                'slug' => $post->post_name,
                'post_date' => $post->post_date,
                'post_parent' => $post->post_parent,
                // 'guid' => $post->guid,
                'categories' => wp_get_post_categories($post->ID),
            ];

        }
    }

    $response['posts'] = $m_posts;


    wp_send_json($m_posts);
    // wp_send_json($response);

}