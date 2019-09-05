<?php if (isset($error['input_name'], $error['input_error_desc'])): ?>
    <div class="form__error-text">
        <h3 class="form__error-title"><?= $error['input_name'] ?></h3>
        <p class="form__error-desc"><?= $error['input_error_desc'] ?></p>
    </div>
<?php endif ?>

