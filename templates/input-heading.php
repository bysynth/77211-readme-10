<label class="adding-post__label form__label" for="<?= $type ?>-heading">Заголовок <span class="form__input-required">*</span></label>
<div class="form__input-section">
    <input class="adding-post__input form__input" id="<?= $type ?>-heading" type="text" name="<?= $type ?>-heading"
           placeholder="Введите заголовок">
    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span>
    </button>
    <div class="form__error-text">
        <h3 class="form__error-title">Заголовок сообщения</h3>
        <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
    </div>
</div>
