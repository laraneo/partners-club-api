CREATE TABLE share_permit_movements_types (
	id bigint IDENTITY(1,1) NOT NULL,
	[desc] varchar(255) NULL,
	[days] varchar(255) NULL,
	[status] int NULL,
	created_at datetime NULL,
	updated_at datetime NULL,
	PRIMARY KEY (id)
)