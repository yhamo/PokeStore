create database if not exists pokestore character set utf8 collate utf8_unicode_ci;
use pokestore;

grant all privileges on pokestore.* to 'poke_user'@'localhost' identified by 'secret';


