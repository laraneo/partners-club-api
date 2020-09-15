CREATE TABLE share_permit_movements (
	id bigint IDENTITY(1,1) NOT NULL,
	[desc] varchar(255) NULL,
	[days] varchar(255) NULL,
	share_id int NULL,
	share_permit_movements_types_id int NULL,
	user_id int NULL,
	created_at datetime NULL,
	updated_at datetime NULL,
	PRIMARY KEY (id)
)

ALTER TABLE share_permit_movements ADD status INT NULL;
ALTER TABLE share_permit_movements ADD date_cancelled date NULL;
ALTER TABLE share_permit_movements ADD userid_cancelled INT NULL;