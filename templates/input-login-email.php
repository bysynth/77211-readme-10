<div class="login__input-wrapper form__input-wrapper">
    <label class="login__label form__label" for="login-email">Электронная почта</label>
    <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
        <input class="login__input form__input" id="login-email" type="email" name="email"
               placeholder="Укажите эл.почту" value="<?= clear_input(get_post_val('email')) ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <?= include_template('input-error.php',
            [
                'error' => $error
            ])
        ?>
    </div>
</div>
