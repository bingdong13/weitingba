-- MySQL dump 10.13  Distrib 5.1.60, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: weitingba
-- ------------------------------------------------------
-- Server version	5.1.60-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backdrop`
--

DROP TABLE IF EXISTS `backdrop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backdrop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '....',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '..URL',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '....',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='..';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backdrop`
--

LOCK TABLES `backdrop` WRITE;
/*!40000 ALTER TABLE `backdrop` DISABLE KEYS */;
INSERT INTO `backdrop` VALUES (1,1,'20140417104339.jpg','2014-04-17 02:43:43'),(2,2,'20140417104958.jpg','2014-04-17 02:50:05'),(3,1,'201404191133327976.jpg','2014-04-19 03:33:37'),(4,1,'201404191600177521.jpeg','2014-04-19 08:09:38');
/*!40000 ALTER TABLE `backdrop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billboard`
--

DROP TABLE IF EXISTS `billboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billboard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '...',
  `link_url` varchar(155) NOT NULL DEFAULT '' COMMENT '..',
  `sign` varchar(100) NOT NULL DEFAULT '' COMMENT '..',
  `content` varchar(450) DEFAULT NULL COMMENT '..',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '....',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='...';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billboard`
--

LOCK TABLES `billboard` WRITE;
/*!40000 ALTER TABLE `billboard` DISABLE KEYS */;
INSERT INTO `billboard` VALUES (1,'20140417132318.jpeg','','bigo','很多时候都是我们自己挖了个坑，然后义无反顾的跳进去。坑是最近挖的跳也是自己跳的，最后爬不出来的还是自己。','2014-04-17 05:23:20'),(2,'20140417135004.jpeg','http://www.lvmaohai.cn/','bigo','很多时候都是我们自己挖了个坑，然后义无反顾的跳进去。坑是最近挖的跳也是自己跳的，最后爬不出来的还是自己。很多时候都是我们自己挖了个坑，然后义无反顾的跳进去。然后义无反顾的跳进去。然后义无反顾的跳进去。','2014-04-18 02:03:05');
/*!40000 ALTER TABLE `billboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `numbers` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '条目数',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `channel_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属频道',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='类别';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'人生','人生,生存,追求','人生，就是人们渴求幸福和享受幸福的过程。','20140413151830.jpeg',1,2,'2014-04-13 07:19:03',1),(2,'情感','爱情,情感,心情,感情','理智要比心灵为高，思想要比感情可靠。','20140413152046.jpeg',2,0,'2014-04-13 07:20:54',1),(3,'心灵','治愈,心灵,温暖,孤独','心灵，是以一种气场的形式存在。','20140413152127.jpeg',3,0,'2014-04-16 14:58:01',1),(4,'麦兜兜','麦兜,死蠢','麦兜是单纯乐观、资质平平的小猪，俗称“死蠢”。','20140413152158.jpeg',4,0,'2014-04-13 07:35:18',1),(5,'冷笑话','冷笑话,无厘头','冷笑话通常没有讽刺意味，只是一些比较无厘头，晦涩的笑话。','20140413152344.jpeg',5,0,'2014-04-13 07:23:57',1),(6,'社会热点','社会,热点','','20140413152436.jpeg',1,2,'2014-04-13 07:25:04',3),(7,'音乐','音乐','音乐','20140417141720.jpeg',1,2,'2014-04-17 06:17:26',4),(8,'笔记类','笔记类','笔记类笔记类笔记类笔记类笔记类笔记类笔记类笔记类笔记类笔记类霏霏林ww','20140418082220.jpeg',1,1,'2014-04-18 00:41:08',2);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm`
--

