-- (A1) USERS
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_name` (`user_name`);

ALTER TABLE `users` CHANGE `user_id` `user_id` INT(11) NOT NULL AUTO_INCREMENT;

-- (A2) DUMMY USERS
INSERT INTO `users` (`user_id`, `user_name`) VALUES
(1, 'John Doe'),
(2, 'Jane Doe'),
(3, 'Josh Doe'),
(4, 'Joy Doe');

-- (B1) RELATIONS
CREATE TABLE `relation` (
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `status` varchar(1) NOT NULL,
  `since` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `relation`
  ADD PRIMARY KEY (`from`,`to`,`status`),
  ADD KEY `since` (`since`);

-- (B2) DUMMY RELATIONSHIPS
INSERT INTO `relation` (`from`, `to`, `status`) VALUES

-- (P) ADD FRIEND
-- JOHN SENDS A FRIEND REQUEST TO JANE
(1, 2, 'P'),
-- JOY SENDS A FRIEND REQUEST TO JOHN
(4, 1, 'P'),

-- (F) FRIENDS
-- JANE & JOSH ARE FRIENDS
(2, 3, 'F'),
(3, 2, 'F'),
-- JANE & JOY ARE FRIENDS
(2, 4, 'F'),
(4, 2, 'F'),

-- (B) BLOCK
-- JANE FINDS JOSH ANNOYING & BLOCKS HIM
(2, 3, 'B');