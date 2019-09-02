<label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
<div class="form__input-section <?= isset($error) ? 'form__input-section--error' : '' ?>">
    <input class="adding-post__input form__input" id="post-link" type="text" name="link-url" value="<?= get_post_val('link-url')?>">
    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
    <?= include_template('input-error.php', [
        'error_title' => $error['input_name'],
        'error_desc' => $error['input_error_desc']
    ])?>
</div>
