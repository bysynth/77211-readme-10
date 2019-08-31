<label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
<div class="form__input-section">
    <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author">
    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
    <?= include_template('input-error.php', [
        'error_title' => 'Заголовок',
        'error_desc' => 'Текст сообщения об ошибке, подробно объясняющий, что не так.'
    ])?>
</div>
