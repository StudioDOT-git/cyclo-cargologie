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
            $newsletter_form = get_field('form_shortcode', 'option');
            echo do_shortcode($newsletter_form);
            ?>
        </div>
        <div class="l-newsletter__column">
            <h3 class="heading3">
                <?php the_field('title_mouvement', 'option') ?>
            </h3>
            <span class="heading6">
                <?php the_field('text_mouvement', 'option') ?>
            </span>



            <?php if (have_rows('buttons', 'option')): ?>
                <div class="l-newsletter__button-container">
                    <?php while (have_rows('buttons', 'option')):
                        the_row() ?>
                        <?php dot_the_layout_part('button', 'option') ?>

                    <?php endwhile; ?>
                </div>
            <?php endif; ?>



            <?php while (have_rows('contact_button', 'option')):
                the_row() ?>

                <?php dot_the_layout_part('button') ?>

            <?php endwhile; ?>



            <div class="l-newsletter__button-container">
                <button class="c-button c-button--s c-button--white">Sensibilisation <svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                        <path class="c-button__arrow"
                            d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                    </svg></button>
                <a href="#" class="c-button c-button--s c-button--white">Sensibilisation <svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                        <path class="c-button__arrow"
                            d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                    </svg></a>
                <a href="#" class="c-button c-button--s c-button--white">Sensibilisation <svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                        <path class="c-button__arrow"
                            d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                    </svg></a>
            </div>
        </div>

    </div>
    <img class="l-newsletter__deco" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/deco-newsletter.svg"
        alt="">

</div>
