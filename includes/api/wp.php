<?php

function dot_register_wp_rest_routes() {
    register_rest_route("dot", "/page-slugs", [
        "methods" => "GET",
        "callback" => "dot_get_all_page_slugs",
    ]);
}
add_action("rest_api_init", 'dot_register_wp_rest_routes');


function dot_get_all_page_slugs() {
    $pages = get_pages();

    $slugs = array_map(function ($page) {
        return $page->post_name;
    }, $pages);

    return $slugs;
}
