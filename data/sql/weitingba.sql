DROP DATABASE `weitingba`;
CREATE DATABASE IF NOT EXISTS `weitingba` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE weitingba;

-- -----------------------------------------------------
-- Table `user_account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_account` (
  `uin` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID' ,
  `account` VARCHAR(45) NOT NULL COMMENT '账号' ,
  `password` VARCHAR(60) NOT NULL COMMENT '密码' ,
  `nickname` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '昵称' ,
  `face` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '头像' ,
  `gender` ENUM('M','F') NOT NULL DEFAULT 'M' COMMENT '性别，M为男性，F为女性' ,
  `birthday` DATE NOT NULL DEFAULT '2014-04-05' COMMENT '生日' ,
  `address` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '地址' ,
  `introduce` VARCHAR(300) NOT NULL DEFAULT '' COMMENT '自我介绍' ,
  PRIMARY KEY (`uin`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账号表';

-- -----------------------------------------------------
-- Data for table `user_account`
-- -----------------------------------------------------
INSERT INTO `user_account` (`uin`, `account`, `password`) VALUES (1, 'bigo', '$2a$08$YmkMxoiVjLLYit05aI3EUuzpdYbINaRTrvAUlAJavLsWh1MXa2tFO');

-- -----------------------------------------------------
-- Table `category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `category` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '标题' ,
  `keywords` VARCHAR(150) NOT NULL DEFAULT '' COMMENT '关键字' ,
  `description` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '简介' ,
  `face_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '缩略图' ,
  `sort` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序' ,
  `numbers` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '条目数' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间' ,
  `channel_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属频道' ,
  PRIMARY KEY (`id`),
  INDEX `sort` (`sort` ASC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='类别';

-- -----------------------------------------------------
-- Table `note_book`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `note_book` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '标题' ,
  `keywords` VARCHAR(150) NOT NULL DEFAULT '' COMMENT '关键字' ,
  `description` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '简介' ,
  `comeform` VARCHAR(90) NOT NULL DEFAULT '' COMMENT '来源' ,
  `content` TEXT COMMENT '内容' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间' ,
  `update_time` TIMESTAMP COMMENT '更新时间' ,
  `access_times` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读次数' ,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态，0 不公开，1 公开' ,
  `category_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属类别' ,
  PRIMARY KEY (`id`) ,
  INDEX `categoryId` (`category_id` ASC),
  INDEX `status` (`status` DESC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='笔记本';

-- -----------------------------------------------------
-- Table `magazine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `magazine` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '标题' ,
  `keywords` VARCHAR(150) NOT NULL DEFAULT '' COMMENT '关键字' ,
  `description` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '简介' ,
  `comeform` VARCHAR(90) NOT NULL DEFAULT '' COMMENT '来源' ,
  `face_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '缩略图' ,
  `content` TEXT COMMENT '内容' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间' ,
  `update_time` TIMESTAMP COMMENT '更新时间' ,
  `access_times` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读次数' ,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态，0 不公开，1 公开' ,
  `category_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属类别' ,
  PRIMARY KEY (`id`) ,
  INDEX `categoryId` (`category_id` ASC),
  INDEX `status` (`status` DESC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='杂志';

-- -----------------------------------------------------
-- Table `shared`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shared` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `content` VARCHAR(450) NULL COMMENT '内容' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间' ,
  `category_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属类别' ,
  `is_top` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否推荐' ,
  PRIMARY KEY (`id`),
  INDEX `categoryId` (`category_id` ASC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='语录';

-- -----------------------------------------------------
-- Table `fm`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fm` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '标题' ,
  `keywords` VARCHAR(150) NOT NULL DEFAULT '' COMMENT '关键字' ,
  `description` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '简介' ,
  `comeform` VARCHAR(90) NOT NULL DEFAULT '' COMMENT '来源' ,
  `content` TEXT COMMENT '内容' ,
  `face_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '缩略图' ,
  `bg_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '背景图' ,
  `anchor` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '主播/歌手' ,
  `voice` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '音频url' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间' ,
  `update_time` TIMESTAMP COMMENT '更新时间' ,
  `access_times` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '播放次数' ,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态，0 开播，1 停播' ,
  `category_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属类别' ,
  PRIMARY KEY (`id`) ,
  INDEX `categoryId` (`category_id` ASC),
  INDEX `status` (`status` ASC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='fm';

-- -----------------------------------------------------
-- Table `billboard`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `billboard` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `face_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '缩略图' ,
  `link_url` VARCHAR(155) NOT NULL DEFAULT '' COMMENT '外链' ,
  `sign` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '签名' ,
  `content` VARCHAR(450) NULL COMMENT '内容' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间' ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='布告板';

-- -----------------------------------------------------
-- Table `backdrop`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `backdrop` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `site` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属位置' ,
  `url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '图片URL' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间' ,
  PRIMARY KEY (`id`),
  INDEX `site` (`site` ASC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='布景';

-- -----------------------------------------------------
-- Table `tour`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tour` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '标题' ,
  `keywords` VARCHAR(150) NOT NULL DEFAULT '' COMMENT '关键字' ,
  `description` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '简介' ,
  `comeform` VARCHAR(90) NOT NULL DEFAULT '' COMMENT '来源' ,
  `face_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '缩略图' ,
  `bg_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '背景图' ,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间' ,
  `update_time` TIMESTAMP COMMENT '更新时间' ,
  `access_times` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读次数' ,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态，0 不公开，1 公开' ,
  `sort` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序' ,
  PRIMARY KEY (`id`),
  INDEX `status` (`status` DESC),
  INDEX `sort` (`sort` ASC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='旅游主题';

-- -----------------------------------------------------
-- Table `tour_photo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tour_photo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tour_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属旅游主题' ,
  `url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '图片URL' ,
  `description` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '简介',
  `sort` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序' ,
  PRIMARY KEY (`id`),
  INDEX `tour_id` (`tour_id` ASC),
  INDEX `sort` (`sort` ASC)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='旅游相册';