<?php
$is_admin_preview = is_admin();
$admin_input_attr = $is_admin_preview ? ' disabled' : '';
$required_input_attr = $is_admin_preview ? '' : ' required';
?>

<div class="f-newsletter-form l-layout">
    <div class="l-container">
        <div class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
            <div class="l-layout__deco-container">
                <?php if (have_rows('sticker')): ?>
                    <?php while (have_rows('sticker')):
                        the_row() ?>
                        <?php dot_the_layout_part('deco') ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="l-layout__titles">
                <h6 class="l-layout__subtitle">
                    <?= get_sub_field('subtitle') ?>
                </h6>
                <h2 class="l-layout__title">
                    <?= get_sub_field('title') ?>
                </h2>
            </div>
            <div class="l-layout__description body-md">
                <?= get_sub_field('description') ?>
            </div>
        </div>

        <div class="f-newsletter-form__container">

            <form id="newsletter-form-block" class="f-newsletter__form c-newsletter-form" action="">
                <label class="c-newsletter-form__control">
                    <input class="c-newsletter-form__input" type="email" name="email" id="newsletter-block-email"
                        placeholder="Votre e-mail*"<?= $required_input_attr ?><?= $admin_input_attr ?>>
                </label>
                <div class="c-newsletter-form__expandable is-expanded">
                    <div class="c-newsletter-form__columns">
                        <label class="c-newsletter-form__control">
                            <input class="c-newsletter-form__input" type="text" name="lastname"
                                id="newsletter-block-lastname" placeholder="Nom de famille*"<?= $required_input_attr ?><?= $admin_input_attr ?>>
                        </label>
                        <label class="c-newsletter-form__control">
                            <input class="c-newsletter-form__input" type="text" name="firstname"
                                id="newsletter-block-firstname" placeholder="Prénom*"<?= $required_input_attr ?><?= $admin_input_attr ?>>
                        </label>
                    </div>

                    <label class="c-newsletter-form__control">
                        <input class="c-newsletter-form__input" type="text" name="company" id="newsletter-block-company"
                            placeholder="Entreprise*"<?= $required_input_attr ?><?= $admin_input_attr ?>>
                    </label>
                    <label class="c-newsletter-form__control">
                        <input class="c-newsletter-form__input" type="text" name="role" id="newsletter-block-role"
                            placeholder="Fonction"<?= $admin_input_attr ?>>
                    </label>
                    <label class="c-newsletter-form__control">
                        <input class="c-newsletter-form__input" type="text" name="city" id="newsletter-block-city"
                            placeholder="Ville*"<?= $required_input_attr ?><?= $admin_input_attr ?>>
                    </label>

                    <div id="newsletter-block-feedback" class="c-newsletter-form__feedback"></div>
                    <label class="c-newsletter-form__terms" for="newsletter-block-terms">
                        <input id="newsletter-block-terms" type="checkbox" name="terms"<?= $admin_input_attr ?> />
                        <img class="c-newsletter-form__checkmark" src="<?= DOT_THEME_URI ?>/assets/icons/check.svg"
                            alt="">
                        <?php the_field('terms') ?>En validant votre inscription, vous acceptez que Cyclo-cargologie
                        mémorise et utilise votre adresse email dans le but de vous envoyer sa lettre d’informations. *
                    </label>
                    <input class="c-button c-button--b c-button--s c-button--yellow" type="submit" value="Envoyer"<?= $admin_input_attr ?> />
                </div>
            </form>
        </div>
    </div>
</div>
