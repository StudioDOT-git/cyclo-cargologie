<?php

$current_categories = $_GET['tribe_events_cat'] ?? [];
$current_categories = AjaxPost::explode($current_categories);

$current_formats = $_GET['format'] ?? [];
$current_formats = AjaxPost::explode($current_formats);


$taxonomies = array(
    array(
        'label' => 'Type d’événement',
        'slug' => 'tribe_events_cat',
        'terms' => get_terms('tribe_events_cat'),
        'current' => $current_categories
    ),
    array(
        'label' => 'Format',
        'slug' => 'format',
        'terms' => get_terms('format'),
        'current' => $current_formats
    ),
);


$resetFiltersDisabled = empty($current_categories) && empty($current_formats) ? 'disabled' : '';

?>

<div id="events-filters-bar" class="c-events-filters-bar">
    <div class="l-container">
        <div class="c-filters-bar">
            <div class="c-filters-bar__header">
                <div class="c-filters-bar__header-left">
                    <div class="c-filters-bar__title">Filtres</div>
                    <button type="button" class="c-button c-button--b c-button--sm c-button--yellow-1 reset-filters" <?=$resetFiltersDisabled?>>Effacer les filtres</button>
                </div>
                <div class="c-filters-bar__header-right c-filters-bar__filters-toggle-wrapper">
                    <button id="filters-open" class="c-filters-bar__filters-open">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.75 12C18.75 12.1989 18.671 12.3897 18.5303 12.5303C18.3897 12.671 18.1989 12.75 18 12.75H6C5.80109 12.75 5.61032 12.671 5.46967 12.5303C5.32902 12.3897 5.25 12.1989 5.25 12C5.25 11.8011 5.32902 11.6103 5.46967 11.4697C5.61032 11.329 5.80109 11.25 6 11.25H18C18.1989 11.25 18.3897 11.329 18.5303 11.4697C18.671 11.6103 18.75 11.8011 18.75 12ZM21.75 6.75H2.25C2.05109 6.75 1.86032 6.82902 1.71967 6.96967C1.57902 7.11032 1.5 7.30109 1.5 7.5C1.5 7.69891 1.57902 7.88968 1.71967 8.03033C1.86032 8.17098 2.05109 8.25 2.25 8.25H21.75C21.9489 8.25 22.1397 8.17098 22.2803 8.03033C22.421 7.88968 22.5 7.69891 22.5 7.5C22.5 7.30109 22.421 7.11032 22.2803 6.96967C22.1397 6.82902 21.9489 6.75 21.75 6.75ZM14.25 15.75H9.75C9.55109 15.75 9.36032 15.829 9.21967 15.9697C9.07902 16.1103 9 16.3011 9 16.5C9 16.6989 9.07902 16.8897 9.21967 17.0303C9.36032 17.171 9.55109 17.25 9.75 17.25H14.25C14.4489 17.25 14.6397 17.171 14.7803 17.0303C14.921 16.8897 15 16.6989 15 16.5C15 16.3011 14.921 16.1103 14.7803 15.9697C14.6397 15.829 14.4489 15.75 14.25 15.75Z"
                                fill="#111928"/>
                        </svg>
                    </button>
                    <button id="filters-close" class="c-filters-bar__filters-close">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                                stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.16992 14.8299L14.8299 9.16992" stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.8299 14.8299L9.16992 9.16992" stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="c-filters-bar__filters">
                <div class="c-filters-bar__filters-taxonomies">
                    <?php foreach ($taxonomies as $tax) : ?>
                        <div
                            class="c-multi-filter c-multi-filter--white c-events-filters-bar__select c-multi-terms-selector"
                            data-taxonomy="<?= $tax['slug'] ?>">
                            <div class="c-multi-filter__toggle">
                                <span class="c-multi-filter__toggle-label"><?= $tax['label'] ?></span>
                                <div class="c-multi-filter__toggle-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"/>
                                        <path class="c-button__arrow"
                                              d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="c-multi-filter__options">
                                <?php foreach ($tax['terms'] as $term) : ?>
                                    <div class="c-multi-filter__option" data-slug="<?= $term->slug ?>"
                                         data-selected="<?= in_array($term->term_id, $tax['current']) ? 'true' : 'false' ?>"
                                         data-term-id="<?= $term->term_id ?>"><?= $term->name ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="c-filters-bar__past-events-btn">
                        <a href="/archive-evenements" class="c-button c-button--filter">
                            <span>Évènements passés</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"/>
                                <path class="c-button__arrow"
                                      d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="c-filters-bar__filters-search">
                    <form id="c-filters-bar-search-form" class="c-filters-bar-search-form c-events-search-form">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11.164 10.133L16 14.97L14.969 16L10.133 11.164C9.03131 12.0397 7.66537 12.5163 6.25801 12.516C5.43579 12.5174 4.62142 12.3562 3.86168 12.0418C3.10195 11.7274 2.41183 11.266 1.83101 10.684C0.65919 9.50899 0.000789981 7.91746 1.21194e-05 6.258C-0.00160851 5.43568 0.159321 4.62116 0.473548 3.86125C0.787776 3.10133 1.2491 2.41102 1.83101 1.83C3.00643 0.6583 4.59834 0.000247782 6.25801 0C7.92801 0 9.49301 0.658 10.684 1.831C11.8564 3.00609 12.5152 4.59805 12.516 6.258C12.516 7.68 12.036 9.031 11.164 10.133ZM6.25801 1.458C4.97801 1.458 3.76801 1.956 2.86201 2.862C0.996012 4.729 0.996012 7.787 2.86201 9.653C3.30717 10.0999 3.8365 10.4542 4.41939 10.6954C5.00229 10.9365 5.6272 11.0598 6.25801 11.058C7.53801 11.058 8.74701 10.56 9.65301 9.653C11.52 7.787 11.52 4.729 9.65301 2.863C9.20797 2.41618 8.67881 2.06196 8.09609 1.82081C7.51338 1.57965 6.88865 1.45634 6.25801 1.458Z"
                                  fill="#181818"/>
                        </svg>
                        <input type="search" class="c-filters-bar-search-form__input" placeholder="Rechercher"/>
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
        </div>
    </div>
</div>
