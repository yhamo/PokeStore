


drop table if exists TYPE;

drop table if exists POKEMON;

/*==============================================================*/
/* Table : TYPE                                                */
/*==============================================================*/
create table TYPE
(
   ID_TYPE          integer not null,
   LIB_TYPE          varchar(20),
   primary key (ID_TYPE)
);

/*==============================================================*/
/* Table : POKEMON                                              */
/*==============================================================*/
create table POKEMON
(
   ID_POKEMON           integer not null,
   ID_Type             integer not null,
   name_pokemon          varchar(50),
   Name_Manufacturer        varchar(20) Default  'Satoshi Tajiri',
   IMG_POK              varchar(200),
   PRICE_POK             numeric(6,2),
   DESCRIPTION          varchar(999),
   primary key (ID_POKEMON)
);


/*==============================================================*/
/* Table : t_user                                              */
/*==============================================================*/

create table t_user (
    usr_id integer not null primary key auto_increment,
    usr_name varchar(50) not null,
    usr_password varchar(88) not null,
    usr_email varchar(88) not null,
    usr_address varchar(200) not null,
    usr_salt varchar(23) not null,
    usr_role varchar(50)  Default  'ROLE_USER'
    constraint uniq_user_email unique key (usr_email),
) 
