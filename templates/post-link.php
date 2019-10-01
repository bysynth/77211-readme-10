<div class="post__main">
    <div class="post-link__wrapper">
        <a class="post-link__external" href="<?= clear_input($url) ?>" title="Перейти по ссылке">
            <div class="post-link__info-wrapper">
                <div class="post-link__icon-wrapper">
                    <img src="https://www.google.com/s2/favicons?domain=<?= clear_input($url) ?>" alt="Иконка">
                </div>
                <div class="post-link__info">
                    <h3><?= clear_input($title) ?></h3>
                    <span><?= clear_input($url) ?></span>
                </div>
            </div>
        </a>
    </div>
</div>
