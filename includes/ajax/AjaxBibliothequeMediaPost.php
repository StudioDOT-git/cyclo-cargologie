<?php

class AjaxBibliothequeMediaPost
{
    const POST_TYPES_ALLOWED = ['bibliotheque-media'];

    static function explode($string): array
    {
        if (empty($string))
            return array();
        $exploded = explode(',', $string);
        return array_map('intval', $exploded);
    }

    static function renderPosts($request_args)
    {
        error_log('Debug AjaxBibliothequeMediaPost: Starting renderPosts');
        error_log('Request args: ' . print_r($request_args, true));

        $posts_per_page = 12;

        $args = array(
            "post_type" => 'bibliotheque-media',
            'post_status' => 'publish',
            "posts_per_page" => $request_args['posts_per_page'] ?? $posts_per_page,
            "paged" => $request_args['paged'] ?? 1,
            "orderby" => $request_args['orderby'] ?? 'date',
            "order" => $request_args['order'] ?? 'DESC',
        );

        // Pass through tax_query if present (for media_category filtering)
        if (isset($request_args['tax_query'])) {
            $args['tax_query'] = $request_args['tax_query'];
        }

        // Search
        if (isset($request_args['s'])) {
            $args["s"] = $request_args['s'];
        }

        error_log('Final query args: ' . print_r($args, true));

        $query = new WP_Query($args);

        ob_start();

        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                include get_template_directory() . '/dotstarter/components/card/media-card.php';
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

    static function setGetBibliothequeMediaPostsRoute()
    {
        register_rest_route('ajax-bibliotheque-media-posts/v1', '/posts', [
            'methods' => 'GET',
            'callback' => function (WP_REST_Request $request) {
                $args = [
                    "page" => $request->get_param('page'),
                    "per_page" => $request->get_param('per_page'),
                    "category" => $request->get_param('category'),
                    "s" => $request->get_param('s'),
                    "orderby" => $request->get_param('orderby'),
                    "order" => $request->get_param('order'),
                ];

                $query = self::renderPosts($args);

                $rendered_posts = $query['render'];
                $total_posts = $query['total_posts'];
                $max_num_page = $query['max_num_pages'];

                $headers = array(
                    'x-ap-totalpages' => $max_num_page,
                );

                return new WP_REST_Response(
                    [
                        'rendered_posts' => $rendered_posts,
                        'max_num_pages' => $max_num_page,
                        'total_posts' => $total_posts,
                        'debug' => [
                            'request_args' => $args,
                            'query_args' => $query['query']->query,
                            'tax_query' => $query['query']->tax_query
                        ]
                    ],
                    200,
                    $headers
                );
            },
        ]);
    }
}
