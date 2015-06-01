alter table POKEMON add constraint FK_DF foreign key (ID_Type)
      references Type (ID_Type) on delete restrict on update restrict;


