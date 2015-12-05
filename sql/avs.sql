-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2014 at 03:37 PM
-- Server version: 5.0.96-community
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Table structure for table `adv`
--

CREATE TABLE IF NOT EXISTS `adv` (
  `adv_id` bigint(20) NOT NULL auto_increment,
  `adv_group` tinyint(3) unsigned NOT NULL default '0',
  `adv_name` varchar(99) NOT NULL default '',
  `adv_text` text NOT NULL,
  `adv_views` bigint(20) NOT NULL default '0',
  `adv_click` bigint(20) NOT NULL default '0',
  `adv_addtime` bigint(20) NOT NULL default '0',
  `adv_status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`adv_id`),
  KEY `adv_group` (`adv_group`),
  KEY `adv_addtime` (`adv_addtime`),
  KEY `adv_status` (`adv_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `adv_group`
--

CREATE TABLE IF NOT EXISTS `adv_group` (
  `advgrp_id` tinyint(3) unsigned NOT NULL default '0',
  `advgrp_name` varchar(99) NOT NULL default '',
  `total_advs` bigint(20) NOT NULL default '0',
  `advgrp_rotate` enum('1','0') NOT NULL default '1',
  `advgrp_status` enum('1','0') NOT NULL default '1',
  `adv_width` tinyint(4) unsigned NOT NULL default '0',
  `adv_height` tinyint(4) unsigned NOT NULL default '0',
  KEY `advgrp_name` (`advgrp_name`),
  KEY `advgrp_rotate` (`advgrp_rotate`),
  KEY `advgrp_status` (`advgrp_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adv_group`
--

INSERT INTO `adv_group` (`advgrp_id`, `advgrp_name`, `total_advs`, `advgrp_rotate`, `advgrp_status`, `adv_width`, `adv_height`) VALUES
(1, 'index_right', 0, '1', '1', 0, 0),
(2, 'index_bottom', 0, '1', '1', 0, 0),
(3, 'videos_right', 0, '1', '1', 0, 0),
(4, 'videos_bottom', 0, '1', '1', 0, 0),
(5, 'categories_right', 0, '1', '1', 0, 0),
(6, 'categories_bottom', 0, '1', '1', 0, 0),
(7, 'community_right', 0, '1', '1', 0, 0),
(8, 'community_bottom', 0, '1', '1', 0, 0),
(9, 'blogs_lefts', 0, '1', '1', 0, 0),
(10, 'blogs_right', 0, '1', '1', 0, 0),
(11, 'blogs_bottom', 0, '1', '1', 0, 0),
(12, 'users_right', 0, '1', '1', 0, 0),
(13, 'users_bottom', 0, '1', '1', 0, 0),
(14, 'albums_right', 0, '1', '1', 0, 0),
(21, 'search_bottom', 0, '1', '1', 0, 0),
(20, 'search_right', 0, '1', '1', 0, 0),
(19, 'video_right_second', 0, '1', '1', 0, 0),
(18, 'photo_bottom', 0, '1', '1', 0, 0),
(17, 'video_bottom', 0, '1', '1', 0, 0),
(16, 'video_right', 0, '1', '1', 0, 0),
(15, 'albums_bottom', 0, '1', '1', 0, 0),
(22, 'search_photos_right', 0, '1', '1', 0, 0),
(23, 'search_photos_bottom', 0, '1', '1', 0, 0),
(24, 'search_users_right', 0, '1', '1', 0, 0),
(25, 'search_users_bottom', 0, '1', '1', 0, 0),
(26, 'games_right', 0, '1', '1', 0, 0),
(27, 'games_bottom', 0, '1', '1', 0, 0),
(28, 'game_right', 0, '1', '1', 0, 0),
(29, 'game_bottom', 0, '1', '1', 0, 0),
(30, 'game_right_second', 0, '1', '1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `adv_media`
--

CREATE TABLE IF NOT EXISTS `adv_media` (
  `adv_id` bigint(20) unsigned NOT NULL auto_increment,
  `adv_url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `duration` tinyint(3) unsigned NOT NULL default '0',
  `media` enum('jpg','swf','flv','mp4') NOT NULL default 'flv',
  `views` bigint(20) NOT NULL default '0',
  `clicks` bigint(20) NOT NULL default '0',
  `addtime` int(10) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`adv_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `adv_text`
--

CREATE TABLE IF NOT EXISTS `adv_text` (
  `adv_id` bigint(20) unsigned NOT NULL auto_increment,
  `adv_url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `views` bigint(20) NOT NULL default '0',
  `clicks` bigint(20) NOT NULL default '0',
  `addtime` int(10) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`adv_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `AID` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `tags` text NOT NULL,
  `category` tinyint(2) NOT NULL default '0',
  `total_photos` bigint(20) NOT NULL default '0',
  `total_views` bigint(20) NOT NULL default '0',
  `type` enum('public','private') NOT NULL default 'public',
  `addtime` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  `adddate` date NOT NULL default '0000-00-00',
  `rate` float NOT NULL default '0',
  `ratedby` bigint(20) NOT NULL default '0',
  `total_comments` bigint(20) NOT NULL default '0',
  `total_favorites` bigint(20) NOT NULL default '0',
  `likes` bigint(20) NOT NULL default '0',
  `dislikes` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`AID`),
  KEY `UID` (`UID`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `bans`
--

CREATE TABLE IF NOT EXISTS `bans` (
  `ban_id` bigint(20) NOT NULL auto_increment,
  `ban_ip` varchar(16) NOT NULL default '',
  `ban_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ban_id`),
  KEY `ban_ip` (`ban_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `BID` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `total_views` bigint(20) NOT NULL default '0',
  `total_comments` bigint(20) NOT NULL default '0',
  `total_links` bigint(20) NOT NULL default '0',
  `addtime` bigint(20) NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`BID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `CID` bigint(20) NOT NULL auto_increment,
  `BID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `addtime` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`CID`),
  KEY `BID` (`BID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `channel`
--

CREATE TABLE IF NOT EXISTS `channel` (
  `CHID` bigint(20) NOT NULL auto_increment,
  `name` varchar(120) NOT NULL default '',
  `total_videos` bigint(20) NOT NULL default '0',
  `total_albums` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`CHID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `confirm`
--

CREATE TABLE IF NOT EXISTS `confirm` (
  `UID` bigint(20) NOT NULL default '0',
  `code` varchar(10) NOT NULL default '',
  KEY `UID` (`UID`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `emailinfo`
--

CREATE TABLE IF NOT EXISTS `emailinfo` (
  `email_id` varchar(50) NOT NULL default '',
  `email_subject` varchar(255) NOT NULL default '',
  `email_path` varchar(255) NOT NULL default '',
  `comment` varchar(255) default NULL,
  PRIMARY KEY  (`email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emailinfo`
--

INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES
('welcome', 'Welcome to {$site_title}', 'emails/welcome.tpl', 'Register welcome email'),
('recover_password', 'Your {$site_name} Username and Password', 'emails/recover_password.tpl', 'Recovering user login password'),
('subscribe_email', '{$sender_name} has uploaded a new video', 'emails/subscribe_email.tpl', 'Video Subscription Email'),
('friend_request', '{$username} added you as a friend on {$site_name}', 'emails/friend_request.tpl', 'Friend Request'),
('invite_friends_email', '{$sender_name} has sent you a invitation!', 'emails/invite.tpl', 'Invite friends email'),
('share_video', '{$sender_name} has sent you a video!', 'emails/share_video.tpl', 'Share video email'),
('share_photo', '{$sender_name} has sent you a photo!', 'emails/share_photo.tpl', 'Share photo email'),
('share_game', '{$sender_name} has sent you a game!', 'emails/share_game.tpl', 'Share game email'),
('verify_email', '{$site_name} Confirmation Email', 'emails/verify_email.tpl', 'Email verification'),
('video_upload', 'Your video was successfuly uploaded to {$site_name}!', 'emails/video_upload.tpl', 'Video upload email'),
('video_approve', 'Your video was successfuly uploaded to {$site_name}!', 'emails/video_approve.tpl', 'Video upload email'),
('photo_approve', 'Your album was successfuly uploaded to {$site_name}!', 'emails/photo_approve.tpl', 'Album approve email'),
('photo_upload', 'Your album was successfuly uploaded to {$site_name}!', 'emails/photo_upload.tpl', 'Album upload email'),
('game_approve', 'Your game was successfuly uploaded to {$site_name}!', 'emails/game_approve.tpl', 'Game approve email'),
('game_upload', 'Your game was successfuly uploaded to {$site_name}!', 'emails/game_upload.tpl', 'Game upload email'),
('wall_comment', 'Your received wall comment!', 'emails/wall_comment.tpl', 'Wall comment email'),
('request_approved', 'Your friend request has been approved!', 'emails/request_approved.tpl', 'Friend request approve'),
('request_rejected', 'Your friend request has been approved!', 'emails/request_rejected.tpl', 'Friend request rejected'),
('video_comment', 'You received video comment from {$username}!', 'emails/video_comment.tpl', 'video comment'),
('blog_comment', 'You received blog comment from {$username}!', 'emails/blog_comment.tpl', 'blog comment'),
('game_comment', 'You received game comment from {$username}!', 'emails/game_comment.tpl', 'game comment'),
('photo_comment', 'You received photo comment from {$username}!', 'emails/photo_comment.tpl', 'photo comment'),
('player_email', 'I want to share this video with you!', 'emails/player_email.tpl', 'Player email');

-- --------------------------------------------------------

--
-- Table structure for table `encoding_avs`
--

CREATE TABLE IF NOT EXISTS `encoding_avs` (
  `video_type` varchar(10) NOT NULL default '',
  `aspect` varchar(10) NOT NULL default '',
  `encode_seq` int(11) NOT NULL default '0',
  `action` varchar(20) NOT NULL default '',
  `ovc_profile` varchar(20) NOT NULL default 'standard',
  `resize_base` varchar(10) NOT NULL default '',
  `resize_width` int(11) NOT NULL default '0',
  `resize_height` int(11) NOT NULL default '0',
  `ref_bitrate` int(11) NOT NULL default '0',
  `ref_type` varchar(10) NOT NULL default '',
  `ref_width` int(11) NOT NULL default '0',
  `ref_height` int(11) NOT NULL default '0',
  `encodepass` tinyint(1) NOT NULL default '1',
  `blackbars` tinyint(1) NOT NULL default '0',
  `audio_sampling` int(5) NOT NULL,
  `audio_bitrate` int(5) NOT NULL,
  `nameext` varchar(10) NOT NULL default '',
  `fileext` varchar(10) NOT NULL default 'flv',
  PRIMARY KEY  (`video_type`,`aspect`,`encode_seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `encoding_avs`
--

INSERT INTO `encoding_avs` (`video_type`, `aspect`, `encode_seq`, `action`, `ovc_profile`, `resize_base`, `resize_width`, `resize_height`, `ref_bitrate`, `ref_type`, `ref_width`, `ref_height`, `encodepass`, `blackbars`, `audio_sampling`, `audio_bitrate`, `nameext`, `fileext`) VALUES
('flv', 'all', 1, 'copy_only', 'standard', '', 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', 'flv'),
('normal', 'all', 1, 'encode_h263', 'standard', 'both', 853, 480, 800, 'fix', 640, 480, 1, 0, 44100, 128, '', 'flv'),
('normal', 'all', 2, 'encode_x264', 'standard', 'both', 1280, 720, 1500, 'standard', 1280, 720, 2, 0, 44100, 256, '', 'mp4'),
('normal', 'all', 3, 'encode_ipod', 'standard', 'both', 768, 432, 750, 'standard', 1280, 720, 1, 0, 44100, 128, '', 'mp4');

-- --------------------------------------------------------

--
-- Table structure for table `encoding_condition`
--

CREATE TABLE IF NOT EXISTS `encoding_condition` (
  `video_type` varchar(10) NOT NULL default '',
  `aspect` varchar(10) NOT NULL default '',
  `encode_seq` int(11) NOT NULL default '0',
  `condition_seq` int(11) NOT NULL default '0',
  `condition_type` varchar(20) NOT NULL default '',
  `condition_operator` varchar(10) NOT NULL default '',
  `condition_value` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`video_type`,`aspect`,`encode_seq`,`condition_seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `encoding_condition`
--

INSERT INTO `encoding_condition` (`video_type`, `aspect`, `encode_seq`, `condition_seq`, `condition_type`, `condition_operator`, `condition_value`) VALUES
('normal', 'all', 2, 1, 'width', 'gt', '479');

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE IF NOT EXISTS `favourite` (
  `UID` bigint(20) NOT NULL default '0',
  `VID` bigint(20) NOT NULL default '0',
  UNIQUE KEY `UID` (`UID`,`VID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `UID` bigint(20) NOT NULL default '0',
  `FID` bigint(20) NOT NULL default '0',
  `invite_date` date NOT NULL default '0000-00-00',
  `status` enum('Pending','Confirmed','Denied') NOT NULL default 'Pending',
  `message` text NOT NULL,
  KEY `UID_FID` (`UID`,`FID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `GID` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `tags` text NOT NULL,
  `category` tinyint(3) NOT NULL default '0',
  `total_plays` bigint(20) NOT NULL default '0',
  `total_comments` bigint(20) NOT NULL default '0',
  `total_favorites` bigint(20) NOT NULL default '0',
  `rate` float NOT NULL default '0',
  `ratedby` bigint(20) NOT NULL default '0',
  `type` enum('public','private') NOT NULL default 'public',
  `space` bigint(20) NOT NULL default '0',
  `playtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `be_commented` enum('yes','no') NOT NULL default 'yes',
  `be_rated` enum('yes','no') NOT NULL default 'yes',
  `addtime` bigint(20) NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  `status` enum('1','0') NOT NULL default '1',
  `likes` bigint(20) NOT NULL default '0',
  `dislikes` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`GID`),
  KEY `UID` (`UID`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `game_categories`
--

CREATE TABLE IF NOT EXISTS `game_categories` (
  `category_id` bigint(20) NOT NULL auto_increment,
  `category_name` varchar(255) NOT NULL default '',
  `total_games` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`category_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `game_comments`
--

CREATE TABLE IF NOT EXISTS `game_comments` (
  `CID` bigint(20) NOT NULL auto_increment,
  `GID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `addtime` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`CID`),
  KEY `GID` (`GID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `game_favorites`
--

CREATE TABLE IF NOT EXISTS `game_favorites` (
  `GID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  KEY `GID` (`GID`),
  KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `game_flags`
--

CREATE TABLE IF NOT EXISTS `game_flags` (
  `FID` bigint(20) NOT NULL auto_increment,
  `GID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `reason` tinyint(1) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `add_date` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`FID`),
  KEY `GID_UID` (`GID`,`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `game_rating_id`
--

CREATE TABLE IF NOT EXISTS `game_rating_id` (
  `GID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  KEY `GID` (`GID`),
  KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `game_rating_ip`
--

CREATE TABLE IF NOT EXISTS `game_rating_ip` (
  `GID` bigint(20) NOT NULL default '0',
  `ip` int(9) NOT NULL default '0',
  KEY `GID` (`GID`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `grab`
--

CREATE TABLE IF NOT EXISTS `grab` (
  `site` varchar(50) NOT NULL default '',
  `id` varchar(255) NOT NULL default '',
  KEY `site_id` (`site`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `grab_cron`
--

CREATE TABLE IF NOT EXISTS `grab_cron` (
  `grab_id` varchar(20) NOT NULL default '',
  `grab_interval` varchar(7) NOT NULL default '',
  `grab_number` tinyint(3) NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`grab_id`),
  KEY `grab_interval` (`grab_interval`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grab_cron`
--

INSERT INTO `grab_cron` (`grab_id`, `grab_interval`, `grab_number`, `status`) VALUES
('youporn', '', 1, '1'),
('pornhub', '', 1, '0'),
('wanktube', '', 1, '0'),
('snizzshare', '', 1, '0'),
('nudevibes', '', 1, '0'),
('tube8', '', 2, '0'),
('haporn', '', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE IF NOT EXISTS `guests` (
  `guest_id` bigint(20) NOT NULL auto_increment,
  `guest_ip` int(9) NOT NULL default '0',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `bandwidth` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`guest_id`),
  KEY `guest_ip` (`guest_ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `mail_id` bigint(20) NOT NULL auto_increment,
  `sender` varchar(15) NOT NULL default '',
  `receiver` varchar(15) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `inbox` enum('1','0') NOT NULL default '1',
  `outbox` enum('1','0') NOT NULL default '0',
  `send_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` enum('1','0') NOT NULL default '1',
  `readed` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`mail_id`),
  KEY `sender` (`sender`),
  KEY `receiver` (`receiver`),
  KEY `inbox` (`inbox`),
  KEY `outbox` (`outbox`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `NID` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `category` tinyint(3) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `total_views` bigint(20) NOT NULL default '0',
  `total_comments` bigint(20) NOT NULL default '0',
  `total_links` bigint(20) NOT NULL default '0',
  `addtime` bigint(20) NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`NID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `notice_categories`
--

CREATE TABLE IF NOT EXISTS `notice_categories` (
  `category_id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `total_notices` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




--
-- Table structure for table `notice_comments`
--

CREATE TABLE IF NOT EXISTS `notice_comments` (
  `CID` bigint(20) NOT NULL auto_increment,
  `NID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `addtime` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`CID`),
  KEY `NID` (`NID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `notice_images`
--

CREATE TABLE IF NOT EXISTS `notice_images` (
  `image_id` bigint(20) NOT NULL auto_increment,
  `addtime` bigint(20) NOT NULL default '0',
  `extension` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `PID` bigint(20) NOT NULL auto_increment,
  `AID` bigint(20) NOT NULL default '0',
  `caption` varchar(100) NOT NULL default '',
  `total_views` bigint(20) NOT NULL default '0',
  `total_comments` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  `rate` float NOT NULL default '0',
  `ratedby` bigint(20) NOT NULL default '0',
  `total_favorites` bigint(20) NOT NULL default '0',
  `type` enum('public','private') NOT NULL default 'public',
  `likes` bigint(20) NOT NULL default '0',
  `dislikes` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`PID`),
  KEY `AID` (`AID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `photo_comments`
--

CREATE TABLE IF NOT EXISTS `photo_comments` (
  `CID` bigint(20) NOT NULL auto_increment,
  `PID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `addtime` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`CID`),
  KEY `PID` (`PID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `photo_favorites`
--

CREATE TABLE IF NOT EXISTS `photo_favorites` (
  `PID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  KEY `PID` (`PID`),
  KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `photo_flags`
--

CREATE TABLE IF NOT EXISTS `photo_flags` (
  `FID` bigint(20) NOT NULL auto_increment,
  `PID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `reason` varchar(15) NOT NULL default '',
  `message` text NOT NULL,
  `add_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`FID`),
  KEY `PID` (`PID`),
  KEY `UID` (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `photo_rating_id`
--

CREATE TABLE IF NOT EXISTS `photo_rating_id` (
  `PID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  KEY `PID` (`PID`),
  KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `photo_rating_ip`
--

CREATE TABLE IF NOT EXISTS `photo_rating_ip` (
  `PID` bigint(20) NOT NULL default '0',
  `ip` int(9) NOT NULL default '0',
  KEY `PID` (`PID`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `profile` varchar(255) NOT NULL default '',
  `autorun` enum('true','false') NOT NULL default 'false',
  `buffertime` tinyint(2) unsigned NOT NULL default '5',
  `buttons` enum('0','1') NOT NULL default '1',
  `logo_url` varchar(255) NOT NULL default '',
  `logo_position` varchar(2) NOT NULL default 'BR',
  `logo_link` varchar(255) NOT NULL default '',
  `logo_alpha` tinyint(2) unsigned NOT NULL default '10',
  `text_adv` enum('0','1') NOT NULL default '1',
  `text_adv_type` enum('global','video','channel') NOT NULL default 'global',
  `text_adv_delay` tinyint(3) unsigned NOT NULL default '5',
  `video_adv` enum('0','1') NOT NULL default '1',
  `video_adv_type` enum('global','video','channel') NOT NULL default 'global',
  `video_adv_position` enum('b','e','be') NOT NULL default 'be',
  `skin` varchar(255) NOT NULL default 'default',
  `embed` enum('0','1') NOT NULL default '1',
  `related` enum('0','1') NOT NULL default '1',
  `related_content` enum('related','featured','commented','rated','viewed') NOT NULL default 'related',
  `share` enum('0','1') NOT NULL default '1',
  `mail` enum('0','1') NOT NULL default '1',
  `replay` enum('0','1') NOT NULL default '1',
  `mail_color` varchar(8) NOT NULL default '0x999999',
  `related_color` varchar(8) NOT NULL default '0x999999',
  `replay_color` varchar(8) NOT NULL default '0x999999',
  `embed_color` varchar(8) NOT NULL default '0x999999',
  `copy_color` varchar(8) NOT NULL default '0x999999',
  `time_color` varchar(8) NOT NULL default '0x999999',
  `share_color` varchar(8) NOT NULL default '0x999999',
  `adv_nav_color` varchar(8) NOT NULL default '0x999999',
  `adv_title_color` varchar(8) NOT NULL default '0x999999',
  `adv_body_color` varchar(8) NOT NULL default '0x999999',
  `adv_link_color` varchar(8) NOT NULL default '0x999900',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `profile` (`profile`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `profile`, `autorun`, `buffertime`, `buttons`, `logo_url`, `logo_position`, `logo_link`, `logo_alpha`, `text_adv`, `text_adv_type`, `text_adv_delay`, `video_adv`, `video_adv_type`, `video_adv_position`, `skin`, `embed`, `related`, `related_content`, `share`, `mail`, `replay`, `mail_color`, `related_color`, `replay_color`, `embed_color`, `copy_color`, `time_color`, `share_color`, `adv_nav_color`, `adv_title_color`, `adv_body_color`, `adv_link_color`, `status`) VALUES
(1, 'default', 'true', 3, '1', '', 'BR', '', 10, '1', 'global', 5, '1', 'global', 'b', 'default', '1', '1', 'related', '1', '1', '1', '0x999999', '0x999999', '0x999999', '0x999999', '0x000000', '0x999999', '0x999999', '0x999999', '0xffa200', '0xf1f1f1', '0x999999', '1');

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `UID` bigint(20) default NULL,
  `VID` bigint(20) default NULL,
  UNIQUE KEY `UID` (`UID`,`VID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
  `server_id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `video_url` varchar(255) NOT NULL default '',
  `server_ip` varchar(255) NOT NULL default '',
  `ftp_username` varchar(255) NOT NULL default '',
  `ftp_password` varchar(255) NOT NULL default '',
  `ftp_root` varchar(255) NOT NULL default '',
  `last_used` datetime NOT NULL default '0000-00-00 00:00:00',
  `current_used` enum('0','1') NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`server_id`),
  UNIQUE KEY `url` (`url`),
  KEY `last_used` (`last_used`),
  KEY `current_used` (`current_used`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `session_expires` int(10) unsigned NOT NULL default '0',
  `session_data` text collate utf8_unicode_ci,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




--
-- Table structure for table `signup`
--

CREATE TABLE IF NOT EXISTS `signup` (
  `UID` bigint(20) NOT NULL auto_increment,
  `email` varchar(80) NOT NULL default '',
  `username` varchar(80) NOT NULL default '',
  `fname` varchar(40) NOT NULL default '',
  `lname` varchar(40) NOT NULL default '',
  `bdate` date NOT NULL default '0000-00-00',
  `gender` varchar(6) NOT NULL default '',
  `relation` varchar(8) NOT NULL default '',
  `aboutme` text NOT NULL,
  `website` varchar(120) NOT NULL default '',
  `town` varchar(80) NOT NULL default '',
  `city` varchar(80) NOT NULL default '',
  `zip` varchar(30) NOT NULL default '',
  `country` varchar(80) NOT NULL default '',
  `occupation` text NOT NULL,
  `company` text NOT NULL,
  `school` text NOT NULL,
  `interest_hobby` text NOT NULL,
  `fav_movie_show` text NOT NULL,
  `fav_music` text NOT NULL,
  `fav_book` text NOT NULL,
  `friends_type` varchar(255) NOT NULL default 'All|Family|Friends',
  `video_viewed` int(10) NOT NULL default '0',
  `profile_viewed` int(10) NOT NULL default '0',
  `watched_video` int(10) NOT NULL default '0',
  `addtime` varchar(20) NOT NULL default '',
  `logintime` varchar(20) NOT NULL default '',
  `emailverified` varchar(3) NOT NULL default 'no',
  `account_status` enum('Active','Inactive') NOT NULL default 'Active',
  `vote` varchar(5) NOT NULL default '',
  `ratedby` varchar(5) NOT NULL default '0',
  `rate` float NOT NULL default '0',
  `parents_name` varchar(50) NOT NULL default '',
  `parents_email` varchar(50) NOT NULL default '',
  `friends_name` varchar(50) NOT NULL default '',
  `friends_email` varchar(50) NOT NULL default '',
  `photo` varchar(100) NOT NULL default '',
  `playlist` enum('Public','Private') NOT NULL default 'Public',
  `user_ip` varchar(16) NOT NULL default '',
  `pwd` varchar(60) NOT NULL default '',
  `interested` varchar(12) NOT NULL default '',
  `turnon` text NOT NULL,
  `turnoff` text NOT NULL,
  `total_albums` bigint(20) NOT NULL default '0',
  `total_blogs` bigint(20) NOT NULL default '0',
  `total_videos` bigint(20) NOT NULL default '0',
  `total_friends` bigint(20) NOT NULL default '0',
  `popularity` bigint(20) NOT NULL default '0',
  `total_games` bigint(20) NOT NULL default '0',
  `points` bigint(20) NOT NULL default '0',
  `premium` int(11) NOT NULL,
  `premiumexpirytime` date NOT NULL,
  `likes` bigint(20) NOT NULL default '0',
  `dislikes` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`UID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`UID`, `email`, `username`, `fname`, `lname`, `bdate`, `gender`, `relation`, `aboutme`, `website`, `town`, `city`, `zip`, `country`, `occupation`, `company`, `school`, `interest_hobby`, `fav_movie_show`, `fav_music`, `fav_book`, `friends_type`, `video_viewed`, `profile_viewed`, `watched_video`, `addtime`, `logintime`, `emailverified`, `account_status`, `vote`, `ratedby`, `rate`, `parents_name`, `parents_email`, `friends_name`, `friends_email`, `photo`, `playlist`, `user_ip`, `pwd`, `interested`, `turnon`, `turnoff`, `total_albums`, `total_blogs`, `total_videos`, `total_friends`, `popularity`, `total_games`, `points`, `premium`, `premiumexpirytime`, `likes`, `dislikes`) VALUES
(1, 'anonymous@yoursite.com', 'anonymous', '', '', '0000-00-00', 'Male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'All|Family|Friends', 297, 37, 0, '1228326055', '1228326055', 'no', 'Active', '', '1', '100', '', '', '', '', '', 'Public', '', '$2a$08$/gSIczQwLZElwKTKZBVhCObjlFjEDi1bSsw4TIqkmzU.AGoHaO5r.', '', '', '', 5, 0, 11, 0, -2, 2, 30, 0, '0000-00-00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `spam`
--

CREATE TABLE IF NOT EXISTS `spam` (
  `spam_id` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `type` enum('video','photo','wall','notice','blog','game') NOT NULL default 'video',
  `parent_id` bigint(20) NOT NULL default '0',
  `comment_id` bigint(20) NOT NULL default '0',
  `addtime` bigint(20) NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`spam_id`),
  KEY `type` (`type`),
  KEY `parent_id` (`parent_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `users_blocks`
--

CREATE TABLE IF NOT EXISTS `users_blocks` (
  `UID` bigint(20) NOT NULL default '0',
  `BID` bigint(20) NOT NULL default '0',
  KEY `UID` (`UID`),
  KEY `BID` (`BID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_blocks`
--

INSERT INTO `users_blocks` (`UID`, `BID`) VALUES
(2, 11),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users_flags`
--

CREATE TABLE IF NOT EXISTS `users_flags` (
  `flag_id` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `RID` bigint(20) NOT NULL default '0',
  `reason` enum('offensive','underage','spammer','other') NOT NULL default 'offensive',
  `message` varchar(100) NOT NULL default '',
  `addtime` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`flag_id`),
  KEY `UID` (`UID`),
  KEY `RID` (`RID`),
  KEY `reason` (`reason`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `users_online`
--

CREATE TABLE IF NOT EXISTS `users_online` (
  `UID` bigint(20) NOT NULL default '0',
  `online` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`UID`),
  KEY `online` (`online`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `users_prefs`
--

CREATE TABLE IF NOT EXISTS `users_prefs` (
  `UID` bigint(20) NOT NULL default '0',
  `show_playlist` enum('0','1','2') NOT NULL default '2',
  `show_favorites` enum('0','1','2') NOT NULL default '2',
  `show_friends` enum('0','1','2') NOT NULL default '2',
  `show_subscriptions` enum('0','1','2') NOT NULL default '2',
  `show_subscribers` enum('0','1','2') NOT NULL default '2',
  `friends_requests` enum('0','1') NOT NULL default '0',
  `wall_public` enum('0','1') NOT NULL default '1',
  `video_approve` enum('0','1') NOT NULL default '1',
  `album_approve` enum('0','1') NOT NULL default '1',
  `video_subscribe` enum('0','1') NOT NULL default '1',
  `friend_request` enum('0','1') NOT NULL default '1',
  `wall_write` enum('0','1') NOT NULL default '1',
  `video_comment` enum('0','1') NOT NULL default '1',
  `photo_comment` enum('0','1') NOT NULL default '1',
  `blog_comment` enum('0','1') NOT NULL default '1',
  `send_message` enum('0','1') NOT NULL default '1',
  `game_comment` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_prefs`
--

INSERT INTO `users_prefs` (`UID`, `show_playlist`, `show_favorites`, `show_friends`, `show_subscriptions`, `show_subscribers`, `friends_requests`, `wall_public`, `video_approve`, `album_approve`, `video_subscribe`, `friend_request`, `wall_write`, `video_comment`, `photo_comment`, `blog_comment`, `send_message`, `game_comment`) VALUES
(1, '2', '2', '2', '2', '2', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_rating_id`
--

CREATE TABLE IF NOT EXISTS `users_rating_id` (
  `UID` bigint(20) NOT NULL default '0',
  `RID` bigint(20) NOT NULL default '0',
  KEY `UID` (`UID`),
  KEY `RID` (`RID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_rating_ip`
--

CREATE TABLE IF NOT EXISTS `users_rating_ip` (
  `UID` bigint(20) NOT NULL default '0',
  `ip` int(9) NOT NULL default '0',
  KEY `UID` (`UID`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `VID` bigint(20) NOT NULL auto_increment,
  `UID` bigint(20) NOT NULL default '0',
  `title` varchar(120) NOT NULL default '',
  `description` text NOT NULL,
  `featuredesc` text NOT NULL,
  `keyword` text NOT NULL,
  `channel` varchar(255) NOT NULL default '0|',
  `vdoname` varchar(40) NOT NULL default '',
  `flvdoname` varchar(40) default NULL,
  `duration` float NOT NULL default '0',
  `space` bigint(20) NOT NULL default '0',
  `type` varchar(7) NOT NULL default '',
  `addtime` varchar(20) default NULL,
  `adddate` date NOT NULL default '0000-00-00',
  `record_date` date NOT NULL default '0000-00-00',
  `location` text NOT NULL,
  `country` varchar(120) NOT NULL default '',
  `vkey` varchar(20) NOT NULL default '',
  `viewnumber` bigint(10) NOT NULL default '0',
  `viewtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `com_num` int(8) NOT NULL default '0',
  `fav_num` int(8) NOT NULL default '0',
  `download_num` bigint(20) NOT NULL default '0',
  `featured` varchar(3) NOT NULL default 'no',
  `ratedby` bigint(10) NOT NULL default '0',
  `rate` float NOT NULL default '0',
  `filehome` varchar(120) NOT NULL default '',
  `be_comment` varchar(3) NOT NULL default 'yes',
  `be_rated` varchar(3) NOT NULL default 'yes',
  `embed` varchar(8) NOT NULL default 'enabled',
  `embed_code` text NOT NULL,
  `thumb` tinyint(1) unsigned NOT NULL default '1',
  `thumbs` tinyint(2) unsigned NOT NULL default '20',
  `voter_id` varchar(200) NOT NULL default '',
  `server` varchar(255) NOT NULL default '',
  `active` char(1) NOT NULL default '',
  `hd_filename` varchar(20) NOT NULL default '',
  `ipod_filename` varchar(20) NOT NULL default '',
  `aspect_hd` varchar(10) NOT NULL default '0',
  `width_hd` int(4) NOT NULL default '0',
  `height_hd` int(4) NOT NULL default '0',
  `aspect_sd` varchar(10) NOT NULL default '0',
  `width_sd` int(4) NOT NULL default '0',
  `height_sd` int(4) NOT NULL default '0',
  `iphone` int(1) NOT NULL default '0',
  `hd` int(1) NOT NULL default '0',
  `likes` bigint(20) NOT NULL default '0',
  `dislikes` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`VID`),
  UNIQUE KEY `vkey` (`vkey`),
  KEY `viewnumber` (`viewnumber`),
  KEY `rate` (`rate`),
  KEY `fav_num` (`fav_num`),
  KEY `active` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `video_comments`
--

CREATE TABLE IF NOT EXISTS `video_comments` (
  `CID` bigint(20) NOT NULL auto_increment,
  `VID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `addtime` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`CID`),
  KEY `VID` (`VID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `video_flags`
--

CREATE TABLE IF NOT EXISTS `video_flags` (
  `FID` bigint(20) NOT NULL auto_increment,
  `VID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `reason` varchar(15) NOT NULL default '',
  `message` text NOT NULL,
  `add_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`FID`),
  KEY `VID` (`VID`),
  KEY `UID` (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `video_subscribe`
--

CREATE TABLE IF NOT EXISTS `video_subscribe` (
  `UID` bigint(20) NOT NULL default '0',
  `SUID` bigint(20) NOT NULL default '0',
  `subscribe_date` date NOT NULL default '0000-00-00',
  KEY `USUID` (`UID`,`SUID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `video_vote_ip`
--

CREATE TABLE IF NOT EXISTS `video_vote_ip` (
  `VID` bigint(20) NOT NULL default '0',
  `ip` int(9) NOT NULL default '0',
  UNIQUE KEY `vid_ip` (`VID`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




--
-- Table structure for table `video_vote_users`
--

CREATE TABLE IF NOT EXISTS `video_vote_users` (
  `VID` bigint(20) NOT NULL default '0',
  `UID` int(9) NOT NULL default '0',
  KEY `vid_uid` (`VID`,`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `wall`
--

CREATE TABLE IF NOT EXISTS `wall` (
  `wall_id` bigint(20) NOT NULL auto_increment,
  `OID` bigint(20) NOT NULL default '0',
  `UID` bigint(20) NOT NULL default '0',
  `message` text NOT NULL,
  `addtime` bigint(20) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`wall_id`),
  KEY `OID` (`OID`),
  KEY `UID` (`UID`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
