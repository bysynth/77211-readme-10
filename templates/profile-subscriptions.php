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
                        <a class="profile__tabs-link filters__button button" href="<?= $urls['posts']?>">Посты</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button button" href="<?= $urls['likes']?>">Лайки</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button filters__button--active button">Подписки</a>
                    </li>
                </ul>
            </div>
            <div class="profile__tab-content">
                <section class="profile__subscriptions">
                    <h2 class="visually-hidden">Подписки</h2>
                    <ul class="profile__subscriptions-list">
                        <li class="post-mini post-mini--photo post user">
                            <div class="post-mini__user-info user__info">
                                <div class="post-mini__avatar user__avatar">
                                    <a class="user__avatar-link" href="#">
                                        <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg"
                                             alt="Аватар пользователя">
                                    </a>
                                </div>
                                <div class="post-mini__name-wrapper user__name-wrapper">
                                    <a class="post-mini__name user__name" href="#">
                                        <span>Петр Демин</span>
                                    </a>
                                    <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на
                                        сайте
                                    </time>
                                </div>
                            </div>
                            <div class="post-mini__rating user__rating">
                                <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                    <span class="post-mini__rating-amount user__rating-amount">556</span>
                                    <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                </p>
                                <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                    <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                    <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                </p>
                            </div>
                            <div class="post-mini__user-buttons user__buttons">
                                <button
                                    class="post-mini__user-button user__button user__button--subscription button button--main"
                                    type="button">Подписаться
                                </button>
                            </div>
                        </li>
                        <li class="post-mini post-mini--photo post user">
                            <div class="post-mini__user-info user__info">
                                <div class="post-mini__avatar user__avatar">
                                    <a class="user__avatar-link" href="#">
                                        <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg"
                                             alt="Аватар пользователя">
                                    </a>
                                </div>
                                <div class="post-mini__name-wrapper user__name-wrapper">
                                    <a class="post-mini__name user__name" href="#">
                                        <span>Петр Демин</span>
                                    </a>
                                    <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на
                                        сайте
                                    </time>
                                </div>
                            </div>
                            <div class="post-mini__rating user__rating">
                                <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                    <span class="post-mini__rating-amount user__rating-amount">556</span>
                                    <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                </p>
                                <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                    <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                    <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                </p>
                            </div>
                            <div class="post-mini__user-buttons user__buttons">
                                <button
                                    class="post-mini__user-button user__button user__button--subscription button button--quartz"
                                    type="button">Отписаться
                                </button>
                            </div>
                        </li>
                        <li class="post-mini post-mini--photo post user">
                            <div class="post-mini__user-info user__info">
                                <div class="post-mini__avatar user__avatar">
                                    <a class="user__avatar-link" href="#">
                                        <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg"
                                             alt="Аватар пользователя">
                                    </a>
                                </div>
                                <div class="post-mini__name-wrapper user__name-wrapper">
                                    <a class="post-mini__name user__name" href="#">
                                        <span>Петр Демин</span>
                                    </a>
                                    <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на
                                        сайте
                                    </time>
                                </div>
                            </div>
                            <div class="post-mini__rating user__rating">
                                <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                    <span class="post-mini__rating-amount user__rating-amount">556</span>
                                    <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                </p>
                                <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                    <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                    <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                </p>
                            </div>
                            <div class="post-mini__user-buttons user__buttons">
                                <button
                                    class="post-mini__user-button user__button user__button--subscription button button--main"
                                    type="button">Подписаться
                                </button>
                            </div>
                        </li>
                        <li class="post-mini post-mini--photo post user">
                            <div class="post-mini__user-info user__info">
                                <div class="post-mini__avatar user__avatar">
                                    <a class="user__avatar-link" href="#">
                                        <img class="post-mini__picture user__picture" src="img/userpic-petro.jpg"
                                             alt="Аватар пользователя">
                                    </a>
                                </div>
                                <div class="post-mini__name-wrapper user__name-wrapper">
                                    <a class="post-mini__name user__name" href="#">
                                        <span>Петр Демин</span>
                                    </a>
                                    <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 лет на
                                        сайте
                                    </time>
                                </div>
                            </div>
                            <div class="post-mini__rating user__rating">
                                <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                    <span class="post-mini__rating-amount user__rating-amount">556</span>
                                    <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                </p>
                                <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                    <span class="post-mini__rating-amount user__rating-amount">1856</span>
                                    <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                </p>
                            </div>
                            <div class="post-mini__user-buttons user__buttons">
                                <button
                                    class="post-mini__user-button user__button user__button--subscription button button--main"
                                    type="button">Подписаться
                                </button>
                            </div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</div>
