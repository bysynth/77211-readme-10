<?php
/**
 * @var array $post
 */
?>

<div class="container">
    <h1 class="page__title page__title--publication"><?= isset($post['title']) ? clear_input($post['title']) : '' ?></h1>
    <section class="post-details">
        <h2 class="visually-hidden">Публикация</h2>
        <div class="post-details__wrapper">
            <div class="post-details__main-block post post--details">
                <?php if ((int)$post['content_type'] === 1) : ?>
                    <?= include_template('post-text.php',
                        [
                            'text' => clear_input($post['content'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post['content_type'] === 2) : ?>
                    <?= include_template('post-quote.php',
                        [
                            'text' => clear_input($post['content']),
                            'author' => clear_input($post['cite_author'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post['content_type'] === 3) : ?>
                    <?= include_template('post-photo.php',
                        [
                            'img_url' => clear_input($post['content'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post['content_type'] === 4) : ?>
                    <?= include_template('post-video.php',
                        [
                            'youtube_url' => clear_input($post['content'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post['content_type'] === 5) : ?>
                    <?= include_template('post-link.php',
                        [
                            'url' => clear_input($post['content']),
                            'title' => clear_input($post['title'])
                        ]) ?>
                <?php endif; ?>
                <div class="post__indicators">
                    <div class="post__buttons">
                        <?php if (isset($post['id'])): ?>
                            <a class="post__indicator post__indicator--likes button"
                               href="/like.php?post_id=<?= $post['id'] ?>" title="Лайк">
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
                        <?php endif; ?>
                        <a class="post__indicator post__indicator--comments button" href="#comments-block" title="Комментарии">
                            <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-comment"></use>
                            </svg>
                            <?php if (isset($post['comments_count'])): ?>
                                <span><?= $post['comments_count'] ?></span>
                                <span class="visually-hidden">количество комментариев</span>
                            <?php endif; ?>
                        </a>
                        <?php if (isset($post['id'])): ?>
                            <a class="post__indicator post__indicator--repost button"
                               href="/repost.php?post_id=<?= $post['id'] ?>" title="Репост">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-repost"></use>
                                </svg>
                                <?php if (isset($post['was_reposted'])): ?>
                                    <span><?= $post['was_reposted'] ?></span>
                                    <span class="visually-hidden">количество репостов</span>
                                <?php endif ?>
                            </a>
                        <?php endif ?>
                    </div>
                    <?php if (isset($post['views_counter'])): ?>
                        <span class="post__view"><?= $views = (int) clear_input($post['views_counter'])?>
                            <?= get_noun_plural_form($views, 'просмотр', 'просмотра', 'просмотров')?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="comments">
                    <form class="comments__form form" method="post">
                        <?php if (isset($_SESSION['user']['avatar'])): ?>
                            <div class="comments__my-avatar">
                                <img class="comments__picture" src="/uploads/<?= $_SESSION['user']['avatar'] ?>" alt="Аватар пользователя">
                            </div>
                        <?php endif ?>
                        <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
                            <textarea class="comments__textarea form__textarea form__input"
                                      placeholder="Ваш комментарий" name="comment" id="comment"><?= get_post_val('comment')?></textarea>
                            <label for="comment" class="visually-hidden">Ваш комментарий</label>
                            <input type="hidden" name="post-id" value="<?= $post['id'] ?>">
                            <button class="form__error-button button" type="button">!</button>
                            <?php if (isset($error)): ?>
                                <?= include_template('input-error.php', [
                                    'error' => $error
                                    ])
                                ?>
                            <?php endif ?>
                        </div>
                        <button class="comments__submit button button--green" type="submit">Отправить</button>
                    </form>
                    <div class="comments__list-wrapper" id="comments-block">
                        <?php if (!empty($comments)) : ?>
                        <ul class="comments__list">
                            <?php foreach ($comments as $comment) : ?>
                                <li class="comments__item user">
                                    <div class="comments__avatar">
                                        <?php if (isset($comment['author_id'], $comment['avatar'])): ?>
                                            <a class="user__avatar-link" href="<?= '/profile.php?user=' . $comment['author_id'] ?>">
                                                <img class="comments__picture" src="/uploads/<?= clear_input($comment['avatar']) ?>"
                                                     alt="Аватар пользователя">
                                            </a>
                                        <?php endif ?>
                                    </div>
                                    <div class="comments__info">
                                        <div class="comments__name-wrapper">
                                            <?php if (isset($comment['name'], $comment['author_id'])): ?>
                                                <a class="comments__user-name" href="<?= '/profile.php?user=' . $comment['author_id'] ?>">
                                                    <span><?= clear_input($comment['name']) ?></span>
                                                </a>
                                            <?php endif ?>
                                            <?php if (isset($comment['created_at'])): ?>
                                                <time class="comments__time" datetime="<?= clear_input($comment['created_at']) ?>>">
                                                    <?= get_relative_time_format(clear_input($comment['created_at']), 'назад') ?>
                                                </time>
                                            <?php endif ?>
                                        </div>
                                        <?php if (isset($comment['comment'])): ?>
                                            <p class="comments__text">
                                                <?= clear_input($comment['comment']) ?>
                                            </p>
                                        <?php endif ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="post-details__user user">
                <div class="post-details__user-info user__info">
                    <div class="post-details__avatar user__avatar">
                        <?php if (isset($post['author_id'])): ?>
                            <a class="post-details__avatar-link user__avatar-link" href="<?= '/profile.php?user=' . $post['author_id'] ?>">
                                <img class="post-details__picture user__picture"
                                     src="/uploads/<?= isset($post['avatar']) ? clear_input($post['avatar']) : '' ?>"
                                     alt="Аватар пользователя">
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="post-details__name-wrapper user__name-wrapper">
                        <?php if (isset($post['author_id'])): ?>
                            <a class="post-details__name user__name"
                               href="<?= '/profile.php?user=' . $post['author_id'] ?>">
                                <span><?= isset($post['name']) ? clear_input($post['name']) : '' ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if (isset($post['user_created_at'])): ?>
                            <time class="post-details__time user__time"
                                  datetime="<?= $created_at = clear_input($post['user_created_at']) ?>">
                                <?= get_relative_time_format($created_at, 'на сайте') ?>
                            </time>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="post-details__rating user__rating">
                    <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="post-details__rating-amount user__rating-amount">
                            <?= $user_subscriptions_count ?>
                        </span>
                        <span class="post-details__rating-text user__rating-text">
                            <?= get_noun_plural_form($user_subscriptions_count, 'подписчик', 'подписчика', 'подписчиков')?>
                        </span>
                    </p>
                    <p class="post-details__rating-item user__rating-item user__rating-item--publications">
                        <span class="post-details__rating-amount user__rating-amount">
                            <?= $user_publications_count ?>
                        </span>
                        <span class="post-details__rating-text user__rating-text">
                            <?= get_noun_plural_form($user_publications_count, 'публикация', 'публикации', 'публикаций')?>
                        </span>
                    </p>
                </div>
                <?php if ($session_user_id !== $post['author_id']): ?>
                    <div class="post-details__user-buttons user__buttons">
                        <a class="user__button user__button--subscription button button--main"
                           href="/subscribe.php?subscribe_user_id=<?= $post['author_id'] ?? '' ?>">
                            <?= $is_subscribed ? 'Отписаться' : 'Подписаться' ?></a>
                        <?php if ($is_subscribed): ?>
                            <a class="user__button user__button--writing button button--green"
                               href="/messages.php?user_id=<?= $post['author_id'] ?>">Сообщение</a>
                        <?php endif; ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>
</div>
