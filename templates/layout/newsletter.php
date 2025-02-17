<?php if (!is_404()): ?>
    <div class="l-newsletter l-layout">
        <div class="l-newsletter__container">
            <div class="l-newsletter__column">
                <h3 class="heading3">
                    <?php the_field('title', 'option') ?>
                </h3>
                <span class="heading6">
                    <?php the_field('text', 'option') ?>
                </span>
                <?php
                // $newsletter_form = get_field('form_shortcode', 'option');
                // echo do_shortcode($newsletter_form);
                ?>
                <form id="newsletter-form" class="f-newsletter__form c-newsletter-form" action="">
                    <label class="c-newsletter-form__control">
                        <input class="c-newsletter-form__input" type="email" name="email" id="newsletter-email"
                            placeholder="Votre e-mail*" required>
                    </label>
                    <div class="c-newsletter-form__expandable">
                        <div class="c-newsletter-form__columns">
                            <label class="c-newsletter-form__control">
                                <input class="c-newsletter-form__input" type="text" name="lastname" id="newsletter-lastname"
                                    placeholder="Nom de famille*" required>
                            </label>
                            <label class="c-newsletter-form__control">
                                <input class="c-newsletter-form__input" type="text" name="firstname"
                                    id="newsletter-firstname" placeholder="Prénom*" required>
                            </label>
                        </div>

                        <label class="c-newsletter-form__control">
                            <input class="c-newsletter-form__input" type="text" name="company" id="newsletter-company"
                                placeholder="Entreprise*" required>
                        </label>
                        <label class="c-newsletter-form__control">
                            <input class="c-newsletter-form__input" type="text" name="role" id="newsletter-role"
                                placeholder="Fonction">
                        </label>
                        <label class="c-newsletter-form__control">
                            <input class="c-newsletter-form__input" type="text" name="city" id="newsletter-city"
                                placeholder="Ville*" required>
                        </label>

                        <div id="newsletter-feedback" class="c-newsletter-form__feedback"></div>
                        <label class="c-newsletter-form__terms" for="newsletter-terms">
                            <input id="newsletter-terms" type="checkbox" name="terms" />
                            <img class="c-newsletter-form__checkmark" src="<?= DOT_THEME_URI ?>/assets/icons/check.svg"
                                alt="">
                            <?php the_field('terms') ?>En validant votre inscription, vous acceptez que Cyclo-cargologie
                            mémorise et utilise votre adresse email dans le but de vous envoyer sa lettre d’informations. *
                        </label>
                        <input class="c-button c-button--b c-button--s c-button--yellow" type="submit" value="Envoyer" />
                    </div>
                </form>
            </div>
            <div class="l-newsletter__column">
                <?php if (get_field('title_mouvement', 'option')): ?>
                    <h3 class="heading3">
                        <?php echo esc_html(get_field('title_mouvement', 'option')); ?>
                    </h3>
                <?php endif; ?>

                <?php if (get_field('text_mouvement', 'option')): ?>
                    <span class="heading6">
                        <?php echo wp_kses_post(get_field('text_mouvement', 'option')); ?>
                    </span>
                <?php endif; ?>

                <?php
                if (have_rows('buttons_mouvement', 'option')):
                    echo '<div class="l-newsletter__button-container">';
                    while (have_rows('buttons_mouvement', 'option')):
                        the_row();
                        if (have_rows('button_mouvement')):
                            while (have_rows('button_mouvement')):
                                the_row();
                                dot_the_layout_part('button');
                            endwhile;
                        endif;
                    endwhile;
                    echo '</div>';
                endif;
                ?>
            </div>
        </div>
        <img class="l-newsletter__deco" src="<?= get_stylesheet_directory_uri(); ?>/assets/img/deco-newsletter.svg"
            alt="deco">
    </div>
<?php endif; ?>
