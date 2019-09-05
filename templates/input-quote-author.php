<div class="adding-post__input-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span
            class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author"
               value="<?= get_post_val('quote-author') ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <?= include_template('input-error.php',
            [
                'error' => $error
            ])
        ?>
    </div>
</div>
