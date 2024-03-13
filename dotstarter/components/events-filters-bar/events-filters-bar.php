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


?>

<div id="events-filters-bar" class="c-events-filters-bar">
    <div class="l-container">
        <div class="c-filters-bar">
            <div class="c-filters-bar__left">
                <div class="c-filters-bar__header">
                    <div class="c-filters-bar__title">Filtres</div>
                    <div class="c-button c-button--sm c-button--yellow-1 reset-filters">Effacer les filtres</div>
                </div>
                <div class="c-filters-bar__filters">
                    <?php foreach ($taxonomies as $tax) : ?>
                        <div
                            class="c-multi-filter c-multi-filter--whitec-events-filters-bar__select c-multi-terms-selector"
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
                </div>
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
            <div class="c-filters-bar__right">
                <form id="c-filters-bar-search-form" class="c-filters-bar-search-form c-events-search-form">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M11.164 10.133L16 14.97L14.969 16L10.133 11.164C9.03131 12.0397 7.66537 12.5163 6.25801 12.516C5.43579 12.5174 4.62142 12.3562 3.86168 12.0418C3.10195 11.7274 2.41183 11.266 1.83101 10.684C0.65919 9.50899 0.000789981 7.91746 1.21194e-05 6.258C-0.00160851 5.43568 0.159321 4.62116 0.473548 3.86125C0.787776 3.10133 1.2491 2.41102 1.83101 1.83C3.00643 0.6583 4.59834 0.000247782 6.25801 0C7.92801 0 9.49301 0.658 10.684 1.831C11.8564 3.00609 12.5152 4.59805 12.516 6.258C12.516 7.68 12.036 9.031 11.164 10.133ZM6.25801 1.458C4.97801 1.458 3.76801 1.956 2.86201 2.862C0.996012 4.729 0.996012 7.787 2.86201 9.653C3.30717 10.0999 3.8365 10.4542 4.41939 10.6954C5.00229 10.9365 5.6272 11.0598 6.25801 11.058C7.53801 11.058 8.74701 10.56 9.65301 9.653C11.52 7.787 11.52 4.729 9.65301 2.863C9.20797 2.41618 8.67881 2.06196 8.09609 1.82081C7.51338 1.57965 6.88865 1.45634 6.25801 1.458Z"
                              fill="#181818"/>
                    </svg>
                    <input type="text" class="c-filters-bar-search-form__input" placeholder="Rechercher"/>
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
        <div class="c-events-filters-bar__filters">
            <div id="reset-filters" class="c-events-filters-bar__reset c-tag c-tag--white">
                Reset <?= dot_get_icon('cross') ?></div>
            <ul id="selected-terms-pills" class="c-events-filters-bar__selected"></ul>
        </div>


    </div>
</div>
