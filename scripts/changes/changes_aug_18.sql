ALTER TABLE tbl_courses
ADD description_var VARCHAR(500); 

ALTER TABLE tbl_courses
ADD event_date_final_dt date; 

ALTER TABLE tbl_courses
ADD event_hour_final_var varchar(10); 

ALTER TABLE tbl_courses
ADD price_rubi_dec decimal(6,2) unsigned; 

ALTER TABLE tbl_customers
ADD cellphone_var varchar(100); 

ALTER TABLE tbl_costs
ADD description_var VARCHAR(200); 
