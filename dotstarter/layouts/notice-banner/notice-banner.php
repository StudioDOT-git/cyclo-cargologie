<?php return; ?>
<div class="f-notice-banner">
    <div class="f-notice-banner__marquee-wrapper">
        <div class="c-marquee__item hidden">
            <span class="f-notice-banner__message"> <?= the_sub_field('message') ?></span>
        </div>
        <div class="c-marquee">
            <div class="c-marquee-inner">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <div class="c-marquee__item">
                        <span class="f-notice-banner__message"> <?= the_sub_field('message') ?></span>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="c-marquee-inner is-last">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <div class="c-marquee__item">
                        <span class="f-notice-banner__message"> <?= the_sub_field('message') ?></span>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
