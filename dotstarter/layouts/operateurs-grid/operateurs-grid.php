<div class="f-operateurs-grid l-layout">
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
        <div class="l-container l-container--md">
            <div class="f-operateurs-grid__image-container">
                <img class="f-operateurs-grid__image" src="<?= get_sub_field('image')['url'] ?>"
                    alt="<?= get_sub_field('image')['alt'] ?>">
            </div>
            <div class="f-operateurs-grid__list">
                <?php
                $operateurs = get_terms(array(
                    'taxonomy' => 'operateur',
                    'hide_empty' => false,
                ));

                if (!empty($operateurs) && !is_wp_error($operateurs)):
                    $counter = 0;
                    foreach ($operateurs as $operateur):
                        $logo = get_field('logo', 'operateur_' . $operateur->term_id);
                        $parcours = get_field('parcours', 'operateur_' . $operateur->term_id);
                        $villes = get_field('villes', 'operateur_' . $operateur->term_id);
                        $texte = get_field('texte', 'operateur_' . $operateur->term_id);
                        $liens = get_field('villes_copier', 'operateur_' . $operateur->term_id);
                        ?>
                        <div class="f-operateurs-grid__item <?= ($counter === 0) ? 'js-open' : '' ?>">
                            <?php $counter++; ?>
                            <?php if ($logo): ?>
                                <div class="f-operateurs-grid__logo">
                                    <?= wp_get_attachment_image($logo['ID'], 'full'); ?>
                                </div>
                            <?php endif; ?>

                            <h3 class="f-operateurs-grid__name heading6"><?php echo $operateur->name; ?></h3>
                            <button class="f-operateurs-grid__dropdown-button"><svg width="9" height="11" viewBox="0 0 9 11"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.02849 10.2561L5.27564 10.0089L7.15037 8.1342L8.65137 6.63321L8.65137 5.13221L8.44641 5.13221L5.36003 8.21859L5.36003 0.930638C5.36003 0.852273 5.29975 0.791992 5.22139 0.791992L4.29306 0.791992C4.2147 0.791992 4.15442 0.852273 4.15442 0.930638L4.15442 8.21256L1.07406 5.13221L0.869109 5.13221L0.869109 6.63321L3.90726 9.67136L4.49199 10.2561L5.02849 10.2561Z"
                                        fill="#181818" />
                                </svg>
                            </button>

                            <div class="f-operateurs-grid__inner">
                                <?php if ($parcours): ?>
                                    <div class="f-operateurs-grid__parcours">
                                        <span class="f-operateurs-grid__parcours-text">Propose les parcours : </span>
                                        <?php foreach ($parcours as $type): ?>
                                            <span class="f-operateurs-grid__parcours-item"><?= $type ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($villes): ?>
                                    <div class="f-operateurs-grid__villes">
                                        <span class="f-operateurs-grid__villes-text">Disponible dans les villes :</span>
                                        <?php foreach ($villes as $ville): ?>
                                            <span class="f-operateurs-grid__ville"><?= $ville['ville'] ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($texte): ?>
                                    <div class="f-operateurs-grid__texte">
                                        <?= $texte ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($liens): ?>
                                    <div class="f-operateurs-grid__liens">
                                        <?php foreach ($liens as $lien): ?>
                                            <a href="<?= $lien['lien']['url'] ?>" target="<?= $lien['lien']['target'] ?>"
                                                class="f-operateurs-grid__lien">
                                                <?= $lien['lien']['title'] ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <button class="c-button c-button--xs c-button--b c-button--green">
                                    <span>Voir les sessions de <?php echo $operateur->name; ?> </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"></circle>
                                        <path class="c-button__arrow"
                                            d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>

            <div class="f-operateurs-grid__cta-wrapper">
                <?php while (have_rows('button')):
                    the_row() ?>
                    <?php dot_the_layout_part('button') ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>