<div class="f-video-player l-layout">
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

        <div class="f-video-player__iframe-container">
            <?php
            $video_type = get_sub_field('video_type'); // true = mp4, false = youtube
            if ($video_type):
                $video_url = get_sub_field('video');
                if ($video_url): ?>
                    <video controls playsinline poster="" width="100%" height="auto">
                        <source src="<?= esc_url($video_url) ?>" type="video/mp4">
                        <?= esc_html__('Votre navigateur ne supporte pas la vidéo HTML5.', 'textdomain') ?>
                    </video>
                <?php endif;
            else:
                $youtube_id = get_sub_field('id_video_youtube');
                if ($youtube_id): ?>
                    <iframe src="https://www.youtube.com/embed/<?= esc_attr($youtube_id) ?>" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <?php endif;
            endif;
            ?>
        </div>
    </div>
</div>