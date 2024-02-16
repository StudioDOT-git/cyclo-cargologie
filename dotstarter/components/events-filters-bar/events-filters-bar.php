<?php
$taxonomies = array(
    array(
        'label' => 'Catégorie',
        'slug' => 'tribe_events_cat',
        'terms' => get_terms('tribe_events_cat')
    ),
    array(
        'label' => 'Tags',
        'slug' => 'tags',
        'terms' => get_tags()
    ),
)
?>

<div id="events-filters-bar" class="c-events-filters-bar">
    <div class="l-container">
        <div class="c-events-filters-bar__filters">
            <a href="/archive-evenements" class="c-events-filters-bar__past-events-btn" title="Évènements passés">
                <?= dot_get_icon('return') ?>
            </a>
            <div class="c-events-filters-bar__taxonomies">
                <?php foreach ($taxonomies as $tax) : ?>
                    <div class="c-events-filters-bar__taxonomy">
                        <div class="c-events-filters-bar__select c-multi-terms-selector" data-taxonomy="<?= $tax['slug'] ?>">
                            <div class="c-multi-terms-selector__label"><?= $tax['label'] ?></div>
                            <div class="c-multi-terms-selector__options-container">
                                <ul class="c-multi-terms-selector__options">
                                    <?php foreach ($tax['terms'] as $term) : ?>
                                        <li class="c-multi-terms-selector__option" data-slug="<?= $term->slug ?>" data-id="<?php echo $term->term_id ?>"><?= $term->name ?></li>
                                    <?php endforeach; ?>
                                    <li class="c-multi-terms-selector__button-container">
                                        <button class="c-multi-terms-selector__apply c-button">Appliquer</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="reset-filters" class="c-events-filters-bar__reset c-tag c-tag--white">Reset <?= dot_get_icon('cross') ?></div>
            <ul id="selected-terms-pills" class="c-events-filters-bar__selected"></ul>
        </div>

        <form id="events-search-form" class="c-events-filters-bar__search-form c-events-search-form">
            <input type="text" class="c-events-search-form__input" placeholder="Rechercher" />
            <input type="submit" class="c-events-search-form__submit" value="Ok" />
        </form>
    </div>
</div>
