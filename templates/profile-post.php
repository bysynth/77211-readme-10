<h1 class="visually-hidden">Профиль</h1>
<div class="profile profile--default">
    <div class="profile__user-wrapper">
        <div class="profile__user user container">
            <div class="profile__user-info user__info">
                <div class="profile__avatar user__avatar">
                    <img class="profile__picture user__picture"
                         src="img/<?= isset($user_info['avatar']) ? clear_input($user_info['avatar']) : '' ?>"
                         alt="Аватар пользователя">
                </div>
                <div class="profile__name-wrapper user__name-wrapper">
                    <span class="profile__name user__name">
                        <?= isset($user_info['name']) ? clear_input($user_info['name']) : '' ?>
                    </span>
                    <time class="profile__user-time user__time" datetime="<?= $created_at = clear_input($user_info['created_at']) ?>">
                        <?= get_relative_time_format($created_at, 'на сайте') ?>
                    </time>
                </div>
            </div>
            <div class="profile__rating user__rating">
                <p class="profile__rating-item user__rating-item user__rating-item--publications">
                    <span class="user__rating-amount">
                        <?= $user_publications_count ?>
                    </span>
                    <span class="profile__rating-text user__rating-text">
                        <?= get_noun_plural_form($user_publications_count, 'публикация', 'публикации', 'публикаций')?>
                    </span>
                </p>
                <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                    <span class="user__rating-amount">
                        <?= $user_subscriptions_count ?>
                    </span>
                    <span class="profile__rating-text user__rating-text">
                        <?= get_noun_plural_form($user_subscriptions_count, 'подписчик', 'подписчика', 'подписчиков') ?>
                    </span>
                </p>
            </div>
            <div class="profile__user-buttons user__buttons">
                <button class="profile__user-button user__button user__button--subscription button button--main"
                        type="button">Подписаться
                </button>
                <a class="profile__user-button user__button user__button--writing button button--green" href="#">Сообщение</a>
            </div>
        </div>
    </div>
    <div class="profile__tabs-wrapper tabs">
        <div class="container">
            <div class="profile__tabs filters">
                <b class="profile__tabs-caption filters__caption">Показать:</b>
                <ul class="profile__tabs-list filters__list">
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button filters__button--active button">Посты</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button button" href="<?= $urls['likes']?>">Лайки</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button button" href="<?= $urls['subscriptions']?>">Подписки</a>
                    </li>
                </ul>
            </div>
            <div class="profile__tab-content">
                <section class="profile__posts">
                    <h2 class="visually-hidden">Публикации</h2>
                    <?php foreach ($posts as $post): ?>
                        <article class="profile__post post post-<?= $post['type_icon'] ?? '' ?>">
                            <header class="post__header">
                                <?php if (isset($post['is_repost'])) : ?>
                                    <div class="post__author">
                                        <?php if (isset($post['original_author_id'])) : ?>
                                            <a class="post__author-link"
                                               href="<?= '/profile.php?user=' . $post['original_author_id'] ?>"
                                               title="Автор">
                                                <div class="post__avatar-wrapper post__avatar-wrapper--repost">
                                                    <?php if (isset($post['original_author_avatar'])) : ?>
                                                        <img class="post__author-avatar"
                                                             src="img/<?= clear_input($post['original_author_avatar']) ?>"
                                                             alt="Аватар пользователя"><!-- TODO: заменить путь каталога с аватарками -->
                                                    <?php endif; ?>
                                                </div>
                                                <div class="post__info">
                                                    <?php if (isset($post['original_author_name'])) : ?>
                                                        <b class="post__author-name">Репост: <?= $post['original_author_name'] ?></b>
                                                    <?php endif; ?>
                                                    <?php if (isset($post['original_post_created_at'])) : ?>
                                                        <time class="post__time" datetime="<?= clear_input($post['original_post_created_at']) ?>">
                                                            <?= get_relative_time_format(clear_input($post['original_post_created_at']), 'назад') ?>
                                                        </time>
                                                    <?php endif; ?>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
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
                                            <svg class="post__indicator-icon post__indicator-icon--like-active"
                                                 width="20"
                                                 height="17">
                                                <use xlink:href="#icon-heart-active"></use>
                                            </svg>
                                            <?php if (isset($post['likes_count'])): ?>
                                                <span><?= $post['likes_count'] ?></span>
                                                <span class="visually-hidden">количество лайков</span>
                                            <?php endif; ?>
                                        </a>
                                        <a class="post__indicator post__indicator--repost button" href="#"
                                           title="Репост">
                                            <svg class="post__indicator-icon" width="19" height="17">
                                                <use xlink:href="#icon-repost"></use>
                                            </svg>
                                            <span>5</span>
                                            <span class="visually-hidden">количество репостов</span>
                                        </a>
                                    </div>
                                    <?php if (isset($post['created_at'])): ?>
                                        <time class="post__time" datetime="<?= clear_input($post['created_at']) ?>">
                                            <?= get_relative_time_format(clear_input($post['created_at']), 'назад') ?>
                                        </time>
                                    <?php endif; ?>
                                </div>
                                <?php if (isset($post['hashtags'])): ?>
                                    <ul class="post__tags">
                                        <?php foreach ($post['hashtags'] as $tag): ?>
                                            <li><a href="/search.php?q=<?= urlencode($tag) ?>"><?= $tag ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </footer>
                            <div class="comments">
                                <?php if (isset($post['post_id'])) : ?>
                                    <a class="comments__button button" href="<?= '/post.php?id=' . $post['post_id'] ?>">
                                        Показать комментарии
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </section>
            </div>
        </div>
    </div>
</div>
