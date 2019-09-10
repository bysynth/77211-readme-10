<div class="authorization__input-wrapper form__input-wrapper">
    <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
        <input class="authorization__input authorization__input--login form__input" type="text" name="email"
               placeholder="Email" value="<?= get_post_val('email') ?>">
        <svg class="form__input-icon" width="19" height="18">
            <use xlink:href="#icon-input-user"></use>
        </svg>
        <label class="visually-hidden">Email</label>
    </div>
    <?php if (!empty($error)) : ?>
        <span class="form__error-label form__error-label--login"><?= $error['input_error_desc'] ?></span>
    <?php endif; ?>
</div>

