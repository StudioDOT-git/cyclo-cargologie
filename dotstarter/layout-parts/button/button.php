<?php

$is_active = get_sub_field('is_active');
if (!$is_active) {
    return;
}
$label = get_sub_field('label');
$color = get_sub_field('color');
$type = get_sub_field('type');
$size = get_sub_field('size');

$link = get_sub_field('link');


$is_button = get_sub_field('fonctionnement')

    ?>

<?php if ($is_active): ?>
    <?php if (is_array($link)): ?>
        <?php
        $url = $link['url'];

        $target = $link['target'] !== '' ? $link['target'] : false;

        if (!$is_button) {
            if ($link['title'] !== '') {
                $label = $link['title'];
            } else {
                $label = $url;
            }
        }

        ?>
        <a <?= $target ? "target=\"$target\"" : '' ?> href="<?= $url ?? '#' ?>"
            class="c-button c-button--<?= $size ?> c-button--<?= $type ?>   c-button--<?= $color ?>">
            <span>
                <?= $label ?>
            </span>
            <?php if ($type == 'a'): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                    <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                    <path class="c-button__arrow"
                        d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                </svg>
            <?php endif; ?>
        </a>
    <?php else: ?>
        <button class="c-button c-button--<?= $size ?> c-button--<?= $type ?>  c-button--<?= $color ?> c-button__modal">
            <span>
                <?= $label ?>
            </span>
            <?php if ($type == 'a'): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                    <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                    <path class="c-button__arrow"
                        d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                </svg>
            <?php endif; ?>
        </button>
    <?php endif; ?>
<?php endif; ?>
