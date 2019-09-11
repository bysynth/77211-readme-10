<div class="container">
    <h1 class="page__title page__title--login">Вход</h1>
</div>
<section class="login container">
    <h2 class="visually-hidden">Форма авторизации</h2>
    <form class="login__form form" action="/login.php" method="post">
        <?= include_template('input-login-email.php',
            [
                'error' => $errors['email'] ?? []
            ])
        ?>
        <?= include_template('input-login-password.php',
            [
                'error' => $errors['password'] ?? []
            ])
        ?>
        <button class="login__submit button button--main" type="submit">Отправить</button>
    </form>
</section>
