<label class="adding-post__label form__label" for="<?= $type ?>-tags">Теги</label>
<div class="form__input-section">
    <input class="adding-post__input form__input" id="<?= $type ?>-tags" type="text" name="<?= $type ?>-tags" placeholder="Введите теги">
    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
    <?= include_template('input-error.php', [
        'error_title' => 'Заголовок',
        'error_desc' => 'Текст сообщения об ошибке, подробно объясняющий, что не так.'
    ])?>
</div>
