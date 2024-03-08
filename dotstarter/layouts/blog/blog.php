<?php

$posts_per_page = 8;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$query = new WP_Query(array(
    "post_type" => "post",
    "posts_per_page" => $posts_per_page,
    "paged" => $paged,
));

$categories = get_categories();
$tags = get_tags();
?>

<div class="f-blog__background">
    <svg viewBox="0 0 219 340" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M95.1074 362H16.3201C10.9402 362 6.56488 357.667 6.46765 352.259V350.304C5.23608 274.134 -56.3743 212.918 -132.18 212.657C-137.592 212.657 -142 208.194 -142 202.753V123.684C-142 118.08 -137.365 113.552 -131.823 113.78C-3.61169 119.025 99.7096 222.92 104.928 351.77C105.154 357.374 100.649 362 95.075 362H95.1074Z"
            fill="#FFEC54"/>
        <path
            d="M31.1005 0H-132.135C-137.586 0 -142 4.42933 -142 9.90085V89.1077C-142 94.5792 -137.586 99.0085 -132.135 99.0085H110.187C115.639 99.0085 120.052 103.438 120.052 108.909V352.099C120.052 357.571 124.466 362 129.918 362H208.842C214.294 362 218.707 357.571 218.707 352.099V188.279C218.707 185.641 217.669 183.133 215.819 181.277L38.0777 2.89861C36.228 1.0422 33.7291 0 31.1005 0Z"
            fill="#FFEC54"/>
    </svg>
</div>
<div class="f-blog" data-posts-per-page="<?= $posts_per_page ?>">
    <div class="l-container l-container--md">
        <div class="c-filters-bar">
            <div class="c-filters-bar__left">
                <div class="c-filters-bar__header">
                    <div class="c-filters-bar__title">Filtres</div>
                    <div class="c-button c-button--sm c-button--yellow-1 reset-filters">Effacer les filtres</div>
                </div>
                <div class="c-filters-bar__filters">
                    <div class="c-multi-filter c-multi-filter--white" data-taxonomy="categories">
                        <div class="c-multi-filter__toggle">
                            <span class="c-multi-filter__toggle-label">Catégories</span>
                            <div class="c-multi-filter__toggle-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                    <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"/>
                                    <path class="c-button__arrow"
                                          d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="c-multi-filter__options">
                            <?php foreach ($categories as $cat) : ?>
                                <div class="c-multi-filter__option" data-term-id="<?= $cat->term_id ?>"
                                     data-selected="false">
                                    <?= $cat->name; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="c-filters-bar__right">
                <form id="posts-search-form" class="c-filters-bar-search-form c-posts-search-form">
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.164 10.133L16 14.97L14.969 16L10.133 11.164C9.03131 12.0397 7.66537 12.5163 6.25801 12.516C5.43579 12.5174 4.62142 12.3562 3.86168 12.0418C3.10195 11.7274 2.41183 11.266 1.83101 10.684C0.65919 9.50899 0.000789981 7.91746 1.21194e-05 6.258C-0.00160851 5.43568 0.159321 4.62116 0.473548 3.86125C0.787776 3.10133 1.2491 2.41102 1.83101 1.83C3.00643 0.6583 4.59834 0.000247782 6.25801 0C7.92801 0 9.49301 0.658 10.684 1.831C11.8564 3.00609 12.5152 4.59805 12.516 6.258C12.516 7.68 12.036 9.031 11.164 10.133ZM6.25801 1.458C4.97801 1.458 3.76801 1.956 2.86201 2.862C0.996012 4.729 0.996012 7.787 2.86201 9.653C3.30717 10.0999 3.8365 10.4542 4.41939 10.6954C5.00229 10.9365 5.6272 11.0598 6.25801 11.058C7.53801 11.058 8.74701 10.56 9.65301 9.653C11.52 7.787 11.52 4.729 9.65301 2.863C9.20797 2.41618 8.67881 2.06196 8.09609 1.82081C7.51338 1.57965 6.88865 1.45634 6.25801 1.458Z" fill="#181818"/>
                    </svg>
                    <input type="text" class="c-filters-bar-search-form__input" placeholder="Rechercher" />
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                            <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"/>
                            <path class="c-button__arrow"
                                  d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <div class="f-blog__posts">
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                <?php dot_the_component('card') ?>
            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>
        </div>
        <?php if (!$query->have_posts()): ?>
            <div class="f-blog__no-results">
                <div>Aucun article trouvé</div>
            </div>
        <?php endif; ?>

        <div class="f-blog__pagination c-pagination" data-max-num-pages="<?= $query->max_num_pages ?>"
             data-paged="<?= $paged ?>">
            <div class="c-pagination__prev" rel="prev">Précédent</div>
            <div class="c-pagination__pages"></div>
            <div class="c-pagination__next" rel="next">Suivant</div>
        </div>
    </div>
</div>


<?php


$events = tribe_get_events(['posts_per_page' => 2, 'start_date' => 'now']);

?>

<div class="f-related-events">
    <div class="l-container l-container--md">
        <div class="f-related-events__tb">
            <div class="f-related-events__title heading2">Nos prochains RDV</div>
            <div class="f-related-events__events">
                <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $event) : ?>
                        <?php setup_postdata($GLOBALS['post'] = $event); ?>
                        <?php dot_the_component('card') ?>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="f-related-events__cta">
                <a href="<?= get_post_type_archive_link('tribe_events') ?>"
                   class="c-button c-button--lg c-button--black">
                    <span>Découvrir les évènements</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"/>
                        <path class="c-button__arrow"
                              d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