DROP TABLE IF EXISTS `fm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '..',
  `anchor` varchar(100) NOT NULL DEFAULT '' COMMENT '../..',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT '...',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '..',
  `comeform` varchar(90) NOT NULL DEFAULT '' COMMENT '..',
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '...',
  `content` text COMMENT '..',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '....',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '....',
  `access_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '....',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '...0 ...1 ..',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '....',
  `voice` varchar(255) NOT NULL DEFAULT '' COMMENT '..url',
  `bg_url` varchar(255) NOT NULL DEFAULT '' COMMENT '背景图',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='fm';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm`
--

LOCK TABLES `fm` WRITE;
/*!40000 ALTER TABLE `fm` DISABLE KEYS */;
INSERT INTO `fm` VALUES (1,'等以后','懿一','','理智冷静客观的成年人，总是对以后有诸多计划，以为自己对未来有充分掌控力。却忘记了人只能活在当下，能掌控的也只有当下而已。','','20140417142353.jpeg','<p>印象中，我家常有啼笑皆非的对话。</p><p>比如，中午吃饭的时候，我爸会突然在饭桌上问：今天上学想爸爸了吗？我说想了。他说骗人。我就会落实到细节处：是真的！上数学课，老师讲到第三道例题的时候，我想爸爸了。</p><p>然后，我爸满意了。我妈就在旁边说：不好好上课，干嘛瞎想？</p><p>但我最怕我爸问一个问题，每问一次，我就不耐烦，很想翻脸。他问：等以后，等爸爸老了，你会嫌弃我，会照顾我吗？</p><p>我说不会，他又说骗人。我就不知道怎么回答</p><p>第一个问题是现在时，幼稚情感类型；第二个问题是将来时，深刻哲学命题。而它直接面对了幼儿无法解决的问题：1，爸爸妈妈会老；2，以后是什么？以后在哪里？以后会怎样？好迷茫。</p><p>父母孩子之间，有各种不同版本类似的问题，无限个以后，无限个不放心：等以后你长大了，等以后你上了大学，等以后你找到好工作，等以后你有了男朋友，等以后你结了婚，等以后你生了孩子... ...</p><p>再往后，发现情侣夫妻之间，也有类似问题，无限个以后，无限个不满意：等换了大房子，等换了好车子，等换了好工作，等挣了大钱，等有了孩子，等孩子长大，等孩子上大学... ...</p><p>各种各样关于以后的愿景和打算，此消彼长，此起彼伏，无限循环。像无数个美妙泡泡一般，重叠悬浮在我们四周。顺着透明泡泡看去，未来无限宽广，无限美好。却没想到泡泡漂浮不定，时近时远，一戳就泡。</p><p>小时候我有个抽屉，里面放着我精心积攒的“垃圾”。包糖果的彩色透明纸、打开有会唱歌的生日卡、断了一条胳膊的芭比娃娃、有香味的信纸、扎头发的丝带、路边摊廉价的项链... ...</p><p>时间长了，我玩得不亦乐乎，抽屉被塞得乱七八糟密不透风。</p><p>在我考试不及格的某一天，爸妈勒令我清理抽屉，扔掉了我一大半藏品。我难过极了，没吃晚饭。一边哭一边恨恨地在日记本上写：等以后，等以后我长大了，我一定要把它们找回来，一定要拥有比这些多千倍万倍的东西。</p><p>终于，现在就是当年我眼中的以后了。我喜欢的东西和八岁时完全不同。我给自己买过簇新的芭比娃娃，买完就送人了... ...</p><p>哪有那么多以后呢？在时间无涯的荒野里，永远不知道时间会在哪一刻停止，甚至不知道明天和意外到底哪一个先来。</p><p>把每一天当作最后一天来过，常被人用来提醒要珍惜现在。</p><p>每一次相遇都是为了以后说再见，常被人用来提醒要珍惜眼前人。</p><p>可是，我们还是会为未知的恐惧和贪婪忽略掉今天；也会为一时的赌气伤害身边人摔门而去... ...</p><p>人生看似很长，但，生命无常。甚至，也怨不得无常。如果不是因为那些无常，你不会遇到看似永没有交集的爱人，不会相交看似在不同圈子里的朋友。只是，这些无常，这些看似的以后，看似的“来日方长”，常常会留给我们太多“来不及”。</p><p>对于父母，为什么总想着以后对他们好，以后陪他们玩呢？为什么不是现在就多给他们打电话，多回家，多带他们出去旅行。</p><p>对于伴侣，为什么总想着以后挣大钱了再让他们享福，为什么不是现在就多陪她，给她做好吃的，哄她开心呢？</p><p>对于孩子，为什么总想着等以后他如何如何才能放心，为什么现在就不能放手呢？</p><p>歌里是这么唱的：你是否能明白，一万个美丽的未来，比不上一个温暖，温暖的现在；你是否能明白，一万个真实的现在，就是你曾经幻想，幻想的未来。</p><p>我知道，理智冷静客观的成年人，总是对以后有诸多计划，以为自己对未来有充分掌控力。却忘记了人只能活在当下，能掌控的也只有当下而已。对未来做再多计划，都不如在现有的条件下，尽力把生活过好。</p><p>我和老公刚结婚的时候，进行过如下探讨。</p><p>他：你为什么总想着出去玩？我的过往人生中，无所事事度假的时间几乎没有，工作比玩重要太多... ...每天晒太阳看风景，难道不是等以后挣够了钱，退休以后的事情？</p><p>我只用一句话就说服了他：现在在海边穿比基尼拍照，和等以后五十岁在海边穿比基尼拍照，有质的区别。</p>','2014-04-18 03:22:38','2014-04-19 01:03:57',54,0,7,'http://cdn.lizhi.fm/audio/2014/04/15/10893993695565574_hd.mp3','20140418003642.jpg'),(2,'人生怎可能永如初见','小蕾','','再没有比我更会体贴你的女人来分割我们的爱情.那时我还会回到你的身边，告诉你，只有我最爱你，只有我最爱你脸上苍老的皱纹。','佚名','20140418112659.jpg','<p>人生怎可能永如初见</p><p><span style=\"line-height: 1.5;\">再没有比我更会体贴你的女人来分割我们的爱情.那时我还会回到你的身边，告诉你，只有我最爱你，只有我最爱你脸上苍老的皱纹...看到这句话。我忽然有些心疼。</span><br/></p><p><span style=\"line-height: 1.5;\">姚晨和老凌离婚了，所有的人都在惋惜、失落与觉得不可思议，因为这一对夫妻的爱情承载了我们太多人的向往。毕业就结婚的大学同学，七年的相互鼓励相互扶持，每次看姚晨在围脖上写她和老凌的小幸福心里都觉得很温暖，也希望自己未来能够遇见那样的一个人，无论富贵还是贫穷，不离不弃白头偕老，可是。</span><br/></p><p><span style=\"line-height: 1.5;\">真的没有爱情童话吗，永恒的真爱果真像鬼一样所有人都听说过却没什么人真正见过吗。</span><br/></p><p><span style=\"line-height: 1.5;\">连静秋的原型，后来去了美国的那个山楂树女孩，都在访谈中说过每次她的丈夫对不起她让她伤心失望的时候她都会想如果那时老三没有死如果她和老三最终在一起，老三也应该不会永远那样爱她那样对她好一辈子。</span><br/></p><p><span style=\"line-height: 1.5;\">人生怎可能永如初见，除非故事根本不开始，既然享受了故事的美好过程，就必须接受最终潦草的结局。</span><br/></p><p><span style=\"line-height: 1.5;\">“永远”这个词语，你还相信吗。</span><br/></p><p><span style=\"line-height: 1.5;\">翻看着姚晨曾经发的围脖，</span><br/></p><p><span style=\"line-height: 1.5;\">“匆匆走进小区院门，远远就望见家里的灯亮着，老凌的身影在里面晃来晃去，放慢了脚步，站在楼下仰头望了一会儿，希望这一副画面永远的保存在我的脑海中。”</span><br/></p><p><span style=\"line-height: 1.5;\">我们可以保存回忆，但却保存不了爱情。</span><br/></p><p><span style=\"line-height: 1.5;\">“一路格桑花，矮矮的它们像新娘的捧花，把盛夏的高原打扮得异常漂亮。藏族有一个传说：不管是谁，只要找到了八瓣格桑花，就找到了幸福。老凌曾在海拔最高的地方，为我带回过一束美丽的格桑花，我如获至宝，小心将它装进瓶中，希望这幸福之花能开得久一些，再久一些。。。”</span><br/></p><p><span style=\"line-height: 1.5;\">再美的幸福都终有凋零的一天，很多年后，你还记得你曾经愿意为他赴汤蹈火的那个人吗，他在哪里。</span><br/></p><p><span style=\"line-height: 1.5;\">“恩泰：和你合作过的男演员谁最帅？我：老凌！恩泰：除了老凌呢？我：韩国的苏志燮！恩泰：长啥样啊？我：长得特象老凌！”</span><br/></p><p><span style=\"line-height: 1.5;\">那个曾经让我们骄傲地跟别人提起，骄傲地拿他打趣，一言一语都有他的人，后来为什么再也不敢提起。</span><br/></p><p><span style=\"line-height: 1.5;\">姚晨曾经说“最适合我的那个人还是凌潇肃”，凌潇肃曾经说“那是我媳妇儿，她成功我只会高兴，我不介意她比我强。”</span><br/></p><p><span style=\"line-height: 1.5;\">曾经，现在，曾经，现在。我们的一切伤悲都来自于这样的对比，物是人非，言犹在耳，君心已变。</span><br/></p><p><span style=\"line-height: 1.5;\">姚晨今早写道“昨夜，西安大雪。晨起，一片白茫茫，午后，太阳照常升起，暖化了积雪，所有的一切又还原了本来的模样、、、”</span><br/></p><p><span style=\"line-height: 1.5;\">我们常常安慰自己，大不了只是回到原点，可是我们心里都明白，没有什么能回到原点，记忆作祟，时光荏苒，看似从孑然一身又回到孑然一身，但我们再也不是原点的那个自己。</span><br/></p><p><span style=\"line-height: 1.5;\">《海边的卡夫卡》中说“回忆会从内侧温暖你的身体，同时又从内侧剧烈切割你的身体。”回忆与现实的反差总是大到让我们不知所措。说着心疼你会永远陪你的那个人现在也会是说着不要再来烦我的人，说着你最重要的那个人现在也会是说你不比别人更特别的人，为博你一笑再辛苦也在所不惜的那个人现在也会是连接你的电话都成为恩赐的人。</span><br/></p><p><span style=\"line-height: 1.5;\">“你自以为了解一个人，当一切出乎意料时，才明白原来那个人是你幻想出来的…”（姚晨）</span><br/></p><p><span style=\"line-height: 1.5;\">“这个世界，时常浪漫美好得让人以为是在梦境；时常又残酷冰冷得让人怀疑是在做梦。反正，活着就象做梦。鬼知道，哪天能醒？”（姚晨）。</span><br/></p><p><span style=\"line-height: 1.5;\">确实如此。</span></p>','2014-04-18 03:27:20','2014-04-19 05:45:23',180,0,7,'http://image.itings.cn/wizzardaudio1/201404/fac92a8f-83a9-4d98-a119-3fa467ee54f7.mp3','20140418112841.jpg');
/*!40000 ALTER TABLE `fm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `magazine`
--

