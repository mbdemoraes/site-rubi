CREATE TABLE tbl_customer_interests(
  tbl_customers_id int UNSIGNED NOT NULL,
  tbl_interests_id int UNSIGNED NOT NULL,
  isinterest_tni tinyint(1) UNSIGNED NOT NULL,
  creation_date_dt date NOT NULL,
  modification_date_dt date NOT NULL,
  FOREIGN KEY (tbl_customers_id) REFERENCES tbl_customers(id)
	 ON DELETE CASCADE
         ON UPDATE CASCADE,
  FOREIGN KEY (tbl_interests_id) REFERENCES tbl_interests(id)
	 ON DELETE CASCADE
         ON UPDATE CASCADE
);

