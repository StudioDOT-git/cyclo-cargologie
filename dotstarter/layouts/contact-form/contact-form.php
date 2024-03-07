<div class="f-contact-form">
    <div class="l-container">
        <div class="f-contact-form__wrapper">
            <div class="f-contact-form__column">
                <div class="f-contact-form__image">
                    <?= wp_get_attachment_image(get_sub_field('image'), 'large') ?>
                </div>
            </div>
            <div class="f-contact-form__column">
                <h1 class="f-contact-form__title heading2">
                    <?= get_sub_field('title') ?>
                </h1>
                <p class="f-contact-form__description body-lg">
                    <?= get_sub_field('description') ?>
                </p>
                <div class="f-contact-form__form-container">
                    <?php
                    $form_shortcode = get_sub_field('form_shortcode');
                    echo do_shortcode($form_shortcode);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>