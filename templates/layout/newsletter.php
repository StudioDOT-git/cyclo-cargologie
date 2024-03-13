<div class="l-newsletter">
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

                    <?php if (have_rows('regions')): ?>
                        <label class="c-newsletter-form__control">
                            <select class="c-newsletter-form__select" name="region" id="newsletter-region"
                                placeholder="Provenance géographique">
                                <option value="" disabled="" selected="">Provenance Géographique</option>

                                <?php while (have_rows('regions')):
                                    the_row() ?>
                                    <option value=" <?php the_sub_field('region') ?>">
                                        <?php the_sub_field('region') ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </label>
                    <?php endif; ?>
                    <div id="newsletter-feedback" class="c-newsletter-form__feedback"></div>
                    <label class="c-newsletter-form__terms" for="newsletter-terms">
                        <input id="newsletter-terms" type="checkbox" name="terms" />
                        <img class="c-newsletter-form__checkmark" src="<?= DOT_THEME_URI ?>/assets/icons/check.png"
                            alt="">
                        <?php the_field('terms') ?>
                    </label>
                    <input class="c-button c-button--dark-gray" type="submit" value="Envoyer" />
                </div>
            </form>

        </div>
        <div class="l-newsletter__column">
            <h3 class="heading3">
                <?php the_field('title_mouvement', 'option') ?>
            </h3>
            <span class="heading6">
                <?php the_field('text_mouvement', 'option') ?>
            </span>

            <?php if (have_rows('buttons_mouvement', 'option')): ?>
                <div class="l-newsletter__button-container">
                    <?php while (have_rows('buttons_mouvement', 'option')):
                        the_row() ?>
                        <?php while (have_rows('button_mouvement', 'option')):
                            the_row() ?>
                            <?php dot_the_layout_part('button') ?>
                        <?php endwhile; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <img class="l-newsletter__deco" src="<?= get_stylesheet_directory_uri(); ?>/assets/img/deco-newsletter.svg"
        alt="deco">
</div>
