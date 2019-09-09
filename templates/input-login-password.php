<div class="login__input-wrapper form__input-wrapper">
    <label class="login__label form__label" for="login-password">Пароль</label>
    <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
        <input class="login__input form__input" id="login-password" type="password" name="password"
               placeholder="Введите пароль">
        <button class="form__error-button button button--main" type="button">!<span class="visually-hidden">Информация об ошибке</span>
        </button>
        <?= include_template('input-error.php',
            [
                'error' => $error
            ])
        ?>
    </div>
</div>
