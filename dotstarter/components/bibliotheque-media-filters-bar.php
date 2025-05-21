<?php
$current_categories = $_GET['category'] ?? [];
$current_categories = AjaxPost::explode($current_categories);

$taxonomies = array(
    array(
        'label' => 'Type de média',
        'slug' => 'category',
        'terms' => get_terms(['taxonomy' => 'category', 'hide_empty' => true]),
        'current' => $current_categories
    ),
);

$resetFiltersDisabled = empty($current_categories) ? 'disabled' : '';
?>
<div id="bibliotheque-media-filters-bar" class="c-formation-filters-bar">
    <div class="l-container">
        <div class="c-filters-bar">
            <div class="c-filters-bar__header">
                <div class="c-filters-bar__header-left">
                    <div class="c-filters-bar__title">Filtres</div>
                    <button type="button" class="c-button c-button--b c-button--sm c-button--yellow-1 reset-filters"
                        <?= $resetFiltersDisabled ?>>Effacer les filtres</button>
                </div>
            </div>
            <div class="c-filters-bar__filters">
                <div class="c-filters-bar__filters-taxonomies">
                    <?php foreach ($taxonomies as $tax): ?>
                        <div class="c-multi-filter c-multi-filter--white c-formation-filters-bar__select c-multi-terms-selector"
                            data-taxonomy="<?= $tax['slug'] ?>">
                            <div class="c-multi-filter__toggle">
                                <span class="c-multi-filter__toggle-label"><?= $tax['label'] ?></span>
                                <div class="c-multi-filter__toggle-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                                        <path class="c-button__arrow"
                                            d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="c-multi-filter__options">
                                <?php foreach ($tax['terms'] as $term): ?>
                                    <div class="c-multi-filter__option" data-slug="<?= $term->slug ?>"
                                        data-selected="<?= in_array($term->term_id, $tax['current']) ? 'true' : 'false' ?>"
                                        data-term-id="<?= $term->term_id ?>">
                                        <?= $term->name ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>