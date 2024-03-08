<?php


/**
 * dot_get_icon
 * Get svg icon from slug
 *
 * @param [type] $slug
 * @param [type] $className
 * @return void
 */
function dot_get_icon($slug, $className = null) {
    $icon = '';

    switch ($slug) {
        case 'facebook':
            $icon = '<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.08512 8.29058L8.08512 8.29054H8.07893H7.47322V8.19589H8.07893C8.39268 8.19589 8.6936 8.07126 8.91547 7.84939C9.13734 7.62752 9.26197 7.32661 9.26197 7.01286V5.55534C9.26197 4.56861 9.39382 4.09239 9.60691 3.84405C9.79903 3.62014 10.1576 3.47322 10.9845 3.47322H11.7605V3.56784H11.6943C10.7309 3.56784 10.1265 3.90083 9.80628 4.43388C9.52608 4.90037 9.52666 5.43434 9.52695 5.70155C9.52696 5.70987 9.52697 5.71793 9.52697 5.72572V6.97499C9.52697 7.28874 9.6516 7.58966 9.87347 7.81153C10.0953 8.0334 10.3963 8.15803 10.71 8.15803H11.6304L11.6207 8.26513L10.7468 8.29065C10.4376 8.2958 10.1423 8.42095 9.92351 8.63976C9.70369 8.85958 9.5784 9.15655 9.57433 9.46739L9.57429 9.46739V9.47358V15.4361H9.26197V9.47358H9.26201L9.26193 9.46739C9.25786 9.15655 9.13257 8.85958 8.91275 8.63976C8.69293 8.41994 8.39596 8.29465 8.08512 8.29058Z" fill="#232323" stroke="#333333" stroke-width="0.946431"/>
            </svg>
            ';
            break;
        case 'instagram':
            $icon = '<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_2001_41595)">
            <path d="M12.0681 3.52344H6.93293C5.04992 3.52344 3.52344 5.04992 3.52344 6.93293V12.0681C3.52344 13.9511 5.04992 15.4776 6.93293 15.4776H12.0681C13.9511 15.4776 15.4776 13.9511 15.4776 12.0681V6.93293C15.4776 5.04992 13.9511 3.52344 12.0681 3.52344Z" stroke="#333333" stroke-miterlimit="10"/>
            <path d="M9.49544 12.2565C11.0203 12.2565 12.2565 11.0203 12.2565 9.49544C12.2565 7.97054 11.0203 6.73438 9.49544 6.73438C7.97054 6.73438 6.73438 7.97054 6.73438 9.49544C6.73438 11.0203 7.97054 12.2565 9.49544 12.2565Z" stroke="#333333" stroke-miterlimit="10"/>
            <path d="M12.9873 6.68156C13.3858 6.68156 13.7089 6.35847 13.7089 5.95992C13.7089 5.56137 13.3858 5.23828 12.9873 5.23828C12.5887 5.23828 12.2656 5.56137 12.2656 5.95992C12.2656 6.35847 12.5887 6.68156 12.9873 6.68156Z" fill="#333333"/>
            </g>
            <defs>
            <clipPath id="clip0_2001_41595">
            <rect width="13" height="13" fill="white" transform="translate(3 3)"/>
            </clipPath>
            </defs>
            </svg>
            ';
            break;
        case 'twitter':
            $icon = '<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.43 5.20001C14.9157 5.5128 14.3504 5.7328 13.76 5.85001C13.5178 5.58386 13.223 5.37089 12.8942 5.22458C12.5654 5.07827 12.2098 5.00179 11.85 5C11.1453 5.01054 10.4734 5.29926 9.98077 5.80316C9.48811 6.30707 9.21463 6.98529 9.21999 7.69C9.2224 7.89519 9.24586 8.09961 9.28999 8.30002C8.24141 8.24455 7.21689 7.96503 6.28542 7.48032C5.35394 6.9956 4.53713 6.31695 3.89 5.49002C3.55071 6.08109 3.44566 6.77799 3.59566 7.44281C3.74566 8.10763 4.13977 8.6919 4.7 9.08002C4.2821 9.07042 3.87315 8.95699 3.50999 8.75V8.75C3.50461 9.36403 3.71025 9.9613 4.09251 10.4419C4.47478 10.9224 5.01048 11.2571 5.60999 11.39C5.38515 11.4513 5.15302 11.4816 4.92 11.48C4.75523 11.4836 4.59064 11.4668 4.42999 11.43C4.58972 11.9598 4.91248 12.4258 5.35236 12.7615C5.79223 13.0972 6.32681 13.2857 6.87999 13.3C5.95627 14.0439 4.80601 14.4497 3.62 14.45C3.41 14.45 3.2 14.45 3 14.45C4.18828 15.2305 5.57835 15.6475 7 15.65C7.9939 15.6436 8.97663 15.4399 9.89124 15.0508C10.8058 14.6617 11.6341 14.095 12.328 13.3834C13.0219 12.6718 13.5677 11.8295 13.9337 10.9054C14.2996 9.9813 14.4785 8.99375 14.46 8C14.46 7.89 14.46 7.77002 14.46 7.65002C14.9778 7.27052 15.4218 6.79941 15.77 6.26001C15.2916 6.47982 14.7824 6.62484 14.26 6.69C14.8142 6.34759 15.2288 5.81958 15.43 5.20001V5.20001Z" stroke="#333333" stroke-linejoin="round"/></svg>';
            break;
        case 'linkedin':
            $icon = '<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_2001_113883)">
            <path d="M4.67188 14.7209V8.38086H5.58187V14.7209H4.67188Z" fill="black" stroke="#333333"/>
            <path d="M5.06001 4.49581L5.12005 4.50307L5.1801 4.49581C5.25101 4.48722 5.32298 4.49395 5.39113 4.51553C5.45928 4.53711 5.52198 4.57303 5.57503 4.62087C5.62812 4.66875 5.67033 4.72744 5.69879 4.79295C5.72723 4.8584 5.74132 4.92928 5.74009 5.00082L5.73961 5.02876L5.74224 5.05658C5.74676 5.10425 5.74116 5.15231 5.72582 5.19762C5.71159 5.23967 5.6893 5.27845 5.66027 5.31182C5.5937 5.37497 5.51515 5.42425 5.42922 5.45671C5.33938 5.49065 5.24342 5.50546 5.14748 5.50018L5.10362 5.49777L5.06001 5.50304C4.98947 5.51157 4.91795 5.50497 4.8502 5.4837C4.78247 5.46243 4.72003 5.42696 4.66702 5.37963C4.61399 5.33228 4.57169 5.27423 4.54292 5.20935C4.51413 5.14442 4.4995 5.07407 4.50001 5.00304L4.50007 5.00304L4.50001 4.99581C4.4995 4.9248 4.51412 4.85448 4.54292 4.78953C4.57169 4.72466 4.61399 4.66661 4.66702 4.61925C4.72003 4.57192 4.78247 4.53646 4.8502 4.51519C4.91802 4.49389 4.98954 4.4873 5.06001 4.49581Z" fill="black" stroke="#333333"/>
            <path d="M13.8582 11.2692V15.2092H15.7681V10.9892C15.7681 8.89922 14.7681 7.70922 13.0381 7.70922C12.6126 7.68354 12.1883 7.77767 11.8136 7.98095C11.4389 8.18423 11.1287 8.4885 10.9182 8.85921L10.2281 10.0192V7.8792H8.32812C8.32812 9.3492 8.32812 13.8792 8.32812 15.2092H10.2381V11.0992C10.2373 10.8337 10.2812 10.57 10.3681 10.3192C10.4947 9.95659 10.7293 9.64146 11.0404 9.41619C11.3515 9.19093 11.7241 9.06633 12.1082 9.0592C12.7482 9.0592 13.8582 9.34922 13.8582 11.2692Z" fill="#333333"/>
            </g>
            <defs>
            <clipPath id="clip0_2001_113883">
            <rect width="11.77" height="11.21" fill="white" transform="translate(4 4)"/>
            </clipPath>
            </defs>
            </svg>
            ';
            break;
        case 'youtube':
            $icon = '<svg class="c-icon" width="15" height="11" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.0605 5.45094C14.0892 6.33332 14.0424 7.21654 13.9205 8.09094C13.8906 8.59875 13.6774 9.07847 13.3205 9.44094C12.9626 9.8015 12.487 10.0215 11.9805 10.0609C8.74319 10.2476 5.49781 10.2476 2.2605 10.0609C1.75113 10.0212 1.27253 9.80145 0.910495 9.44094C0.551258 9.08006 0.337636 8.59942 0.310489 8.09094C0.120462 6.33941 0.120462 4.57246 0.310489 2.82093C0.337636 2.31245 0.551258 1.83183 0.910495 1.47094C1.27253 1.11043 1.75113 0.890628 2.2605 0.85093C5.49781 0.664273 8.74319 0.664273 11.9805 0.85093C12.487 0.890354 12.9626 1.11038 13.3205 1.47094C13.6774 1.83342 13.8906 2.31311 13.9205 2.82093C14.0421 3.692 14.089 4.57188 14.0605 5.45094Z" fill="#26211F" /><path d="M6.22842 7.73085L5.91843 7.44086L5.64844 3.13086L9.41843 5.41086L6.22842 7.73085Z" fill="white" /></svg>';
            break;
        case 'return':
            return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.67443 17.9858C4.62012 21.0989 8.06806 23.1622 12.0047 23.1622C18.077 23.1622 23 18.2392 23 12.1668C23 6.09445 18.086 1.17139 12.0137 1.17139C7.63363 1.17139 3.85087 3.73245 2.08618 7.44283" stroke="#232323" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/><path d="M1 3.87695L2.07692 7.43348L5.63345 6.36562" stroke="#232323" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/><path d="M12.9003 6.13965V13.4971L7.75098 16.1577" stroke="#232323" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/></svg>';
            break;
    }

    if ($className) {
        str_replace('class="c-icon"', "class=\"c-icon $className\"", $icon);
    }

    return $icon;
}

