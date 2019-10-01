<?php $input_name = $type . '-heading'; ?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="<?= clear_input($input_name) ?>">Заголовок <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="<?= clear_input($input_name) ?>" type="text" name="<?= clear_input($input_name) ?>"
               placeholder="Введите заголовок" value="<?= clear_input(get_post_val($input_name)) ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <?= include_template('input-error.php',
            [
                'error' => $error
            ])
        ?>
    </div>
</div>
