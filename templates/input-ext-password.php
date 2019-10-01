<div class="authorization__input-wrapper form__input-wrapper">
    <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
        <input class="authorization__input authorization__input--password form__input" type="password" name="password"
               placeholder="Пароль">
        <svg class="form__input-icon" width="16" height="20">
            <use xlink:href="#icon-input-password"></use>
        </svg>
        <label class="visually-hidden">Пароль</label>
    </div>
    <?php if (!empty($error)) : ?>
        <span class="form__error-label"><?= clear_input($error['input_error_desc']) ?></span>
    <?php endif; ?>
</div>

