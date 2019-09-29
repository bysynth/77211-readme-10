<section class="profile__likes">
    <h2 class="visually-hidden">Лайки</h2>
    <?php if (!empty($content)): ?>
        <ul class="profile__likes-list">
            <?php foreach ($content as $like): ?>
                <li class="post-mini post-mini--<?= $like['content_type'] ?? '' ?> post user">
                    <div class="post-mini__user-info user__info">
                        <?php if (isset($like['user_id'], $like['avatar'])): ?>
                            <div class="post-mini__avatar user__avatar">
                                <a class="user__avatar-link" href="/profile.php?user=<?= $like['user_id'] ?>">
                                    <img class="post-mini__picture user__picture" src="/uploads/<?= clear_input($like['avatar']) ?>"
                                         alt="Аватар пользователя">
                                </a>
                            </div>
                        <?php endif ?>
                        <div class="post-mini__name-wrapper user__name-wrapper">
                            <?php if (isset($like['user_id'], $like['name'])): ?>
                                <a class="post-mini__name user__name" href="/profile.php?user=<?= $like['user_id'] ?>">
                                    <span><?= clear_input($like['name']) ?></span>
                                </a>
                            <?php endif ?>
                            <div class="post-mini__action">
                                <span class="post-mini__activity user__additional">Лайкнул публикацию</span>
                                <?php if (isset($like['created_at'])): ?>
                                    <time class="post-mini__time user__additional" datetime="<?= $like['created_at'] ?>">
                                        <?= get_relative_time_format(clear_input($like['created_at']),
                                            'назад') ?>
                                    </time>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <div class="post-mini__preview">
                        <?php if (isset($like['post_id'])): ?>
                            <a class="post-mini__link" href="/post.php?id=<?= $like['post_id']?>" title="Перейти на публикацию">
                            <?php if ($like['content_type'] === 1): ?>
                                <span class="visually-hidden">Текст</span>
                                <svg class="post-mini__preview-icon" width="20" height="21">
                                    <use xlink:href="#icon-filter-text"></use>
                                </svg>
                         <?php endif ?>
                            <?php if ($like['content_type'] === 2): ?>
                                <span class="visually-hidden">Цитата</span>
                                <svg class="post-mini__preview-icon" width="21" height="20">
                                    <use xlink:href="#icon-filter-quote"></use>
                                </svg>
                            <?php endif ?>
                            <?php if ($like['content_type'] === 3): ?>
                                <div class="post-mini__image-wrapper">
                                    <?php if (isset($like['content'])): ?>
                                        <img class="post-mini__image" src="/uploads/<?= $like['content'] ?>" width="109"
                                             height="109"
                                             alt="Превью публикации">
                                    <?php endif ?>
                                </div>
                                <span class="visually-hidden">Фото</span>
                            <?php endif ?>
                            <?php if ($like['content_type'] === 4): ?>
                                <div class="post-mini__image-wrapper">
                                    <?php if (isset($like['content'])): ?>
                                        <img class="post-mini__image" src="<?= get_youtube_cover_url($like['content']) ?>" width="109" height="109"
                                             alt="Превью публикации">
                                        <span class="post-mini__play-big">
                                            <svg class="post-mini__play-big-icon" width="12" height="13">
                                              <use xlink:href="#icon-video-play-big"></use>
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <span class="visually-hidden">Видео</span>
                            <?php endif ?>
                            <?php if ($like['content_type'] === 5): ?>
                                <span class="visually-hidden">Ссылка</span>
                                <svg class="post-mini__preview-icon" width="21" height="18">
                                    <use xlink:href="#icon-filter-link"></use>
                                </svg>
                            <?php endif ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
