<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span
            class="form__input-required">*</span></label>
    <div class="form__input-section <?= isset($error) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="video-url" type="text" name="video-url"
               placeholder="Введите ссылку" value="<?= get_post_val('video-url') ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <?= include_template('input-error.php', [
            'error_title' => $error['input_name'],
            'error_desc' => $error['input_error_desc']
        ]) ?>
    </div>
</div>
