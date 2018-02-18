--
--  blogger.db structure
--

CREATE TABLE Posts
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL,
    teaser varchar(1024) NOT NULL,
    body varchar(65535) NOT NULL,
    tags varchar(255) NOT NULL,
    author varchar(255) NOT NULL,
    modified timestamp NOT NULL,
    created timestamp NOT NULL
);
