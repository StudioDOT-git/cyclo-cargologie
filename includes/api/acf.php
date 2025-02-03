<?php

function dot_register_acf_rest_routes() {
    register_rest_route("dot", "options/all", [
        "methods" => "GET",
        "callback" => "dot_acf_options_route",
    ]);

    register_rest_route("dot", "options/(?P<slug>[a-zA-Z0-9-]+)", [
        "methods" => "GET",
        "callback" => "dot_acf_option_route",
        'args' => array(
            'slug' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param);
                }
            )
        ),
    ]);
}
add_action("rest_api_init", 'dot_register_acf_rest_routes');


function dot_acf_options_route() {
    return get_fields('options');
}


function dot_acf_option_route(WP_REST_Request $data) {
    return get_field($data['slug'], 'options');
}
