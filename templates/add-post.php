<div class="page__main-section">
    <div class="container">
        <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
    </div>
    <div class="adding-post container">
        <div class="adding-post__tabs-wrapper tabs">
            <div class="adding-post__tabs filters">
                <ul class="adding-post__tabs-list filters__list tabs__list">
                    <?php foreach ($content_types as $key => $content_type): ?>
                        <li class="adding-post__tabs-item filters__item">
                            <?php if (isset($type)): ?>
                                <a class="adding-post__tabs-link filters__button filters__button--<?= clear_input($content_type['type_icon']) ?? '' ?> tabs__item button
                                <?= ($type === $content_type['id']) || array_key_exists($content_type['type_icon'],
                                    $_POST) ? 'filters__button--active tabs__item--active' : '' ?>"
                                   href="/add.php?type=<?= clear_input($content_type['id']) ?>">
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-<?= clear_input($content_type['type_icon']) ?? '' ?>"></use>
                                    </svg>
                                    <span><?= clear_input($content_type['type_name']) ?? '' ?></span>
                                </a>
                            <?php endif ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="adding-post__tab-content">
                <?php if (isset($type) && $type === POST_TYPE_TEXT): ?>
                    <section class="adding-post__text tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Форма добавления текста</h2>
                        <form class="adding-post__form form" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= include_template('input-heading.php',
                                        [
                                            'type' => 'text',
                                            'error' => $errors['text-heading'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-post-text.php',
                                        [
                                            'error' => $errors['text-content'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-tags.php',
                                        [
                                            'type' => 'text'
                                        ])
                                    ?>
                                </div>
                                <?php if (!empty($errors) && isset($_POST['text'])) : ?>
                                    <?= include_template('form-invalid-block.php',
                                        [
                                            'errors' => $errors
                                        ])
                                    ?>
                                <?php endif; ?>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit" name="text">
                                    Опубликовать
                                </button>
                            </div>
                        </form>
                    </section>
                <?php endif ?>

                <?php if (isset($type) && $type === POST_TYPE_QUOTE): ?>
                    <section class="adding-post__quote tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Форма добавления цитаты</h2>
                        <form class="adding-post__form form" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= include_template('input-heading.php',
                                        [
                                            'type' => 'quote',
                                            'error' => $errors['quote-heading'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-quote-text.php',
                                        [
                                            'error' => $errors['quote-content'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-quote-author.php',
                                        [
                                            'error' => $errors['quote-author'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-tags.php',
                                        [
                                            'type' => 'quote'
                                        ])
                                    ?>
                                </div>
                                <?php if (!empty($errors) && isset($_POST['quote'])) : ?>
                                    <?= include_template('form-invalid-block.php',
                                        [
                                            'errors' => $errors
                                        ])
                                    ?>
                                <?php endif; ?>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit" name="quote">
                                    Опубликовать
                                </button>
                            </div>
                        </form>
                    </section>
                <?php endif ?>

                <?php if (isset($type) && $type === POST_TYPE_PHOTO): ?>
                    <section class="adding-post__photo tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Форма добавления фото</h2>
                        <form class="adding-post__form form" method="post"
                              enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= include_template('input-heading.php',
                                        [
                                            'type' => 'photo',
                                            'error' => $errors['photo-heading'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-photo-url.php',
                                        [
                                            'error' => $errors['photo-url'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-tags.php',
                                        [
                                            'type' => 'photo'
                                        ])
                                    ?>
                                </div>
                                <?php if (!empty($errors) && (isset($_POST['photo']) || isset($_FILES['upload-file']))) : ?>
                                    <?= include_template('form-invalid-block.php',
                                        [
                                            'errors' => $errors
                                        ])
                                    ?>
                                <?php endif; ?>
                            </div>
                            <div
                                class="adding-post__input-file-container form__input-container form__input-container--file">
                                <input type="file" name="upload-file">
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" id="photo-submit" type="submit"
                                        name="photo">Опубликовать
                                </button>
                            </div>
                        </form>
                    </section>
                <?php endif ?>

                <?php if (isset($type) && $type === POST_TYPE_VIDEO): ?>
                    <section class="adding-post__video tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Форма добавления видео</h2>
                        <form class="adding-post__form form" method="post"
                              enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= include_template('input-heading.php',
                                        [
                                            'type' => 'video',
                                            'error' => $errors['video-heading'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-video-url.php',
                                        [
                                            'error' => $errors['video-url'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-tags.php',
                                        [
                                            'type' => 'video'
                                        ])
                                    ?>
                                </div>
                                <?php if (!empty($errors) && isset($_POST['video'])) : ?>
                                    <?= include_template('form-invalid-block.php',
                                        [
                                            'errors' => $errors
                                        ])
                                    ?>
                                <?php endif; ?>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit" name="video">
                                    Опубликовать
                                </button>
                            </div>
                        </form>
                    </section>
                <?php endif ?>

                <?php if (isset($type) && $type === POST_TYPE_LINK): ?>
                    <section class="adding-post__link tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Форма добавления ссылки</h2>
                        <form class="adding-post__form form" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= include_template('input-heading.php',
                                        [
                                            'type' => 'link',
                                            'error' => $errors['link-heading'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-post-link.php',
                                        [
                                            'error' => $errors['link-url'] ?? []
                                        ])
                                    ?>
                                    <?= include_template('input-tags.php',
                                        [
                                            'type' => 'link'
                                        ])
                                    ?>
                                </div>
                                <?php if (!empty($errors) && isset($_POST['link'])) : ?>
                                    <?= include_template('form-invalid-block.php',
                                        [
                                            'errors' => $errors
                                        ])
                                    ?>
                                <?php endif; ?>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit" name="link">
                                    Опубликовать
                                </button>
                            </div>
                        </form>
                    </section>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
