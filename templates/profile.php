<h1 class="visually-hidden">Профиль</h1>
<div class="profile profile--default">
    <div class="profile__user-wrapper">
        <div class="profile__user user container">
            <div class="profile__user-info user__info">
                <div class="profile__avatar user__avatar">
                    <img class="profile__picture user__picture"
                         src="/uploads/<?= isset($user_info['avatar']) ? clear_input($user_info['avatar']) : '' ?>"
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
                <a class="profile__user-button user__button user__button--subscription button button--main"
                   href="/subscribe.php?subscribe_user_id=<?= isset($user_info['id']) ? clear_input($user_info['id']) : '' ?>">
                    <?= !isset($is_subscribed) ? 'Подписаться' : 'Отписаться'?>
                </a>
                <?php if (isset($is_subscribed)): ?>
                    <a class="profile__user-button user__button user__button--writing button button--green" href="#">Сообщение</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="profile__tabs-wrapper tabs">
        <div class="container">
            <div class="profile__tabs filters">
                <b class="profile__tabs-caption filters__caption">Показать:</b>
                <ul class="profile__tabs-list filters__list">
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button <?= isset($is_posts) ? 'filters__button--active' : '' ?> button"
                            <?= isset($is_posts) ? '' : 'href="'. $urls['posts'] .'"'?>>Посты</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button <?= isset($is_likes) ? 'filters__button--active' : '' ?> button"
                            <?= isset($is_likes) ? '' : 'href="'. $urls['likes'] .'"'?>>Лайки</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button <?= isset($is_subscriptions) ? 'filters__button--active' : '' ?> button"
                            <?= isset($is_subscriptions) ? '' : 'href="'. $urls['subscriptions'] .'"'?>>Подписки</a>
                    </li>
                </ul>
            </div>
            <div class="profile__tab-content">
                <?= include_template($template, ['content' => $content]) ?>
            </div>
        </div>
    </div>
</div>