DROP TABLE IF EXISTS `magazine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `magazine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `comeform` varchar(90) NOT NULL DEFAULT '' COMMENT '来源',
  `content` text COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别',
  `access_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '....',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '...0 ....1 ..',
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='杂志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `magazine`
--

LOCK TABLES `magazine` WRITE;
/*!40000 ALTER TABLE `magazine` DISABLE KEYS */;
INSERT INTO `magazine` VALUES (1,'过自己喜欢的生活前，得有资本fff','追梦,奋斗','如果你正为自己想要的生活而努力奋斗着，那么请继续坚持。别害怕追梦过程中的孤独寂寞，因为追梦就像是一场马拉松，最终能坚持到终点的人寥寥无几。','','<p>在你打算过自己喜欢的生活前，你有资本吗？有后路可退吗？</p><p>\r\n	你羡慕别人放下一切的说走就走，你渴望摆脱工作的苦逼烦躁，你奢望过陶渊明式的田园生活，你总是在想，别人为什么能考上喜欢的大学，别人为什么能拿奖学金，别人为什么能升职。你总是别人别人的以为着，希望自己也能像别人那样。但是，你有资本吗？没有资本的话，就请在今天努力吧。因为我一直都这样认为，过自己喜欢的生活是要有物质保障的。除非你家庭很牛逼。</p><p>\r\n	很多时候，你只知道羡慕别人的优越，却不知道别人为了过自己喜欢的生活付出了太多太多的辛苦与汗水。你只知道别人的生活很有趣，却不知道别人是人前风光，人后遭罪。我知道你有很多宏伟的想法，但如果没有为之行动，都是空想，只会浪费宝贵的时间。</p><p>\r\n	我最近读苏美写的《倾我所有去生活》，她写了这样几句话，替我的迷茫有了解答。<span style=\"color:#337FE5;\">1、有床就睡，有饭就吃，余下一些力气，干点力所能及的工作，这就很让我踏实了。2、不管故事多难过，都应该有笑声。3、有些事不懂，就先放下，不急，假以时日，像是枝头的葡萄，自然会熟，落下来，尝了，就懂了。</span></p><p>\r\n	我很喜欢书名，《倾我所有去生活》。拿到书后，看了书名和简介，脑海里立马想到的就是这篇文章的标题，以及开头所写的话。其实，与其说是一篇读书札记，不如说是因为一个句子而发生的瞬间感悟，需要记下，以免忘记。</p><p>\r\n	有时候，你会和朋友爆一句粗口说，妈蛋，老子的青春十八岁后就没有了。高中时为了高考，过着机械式重复生活；大学时为了毕业找个好工作，匆匆了结无疾而终的恋爱。等真正工作了，踏入社会后，又要为结婚、买房、买车操劳。只是你想过没有，你如此的苦逼着努力是为了什么？还不是为了赚钱，为了自己爱的人有一个稳当的保障。你只要有了保障，青春随时都有。</p><p>\r\n	苏美在这本《倾我所有去生活》一书中，写的都是生活中柴米油盐酱醋茶的小事，像是一个女子的唠唠叨叨，在你耳畔说着今天买菜花了多少钱，今天某某商场打几折，今天和闺蜜遇见了什么样的极品事情。这些，看似寻常，但苏美的笔调不寻常。整本书的文字很接地气，几乎都是用口语来表达生活中发生的故事，避免了书面语的文绉绉，读起来不累。而且，每一篇故事都有各自的闪光点——即在你防不胜防时冒出一两句貌似粗鲁实际恰当的词语在文字中。</p><p>\r\n	“十五年前大学新生报到，我坐的是他的尼桑。无论如何，我都必须承认他牛逼过。可是，这又如何？他还是要去躺在手术台上，被人切得乱七八糟。”读到苏美写父亲这一段时，心中想着，我们如此奋不顾身的拼命奋斗为的是什么？为的就是让父母过好的生活。他们也尝过了苦尽甘来，只是现在的这份甘甜，兴许还不够，没有甜到让他们感到腻味。所以，我今天必须比昨天再努力一点。</p><p>\r\n	你努力奋斗最重要的理由，就是过上自己想要的生活。</p><p><span style=\"color:#337FE5;\">如果你正为自己想要的生活而努力奋斗着，那么请继续坚持。别害怕追梦过程中的孤独寂寞，因为追梦就像是一场马拉松，最终能坚持到终点的人寥寥无几。</span></p>','2014-04-13 02:45:17','2014-04-18 00:59:59',6,0,1,'20140413151600.jpeg'),(3,'过自己喜欢的生活前，得有资本','追梦,奋斗','如果你正为自己想要的生活而努力奋斗着，那么请继续坚持。别害怕追梦过程中的孤独寂寞，因为追梦就像是一场马拉松，最终能坚持到终点的人寥寥无几。','网络','<p>在你打算过自己喜欢的生活前，你有资本吗？有后路可退吗？</p><p>\r\n	你羡慕别人放下一切的说走就走，你渴望摆脱工作的苦逼烦躁，你奢望过陶渊明式的田园生活，你总是在想，别人为什么能考上喜欢的大学，别人为什么能拿奖学金，别人为什么能升职。你总是别人别人的以为着，希望自己也能像别人那样。但是，你有资本吗？没有资本的话，就请在今天努力吧。因为我一直都这样认为，过自己喜欢的生活是要有物质保障的。除非你家庭很牛逼。</p><p>\r\n	很多时候，你只知道羡慕别人的优越，却不知道别人为了过自己喜欢的生活付出了太多太多的辛苦与汗水。你只知道别人的生活很有趣，却不知道别人是人前风光，人后遭罪。我知道你有很多宏伟的想法，但如果没有为之行动，都是空想，只会浪费宝贵的时间。</p><p>\r\n	我最近读苏美写的《倾我所有去生活》，她写了这样几句话，替我的迷茫有了解答。<span style=\"color:#337FE5;\">1、有床就睡，有饭就吃，余下一些力气，干点力所能及的工作，这就很让我踏实了。2、不管故事多难过，都应该有笑声。3、有些事不懂，就先放下，不急，假以时日，像是枝头的葡萄，自然会熟，落下来，尝了，就懂了。</span></p><p>\r\n	我很喜欢书名，《倾我所有去生活》。拿到书后，看了书名和简介，脑海里立马想到的就是这篇文章的标题，以及开头所写的话。其实，与其说是一篇读书札记，不如说是因为一个句子而发生的瞬间感悟，需要记下，以免忘记。</p><p>\r\n	有时候，你会和朋友爆一句粗口说，妈蛋，老子的青春十八岁后就没有了。高中时为了高考，过着机械式重复生活；大学时为了毕业找个好工作，匆匆了结无疾而终的恋爱。等真正工作了，踏入社会后，又要为结婚、买房、买车操劳。只是你想过没有，你如此的苦逼着努力是为了什么？还不是为了赚钱，为了自己爱的人有一个稳当的保障。你只要有了保障，青春随时都有。</p><p>\r\n	苏美在这本《倾我所有去生活》一书中，写的都是生活中柴米油盐酱醋茶的小事，像是一个女子的唠唠叨叨，在你耳畔说着今天买菜花了多少钱，今天某某商场打几折，今天和闺蜜遇见了什么样的极品事情。这些，看似寻常，但苏美的笔调不寻常。整本书的文字很接地气，几乎都是用口语来表达生活中发生的故事，避免了书面语的文绉绉，读起来不累。而且，每一篇故事都有各自的闪光点——即在你防不胜防时冒出一两句貌似粗鲁实际恰当的词语在文字中。</p><p>\r\n	“十五年前大学新生报到，我坐的是他的尼桑。无论如何，我都必须承认他牛逼过。可是，这又如何？他还是要去躺在手术台上，被人切得乱七八糟。”读到苏美写父亲这一段时，心中想着，我们如此奋不顾身的拼命奋斗为的是什么？为的就是让父母过好的生活。他们也尝过了苦尽甘来，只是现在的这份甘甜，兴许还不够，没有甜到让他们感到腻味。所以，我今天必须比昨天再努力一点。</p><p>\r\n	你努力奋斗最重要的理由，就是过上自己想要的生活。</p><p><span style=\"color:#337FE5;\">如果你正为自己想要的生活而努力奋斗着，那么请继续坚持。别害怕追梦过程中的孤独寂寞，因为追梦就像是一场马拉松，最终能坚持到终点的人寥寥无几。</span></p>','2014-04-13 02:45:17','2014-04-17 14:36:11',6,0,0,'15250433601cd6620aeb58.jpg');
/*!40000 ALTER TABLE `magazine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_book`
--

DROP TABLE IF EXISTS `note_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note_book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `comeform` varchar(90) NOT NULL DEFAULT '' COMMENT '来源',
  `content` text COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别',
  `access_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '....',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '...0 ....1 ..',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='笔记本';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_book`
