CREATE TABLE tbl_course_customers (
  id int UNSIGNED NOT NULL,
  tbl_courses_id int UNSIGNED NOT NULL,
  tbl_courses_name_var varchar(255) NOT NULL,
  tbl_customers_id int UNSIGNED NOT NULL,
  tbl_customers_name_var varchar(255) NOT NULL,
  payment_tni tinyint(1) NOT NULL,
  payment_type_var varchar(30) NOT NULL,
  payment_info_var varchar(200) NOT NULL,
  payment_date_dt date NULL DEFAULT NULL,
  creation_date_dt date NOT NULL,
  modification_date_dt date NOT NULL,
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

ALTER TABLE tbl_course_customers
  ADD PRIMARY KEY (id);

ALTER TABLE tbl_course_customers
  MODIFY id int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;