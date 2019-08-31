<label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
<div class="form__input-section">
    <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="text-content" placeholder="Введите текст публикации"></textarea>
    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
    <?= include_template('input-error.php', [
        'error_title' => 'Заголовок',
        'error_desc' => 'Текст сообщения об ошибке, подробно объясняющий, что не так.'
    ])?>
</div>
