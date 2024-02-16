<?php

global $events_archive_query, $events_query_base_args, $is_doing_events_archive_ajax, $events_query_posts_per_page;
$events_query_posts_per_page = 12;
$is_doing_events_archive_ajax = false;

// The base for the main Events Query arguments
$events_query_base_args = array(
    "post_type" => "tribe_events",
    'post_status' => 'publish',
    "posts_per_page" => $events_query_posts_per_page,
    "orderby" => "meta_value",
    "meta_key" => "_EventStartDate",
    "order" => "ASC",
);

/**
 * Load next events page in events archive. Ajax call only.
 *
 * @return array $data;
 * $data = [
 *  'html':   (string) => The rendered HTML
 *  'offset:' (int)    => Amount of currently loaded posts
 * ]
 *
 */
function dot_events_archive_load_next_page()
{
    if (!wp_doing_ajax()) {
        return;
    }

    global $is_doing_events_archive_ajax, $events_query_base_args, $events_archive_query, $events_query_posts_per_page;
    $is_doing_events_archive_ajax = true;

    $query_args = $events_query_base_args;

    // Prepare tax query
    $data = (json_decode(html_entity_decode(stripslashes($_POST['data'])), true));
    $termsSelection = array();

    // Set offset
    $query_args['offset'] = $data['offset'];
    $query_args['posts_per_page'] = $events_query_posts_per_page;
    $query_args['suppress_filters'] = true;

    // Get tax query taxonomies & terms
    foreach ($data['taxQueryParams'] as $taxConfig) {
        $taxonomy = $taxConfig['taxonomy'];
        $terms = $taxConfig['terms'];

        if (!empty($terms)) {
            $termsSelection[$taxonomy] = $terms;
        }
    }

    // Set tax query relation if needed
    $tax_query = array();
    if (count($termsSelection) > 1) {
        $tax_query['relation'] = 'AND';
    }

    // Build final tax_query
    foreach ($termsSelection as $taxonomy => $terms) {
        $tax_query[] = array(
            "taxonomy" => $taxonomy,
            "terms"    => $terms,
            "field"    => "slug",
            "operator" => "IN"
        );
    }

    // Add tax query to query args
    $query_args['tax_query'] = $tax_query;

    // Load only events starting from today
    $query_args['meta_query'] = array(
        array(
            "key" => "_EventEndDate",
            'value' => date("Y-m-d H:i:s"),
            'compare' => '>='
        ),
    );

    $events_archive_query = new WP_Query($query_args);
    $found_posts = $events_archive_query->found_posts;

    if ($found_posts > 0) {

        ob_start();

        while ($events_archive_query->have_posts()) {
            $events_archive_query->the_post();
            include(DOT_THEME_PATH . '/dotstarter/components/event-card/event-card.php');
        }

        $html = ob_get_clean();
    } else {
        $html = '<p>Aucun résultat pour cette recherche</p>';
    }

    $response = array(
        'html' => $html,
        'offset' => $query_args['offset'] + $events_query_posts_per_page,
        'found_posts' => $events_archive_query->found_posts,
        'fully_loaded' => $events_archive_query->found_posts < $events_query_posts_per_page
    );

    global $events_archive_query;
    if ($events_archive_query->post_count === 0) {
        wp_send_json_error($response);
    } else {
        wp_send_json_success($response);
    }

    $is_doing_events_archive_ajax = false;
    wp_die();
}
add_action('wp_ajax_load_events_archive_next_page', 'dot_events_archive_load_next_page');
add_action('wp_ajax_nopriv_load_events_archive_next_page', 'dot_events_archive_load_next_page');

/**
 * Load next month events in events archive. Ajax call only.
 *
 * @return array $data;
 * $data = [
 *  'html':               (string) => The rendered HTML
 * ]
 *
 */
