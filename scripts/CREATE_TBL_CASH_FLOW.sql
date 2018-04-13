CREATE TABLE tbl_cash_flow (
  id int UNSIGNED NOT NULL,
  month_int INT DEFAULT 0 NOT NULL,
  year_int INT DEFAULT 0 NOT NULL,
  costs_dec decimal(6,2) UNSIGNED DEFAULT 0.0 NOT NULL,
  income_dec decimal(6,2) UNSIGNED DEFAULT 0.0 NOT NULL,
  balance_dec decimal(6,2) DEFAULT 0.0 NULL
  
);

ALTER TABLE tbl_cash_flow
  ADD PRIMARY KEY (id);

ALTER TABLE tbl_cash_flow
  MODIFY id int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;