--

LOCK TABLES `note_book` WRITE;
/*!40000 ALTER TABLE `note_book` DISABLE KEYS */;
INSERT INTO `note_book` VALUES (1,'测试一下笔记功能','测试一下笔记功能','测试一下笔记功能','笔记功能','<p>测试一下笔记功能测试一下笔记功能测试一下笔记功能测试一下笔记功能测试一下笔记功能测试一下笔记功能</p>','2014-04-18 00:31:15','2014-04-18 00:49:53',8,6,1);
/*!40000 ALTER TABLE `note_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shared`
--

DROP TABLE IF EXISTS `shared`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shared` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(450) DEFAULT NULL COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别',
  `is_top` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='语录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shared`
--

LOCK TABLES `shared` WRITE;
/*!40000 ALTER TABLE `shared` DISABLE KEYS */;
INSERT INTO `shared` VALUES (1,'化解困难需要一段时间，等待成效需要一个过程，切勿心急，平和的心态最重要。','2014-04-12 14:03:45',1,0),(2,'很多时候都是我们自己挖了个坑，然后义无反顾的跳进去。坑是最近挖的跳也是自己跳的，最后爬不出来的还是自己。','2014-04-12 14:27:03',1,1);
/*!40000 ALTER TABLE `shared` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_account`
--

DROP TABLE IF EXISTS `user_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_account` (
  `uin` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` varchar(45) NOT NULL COMMENT '账号',
  `password` varchar(60) NOT NULL COMMENT '密码',
  `nickname` varchar(45) NOT NULL DEFAULT '' COMMENT '昵称',
  `face` varchar(45) NOT NULL DEFAULT '' COMMENT '头像',
  `gender` enum('M','F') NOT NULL DEFAULT 'M' COMMENT '性别，M为男性，F为女性',
  `birthday` date NOT NULL DEFAULT '2014-04-05' COMMENT '生日',
  `address` varchar(45) NOT NULL DEFAULT '' COMMENT '地址',
  `introduce` varchar(300) NOT NULL DEFAULT '' COMMENT '自我介绍',
  PRIMARY KEY (`uin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户账号表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_account`
--

LOCK TABLES `user_account` WRITE;
/*!40000 ALTER TABLE `user_account` DISABLE KEYS */;
INSERT INTO `user_account` VALUES (1,'bigo','$2a$08$AFfeK7LRDrkKYrGzgXhsPelUfSGbI/.vKgM7Msym2e5t8dXDCLxp6','bigo','201404191120057081.jpeg','M','2014-04-05','上海，浦东新区','不去评判，只观照自我，积极行动，尽量圆满，至于结果得失，来了便是要接受的。');
/*!40000 ALTER TABLE `user_account` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-19 16:46:46
