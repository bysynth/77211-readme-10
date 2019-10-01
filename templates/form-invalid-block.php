<div class="form__invalid-block">
    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
    <ul class="form__invalid-list">
        <?php foreach ($errors as $error) : ?>
            <?php if (isset($error['input_name'], $error['input_error_desc'])): ?>
                <?= '<li class="form__invalid-item">' . clear_input($error['input_name']) . '. ' . clear_input($error['input_error_desc']) . '</li>' ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
