CREATE DATABASE IF NOT EXISTS readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE users
(
    id         INT(10) AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    email      VARCHAR(255)                       NOT NULL UNIQUE,
    name       VARCHAR(128)                       NOT NULL,
    password   VARCHAR(255)                       NOT NULL,
    avatar     VARCHAR(255)                       NULL,
    about_user TEXT                               NULL
);

CREATE TABLE content_types
(
    id        INT(2) AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(25) NOT NULL UNIQUE,
    type_icon VARCHAR(25) NOT NULL UNIQUE
);

CREATE TABLE posts
(
    id                 INT(10) AUTO_INCREMENT PRIMARY KEY,
    created_at         DATETIME   DEFAULT CURRENT_TIMESTAMP NOT NULL,
    title              VARCHAR(255)                         NOT NULL,
    content            TEXT                                 NULL,
    cite_author        VARCHAR(255)                         NULL,
    views_counter      INT(12)    DEFAULT 0                 NOT NULL,
    is_repost          TINYINT(1) DEFAULT 0                 NOT NULL,
    author_id          INT(10)                              NOT NULL,
    original_author_id INT(10)                              NULL,
    content_type       INT(10)                              NOT NULL,
    FOREIGN KEY (author_id) REFERENCES users (id),
    FOREIGN KEY (original_author_id) REFERENCES users (id),
    FOREIGN KEY (content_type) REFERENCES content_types (id)
);

CREATE TABLE comments
(
    id         INT(10) AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    comment    TEXT                               NOT NULL,
    author_id  INT(10)                            NOT NULL,
    post_id    INT(10)                            NOT NULL,
    FOREIGN KEY (author_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE likes
(
    user_id INT(10) NOT NULL,
    post_id INT(10) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE subscriptions
(
    id                INT(10) AUTO_INCREMENT PRIMARY KEY,
    author_id         INT(10) NOT NULL,
    subscribe_user_id INT(10) NOT NULL,
    FOREIGN KEY (author_id) REFERENCES users (id),
    FOREIGN KEY (subscribe_user_id) REFERENCES users (id)
);

CREATE TABLE messages
(
    id          INT(10) AUTO_INCREMENT PRIMARY KEY,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    message     TEXT                               NOT NULL,
    sender_id   INT(10)                            NOT NULL,
    receiver_id INT(10)                            NOT NULL,
    FOREIGN KEY (sender_id) REFERENCES users (id),
    FOREIGN KEY (receiver_id) REFERENCES users (id)
);

CREATE TABLE hashtags
(
    id      INT(10) AUTO_INCREMENT PRIMARY KEY,
    hashtag VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE hashtags_posts
(
    id         INT(10) AUTO_INCREMENT PRIMARY KEY,
    hashtag_id INT(10) NOT NULL,
    post_id    INT(10) NOT NULL,
    FOREIGN KEY (hashtag_id) REFERENCES hashtags (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

# Индексы по заданию
# CREATE INDEX title ON posts (title);
# CREATE FULLTEXT INDEX content ON posts (content, cite_author);
# CREATE INDEX posts_tags ON posts (post_id, hashtag_id);
