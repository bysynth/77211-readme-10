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
                        <?= clear_input($user_publications_count) ?>
                    </span>
                    <span class="profile__rating-text user__rating-text">
                        <?= get_noun_plural_form(clear_input($user_publications_count), 'публикация', 'публикации', 'публикаций')?>
                    </span>
                </p>
                <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                    <span class="user__rating-amount">
                        <?= clear_input($user_subscriptions_count) ?>
                    </span>
                    <span class="profile__rating-text user__rating-text">
                        <?= get_noun_plural_form(clear_input($user_subscriptions_count), 'подписчик', 'подписчика', 'подписчиков') ?>
                    </span>
                </p>
            </div>
            <div class="profile__user-buttons user__buttons">
                <?php if (isset($user_info['id']) && ($session_user_id !== $user_info['id'])): ?>
                    <a class="profile__user-button user__button user__button--subscription button button--main"
                       href="/subscribe.php?subscribe_user_id=<?= clear_input($user_info['id']) ?>">
                        <?= $is_subscribed ? 'Отписаться' : 'Подписаться' ?>
                    </a>
                    <?php if ($is_subscribed): ?>
                        <a class="profile__user-button user__button user__button--writing button button--green"
                           href="/messages.php?user_id=<?= clear_input($user_info['id']) ?>">Сообщение</a>
                    <?php endif; ?>
                <?php endif ?>
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
                            <?= isset($is_posts) ? '' : 'href="'. clear_input($urls['posts']) .'"'?>>Посты</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button <?= isset($is_likes) ? 'filters__button--active' : '' ?> button"
                            <?= isset($is_likes) ? '' : 'href="'. clear_input($urls['likes']) .'"'?>>Лайки</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button <?= isset($is_subscriptions) ? 'filters__button--active' : '' ?> button"
                            <?= isset($is_subscriptions) ? '' : 'href="'. clear_input($urls['subscriptions']) .'"'?>>Подписки</a>
                    </li>
                </ul>
            </div>
            <div class="profile__tab-content">
                <?= include_template($template, ['content' => $content]) ?>
            </div>
        </div>
    </div>
</div>
