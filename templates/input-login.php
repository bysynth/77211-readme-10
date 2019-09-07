<div class="registration__input-wrapper form__input-wrapper">
    <label class="registration__label form__label" for="registration-login">Логин <span
            class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
        <input class="registration__input form__input" id="registration-login" type="text" name="login"
               placeholder="Укажите логин" value="<?= get_post_val('login') ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <?= include_template('input-error.php',
            [
                'error' => $error
            ])
        ?>
    </div>
</div>
