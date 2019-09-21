<div class="container">
    <h1 class="page__title page__title--registration">Регистрация</h1>
</div>
<section class="registration container">
    <h2 class="visually-hidden">Форма регистрации</h2>
    <form class="registration__form form" action="/registration.php" method="post" enctype="multipart/form-data">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?= include_template('input-email.php',
                    [
                        'error' => $errors['email'] ?? []
                    ])
                ?>
                <?= include_template('input-login.php',
                    [
                        'error' => $errors['login'] ?? []
                    ])
                ?>
                <?= include_template('input-password.php',
                    [
                        'error' => $errors['password'] ?? []
                    ])
                ?>
                <?= include_template('input-password-repeat.php',
                    [
                        'error' => $errors['password-repeat'] ?? []
                    ])
                ?>
            </div>
            <?php if (!empty($errors)) : ?>
                <?= include_template('form-invalid-block.php',
                    [
                        'errors' => $errors
                    ])
                ?>
            <?php endif; ?>
        </div>
        <div class="registration__input-file-container form__input-container form__input-container--file">
            <input type="file" name="userpic-file">
        </div>
        <button class="registration__submit button button--main" type="submit">Отправить</button>
    </form>
</section>
