DROP DATABASE IF EXISTS `discoverify`;

CREATE DATABASE `discoverify`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

use `discoverify`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned AUTO_INCREMENT,
  `email` varchar(50) UNIQUE NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `profile_picture` varchar(256),
  `cover_picture` varchar(256),
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_of_birth` datetime,
  `bio` varchar(256) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `lives_in` varchar(128) DEFAULT NULL,
  `works_at` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int unsigned AUTO_INCREMENT,
  `receiverId` int unsigned NOT NULL,
  `senderId` int unsigned NOT NULL,
  `content` varchar(512) NOT NULL,
  `seen` tinyint(1) DEFAULT 0,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`receiverId`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`senderId`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE `request_status` (
  id tinyint(1),
  name varchar(15),
  PRIMARY KEY (id)
);

INSERT INTO `request_status` VALUES (1, 'pending');
INSERT INTO `request_status` VALUES (2, 'accepted');
INSERT INTO `request_status` VALUES (3, 'rejected');

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `receiverId` int unsigned NOT NULL,
  `senderId` int unsigned NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `uuid_socket_secret_key` varchar(64) UNIQUE NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`receiverId`, `senderId`),
  FOREIGN KEY (`receiverId`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`senderId`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`status`) REFERENCES `request_status`(`id`)
);

DROP TABLE IF EXISTS `blocked_users`;
CREATE TABLE `blocked_users` (
  `blocked` int unsigned NOT NULL,
  `blocked_by` int unsigned NOT NULL,
  PRIMARY KEY(`blocked`, `blocked_by`),
  FOREIGN KEY (`blocked_by`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`blocked`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `page_picture` varchar(256),
  `cover_picture` varchar(256),
  `description` varchar(256),
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `page_likes`;
CREATE TABLE `page_likes` (
  `page_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  PRIMARY KEY (`page_id`, `user_id`),
  FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);


DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `content` varchar(256),
  `seen` tinyint(1) DEFAULT 0,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `page_id` int unsigned DEFAULT NULL,
  `content` varchar(1020),
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `post_videos`;
CREATE TABLE `post_videos` (
  `post_id` int unsigned NOT NULL,
  `video_url` varchar(256) NOT NULL,
  PRIMARY KEY (`post_id`, `video_url`),
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `post_photos`;
CREATE TABLE `post_photos` (
  `post_id` int unsigned NOT NULL,
  `photo_url` varchar(256) NOT NULL,
  PRIMARY KEY (`post_id`, `photo_url`),
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `post_comments`;
CREATE TABLE `post_comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `post_id` int unsigned NOT NULL,
  `content` varchar(1020),
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `post_shares`;
CREATE TABLE `post_shares` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `content` varchar(1020),
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `reactions`;
CREATE TABLE `reactions` (
  `id` tinyint(1),
  `name` varchar(5),
  `value` varchar(8),
  PRIMARY KEY (`id`)
);

INSERT INTO `reactions` VALUES (1, 'like', '👍');
INSERT INTO `reactions` VALUES (2, 'love', '❤️');
INSERT INTO `reactions` VALUES (3, 'haha', '😂');
INSERT INTO `reactions` VALUES (4, 'wow', '😯');
INSERT INTO `reactions` VALUES (5, 'sad', '😢');
INSERT INTO `reactions` VALUES (6, 'angry', '😡');


DROP TABLE IF EXISTS `post_reacts`;
CREATE TABLE `post_reacts` (
  `user_id` int unsigned NOT NULL,
  `post_id` int unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`, `post_id`),
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`type`) REFERENCES `reactions`(`id`)
);

DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `reporter_id` int unsigned NOT NULL,
  `reported_id` int unsigned NOT NULL,
  `type` ENUM('user', 'page', 'post'),
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(512),
  `resolved` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`reporter_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `email_services`;
CREATE TABLE `email_services` (
  `id` int unsigned AUTO_INCREMENT,
  `enabled_chat_notifications` tinyint(1) DEFAULT 1,
  `enabled_friends_notifications` tinyint(1) DEFAULT 1,
  `enabled_posts_notifications` tinyint(1) DEFAULT 1,
  `enabled_pages_notifications` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);