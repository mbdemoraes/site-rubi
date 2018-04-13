CREATE TABLE tbl_interests(
  id int UNSIGNED NOT NULL,
  name_var varchar(50) NOT NULL 
 
);

ALTER TABLE tbl_interests
  ADD PRIMARY KEY (id);

ALTER TABLE tbl_interests
  MODIFY id int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;