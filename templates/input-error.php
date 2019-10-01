<?php if (isset($error['input_name'], $error['input_error_desc'])): ?>
    <div class="form__error-text">
        <h3 class="form__error-title"><?= clear_input($error['input_name']) ?></h3>
        <p class="form__error-desc"><?= clear_input($error['input_error_desc']) ?></p>
    </div>
<?php endif ?>

