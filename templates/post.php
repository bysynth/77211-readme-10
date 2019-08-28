<?php
/**
 * @var array $post_content
 */
?>

<div class="container">
    <h1 class="page__title page__title--publication"><?= isset($post_content['title']) ? clear_input($post_content['title']) : '' ?></h1>
    <section class="post-details">
        <h2 class="visually-hidden">Публикация</h2>
        <div class="post-details__wrapper"><!-- вот здесь есть класс, например, post-quote, но я его удалил потому что мне кажется он нигде не используется -->
            <div class="post-details__main-block post post--details">
                <?php if ((int)$post_content['content_type'] === 1) : ?>
                    <?= include_template('post-text.php',
                        [
                            'text' => clear_input($post_content['content'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post_content['content_type'] === 2) : ?>
                    <?= include_template('post-quote.php',
                        [
                            'text' => clear_input($post_content['content']),
                            'author' => clear_input($post_content['cite_author'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post_content['content_type'] === 3) : ?>
                    <?= include_template('post-photo.php',
                        [
                            'img_url' => clear_input($post_content['content'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post_content['content_type'] === 4) : ?>
                    <?= include_template('post-video.php',
                        [
                            'youtube_url' => clear_input($post_content['content'])
                        ]) ?>
                <?php endif; ?>
                <?php if ((int)$post_content['content_type'] === 5) : ?>
                    <?= include_template('post-link.php',
                        [
                            'url' => clear_input($post_content['content']),
                            'title' => clear_input($post_content['title'])
                        ]) ?>
                <?php endif; ?>
                <div class="post__indicators">
                    <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                            <svg class="post__indicator-icon" width="20" height="17">
                                <use xlink:href="#icon-heart"></use>
                            </svg>
                            <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                <use xlink:href="#icon-heart-active"></use>
                            </svg>
                            <span>250</span>
                            <span class="visually-hidden">количество лайков</span>
                        </a>
                        <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
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
                    <?php if (isset($post_content['views_counter'])): ?>
                        <span class="post__view"><?= $views = (int) clear_input($post_content['views_counter'])?>
                            <?= get_noun_plural_form($views, 'просмотр', 'просмотра', 'просмотров')?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="comments">
                    <form class="comments__form form" action="#" method="post">
                        <div class="comments__my-avatar">
                            <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                        </div>
                        <div class="form__input-section form__input-section--error">
                            <textarea class="comments__textarea form__textarea form__input" placeholder="Ваш комментарий"></textarea>
                            <label class="visually-hidden">Ваш комментарий</label>
                            <button class="form__error-button button" type="button">!</button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Ошибка валидации</h3>
                                <p class="form__error-desc">Это поле обязательно к заполнению</p>
                            </div>
                        </div>
                        <button class="comments__submit button button--green" type="submit">Отправить</button>
                    </form>
                    <div class="comments__list-wrapper">
                        <ul class="comments__list">
                            <li class="comments__item user">
                                <div class="comments__avatar">
                                    <a class="user__avatar-link" href="#">
                                        <img class="comments__picture" src="img/userpic-larisa.jpg" alt="Аватар пользователя">
                                    </a>
                                </div>
                                <div class="comments__info">
                                    <div class="comments__name-wrapper">
                                        <a class="comments__user-name" href="#">
                                            <span>Лариса Роговая</span>
                                        </a>
                                        <time class="comments__time" datetime="2019-03-20">1 ч назад</time>
                                    </div>
                                    <p class="comments__text">
                                        Красота!!!1!
                                    </p>
                                </div>
                            </li>
                            <li class="comments__item user">
                                <div class="comments__avatar">
                                    <a class="user__avatar-link" href="#">
                                        <img class="comments__picture" src="img/userpic-larisa.jpg" alt="Аватар пользователя">
                                    </a>
                                </div>
                                <div class="comments__info">
                                    <div class="comments__name-wrapper">
                                        <a class="comments__user-name" href="#">
                                            <span>Лариса Роговая</span>
                                        </a>
                                        <time class="comments__time" datetime="2019-03-18">2 дня назад</time>
                                    </div>
                                    <p class="comments__text">
                                        Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <a class="comments__more-link" href="#">
                            <span>Показать все комментарии</span>
                            <sup class="comments__amount">45</sup>
                        </a>
                    </div>
                </div>
            </div>
            <div class="post-details__user user">
                <div class="post-details__user-info user__info">
                    <div class="post-details__avatar user__avatar">
                        <a class="post-details__avatar-link user__avatar-link" href="#">
                            <img class="post-details__picture user__picture"
                                 src="img/<?= isset($post_content['avatar']) ? clear_input($post_content['avatar']) : '' ?>"
                                 alt="Аватар пользователя">
                        </a>
                    </div>
                    <div class="post-details__name-wrapper user__name-wrapper">
                        <a class="post-details__name user__name" href="#">
                            <span><?= isset($post_content['name']) ? clear_input($post_content['name']) : '' ?></span>
                        </a>
                        <?php if (isset($post_content['user_created_at'])): ?>
                            <time class="post-details__time user__time"
                                  datetime="<?= $created_at = clear_input($post_content['user_created_at']) ?>>">
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
                <div class="post-details__user-buttons user__buttons">
                    <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
                    <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
                </div>
            </div>
        </div>
    </section>
</div>