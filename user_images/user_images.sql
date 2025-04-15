alter table JJ_reg_users
	add index (emailAddr);
	
CREATE TABLE `JJ_user_images` (
  email varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  fileName varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  fileType varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (email, fileName),
  foreign key (email) references JJ_reg_users(emailAddr)
) DEFAULT CHARSET=utf8mb4;

ALTER TABLE JJ_reg_users
ADD folder varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;