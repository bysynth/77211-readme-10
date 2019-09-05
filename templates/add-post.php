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
                            <a class="adding-post__tabs-link filters__button filters__button--<?= $content_type['type_icon'] ?? '' ?> tabs__item button
                            <?= (empty($_POST) && $key === 0) || array_key_exists($content_type['type_icon'], $_POST) ? 'filters__button--active tabs__item--active' : '' ?>">
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-<?= $content_type['type_icon'] ?? '' ?>"></use>
                                </svg>
                                <span><?= $content_type['type_name'] ?? '' ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="adding-post__tab-content">
                <section class="adding-post__text tabs__content <?= empty($_POST) || isset($_POST['text']) ? 'tabs__content--active' : '' ?>">
                    <h2 class="visually-hidden">Форма добавления текста</h2>
                    <form class="adding-post__form form" action="/add.php" method="post">
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
                            <button class="adding-post__submit button button--main" type="submit" name="text">Опубликовать</button>
                            <a class="adding-post__close" href="#">Закрыть</a>
                        </div>
                    </form>
                </section>

                <section class="adding-post__quote tabs__content <?= isset($_POST['quote']) ? 'tabs__content--active' : '' ?>">
                    <h2 class="visually-hidden">Форма добавления цитаты</h2>
                    <form class="adding-post__form form" action="/add.php" method="post">
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
                            <button class="adding-post__submit button button--main" type="submit" name="quote">Опубликовать</button>
                            <a class="adding-post__close" href="#">Закрыть</a>
                        </div>
                    </form>
                </section>

                <section class="adding-post__photo tabs__content <?= isset($_POST['photo']) ? 'tabs__content--active' : '' ?>">
                    <h2 class="visually-hidden">Форма добавления фото</h2>
                    <form class="adding-post__form form" action="/add.php" method="post" enctype="multipart/form-data">
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
                        <div class="adding-post__input-file-container form__input-container form__input-container--file">
                            <input type="file" name="upload-file">
                        </div>
<!--                        <div class="adding-post__input-file-container form__input-container form__input-container--file">
                            <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                                <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                                    <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="userpic-file-photo" title=" ">
                                    <div class="form__file-zone-text">
                                        <span>Перетащите фото сюда</span>
                                    </div>
                                </div>
                                <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                                    <span>Выбрать фото</span>
                                    <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                                        <use xlink:href="#icon-attach"></use>
                                    </svg>
                                </button>
                            </div>
                            <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">
                            </div>
                        </div>-->
                        <div class="adding-post__buttons">
                            <button class="adding-post__submit button button--main" id="photo-submit" type="submit" name="photo">Опубликовать</button>
                            <a class="adding-post__close" href="#">Закрыть</a>
                        </div>
                    </form>
                </section>

                <section class="adding-post__video tabs__content <?= isset($_POST['video']) ? 'tabs__content--active' : '' ?>">
                    <h2 class="visually-hidden">Форма добавления видео</h2>
                    <form class="adding-post__form form" action="/add.php" method="post" enctype="multipart/form-data">
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
                            <button class="adding-post__submit button button--main" type="submit" name="video">Опубликовать</button>
                            <a class="adding-post__close" href="#">Закрыть</a>
                        </div>
                    </form>
                </section>

                <section class="adding-post__link tabs__content <?= isset($_POST['link']) ? 'tabs__content--active' : '' ?>">
                    <h2 class="visually-hidden">Форма добавления ссылки</h2>
                    <form class="adding-post__form form" action="/add.php" method="post">
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
                            <button class="adding-post__submit button button--main" type="submit" name="link">Опубликовать</button>
                            <a class="adding-post__close" href="#">Закрыть</a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
