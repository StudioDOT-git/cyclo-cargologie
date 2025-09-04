<?php
// Activation guard: if disabled in options, output nothing
// if (!get_field('activer_les_pop-ups', 'option')) {
//     return;
// }
// Get today's date and the start/end dates in the same format as ACF date_picker return_format
$today = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
// Fetch ACF group for personalized message
$message_perso = get_field('message_personnalise', 'option');
$date_debut = $message_perso && isset($message_perso['date_debut_popup_perso']) ? $message_perso['date_debut_popup_perso'] : '';
$date_fin = $message_perso && isset($message_perso['date_fin_popup_perso']) ? $message_perso['date_fin_popup_perso'] : '';

// Convert to DateTime objects for comparison
$date_debut_obj = $date_debut ? DateTime::createFromFormat('d/m/Y', $date_debut) : false;
$date_fin_obj = $date_fin ? DateTime::createFromFormat('d/m/Y', $date_fin) : false;

// Check if today is within the range (inclusive)
$is_perso = false;
if ($date_debut_obj && $date_fin_obj) {
    $is_perso = ($today >= $date_debut_obj && $today <= $date_fin_obj);
}

// Get color class
$color_class = $is_perso
    ? 'l-pop-up--' . esc_attr($message_perso['couleur_popup_perso'] ?? '')
    : 'l-pop-up--' . esc_attr(get_field('couleur_popup_newsletter', 'option'));
?>
<?php
// Determine cookie duration based on context (newsletter vs personalized)
if ($is_perso) {
    $cookie_duration = $message_perso['duree_du_cookie_message_personnalise'] ?? '';
} else {
    $cookie_duration = get_field('cookie_duration_popup_perso', 'option');
}
if (!$cookie_duration)
    $cookie_duration = 24; // fallback

// Create content hash to reset cookie when content changes
$popup_title = $is_perso
    ? ($message_perso['titre_popup_perso'] ?? '')
    : get_field('titre_popup_newsletter', 'option');
$content_hash = substr(md5($popup_title), 0, 8); // Short hash of title
?>
<div class="l-pop-up <?= $color_class ?>" data-cookie-duration="<?= esc_attr($cookie_duration) ?>"
    data-content-hash="<?= esc_attr($content_hash) ?>">
    <button class="l-pop-up__close" aria-label="Fermer le pop-up">&times;</button>

    <?php if ($is_perso): ?>
        <div class="l-pop-up__header-container">
            <?php if (have_rows('message_personnalise_sticker_message_perso', 'option')): ?>
                <?php while (have_rows('message_personnalise_sticker_message_perso', 'option')):
                    the_row(); ?>
                    <?php dot_the_layout_part('deco'); ?>
                <?php endwhile; ?>
            <?php endif; ?>
            <div>
                <h3><?php echo esc_html($message_perso['titre_popup_perso'] ?? ''); ?></h3>
                <p><?php echo wp_kses_post($message_perso['text_popup_perso_copier'] ?? ''); ?></p>
            </div>
        </div>
        <?php if (have_rows('message_personnalise_button_popup_perso', 'option')): ?>
            <div class="f-cards-columns__cta-wrapper">
                <?php while (have_rows('message_personnalise_button_popup_perso', 'option')):
                    the_row(); ?>
                    <?php dot_the_layout_part('button'); ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="l-pop-up__header-container">

            <?php if (have_rows('sticker_message_newsletter', 'option')): ?>
                <?php while (have_rows('sticker_message_newsletter', 'option')):
                    the_row(); ?>
                    <?php dot_the_layout_part('deco'); ?>
                <?php endwhile; ?>
            <?php endif; ?>
            <div>
                <h3><?php the_field('titre_popup_newsletter', 'option'); ?></h3>
                <p><?php the_field('text_pop_newsletter', 'option'); ?></p>
            </div>
        </div>
        <form id="newsletter-popup-form" class="f-newsletter__form c-newsletter-form" action="">
            <label class="c-newsletter-form__control">
                <input class="c-newsletter-form__input" type="email" name="email" id="newsletter-popup-email"
                    placeholder="Votre e-mail*" required>
            </label>
            <div class="c-newsletter-form__expandable">
                <div class="c-newsletter-form__columns">
                    <label class="c-newsletter-form__control">
                        <input class="c-newsletter-form__input" type="text" name="lastname" id="newsletter-popup-lastname"
                            placeholder="Nom de famille*" required>
                    </label>
                    <label class="c-newsletter-form__control">
                        <input class="c-newsletter-form__input" type="text" name="firstname" id="newsletter-popup-firstname"
                            placeholder="Prénom*" required>
                    </label>
                </div>

                <label class="c-newsletter-form__control">
                    <input class="c-newsletter-form__input" type="text" name="company" id="newsletter-popup-company"
                        placeholder="Entreprise*" required>
                </label>
                <label class="c-newsletter-form__control">
                    <input class="c-newsletter-form__input" type="text" name="role" id="newsletter-popup-role"
                        placeholder="Fonction">
                </label>
                <label class="c-newsletter-form__control">
                    <input class="c-newsletter-form__input" type="text" name="city" id="newsletter-popup-city"
                        placeholder="Ville*" required>
                </label>

                <div id="newsletter-popup-feedback" class="c-newsletter-form__feedback"></div>
                <label class="c-newsletter-form__terms" for="newsletter-popup-terms">
                    <input id="newsletter-popup-terms" type="checkbox" name="terms" />
                    <img class="c-newsletter-form__checkmark" src="<?= DOT_THEME_URI ?>/assets/icons/check.svg" alt="">
                    <?php the_field('terms') ?>En validant votre inscription, vous acceptez que Cyclo-cargologie
                    mémorise et utilise votre adresse email dans le but de vous envoyer sa lettre
                    d’informations. *
                </label>
                <input class="c-button c-button--b c-button--s c-button--yellow" type="submit" value="Envoyer" />
            </div>
        </form>
    <?php endif; ?>
</div>
