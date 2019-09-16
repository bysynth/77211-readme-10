<h1 class="visually-hidden">Страница результатов поиска</h1>
<section class="search">
    <h2 class="visually-hidden">Результаты поиска</h2>
    <div class="search__query-wrapper">
        <div class="search__query container">
            <span>Вы искали:</span>
            <span class="search__query-text"><?= $search_query ?></span>
        </div>
    </div>
    <div class="search__results-wrapper">
        <div class="container">
            <div class="search__content">
                <?php foreach ($posts as $post): ?>
                    <article class="search__post post post-<?= $post['type_icon'] ?? '' ?>">
                        <header class="post__header post__author">
                            <?php if (isset($post['user_id'], $post['avatar'])): ?>
                                <a class="post__author-link" href="<?= '/profile.php?id=' . $post['user_id'] ?>"
                                   title="Автор">
                                    <div class="post__avatar-wrapper">
                                        <?php if (isset($post['avatar'])): ?>
                                            <img class="post__author-avatar"
                                                 src="/uploads/<?= clear_input($post['avatar']) ?>"
                                                 alt="Аватар пользователя" width="60"
                                                 height="60">
                                        <?php endif; ?>
                                    </div>
                                    <div class="post__info">
                                        <?php if (isset($post['name'])): ?>
                                            <b class="post__author-name">
                                                <?= clear_input($post['name']) ?>
                                            </b>
                                        <?php endif; ?>
                                        <?php if (isset($post['created_at'])): ?>
                                            <span class="post__time">
                                            <?= get_relative_time_format(clear_input($post['created_at']), 'назад') ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </header>
                        <div class="post__main">
                            <?php if (isset($post['type_name']) && $post['type_name'] === 'Цитата'): ?>
                                <blockquote>
                                    <?php if (isset($post['content'], $post['cite_author'])): ?>
                                        <p>
                                            <?= clear_input($post['content']) ?>
                                        </p>
                                        <cite>
                                            <?= $post['cite_author'] ?>
                                        </cite>
                                    <?php endif; ?>
                                </blockquote>
                            <?php endif; ?>

                            <?php if (isset($post['type_name']) && $post['type_name'] === 'Текст'): ?>
                                <?php if (isset($post['title'], $post['post_id'])): ?>
                                    <h2>
                                        <a href="<?= '/post.php?id=' . $post['post_id'] ?>"><?= clear_input($post['title']) ?></a>
                                    </h2>
                                <?php endif; ?>
                                <?php if (isset($post['content'])): ?>
                                    <?= cut_text(clear_input($post['content'])) ?>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (isset($post['type_name']) && $post['type_name'] === 'Картинка'): ?>
                                <?php if (isset($post['title'], $post['post_id'])): ?>
                                    <h2>
                                        <a href="<?= '/post.php?id=' . $post['post_id'] ?>"><?= clear_input($post['title']) ?></a>
                                    </h2>
                                <?php endif; ?>
                                <div class="post-photo__image-wrapper">
                                    <?php if (isset($post['content'])): ?>
                                        <img src="/uploads/<?= clear_input($post['content']) ?>"
                                             alt="Фото от пользователя" width="760" height="396">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($post['type_name']) && $post['type_name'] === 'Видео'): ?>
                                <div class="post-video__block">
                                    <?= embed_youtube_video(clear_input($post['content'])) ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($post['type_name']) && $post['type_name'] === 'Ссылка'): ?>
                                <div class="post-link__wrapper">
                                    <a class="post-link__external"
                                       href="<?= isset($post['content']) ? clear_input($post['content']) : '' ?>"
                                       title="Перейти по ссылке">
                                        <div class="post-link__icon-wrapper">
                                            <img
                                                src="https://www.google.com/s2/favicons?domain=<?= isset($post['content']) ? clear_input($post['content']) : '' ?>"
                                                alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <?php if (isset($post['title'], $post['content'])): ?>
                                                <h3><?= clear_input($post['title']) ?></h3>
                                                <span><?= clear_input($post['content']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <svg class="post-link__arrow" width="11" height="16">
                                            <use xlink:href="#icon-arrow-right-ad"></use>
                                        </svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <footer class="post__footer">
                            <div class="post__indicators">
                                <div class="post__buttons">
                                    <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                        <svg class="post__indicator-icon" width="20" height="17">
                                            <use xlink:href="#icon-heart"></use>
                                        </svg>
                                        <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                                             height="17">
                                            <use xlink:href="#icon-heart-active"></use>
                                        </svg>
                                        <?php if (isset($post['likes_count'])): ?>
                                            <span><?= $post['likes_count'] ?></span>
                                            <span class="visually-hidden">количество лайков</span>
                                        <?php endif; ?>
                                    </a>
                                    <a class="post__indicator post__indicator--comments button" href="#"
                                       title="Комментарии">
                                        <svg class="post__indicator-icon" width="19" height="17">
                                            <use xlink:href="#icon-comment"></use>
                                        </svg>
                                        <?php if (isset($post['comments_count'])): ?>
                                            <span><?= $post['comments_count'] ?></span>
                                            <span class="visually-hidden">количество комментариев</span>
                                        <?php endif; ?>
                                    </a>
                                    <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                                        <svg class="post__indicator-icon" width="19" height="17">
                                            <use xlink:href="#icon-repost"></use>
                                        </svg>
                                        <span>5</span>
                                        <span class="visually-hidden">количество репостов</span>
                                    </a>
                                </div>
                            </div>
                            <?php if (isset($post['hashtags'])): ?>
                                <ul class="post__tags">
                                    <?php foreach ($post['hashtags'] as $tag): ?>
                                        <li><a href="/search.php?q=<?= urlencode($tag) ?>"><?= $tag ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </footer>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
