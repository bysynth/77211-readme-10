<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section <?= isset($error) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-url"
               placeholder="Введите ссылку" value="<?= get_post_val('photo-url') ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <?= include_template('input-error.php', [
            'error_title' => $error['input_name'],
            'error_desc' => $error['input_error_desc']
        ]) ?>
    </div>
</div>
