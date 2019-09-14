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
                        <a class="profile__tabs-link filters__button filters__button--active button">Лайки</a>
                    </li>
                    <li class="profile__tabs-item filters__item">
                        <a class="profile__tabs-link filters__button button" href="<?= $urls['subscriptions']?>">Подписки</a>
                    </li>
                </ul>
            </div>
            <div class="profile__tab-content">
                <section class="profile__likes">
                    <h2 class="visually-hidden">Лайки</h2>
                    <ul class="profile__likes-list">
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
                                    <div class="post-mini__action">
                                        <span
                                            class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5
                                            минут назад
                                        </time>
                                    </div>
                                </div>
                            </div>
                            <div class="post-mini__preview">
                                <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                    <div class="post-mini__image-wrapper">
                                        <img class="post-mini__image" src="img/rock-small.png" width="109" height="109"
                                             alt="Превью публикации">
                                    </div>
                                    <span class="visually-hidden">Фото</span>
                                </a>
                            </div>
                        </li>
                        <li class="post-mini post-mini--text post user">
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
                                    <div class="post-mini__action">
                                        <span
                                            class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T20:05">15
                                            минут назад
                                        </time>
                                    </div>
                                </div>
                            </div>
                            <div class="post-mini__preview">
                                <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                    <span class="visually-hidden">Текст</span>
                                    <svg class="post-mini__preview-icon" width="20" height="21">
                                        <use xlink:href="#icon-filter-text"></use>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        <li class="post-mini post-mini--video post user">
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
                                    <div class="post-mini__action">
                                        <span
                                            class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T18:20">2
                                            часа назад
                                        </time>
                                    </div>
                                </div>
                            </div>
                            <div class="post-mini__preview">
                                <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                    <div class="post-mini__image-wrapper">
                                        <img class="post-mini__image" src="img/coast-small.png" width="109" height="109"
                                             alt="Превью публикации">
                                        <span class="post-mini__play-big">
                            <svg class="post-mini__play-big-icon" width="12" height="13">
                              <use xlink:href="#icon-video-play-big"></use>
                            </svg>
                          </span>
                                    </div>
                                    <span class="visually-hidden">Видео</span>
                                </a>
                            </div>
                        </li>
                        <li class="post-mini post-mini--quote post user">
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
                                    <div class="post-mini__action">
                                        <span
                                            class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                        <time class="post-mini__time user__additional" datetime="2014-03-15T20:05">5
                                            дней назад
                                        </time>
                                    </div>
                                </div>
                            </div>
                            <div class="post-mini__preview">
                                <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                    <span class="visually-hidden">Цитата</span>
                                    <svg class="post-mini__preview-icon" width="21" height="20">
                                        <use xlink:href="#icon-filter-quote"></use>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        <li class="post-mini post-mini--link post user">
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
                                    <div class="post-mini__action">
                                        <span
                                            class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                        <time class="post-mini__time user__additional" datetime="2014-03-20T20:05">в
                                            далеком 2007-ом
                                        </time>
                                    </div>
                                </div>
                            </div>
                            <div class="post-mini__preview">
                                <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                    <span class="visually-hidden">Ссылка</span>
                                    <svg class="post-mini__preview-icon" width="21" height="18">
                                        <use xlink:href="#icon-filter-link"></use>
                                    </svg>
                                </a>
                            </div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</div>
