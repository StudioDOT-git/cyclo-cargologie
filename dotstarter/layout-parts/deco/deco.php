<?php

$is_active = get_sub_field('is_deco_active');
if (!$is_active) {
    return;
}
$deco_name = get_sub_field('deco');

?>

<div class="c-deco">
    <img src="<?= DOT_THEME_URI . '/assets/img/deco/' . $deco_name . '.svg' ?>" alt="Décoration">
</div>
