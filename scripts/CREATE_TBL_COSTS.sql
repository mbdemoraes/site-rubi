CREATE TABLE tbl_costs (
  id int UNSIGNED NOT NULL,
  type_var varchar(50) NOT NULL,
  value_dec DECIMAL(6,2) UNSIGNED NOT NULL ,
  payment_tni tinyint(1) NOT NULL,
  deadline_dt date NOT NULL,
  creation_date_dt date NOT NULL,
  modification_date_dt date NOT NULL
);

ALTER TABLE tbl_costs
  ADD PRIMARY KEY (id);

ALTER TABLE tbl_costs
  MODIFY id int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;