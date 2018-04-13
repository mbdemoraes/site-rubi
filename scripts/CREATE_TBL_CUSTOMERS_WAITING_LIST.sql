CREATE TABLE tbl_waiting_list(
  id int UNSIGNED NOT NULL,
  tbl_courses_id int UNSIGNED NOT NULL,
  tbl_customers_id int UNSIGNED NOT NULL,
  tbl_customers_name_var varchar(255) NOT NULL UNIQUE,
  creation_date_dt date NOT NULL,
  FOREIGN KEY (tbl_courses_id) REFERENCES tbl_courses(id)
	 ON DELETE CASCADE
         ON UPDATE CASCADE,
  FOREIGN KEY (tbl_customers_id) REFERENCES tbl_customers(id)
 	 ON DELETE CASCADE
         ON UPDATE CASCADE,
  FOREIGN KEY (tbl_customers_name_var) REFERENCES tbl_customers(name_var)
 	 ON DELETE CASCADE
         ON UPDATE CASCADE
  
);

ALTER TABLE tbl_waiting_list
  ADD PRIMARY KEY (id);
  
ALTER TABLE tbl_waiting_list
  MODIFY id int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;