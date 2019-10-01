<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="<?= clear_input($type) ?>-tags">Теги</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="<?= clear_input($type) ?>-tags" type="text" name="tags"
               placeholder="Введите теги" value="<?= clear_input(get_post_val('tags')) ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
    </div>
</div>
