CREATE TABLE tbl_users (
  id int UNSIGNED NOT NULL,
  name_var varchar(50) UNIQUE NOT NULL,
  username_var varchar(50) UNIQUE NOT NULL,
  password_var varchar(255) NOT NULL,
  userType_var varchar(15) NOT NULL,
  creation_date_dt date NOT NULL,
  modification_date_dt date NOT NULL
  
);

ALTER TABLE tbl_users
  ADD PRIMARY KEY (id);

ALTER TABLE tbl_users
  MODIFY id int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;