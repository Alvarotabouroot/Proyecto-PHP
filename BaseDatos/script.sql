CREATE DATABASE IF NOT EXISTS cofradia;
use cofradia;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS `users`(
    `id`  int(255) auto_increment not null,
    `nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `token_esp` timestamp NULL DEFAULT NULL,

    CONSTRAINT pk_users PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS hermanos;
CREATE TABLE IF NOT EXISTS `hermanos`(
    `id`  int(255) auto_increment not null,
    `nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `apellidos` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `token_esp` timestamp NULL DEFAULT NULL,

    CONSTRAINT pk_hermanos PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS eventos;
CREATE TABLE IF NOT EXISTS `eventos`(
    `id`  int(255) auto_increment not null,
    `nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `fecha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `numParticipantes` int(255) COLLATE utf8mb4_unicode_ci NOT NULL,

    CONSTRAINT pk_eventos PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS asistentesEventos;
CREATE TABLE IF NOT EXISTS asistentesEventos( 
id              int auto_increment not null,
hermano_id     int not null,
evento_id       int not null,

CONSTRAINT pk_asistentesEventos PRIMARY KEY(id),
CONSTRAINT fk_asistente_hermano FOREIGN KEY(hermano_id) REFERENCES hermanos(id),
CONSTRAINT fk_asistentes_evento FOREIGN KEY(evento_id) REFERENCES eventos(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