function dot_get_formatted_event_date()
{
    $start_date = tribe_get_start_date(null, true, 'D. d F, H\h');
    $start_date = ucwords($start_date);

    $end_date = tribe_get_end_date(null, false, 'D. d F');

    $start_date_year = tribe_get_start_date(null, false, 'Y');
    $end_date_year = tribe_get_end_date(null, false, 'Y');

    $show_start_date_year = false;
    $show_end_date = false;

    if ($start_date !== $end_date) {
        $show_end_date = false;

        if ($start_date_year === $end_date_year) {
            $show_start_date_year = false;
        }
    }

    if ($show_start_date_year) {
        $start_date = "$start_date\h, <span>$start_date_year</span>";
    }

    $full_date = $show_end_date ?
        "$start_date > $end_date <span>$end_date_year</span>" :
        $start_date;

    return $full_date;
}


/**
 * the_menu
 * function to render a menu using a custom Walker_Nav_Menu
 *
 * @param string $location
 * @return void
 */
function the_menu($location = 'main-menu') {
    $menu_params = array(
        'theme_location' => $location,
        'container'       => false,
        'echo'            => false,
        'depth'           => 0,
        'walker' => new Description_Walker,
    );

    $menu = strip_tags(wp_nav_menu($menu_params), '<a>');

    echo $menu;
}


/**
 * is_edit_page
 * function to check if the current page is a post edit page
 *
 * @param string $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
 * @return boolean
 * @author Ohad Raz <admin@bainternet.info>
 *
 */
function is_edit_page($new_edit = null) {
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;

    if ($new_edit == "edit")
        return in_array($pagenow, array('post.php',));
    elseif ($new_edit == "new") //check for new post page
        return in_array($pagenow, array('post-new.php'));
    else //check for either new or edit
        return in_array($pagenow, array('post.php', 'post-new.php'));
}

/**
 * is_edit_page_post_type_page
 * function to check if the current page is the page edit page
 *
 * @return boolean
 */
function is_edit_page_type_page(): bool {
    if (!is_edit_page())
        return false;

    if (get_current_screen() && get_current_screen()->post_type === 'page')
        return true;

    return false;
}


