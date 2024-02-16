<div class="f-impact-section">
    <div class="l-container">
        <div class="f-impact-section__tb">
            <div class="f-impact-section__headings">
                <h6 class="f-impact-section__subtitle"><?= get_sub_field('subtitle'); ?></h6>
                <h2 class="f-impact-section__title"><?= get_sub_field('title'); ?></h2>
                <p class="f-impact-section__introduction"><?= get_sub_field('introduction') ?></p>
            </div>

            <div class="f-impact-section__content">
                <?php $key_numbers_section = get_sub_field('key_numbers_section'); ?>
                <h3 class="f-impact-section__key-numbers-title"><?= $key_numbers_section['title'] ?></h3>
                <ul class="f-impact-section__key-numbers-list">
                    <?php foreach ($key_numbers_section['key_numbers'] as $key_number): ?>
                        <li class="f-impact-section__key-number">
                            <h4 class="f-impact-section__key-number-title"><?= $key_number['number'] ?></h4>
                            <p class="f-impact-section__key-number-value"><?= $key_number['representation'] ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
