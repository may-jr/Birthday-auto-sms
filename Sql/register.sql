Create database AUTO_BIRTHDAY_WHISH;
USE AUTO_BIRTHDAY_WHISH;

-- creating tables
create table users(
	ID int auto_increment primary key,
    FULLNAME varchar(255),
    Email varchar(255),
    Password varchar(255),
    Confirm_Password varchar(255)    
);

INSERT INTO users (FUllNAME, Email, Password, Confirm_Password) VALUES ('Admin', 'Admin@mail.com','Admin1234','Admin1234');
INSERT INTO users (FUllNAME, Email, Password, Confirm_Password) VALUES ('User', 'User@mail.com','User1234','User1234');

select * from users
