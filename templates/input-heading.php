<?php
$classname = isset($error) ? 'form__input-section--error' : '';
$input_name = $type . '-heading';
?>

<label class="adding-post__label form__label" for="<?= $type ?>-heading">Заголовок <span class="form__input-required">*</span></label>
<div class="form__input-section <?= $classname ?>">
    <input class="adding-post__input form__input" id="<?= $type ?>-heading" type="text" name="<?= $type ?>-heading"
           placeholder="Введите заголовок" value="<?= get_post_val($input_name) ?>">
    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span>
    </button>
    <?= include_template('input-error.php', [
        'error_title' => $error['input_name'],
        'error_desc' => $error['input_error_desc']
    ]) ?>
</div>
