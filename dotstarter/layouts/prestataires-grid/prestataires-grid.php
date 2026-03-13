<div class="f-prestataires-grid l-layout">
    <div class="l-container">
        <div class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
            <div class="l-layout__deco-container">
                <?php if (have_rows('sticker')): ?>
                    <?php while (have_rows('sticker')):
                        the_row(); ?>
                        <?php dot_the_layout_part('deco'); ?>
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

        <div class="l-container l-container--md">
            <?php $image = get_sub_field('image'); ?>
            <?php if ($image): ?>
                <div class="f-prestataires-grid__image-container">
                    <img
                        class="f-prestataires-grid__image"
                        src="<?= $image['url'] ?>"
                        alt="<?= $image['alt'] ?>">
                </div>
            <?php endif; ?>

            <div class="f-prestataires-grid__list">
                <?php
                $prestataires = get_terms(array(
                    'taxonomy' => 'prestataire',
                    'hide_empty' => false,
                ));

                if (!empty($prestataires) && !is_wp_error($prestataires)):
                    $counter = 0;

                    foreach ($prestataires as $prestataire):
                        $term_context = 'prestataire_' . $prestataire->term_id;
                        $logo = get_field('logo', $term_context);
                        $materiels = get_field('materiel_propose', $term_context);
                        $texte = get_field('texte', $term_context);
                        $site_internet = get_field('site_internet', $term_context);

                        if ($materiels && !is_array($materiels)) {
                            $materiels = array($materiels);
                        }
                        ?>
                        <div class="f-prestataires-grid__item <?= ($counter === 0) ? 'js-open' : '' ?>">
                            <?php $counter++; ?>

                            <?php if ($logo): ?>
                                <div class="f-prestataires-grid__logo">
                                    <?= wp_get_attachment_image($logo['ID'], 'full'); ?>
                                </div>
                            <?php endif; ?>

                            <h3 class="f-prestataires-grid__name heading6">
                                <?= $prestataire->name; ?>
                            </h3>

                            <button class="f-prestataires-grid__dropdown-button">
                                <svg width="9" height="11" viewBox="0 0 9 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.02849 10.2561L5.27564 10.0089L7.15037 8.1342L8.65137 6.63321L8.65137 5.13221L8.44641 5.13221L5.36003 8.21859L5.36003 0.930638C5.36003 0.852273 5.29975 0.791992 5.22139 0.791992L4.29306 0.791992C4.2147 0.791992 4.15442 0.852273 4.15442 0.930638L4.15442 8.21256L1.07406 5.13221L0.869109 5.13221L0.869109 6.63321L3.90726 9.67136L4.49199 10.2561L5.02849 10.2561Z"
                                        fill="#181818" />
                                </svg>
                            </button>

                            <div class="f-prestataires-grid__inner">
                                <?php if (!empty($materiels)): ?>
                                    <div class="f-prestataires-grid__materiels">
                                        <span class="f-prestataires-grid__materiels-text">Matériel proposé :</span>
                                        <?php foreach ($materiels as $materiel): ?>
                                            <?php
                                            $materiel_id = is_object($materiel) ? $materiel->ID : $materiel;
                                            $materiel_title = get_the_title($materiel_id);
                                            if (!$materiel_title) {
                                                continue;
                                            }
                                            ?>
                                            <span class="f-prestataires-grid__materiel-item"><?= $materiel_title; ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($texte): ?>
                                    <div class="f-prestataires-grid__texte">
                                        <?= $texte; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($site_internet['url'])): ?>
                                    <div class="f-prestataires-grid__liens">
                                        <a
                                            href="<?= $site_internet['url']; ?>"
                                            target="<?= !empty($site_internet['target']) ? $site_internet['target'] : '_self'; ?>"
                                            class="f-prestataires-grid__lien">
                                            <?= !empty($site_internet['title']) ? $site_internet['title'] : 'Site internet'; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if (have_rows('button', $term_context)): ?>
                                    <?php while (have_rows('button', $term_context)):
                                        the_row(); ?>
                                        <?php dot_the_layout_part('button'); ?>
                                    <?php endwhile; ?>
                                <?php elseif (!empty($site_internet['url'])): ?>
                                    <a
                                        href="<?= $site_internet['url']; ?>"
                                        target="<?= !empty($site_internet['target']) ? $site_internet['target'] : '_self'; ?>"
                                        class="c-button c-button--xs c-button--b c-button--green">
                                        <span>Contacter l'entreprise</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                            <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"></circle>
                                            <path class="c-button__arrow"
                                                d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z">
                                            </path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="f-prestataires-grid__cta-wrapper">
                <?php while (have_rows('button')):
                    the_row(); ?>
                    <?php dot_the_layout_part('button'); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
