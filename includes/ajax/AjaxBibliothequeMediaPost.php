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

        $args = array_merge([
            "post_type" => 'bibliotheque-media',
            'post_status' => 'publish',
            "posts_per_page" => $request_args['posts_per_page'] ?? $posts_per_page,
            "paged" => $request_args['paged'] ?? 1,
        ], $request_args);

        // Pass through tax_query if present (for media_category filtering)
        if (isset($request_args['tax_query'])) {
            $args['tax_query'] = $request_args['tax_query'];
        }

        // Search
        if (isset($request_args['s'])) {
            $args["s"] = $request_args['s'];
        }

        if (isset($request_args['meta_key'])) {
            $args['meta_key'] = $request_args['meta_key'];
        }
        if (isset($request_args['meta_type'])) {
            $args['meta_type'] = $request_args['meta_type'];
        }
        if (isset($request_args['orderby'])) {
            $args['orderby'] = $request_args['orderby'];
        }

        error_log('Final query args: ' . print_r($args, true));

        $query = new WP_Query($args);

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

    static function setGetBibliothequeMediaPostsRoute()
    {
        register_rest_route('ajax-bibliotheque-media-posts/v1', '/posts', [
            'methods' => 'GET',
            'callback' => function (WP_REST_Request $request) {
                // Normalize and map incoming params to WP_Query args
                $args = [];

                // Pagination
                $page = intval($request->get_param('page')) ?: 1;
                $per_page = intval($request->get_param('per_page')) ?: 12;
                $args['paged'] = $page;
                $args['posts_per_page'] = $per_page;

                // Search and ordering
                if ($request->get_param('s')) {
                    $args['s'] = $request->get_param('s');
                }
                if ($request->get_param('orderby')) {
                    $args['orderby'] = $request->get_param('orderby');
                }
                if ($request->get_param('order')) {
                    $args['order'] = $request->get_param('order');
                }

                // Support legacy "category" and specific taxonomy "media_category" (comma-separated slugs)
                $media_category = $request->get_param('media_category');
                $category = $request->get_param('category');
                if (!empty($media_category)) {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'media_category',
                            'field' => 'slug',
                            'terms' => array_map('trim', explode(',', $media_category)),
                        ]
                    ];
                } elseif (!empty($category)) {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'media_category',
                            'field' => 'slug',
                            'terms' => array_map('trim', explode(',', $category)),
                        ]
                    ];
                }

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
