Create database AUTO_BIRTHDAY_WHISH;
USE AUTO_BIRTHDAY_WHISH;

-- creating tables
create table clients(
	ID int auto_increment primary key,
    FULLNAME varchar(100),
    Email varchar(150),
    Password varchar(200),
    Confirm_Password varchar(200)    
);

INSERT INTO clients (FUllNAME, Email, Password, Confirm_Password) VALUES ('Admin', 'Admin@mail.com','Admin1234','Admin1234');
INSERT INTO clients (FUllNAME, Email, Password, Confirm_Password) VALUES ('User', 'User@mail.com','User1234','User1234');

select * from clients


CREATE TABLE birthdays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    date DATE NOT NULL
);

INSERT INTO birthdays (name, date) VALUES ('Sam Derek', '1999-04-03');

CREATE TABLE wish_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    relationship VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);