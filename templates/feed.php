<?php
/**
 * @var array $content_types
 * @var array $posts
 * @var string $type
 */
?>

<div class="container">
    <h1 class="page__title page__title--feed">Моя лента</h1>
</div>
<div class="page__main-wrapper container">
    <section class="feed">
        <h2 class="visually-hidden">Лента</h2>
        <div class="feed__main-wrapper">
            <div class="feed__wrapper">
                <?php foreach ($posts as $post): ?>
                    <article class="feed__post post post-<?= $post['type_icon'] ?? '' ?>">
                        <header class="post__header post__author">
                            <?php if (isset($post['user_id'], $post['avatar'])): ?>
                                <a class="post__author-link" href="<?= '/profile.php?id=' . $post['user_id'] ?>"
                                   title="Автор">
                                    <div class="post__avatar-wrapper">
                                        <?php if (isset($post['avatar'])): ?>
                                            <img class="post__author-avatar"
                                                 src="img/<?= clear_input($post['avatar']) ?>"
                                                 alt="Аватар пользователя" width="60"
                                                 height="60"><!-- TODO: заменить путь каталога с аватарками -->
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
                                    <p>
                                        <?= cut_text(clear_input($post['content'])) ?>
                                    </p>
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
                                        <img src="/upload/<?= clear_input($post['content']) ?>"
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
                                        <span>250</span>
                                        <span class="visually-hidden">количество лайков</span>
                                    </a>
                                    <a class="post__indicator post__indicator--comments button" href="#"
                                       title="Комментарии">
                                        <svg class="post__indicator-icon" width="19" height="17">
                                            <use xlink:href="#icon-comment"></use>
                                        </svg>
                                        <span>25</span>
                                        <span class="visually-hidden">количество комментариев</span>
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
        <ul class="feed__filters filters">
            <li class="feed__filters-item filters__item">
                <a class="filters__button <?= !isset($type) ? 'filters__button--active' : '' ?>" href="/feed.php">
                    <span>Все</span>
                </a>
            </li>
            <?php foreach ($content_types as $content_type): ?>
                <li class="feed__filters-item filters__item">
                    <a class="filters__button filters__button--<?= $content_type['type_icon'] ?? '' ?> button
                    <?php if (isset($content_type['id']) && $type === $content_type['id']): ?>filters__button--active<?php endif; ?>"
                       href="<?= '/feed.php?type=' . $content_type['id'] ?>">
                        <span class="visually-hidden"><?= $content_type['type_name'] ?? '' ?></span>
                        <svg class="filters__icon" width="22" height="18">
                            <use xlink:href="#icon-filter-<?= $content_type['type_icon'] ?? '' ?>"></use>
                        </svg>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <aside class="promo">
        <article class="promo__block promo__block--barbershop">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
                Все еще сидишь на окладе в офисе? Открой свой барбершоп по нашей франшизе!
            </p>
            <a class="promo__link" href="#">
                Подробнее
            </a>
        </article>
        <article class="promo__block promo__block--technomart">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
                Товары будущего уже сегодня в онлайн-сторе Техномарт!
            </p>
            <a class="promo__link" href="#">
                Перейти в магазин
            </a>
        </article>
        <article class="promo__block">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
                Здесь<br> могла быть<br> ваша реклама
            </p>
            <a class="promo__link" href="#">
                Разместить
            </a>
        </article>
    </aside>
</div>