function dot_events_archive_load_next_month()
{
    if (!wp_doing_ajax()) {
        return;
    }

    if (!isset($_POST)) {
        wp_send_json_error('Error : missing POST data');
        wp_die();
    }

    global $is_doing_events_archive_ajax, $events_query_base_args, $events_archive_query;
    $events_archive_query = null;
    $is_doing_events_archive_ajax = true;

    $query_args = $events_query_base_args;

    $data = json_decode(html_entity_decode(stripslashes($_POST['data'])), true);

    $start_date = new DateTime($data['intervalStart']);
    $months_to_load_count = $data['monthsToLoadCount'];

    // Prepare query
    $query_args['suppress_filters'] = true; // Remove tribe filters
    $query_args['posts_per_page'] = -1;

    $html = '';

    $i = 0;
    while ($i < $months_to_load_count) {
        if ($i > 0) {
            $start_date->modify('first day of next month');
        }

        $end_date = clone $start_date;
        $end_date->modify('first day of next month');

        $current_date = new DateTime();
        if ($current_date->format('m-Y') === $start_date->format('m-Y')) {
            $start_date = $current_date;
        }

        $query_args['meta_query'] = array(
            "relation" => "OR",
            array(
                "relation" => "AND", // Starts after first day of month and finish before last day of month
                array(
                    "key" => "_EventStartDate",
                    'value' => $start_date->format('Y-m-d'),
                    'compare' => '>='
                ),
                array(
                    "key" => "_EventEndDate",
                    'value' => $end_date->format('Y-m-d'),
                    'compare' => '<'
                ),
            ),
            array(
                "relation" => "AND", // Start before month but ends after
                array(
                    "key" => "_EventStartDate",
                    'value' => $start_date->format('Y-m-d'),
                    'compare' => '<='
                ),
                array(
                    "key" => "_EventEndDate",
                    "value" => $end_date->format('Y-m-d'),
                    "compare" => ">="
                )
            ),
            array(
                "relation" => "AND", // Start before month but ends after
                array(
                    "key" => "_EventStartDate",
                    'value' => $start_date->format('Y-m-d'),
                    'compare' => '>='
                ),
                array(
                    "key" => "_EventStartDate",
                    "value" => $end_date->format('Y-m-d'),
                    "compare" => "<"
                ),
                array(
                    "key" => "_EventEndDate",
                    "value" => $end_date->format('Y-m-d'),
                    "compare" => ">="
                )
            ),
            array(
                "relation" => "AND", // Start before month but ends after
                array(
                    "key" => "_EventStartDate",
                    'value' => $start_date->format('Y-m-d'),
                    'compare' => '<='
                ),
                array(
                    "key" => "_EventEndDate",
                    "value" => $end_date->format('Y-m-d'),
                    "compare" => "<"
                ),
                array(
                    "key" => "_EventEndDate",
                    "value" => $start_date->format('Y-m-d'),
                    "compare" => ">="
                ),
            )
        );

        // Prepare HTML
        $events_archive_query = new WP_Query($query_args);
        ob_start();

        dot_the_component('month-events-grid');

        $html .= ob_get_clean();

        $i++;
    }

    $response = array(
        'html' => $html,
        'found_posts' => $events_archive_query->found_posts
    );

    global $events_archive_query;
    if ($events_archive_query->post_count === 0) {
        wp_send_json_error($response);
    } else {
        wp_send_json_success($response);
    }

    $is_doing_events_archive_ajax = false;
    wp_die();
}
add_action('wp_ajax_load_events_archive_next_month', 'dot_events_archive_load_next_month');
add_action('wp_ajax_nopriv_load_events_archive_next_month', 'dot_events_archive_load_next_month');

function dot_past_events_load_more()
{
    $posts_per_page = $_POST['postsPerPage'] ?: 8;
    $offset = $_POST['offset'] ?: $posts_per_page;

    $eventsQuery = new WP_Query(array(
        "post_type" => "tribe_events",
        "post_status" => "publish",
        "posts_per_page" => $posts_per_page,
        "offset" => $offset,
        "orderby" => "meta_value",
        "meta_key" => "_EventStartDate",
        "order" => "DESC",
        "meta_query" => array(
            array(
                "key" => "_EventEndDate",
                'value' => (new DateTime())->format('Y-m-d'),
                'compare' => '<'
            ),
        )
    ));


    if ($eventsQuery->have_posts()) :
        while ($eventsQuery->have_posts()) :
            $eventsQuery->the_post();
            dot_the_component('event-card');
        endwhile;
    else :
        wp_send_json_error(null, 404);
    endif;

    wp_die();
}
add_action('wp_ajax_past_events_load_more', 'dot_past_events_load_more');
add_action('wp_ajax_nopriv_past_events_load_more', 'dot_past_events_load_more');

function dot_search_for_events()
{
    // Get search query
    if (!isset($_POST['s'])) {
        wp_send_json_error(null, 400);
    }

    global $events_query_base_args;
    $query_args = $events_query_base_args;

    $query_args['s'] = $_POST['s'];

    ob_start();

    $query = new WP_Query($query_args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            include(DOT_THEME_PATH . '/dotstarter/components/event-card/event-card.php');
        }
        wp_reset_postdata();
    } else {
        wp_send_json_error(null, 404);
    }

    $html = ob_get_clean();

    wp_send_json_success($html);

    wp_die();
}

add_action('wp_ajax_search_for_events', 'dot_search_for_events');
add_action('wp_ajax_nopriv_search_for_events', 'dot_search_for_events');
