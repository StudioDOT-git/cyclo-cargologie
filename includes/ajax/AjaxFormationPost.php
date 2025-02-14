<?php

class AjaxFormationPost
{
    const POST_TYPES_ALLOWED = ['formation'];

    static function explode($string): array
    {
        if (empty($string))
            return array();
        $exploded = explode(',', $string);
        return array_map('intval', $exploded);
    }
    static function renderPosts($request_args)
    {
        // Add debug output at the start
        echo '<div style="display:block" class="debug-info">';
        echo 'Request args: ';
        print_r($request_args);
        echo '<br>';

        $args = array(
            "post_type" => 'formation',
            'post_status' => 'publish',
            "posts_per_page" => $request_args['per_page'] ?? $posts_per_page,
            "paged" => $request_args['page'] ?? 1,
            "tax_query" => array(
                'relation' => 'AND'
            ),
            'meta_key' => 'date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_type' => 'NUMERIC'
        );

        if (isset($request_args['metier']) && !empty($request_args['metier'])) {
            $args["tax_query"][] = [
                "taxonomy" => "metier",
                "field" => "slug",
                "terms" => explode(',', $request_args['metier']),
                "operator" => "IN"
            ];
        }

        if (isset($request_args['operateur']) && !empty($request_args['operateur'])) {
            $args["tax_query"][] = [
                "taxonomy" => "operateur",
                "field" => "id",
                "terms" => self::explode($request_args['operateur']),
                "operator" => "IN"
            ];
            // Add debug output for tax query
            echo 'Operateur tax query: ';
            print_r($args["tax_query"]);
        }

        echo '</div>';

        if (isset($request_args['ville'])) {
            $args["tax_query"][] = [
                "taxonomy" => "ville",
                "field" => "id",
                "terms" => self::explode($request_args['ville']),
                "operator" => "IN"
            ];
        }

        $query = new WP_Query($args);

        echo '<div style="display:block" class="debug-info">';
        echo 'Found posts: ' . $query->found_posts . '<br>';
        echo 'Post IDs: ';
        while ($query->have_posts()) {
            $query->the_post();
            echo get_the_ID() . ', ';
        }
        echo '</div>';

        wp_reset_postdata();

        ob_start();

        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                dot_the_component('card');
            endwhile;
        endif;
        wp_reset_postdata();

        return [
            "render" => ob_get_clean(),
            "total_posts" => $query->found_posts,
            "max_num_pages" => $query->max_num_pages,
            "query" => $query
        ];
    }
    static function setGetFormationPostsRoute()
    {
        register_rest_route('ajax-formation-posts/v1', '/posts', [
            'methods' => 'GET',
            'callback' => function (WP_REST_Request $request) {
                $args = [
                    "page" => $request->get_param('page'),
                    "per_page" => $request->get_param('per_page'),
                    "ville" => $request->get_param('ville'),
                    "operateur" => $request->get_param('operateur'),
                    "date_filter" => $request->get_param('date_filter'),
                    "metier" => $request->get_param('metier'), // Add metier parameter
                    "s" => $request->get_param('s'),
                ];

                $query = self::renderPosts($args);

                $rendered_posts = $query['render'];
                $total_posts = $query['total_posts'];
                $max_num_page = $query['max_num_pages'];

                $headers = array(
                    'x-ap-totalpages' => $max_num_page,
                );

                return new WP_REST_Response(
                    ['rendered_posts' => $rendered_posts, 'max_num_pages' => $max_num_page, 'total_posts' => $total_posts],
                    200,
                    $headers
                );
            },
        ]);
    }
}
