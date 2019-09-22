<?php

?>

<div class="container">
    <h1 class="page__title page__title--popular">Популярное</h1>
</div>
<div class="popular container">
    <div class="popular__filters-wrapper">
        <div class="popular__sorting sorting">
            <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
            <ul class="popular__sorting-list sorting__list">
                <li class="sorting__item sorting__item--popular">
                    <a class="sorting__link
                    <?= ($sort === null || $sort === 'popular-desc') ? 'sorting__link--active' : '' ?>
                    <?= ($sort === 'popular-asc') ? 'sorting__link--active sorting__link--reverse' : '' ?>"
                       href="<?= ($sort === null || $sort === 'popular-desc') ? $sort_url['popular-asc'] : $sort_url['popular-desc'] ?>">
                        <span>Популярность</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link
                    <?= ($sort === 'likes-desc') ? 'sorting__link--active' : '' ?>
                    <?= ($sort === 'likes-asc') ? 'sorting__link--active sorting__link--reverse' : '' ?>"
                       href="<?= ($sort === 'likes-desc') ? $sort_url['likes-asc'] : $sort_url['likes-desc'] ?>">
                        <span>Лайки</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link
                    <?= ($sort === 'date-desc') ? 'sorting__link--active' : '' ?>
                    <?= ($sort === 'date-asc') ? 'sorting__link--active sorting__link--reverse' : '' ?>"
                       href="<?= ($sort === 'date-desc') ? $sort_url['date-asc'] : $sort_url['date-desc'] ?>">
                        <span>Дата</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <div class="popular__filters filters">
            <b class="popular__filters-caption filters__caption">Тип контента:</b>
            <ul class="popular__filters-list filters__list">
                <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                    <a class="filters__button filters__button--ellipse filters__button--all <?= !isset($type) ? 'filters__button--active' : '' ?>"
                       href="/popular.php">
                        <span>Все</span>
                    </a>
                </li>
                <?php foreach ($content_types as $content_type): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--<?= $content_type['type_icon'] ?? '' ?> button
                            <?php if (isset($content_type['id']) && $type === $content_type['id']): ?>filters__button--active<?php endif; ?>"
                           href="<?= '/popular.php?page=1&type=' . $content_type['id'] ?>">
                            <span class="visually-hidden">
                                <?= $content_type['type_name'] ?? '' ?>
                            </span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-<?= $content_type['type_icon'] ?? '' ?>"></use>
                            </svg>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="popular__posts">
        <?php foreach ($posts as $post): ?>
            <article class="popular__post post post-<?= $post['type_icon'] ?? '' ?>">
                <header class="post__header">
                    <?php if (isset($post['title'], $post['post_id'])): ?>
                        <h2>
                            <a href="<?= '/post.php?id=' . $post['post_id'] ?>"><?= clear_input($post['title']) ?></a>
                        </h2>
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
                        <?php if (isset($post['content'])): ?>
                            <?= cut_text(clear_input($post['content'])) ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($post['type_name']) && $post['type_name'] === 'Картинка'): ?>
                        <div class="post-photo__image-wrapper">
                            <?php if (isset($post['content'])): ?>
                                <img src="img/<?= clear_input($post['content']) ?>" alt="Фото от пользователя"
                                     width="360" height="240">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($post['type_name']) && $post['type_name'] === 'Видео'): ?>
                        <div class="post-video__block">
                            <div class="post-video__preview">
                                <?php if (isset($post['content'])): ?>
                                    <?= embed_youtube_cover(clear_input($post['content'])) ?>
                                <?php endif; ?>
                            </div>
                            <a href="<?= '/post.php?id=' . $post['post_id'] ?>" class="post-video__play-big button">
                                <svg class="post-video__play-big-icon" width="14" height="14">
                                    <use xlink:href="#icon-video-play-big"></use>
                                </svg>
                                <span class="visually-hidden">Запустить проигрыватель</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($post['type_name']) && $post['type_name'] === 'Ссылка'): ?>
                        <div class="post-link__wrapper">
                            <a class="post-link__external"
                               href="<?= isset($post['content']) ? clear_input($post['content']) : '' ?>"
                               title="Перейти по ссылке">
                                <div class="post-link__info-wrapper">
                                    <div class="post-link__icon-wrapper">
                                        <img
                                            src="https://www.google.com/s2/favicons?domain=<?= isset($post['content']) ? clear_input($post['content']) : '' ?>"
                                            alt="Иконка">
                                    </div>
                                    <div class="post-link__info">
                                        <?php if (isset($post['title'])): ?>
                                            <h3><?= clear_input($post['title']) ?></h3>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if (isset($post['content'])): ?>
                                    <span><?= clear_input($post['content']) ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
                <footer class="post__footer">
                    <div class="post__author">
                        <?php if (isset($post['user_id'])): ?>
                            <a class="post__author-link" href="<?= '/profile.php?user=' . $post['user_id'] ?>"
                               title="Автор">
                                <div class="post__avatar-wrapper">
                                    <?php if (isset($post['avatar'])): ?>
                                        <img class="post__author-avatar" src="/uploads/<?= clear_input($post['avatar']) ?>"
                                             alt="Аватар пользователя">
                                    <?php endif; ?>
                                </div>
                                <div class="post__info">
                                    <?php if (isset($post['name'])): ?>
                                        <b class="post__author-name"><?= clear_input($post['name']) ?></b>
                                    <?php endif; ?>
                                    <?php if (isset($post['created_at'])): ?>
                                        <time class="post__time"
                                              datetime="<?= $time = clear_input($post['created_at']) ?>"
                                              title="<?= get_custom_time_format($time) ?>">
                                            <?= get_relative_time_format($time, 'назад') ?>
                                        </time>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <?php if (isset($post['post_id'])): ?>
                                <a class="post__indicator post__indicator--likes button"
                                   href="/like.php?post_id=<?= $post['post_id'] ?>" title="Лайк">
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
                                <a class="post__indicator post__indicator--comments button"
                                   href="<?= '/post.php?id=' . $post['post_id'] . '#comments-block'?>"
                                   title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <?php if (isset($post['comments_count'])): ?>
                                        <span><?= $post['comments_count'] ?></span>
                                        <span class="visually-hidden">количество комментариев</span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </footer>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if ($pages_count > 1): ?>
        <div class="popular__page-links">
            <a class="popular__page-link popular__page-link--prev button button--gray" <?= $prev_url ?>>Предыдущая страница</a>
            <a class="popular__page-link popular__page-link--next button button--gray" <?= $next_url ?>>Следующая страница</a>
        </div>
    <?php endif ?>
</div>
