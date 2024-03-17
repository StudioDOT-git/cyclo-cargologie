<?php

class  AjaxPost
{
//    TODO : Add the ability to filter by post type
    const POST_TYPES_ALLOWED = ['post', 'tribe_events', 'page'];

    static function explode($string): array
    {
        if (empty($string)) return array();
        $exploded = explode(',', $string);
        return array_map('intval', $exploded);
    }

    static function renderPosts($request_args)
    {

        $posts_per_page = 4;

        $args = array(
            "post_type" => $request_args['post_type'] ?? 'post',
            'post_status' => 'publish',
            "posts_per_page" => $request_args['per_page'] ?? $posts_per_page,
            "paged" => $request_args['page'] ?? 1,
            "tax_query" =>  array(
                'relation' => 'AND'
            )
        );
        if (isset( $request_args['post_type'] )) {
            if($request_args['post_type'] === 'all'){
                $args['post_type'] = self::POST_TYPES_ALLOWED;
            }
        }

        if (isset($request_args['tribe_events_cat'])) {
            $args["tax_query"][] = [
                "taxonomy" => "tribe_events_cat",
                "field" => "id",
                "terms" => self::explode($request_args['tribe_events_cat']),
                "operator" => "IN"

            ];
        }

        if (isset($request_args['format'])) {
            $args["tax_query"][] = [
                "taxonomy" => "format",
                "field" => "id",
                "terms" => self::explode($request_args['format']),
                "operator" => "IN"

            ];
        }

        if (isset($request_args['categories'])) {
            $args["tax_query"][] = [
                "taxonomy" => "category",
                "field" => "id",
                "terms" => self::explode($request_args['categories']),
                "operator" => "IN"
            ];
        }

        if (isset($request_args['s'])) {
            $args["s"] = $request_args['s'];
        }

        $query = new WP_Query($args);



        ?>
        <?php ob_start(); ?>

        <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php dot_the_component('card') ?>
        <?php endwhile; ?>
    <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <?php return ["render" => ob_get_clean(), "total_posts" => $query->found_posts, "max_num_pages" => $query->max_num_pages];
    }


    static function setGetPostsRoute()
    {
        register_rest_route('ajax-posts/v1', '/posts', [
            'methods' => 'GET',
            'callback' => function (WP_REST_Request $request) {
                $args = [
                    "page" => $request->get_param('page'),
                    "post_type" => $request->get_param('post_type'),
                    "per_page" => $request->get_param('per_page'),
                    "page" => $request->get_param('page'),
                    "tribe_events_cat" => $request->get_param('tribe_events_cat'),
                    "format" => $request->get_param('format'),
                    "categories" => $request->get_param('categories'),
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
