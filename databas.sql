CREATE TABLE messages ( userid INT NOT NULL , message TEXT NOT NULL , date DATETIME NOT NULL);

ALTER TABLE messages ADD INDEX (date);
ALTER TABLE messages ADD INDEX (userid);
ALTER TABLE messages ADD FOREIGN KEY (userid) REFERENCES users(id);