<label class="adding-post__label form__label" for="quote-text">Текст цитаты <span class="form__input-required">*</span></label>
<div class="form__input-section <?= isset($error) ? 'form__input-section--error' : '' ?>">
    <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="quote-text" name="content" placeholder="Текст цитаты"><?= get_post_val('content')?></textarea>
    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
    <?= include_template('input-error.php', [
        'error_title' => $error['input_name'],
        'error_desc' => $error['input_error_desc']
    ])?>
</div>
