<section class="profile__subscriptions">
    <h2 class="visually-hidden">Подписки</h2>
    <?php if (!empty($content)): ?>
        <ul class="profile__subscriptions-list">
            <?php foreach ($content as $sub): ?>
                <li class="post-mini post-mini--photo post user">
                    <div class="post-mini__user-info user__info">
                        <?php if (isset($sub['user_id'], $sub['avatar'])): ?>
                            <div class="post-mini__avatar user__avatar">
                                <a class="user__avatar-link" href="/profile.php?user=<?= $sub['user_id'] ?>">
                                    <img class="post-mini__picture user__picture" src="/uploads/<?= $sub['avatar'] ?>"
                                         alt="Аватар пользователя">
                                </a>
                            </div>
                        <?php endif ?>
                        <div class="post-mini__name-wrapper user__name-wrapper">
                            <?php if (isset($sub['user_id'], $sub['name'])): ?>
                                <a class="post-mini__name user__name" href="/profile.php?user=<?= $sub['user_id'] ?>">
                                    <span><?= $sub['name'] ?></span>
                                </a>
                            <?php endif ?>
                            <?php if (isset($sub['created_at'])): ?>
                                <time class="post-mini__time user__additional" datetime="<?= $sub['created_at'] ?>">
                                    <?= get_relative_time_format(clear_input($sub['created_at']),
                                        'назад') ?>
                                </time>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php if (isset($sub['publ_count'], $sub['sub_count'])): ?>
                        <div class="post-mini__rating user__rating">
                            <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                <span class="post-mini__rating-amount user__rating-amount"><?= $sub['publ_count'] ?></span>
                                <span class="post-mini__rating-text user__rating-text">
                                    <?= get_noun_plural_form($sub['publ_count'], 'публикация', 'публикации', 'публикаций')?>
                                </span>
                            </p>
                            <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                <span class="post-mini__rating-amount user__rating-amount"><?= $sub['sub_count'] ?></span>
                                <span class="post-mini__rating-text user__rating-text">
                                    <?= get_noun_plural_form($sub['sub_count'], 'подписчик', 'подписчика', 'подписчиков') ?>
                                </span>
                            </p>
                        </div>
                    <?php endif ?>
                    <div class="post-mini__user-buttons user__buttons">
                        <a class="post-mini__user-button user__button user__button--subscription button
                        button--<?= $sub['is_session_user_subscribed'] ? 'quartz' : 'main' ?>"
                        href="/subscribe.php?subscribe_user_id=<?= $sub['user_id'] ?>">
                            <?= $sub['is_session_user_subscribed'] ? 'Отписаться' : 'Подписаться' ?>
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
