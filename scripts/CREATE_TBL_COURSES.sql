CREATE TABLE tbl_courses (
  id int UNSIGNED NOT NULL,
  name_var varchar(255) NOT NULL,
  professor_var varchar(255) NOT NULL,
  numSlots_int int NOT NULL,
  numSlotsTaken_int int NOT NULL,
  price_dec decimal(6,2) UNSIGNED NOT NULL,
  event_date_dt date NOT NULL,
  event_hour_var varchar(10) NOT NULL,
  status_var varchar(10) NOT NULL DEFAULT 'Aberto',
  creation_date_dt date NOT NULL,
  modification_date_dt date NOT NULL
);

ALTER TABLE tbl_courses
  ADD PRIMARY KEY (id);
  
ALTER TABLE tbl_courses
  MODIFY id int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;