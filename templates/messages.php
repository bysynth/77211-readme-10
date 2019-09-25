<h1 class="visually-hidden">Личные сообщения</h1>
<section class="messages tabs">
    <h2 class="visually-hidden">Сообщения</h2>
    <?php if (isset($interlocutors)): ?>
        <div class="messages__contacts">
            <?php if (!empty($interlocutors)): ?>
                <ul class="messages__contacts-list tabs__list">
                    <?php foreach ($interlocutors as $interlocutor) : ?>
                        <li class="messages__contacts-item">
                            <?php if (isset($interlocutor['id'])): ?>
                                <a class="messages__contacts-tab <?= $interlocutor['id'] === $interlocutor_id ? 'messages__contacts-tab--active' : '' ?>"
                                   href="/messages.php?user_id=<?= $interlocutor['id'] ?>">
                                    <div class="messages__avatar-wrapper">
                                        <?php if (isset($interlocutor['avatar'])): ?>
                                            <img class="messages__avatar" src="/uploads/<?= $interlocutor['avatar'] ?>"
                                                 alt="Аватар пользователя">
                                        <?php endif ?>
                                    </div>
                                    <div class="messages__info">
                                        <?php if (isset($interlocutor['name'])): ?>
                                            <span class="messages__contact-name"><?= $interlocutor['name'] ?></span>
                                        <?php endif ?>
                                        <?php if (isset($interlocutor['last_message_date'])): ?>
                                            <div class="messages__preview">
                                                <time style="max-width: none;" class="messages__preview-time"
                                                      datetime="<?= $interlocutor['last_message_date'] ?>">
                                                    <?= get_relative_time_format($interlocutor['last_message_date'],
                                                        'назад') ?>
                                                </time>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </a>
                            <?php endif ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif ?>
        </div>
        <div class="messages__chat" style="min-height: 210px;">
            <?php if (!empty($messages)): ?>
                <div class="messages__chat-wrapper">
                    <ul class="messages__list">
                        <?php foreach ($messages as $message): ?>
                            <?php if (isset($message['id'])): ?>
                                <li class="messages__item <?= $message['id'] === $session_user_id ? 'messages__item--my' : '' ?>">
                                    <div class="messages__info-wrapper">
                                        <div class="messages__item-avatar">
                                            <?php if (isset($message['id'], $message['avatar'])): ?>
                                                <a class="messages__author-link"
                                                   href="/profile.php?user=<?= $message['id'] ?>">
                                                    <img class="messages__avatar"
                                                         src="/uploads/<?= $message['avatar'] ?>"
                                                         alt="Аватар пользователя">
                                                </a>
                                            <?php endif ?>
                                        </div>
                                        <div class="messages__item-info">
                                            <?php if (isset($message['id'], $message['name'])): ?>
                                                <a class="messages__author"
                                                   href="/profile.php?user=<?= $message['id'] ?>">
                                                    <?= $message['name'] ?>
                                                </a>
                                            <?php endif ?>
                                            <?php if (isset($message['created_at'])): ?>
                                                <time class="messages__time" datetime="<?= $message['created_at'] ?>">
                                                    <?= get_relative_time_format($message['created_at'], 'назад') ?>
                                                </time>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <?php if (isset($message['message'])): ?>
                                        <p class="messages__text">
                                            <?= $message['message'] ?>
                                        </p>
                                    <?php endif ?>
                                </li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif ?>
            <?php if ($interlocutor_id !== ''): ?>
                <div class="comments">
                    <form class="comments__form form" method="post">
                        <?php if (isset($_SESSION['user']['avatar'])): ?>
                            <div class="comments__my-avatar">
                                <img class="comments__picture" src="/uploads/<?= $_SESSION['user']['avatar'] ?>"
                                     alt="Аватар пользователя">
                            </div>
                        <?php endif ?>
                        <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
                    <textarea class="comments__textarea form__textarea form__input" name="message" id="message"
                              placeholder="Ваше сообщение"><?= get_post_val('message') ?></textarea>
                            <label for="message" class="visually-hidden">Ваше сообщение</label>
                            <input type="hidden" name="receiver-id" value="<?= $interlocutor_id ?>">
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
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
</section>
