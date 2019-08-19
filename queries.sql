INSERT INTO content_types (type_name, type_class)
VALUES ('Текст', 'post-text'),
       ('Цитата', 'post-quote'),
       ('Картинка', 'post-photo'),
       ('Видео', 'post-video'),
       ('Ссылка', 'post-link');

INSERT INTO users (created_at, email, name, password)
VALUES ('2018-04-10 10:32:01', 'oleg@menshikov.ru', 'Олег Меньшиков', 'ilovewatches'),
       ('2018-10-27 20:10:56', 'nikita@mihalkov.ru', 'Никита Михалков', 'kingoftheworld'),
       ('2019-01-08 14:15:47', 'sergey@bezrukov.ru', 'Сергей Безруков', 'vysotskyalive'),
       ('2019-03-02 08:06:15', 'anna@semenovich.ru', 'Анна Семенович', 'loveboobs'),
       ('2019-05-08 12:57:16', 'olga@buzova.ru', 'Ольга Бузова', 'dom2forever');

INSERT INTO posts (created_at, title, text_content, cite_author, image, video, link, views_counter, is_repost, author_id,
                   original_author_id, content_type)
VALUES ('2018-04-10 10:40:00', 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Сергей Есенин',
        NULL, NULL, NULL, 35640, 0, 1, NULL, 2),
       ('2018-10-28 09:10:15', 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!',
        NULL, NULL, NULL, NULL, 26187, 0, 2, NULL, 1),
       ('2019-01-09 15:01:36', 'Наконец, обработал фотки!', NULL, NULL, 'rock-medium.jpg', NULL, NULL, 16501, 0, 3,
        NULL, 3),
       ('2019-03-03 18:46:01', 'Моя мечта', NULL, NULL, 'coast-medium.jpg', NULL, NULL, 12349, 0, 4, NULL, 3),
       ('2019-05-10 07:02:23', 'Лучшие курсы', NULL, NULL, NULL, NULL, 'www.htmlacademy.ru', 5784, 0, 5, NULL, 5);

INSERT INTO comments (created_at, comment, author_id, post_id)
VALUES ('2018-10-29 02:35:41', 'Олег, великолепные слова. Есенин мой любимый поэт.', 2, 1),
       ('2018-10-28 15:31:28', 'Никита Сергеевич, когда свою Игру Престолов снимешь???', 1, 2),
       ('2019-01-11 10:56:11', 'Меня приглашали на роль Тириона Ланнистера, но я отказался, загруженный график((', 3,
        2),
       ('2019-01-12 08:12:34', 'Сережа, прекрасные фотокарточки! У тебя хорошо получается ;)', 1, 3),
       ('2019-03-04 09:34:47', 'Какая красота, я бы заехал в этот домик', 2, 4),
       ('2019-05-11 13:18:46', 'О, клёвая школа, как раз изучаю здесь HTML, HTML программисткой решила стать :)', 4, 5),
       ('2019-05-12 09:55:03', 'Да Да, ну его этот шоу-биз, буду React разработчицей X-D', 5, 5);

# Получаю список постов с сортировкой по популярности и вместе с именами авторов и типом контента

SELECT p.id, p.title, u.name, t.type_name, p.views_counter
FROM posts AS p
         JOIN users AS u
              ON u.id = p.author_id
         JOIN content_types AS t
              ON t.id = p.id
ORDER BY p.views_counter DESC;

# Получаю список постов для конкретного пользователя;

SELECT id, title
FROM posts
WHERE author_id = 1;

# Получаю список комментариев для одного поста, в комментариях должен быть логин пользователя;

SELECT c.comment, u.name
FROM comments AS c
         JOIN users AS u
              ON c.author_id = u.id
WHERE c.post_id = 2;

# Добавляю лайк к посту

INSERT INTO likes
SET user_id = 2,
    post_id = 1;

# Подписываюсь на пользователя

INSERT INTO subscriptions
SET author_id         = 1,
    subscribe_user_id = 3;
