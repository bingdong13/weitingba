-- MySQL dump 10.13  Distrib 5.1.60, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: weitingba_dev
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
  `site` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属位置',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片URL',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  PRIMARY KEY (`id`),
  KEY `site` (`site`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='布景';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backdrop`
--

LOCK TABLES `backdrop` WRITE;
/*!40000 ALTER TABLE `backdrop` DISABLE KEYS */;
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
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `link_url` varchar(155) NOT NULL DEFAULT '' COMMENT '外链',
  `sign` varchar(100) NOT NULL DEFAULT '' COMMENT '签名',
  `content` varchar(450) DEFAULT NULL COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='布告板';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billboard`
--

LOCK TABLES `billboard` WRITE;
/*!40000 ALTER TABLE `billboard` DISABLE KEYS */;
INSERT INTO `billboard` VALUES (1,'201404202217494986.jpg','','bigo，上海','世上并没有那么多冷漠无情的人，多的只是不擅表达的人。谁都希望遇到一个人，能读懂自己冷漠下的热情、微笑中的忧伤。奈何再近的两颗心，也难免有误读，那些言不由衷，常常被误以为真。人们总固执的认为，最好的沟通是不说也懂。很多人就是这样彼此错过。','2014-04-20 14:17:54');
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
INSERT INTO `category` VALUES (1,'人生','人生,生存,追求','人生，就是人们渴求幸福和享受幸福的过程。','201404202040569741.jpeg',1,3,'2014-04-20 12:40:59',1),(2,'情感','爱情,情感,心情,感情','理智要比心灵为高，思想要比感情可靠。','201404202044252453.jpeg',2,1,'2014-04-20 12:44:37',1),(3,'心灵','治愈,心灵,温暖,孤独','心灵，是以一种气场的形式存在。','201404202045294115.jpeg',3,1,'2014-04-20 12:45:32',1),(4,'麦兜兜','麦兜,死蠢','麦兜是单纯乐观、资质平平的小猪，俗称“死蠢”。','201404202048012603.jpeg',4,0,'2014-04-20 12:48:04',1),(5,'冷笑话','冷笑话,无厘头','冷笑话通常没有讽刺意味，只是一些比较无厘头，晦涩的笑话。','201404202048554588.jpeg',5,1,'2014-04-20 12:48:56',1),(6,'杂谈','杂谈','想到什么，就写点；写着写着，就成长了。','201404202054169079.jpeg',1,2,'2014-04-20 12:54:20',2),(7,'社会热点','社会,热点,奇谈','大千世界，无奇不有；在屌丝的时代，每天都是那么鲜艳。','201404202059024709.jpeg',1,1,'2014-04-20 12:59:04',3),(8,'有声读物','广播剧,声音,书','有声音的书，也称广播剧。','201404202103176457.jpeg',1,2,'2014-04-20 13:03:39',4);
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
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `comeform` varchar(90) NOT NULL DEFAULT '' COMMENT '来源',
  `content` text COMMENT '内容',
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `bg_url` varchar(255) NOT NULL DEFAULT '' COMMENT '背景图',
  `anchor` varchar(100) NOT NULL DEFAULT '' COMMENT '主播/歌手',
  `voice` varchar(255) NOT NULL DEFAULT '' COMMENT '音频url',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `access_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '播放次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0 开播，1 停播',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`category_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='fm';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm`
--

LOCK TABLES `fm` WRITE;
/*!40000 ALTER TABLE `fm` DISABLE KEYS */;
INSERT INTO `fm` VALUES (1,'等以后','等以后,计划,活在当下','理智冷静客观的成年人，总是对以后有诸多计划，以为自己对未来有充分掌控力。却忘记了人只能活在当下，能掌控的也只有当下而已。','赵款款','<p>印象中，我家常有啼笑皆非的对话。</p><p>比如，中午吃饭的时候，我爸会突然在饭桌上问：今天上学想爸爸了吗？我说想了。他说骗人。我就会落实到细节处：是真的！上数学课，老师讲到第三道例题的时候，我想爸爸了。</p><p>然后，我爸满意了。我妈就在旁边说：不好好上课，干嘛瞎想？</p><p>但我最怕我爸问一个问题，每问一次，我就不耐烦，很想翻脸。他问：等以后，等爸爸老了，你会嫌弃我，会照顾我吗？</p><p>我说不会，他又说骗人。我就不知道怎么回答</p><p>第一个问题是现在时，幼稚情感类型；第二个问题是将来时，深刻哲学命题。而它直接面对了幼儿无法解决的问题：1，爸爸妈妈会老；2，以后是什么？以后在哪里？以后会怎样？好迷茫。</p><p>父母孩子之间，有各种不同版本类似的问题，无限个以后，无限个不放心：等以后你长大了，等以后你上了大学，等以后你找到好工作，等以后你有了男朋友，等以后你结了婚，等以后你生了孩子... ...</p><p>再往后，发现情侣夫妻之间，也有类似问题，无限个以后，无限个不满意：等换了大房子，等换了好车子，等换了好工作，等挣了大钱，等有了孩子，等孩子长大，等孩子上大学... ...</p><p>各种各样关于以后的愿景和打算，此消彼长，此起彼伏，无限循环。像无数个美妙泡泡一般，重叠悬浮在我们四周。顺着透明泡泡看去，未来无限宽广，无限美好。却没想到泡泡漂浮不定，时近时远，一戳就泡。</p><p>小时候我有个抽屉，里面放着我精心积攒的“垃圾”。包糖果的彩色透明纸、打开有会唱歌的生日卡、断了一条胳膊的芭比娃娃、有香味的信纸、扎头发的丝带、路边摊廉价的项链... ...</p><p>时间长了，我玩得不亦乐乎，抽屉被塞得乱七八糟密不透风。</p><p>在我考试不及格的某一天，爸妈勒令我清理抽屉，扔掉了我一大半藏品。我难过极了，没吃晚饭。一边哭一边恨恨地在日记本上写：等以后，等以后我长大了，我一定要把它们找回来，一定要拥有比这些多千倍万倍的东西。</p><p>终于，现在就是当年我眼中的以后了。我喜欢的东西和八岁时完全不同。我给自己买过簇新的芭比娃娃，买完就送人了... ...</p><p>哪有那么多以后呢？在时间无涯的荒野里，永远不知道时间会在哪一刻停止，甚至不知道明天和意外到底哪一个先来。</p><p>把每一天当作最后一天来过，常被人用来提醒要珍惜现在。</p><p>每一次相遇都是为了以后说再见，常被人用来提醒要珍惜眼前人。</p><p>可是，我们还是会为未知的恐惧和贪婪忽略掉今天；也会为一时的赌气伤害身边人摔门而去... ...</p><p>人生看似很长，但，生命无常。甚至，也怨不得无常。如果不是因为那些无常，你不会遇到看似永没有交集的爱人，不会相交看似在不同圈子里的朋友。只是，这些无常，这些看似的以后，看似的“来日方长”，常常会留给我们太多“来不及”。</p><p>对于父母，为什么总想着以后对他们好，以后陪他们玩呢？为什么不是现在就多给他们打电话，多回家，多带他们出去旅行。</p><p>对于伴侣，为什么总想着以后挣大钱了再让他们享福，为什么不是现在就多陪她，给她做好吃的，哄她开心呢？</p><p>对于孩子，为什么总想着等以后他如何如何才能放心，为什么现在就不能放手呢？</p><p>歌里是这么唱的：你是否能明白，一万个美丽的未来，比不上一个温暖，温暖的现在；你是否能明白，一万个真实的现在，就是你曾经幻想，幻想的未来。</p><p>我知道，理智冷静客观的成年人，总是对以后有诸多计划，以为自己对未来有充分掌控力。却忘记了人只能活在当下，能掌控的也只有当下而已。对未来做再多计划，都不如在现有的条件下，尽力把生活过好。</p><p>我和老公刚结婚的时候，进行过如下探讨。</p><p>他：你为什么总想着出去玩？我的过往人生中，无所事事度假的时间几乎没有，工作比玩重要太多... ...每天晒太阳看风景，难道不是等以后挣够了钱，退休以后的事情？</p><p>我只用一句话就说服了他：现在在海边穿比基尼拍照，和等以后五十岁在海边穿比基尼拍照，有质的区别。</p>','201404202107202547.jpg','201404202126147766.jpg','懿一','http://cdn.lizhi.fm/audio/2014/04/15/10893993695565574_hd.mp3','2014-04-20 13:08:23','2014-04-20 13:26:18',6,0,8),(2,'用现实和理想谈青春','青春,宿命,委屈,挣扎,奋斗','没有一代人的青春是容易的。每一代有每一代人的宿命、委屈、挣扎、奋斗，没什么可抱怨的','白岩松','<p>先把理想藏起来，理想不必天天想。因为买不起房子，所以爱情太贵了；人际关系太难处了，都不敢说不了；想到北京、上海、广州漂流的，你们是现在最委屈、最难受、最不幸的一代。从喝完酒后做什么事情来判断是哪一代人。</p><p><br/></p><p>60后：留在原地喝茶聊天</p><p><br/></p><p>70后：唱卡拉OK</p><p><br/></p><p>80后：去夜店</p><p><br/></p><p>90后：十几个人坐一起，没人说话，都在拿手机跟别人聊天</p><p><br/></p><p>在我成长的年代里，我不知道什么是新闻。因为我在内蒙古一个边疆的小城市里。在我们那没有新闻，我也不知道记者是干什么的。广播学院考试容易过，逃课没人抓，课外书随便看。</p><p><br/></p><p>因为这个报考的。现在考广院，恨不得北大、清华的分才能进热门专业。我说，我买的是原始股。因此，有很多不认为自己的学校是名牌大学的学生，我经常给它讲我的故事。</p><p><br/></p><p>北大很牛，不是现在在那里上学的学生造成的。我们要用自己的努力，把一个学校从无名之辈变成名校。要成为原始股的购买者。人家买的是期货，不是现货。我夫人认识我的时候，我什么都不是，只是一个很可爱的人。对于爱情来说，这个就够了。</p><p><br/></p><p>但是现在要用房子、车子来衡量是否要跟他拥有爱情。对于60后来说，连上大学都是懵懵懂懂。房子太贵，我们这一代人从来都没有想过，能买自己的房子。有人说，我们在上海漂流，是蚁族。但是我们这一代连漂流的机会都没有。你们的痛苦是让我们羡慕的幸福。</p><p><br/></p><p>过了30之后社会才给我们这样的人提供漂流的机会。89年，我们的毕业空前绝后。我们是唱着大约在冬季，一批一批人在火车站泪洒火车站，充满了绝望，不知道未来在哪里。有时候，经历了也发生变化，那似乎是一个转折。</p><p>我待的地方是周口店。从我的窗口就能看到猿人遗址，一年就看了21次这个遗址。</p><p><br/></p><p>偶尔从周口店回北京城，第一件事就是花一块钱买一根香肠，站在马路上吃完。跟你们比，我是幸福还是痛苦？我在北京搬了八次家。我的孩子就是在搬家过程中孕育的。我一直离城市的距离保持在五环之外。白哥，你别装了，你还能买不起房子？我现在能买得起房子。本台最后一次分房子，我排倒数第一。我肯定拿不到朝向好的房子，“没关系，朝下我都要！”成了中央电视台的至理名言。这是我们这一代的故事。</p><p><br/></p><p>1949年出生的这一代。他们幸福死了，用一个诗人的话说，时间开始了。当他们12、13岁正是长身体的时候，三年自然灾害。等他们开始上学时，文化大革命开始了；等他们要谈恋爱时，男女不分，所有的人都穿一样的衣服，男人能干的，女人也都要干。等他们27、28，终于生活安定下来，想要结婚要小孩的时候，突然恢复高考了。有的回城，有的高考，命运从此发生了转折。终于到30多岁，想要多要几个时，计划生育了；等他们开始享受天伦之乐时，下岗了，大学生找不到工作了。和这一代相比，你们幸福么？</p><p><br/></p><p>再往上走，季羡林，季老到德国学习的时候，哪知道赶上第二次世界大战。在德国一待就是10年，想回都回不来。和这一代相比，你体会不到两国相隔。</p><p><br/></p><p>没有一代人的青春是容易的。每一代有每一代人的宿命、委屈、挣扎、奋斗，没什么可抱怨的。幸运的你们，由于有了互联网，可以把你们的委屈和抱怨让世界看到，于是诞生了蚁族、北漂，这是痛苦中的幸福。社会应该关爱你们，但不是溺爱。身在青春期的人应该明白，天上不会掉馅饼，如果掉，会是铁饼。</p><p><br/></p><p>21岁，我们走出青春的沼泽地。这首诗，我回想起来的时候，青春回忆的时候很美好浪漫，但经历的时候很残酷。青春就是残酷，人生的很多次第一次都在青春期，你要抉择，不要以为每一代人都说青春好，你便产生了幻觉。我经常会感受到我在青春期的时候经历的痛苦和挣扎。我们在实习的时候，集体口号是，装孙子。我们那一代人比你们更艰难，也比你们更会找艰难。我们那个时候要打水、拖地，你们不用了，有饮水机、有清洁工人。青春既然是不容易的，面对它。这是作为过来人的感慨，有的有用，有的没用。</p><p><br/></p><p>第一的素质不是你的才华，而是你是否有一个强大的心脏。当你离开校园往前走的时候，打击多了，没用心理素质，想在将来这个社会上混，是不行的。不是特指中国，在美国也一样。</p><p><br/></p><p>我在招人的时候，经常会观察这个人心理素质如何；这就像一个拳击手，被别人不断打击都不倒才是重要的。我看到很多年轻人在最初的表扬中，跌倒了。不靠谱的表扬更会毁人。对批评有耐受性，对表扬有警觉。</p><p><br/></p><p>第二，17年前，龙永图那时候入关谈判，他问我什么叫谈判，不就是像你们一样么，跟对手在争斗在吵架。他说，不，谈判一门双方妥协的艺术。我是在年到40的时候才明白这个道理。任何单方面的谈判，不是谈判，是战争、侵略。人跟自己的理想、事业、同伴、生命都是一场谈判，从来不会单方面的获胜。只有双方妥协才是一种获胜。你怎么能够完全让生命按照你认为的方向去走呢？那不是谈判，那是你对生命发动的战争。爱情、婚姻也如此。离婚的一定是有一方不妥协，或者双方都不妥协。关键时刻，伤人的那句话能够憋住，才会有传奇。踢足球也是一样，我现在一周两场球，我的队友有三分之一是国家队。别忘了，我四十多了。要学会用40岁的方式去踢足球。各种伤痛都经历了，我还在用20多岁的方式去踢，很暴力、很想获得胜利，但是我现在明白了，我必须妥协。</p>','201404202115231265.jpg','201404202126297585.jpg','陈川','http://cdn.lizhi.fm/audio/2014/04/15/10893974099771142_hd.mp3','2014-04-20 13:16:30','2014-04-20 13:43:17',12,0,8);
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
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `content` text COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `access_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0 不公开，1 公开',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`category_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='杂志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `magazine`
--

LOCK TABLES `magazine` WRITE;
/*!40000 ALTER TABLE `magazine` DISABLE KEYS */;
INSERT INTO `magazine` VALUES (1,'过自己喜欢的生活前，得有资本','追梦,奋斗','如果你正为自己想要的生活而努力奋斗着，那么请继续坚持。别害怕追梦过程中的孤独寂寞，因为追梦就像是一场马拉松，最终能坚持到终点的人寥寥无几。','壹心理','201404202151541973.jpg','<p>在你打算过自己喜欢的生活前，你有资本吗？有后路可退吗？</p><p><br/></p><p>你羡慕别人放下一切的说走就走，你渴望摆脱工作的苦逼烦躁，你奢望过陶渊明式的田园生活，你总是在想，别人为什么能考上喜欢的大学，别人为什么能拿奖学金，别人为什么能升职。你总是别人别人的以为着，希望自己也能像别人那样。但是，你有资本吗？没有资本的话，就请在今天努力吧。因为我一直都这样认为，过自己喜欢的生活是要有物质保障的。除非你家庭很牛逼。</p><p><br/></p><p>很多时候，你只知道羡慕别人的优越，却不知道别人为了过自己喜欢的生活付出了太多太多的辛苦与汗水。你只知道别人的生活很有趣，却不知道别人是人前风光，人后遭罪。我知道你有很多宏伟的想法，但如果没有为之行动，都是空想，只会浪费宝贵的时间。</p><p><br/></p><p>我最近读苏美写的《倾我所有去生活》，她写了这样几句话，替我的迷茫有了解答。1、有床就睡，有饭就吃，余下一些力气，干点力所能及的工作，这就很让我踏实了。2、不管故事多难过，都应该有笑声。3、有些事不懂，就先放下，不急，假以时日，像是枝头的葡萄，自然会熟，落下来，尝了，就懂了。</p><p><br/></p><p>我很喜欢书名，《倾我所有去生活》。拿到书后，看了书名和简介，脑海里立马想到的就是这篇文章的标题，以及开头所写的话。其实，与其说是一篇读书札记，不如说是因为一个句子而发生的瞬间感悟，需要记下，以免忘记。</p><p><br/></p><p>有时候，你会和朋友爆一句粗口说，妈蛋，老子的青春十八岁后就没有了。高中时为了高考，过着机械式重复生活；大学时为了毕业找个好工作，匆匆了结无疾而终的恋爱。等真正工作了，踏入社会后，又要为结婚、买房、买车操劳。只是你想过没有，你如此的苦逼着努力是为了什么？还不是为了赚钱，为了自己爱的人有一个稳当的保障。你只要有了保障，青春随时都有。</p><p><br/></p><p>苏美在这本《倾我所有去生活》一书中，写的都是生活中柴米油盐酱醋茶的小事，像是一个女子的唠唠叨叨，在你耳畔说着今天买菜花了多少钱，今天某某商场打几折，今天和闺蜜遇见了什么样的极品事情。这些，看似寻常，但苏美的笔调不寻常。整本书的文字很接地气，几乎都是用口语来表达生活中发生的故事，避免了书面语的文绉绉，读起来不累。而且，每一篇故事都有各自的闪光点——即在你防不胜防时冒出一两句貌似粗鲁实际恰当的词语在文字中。</p><p><br/></p><p>“十五年前大学新生报到，我坐的是他的尼桑。无论如何，我都必须承认他牛逼过。可是，这又如何？他还是要去躺在手术台上，被人切得乱七八糟。”读到苏美写父亲这一段时，心中想着，我们如此奋不顾身的拼命奋斗为的是什么？为的就是让父母过好的生活。他们也尝过了苦尽甘来，只是现在的这份甘甜，兴许还不够，没有甜到让他们感到腻味。所以，我今天必须比昨天再努力一点。</p><p><br/></p><p>你努力奋斗最重要的理由，就是过上自己想要的生活。</p><p><br/></p><p>如果你正为自己想要的生活而努力奋斗着，那么请继续坚持。别害怕追梦过程中的孤独寂寞，因为追梦就像是一场马拉松，最终能坚持到终点的人寥寥无几。</p>','2014-04-20 13:49:05','2014-04-20 13:53:45',0,1,7);
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
  `access_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0 不公开，1 公开',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`category_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='笔记本';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_book`
--

LOCK TABLES `note_book` WRITE;
/*!40000 ALTER TABLE `note_book` DISABLE KEYS */;
INSERT INTO `note_book` VALUES (1,'作为开发者，你不应该害怕的8件事','开发者,编程,坏代码','编程就像性一样：一次犯错，终生维护。——Michael Sinz','网络','<p><strong>1. 改变</strong></p><p><br/></p><p><span style=\"line-height: 1.5;\">在软件开发中，没有什么事情会一直停滞不前。现在你正在开发的东西，只是软件的其中一个版本，未来随时可能发生变化。</span><br/></p><p><br/></p><p>变化是在软件开发中最常见的事情，你最好接受这一事实。一种好的做法是，使你的代码更加模块化，这样在未来需求改变时，可以容易地进行更改。</p><p><br/></p><p>遵循DRY（Don&#39;t Repeat Yourself）和YAGNI（You Aren&#39;t Gonna Need It）原则。经常看看你的代码，相信自己可以做得更好。立即采取行动，并进行重构，你等的时间越长，代码维护起来就越艰难。有可能会混乱到你无法处理。</p><p><br/></p><p>好代码是很容易改变的代码。代码会不断改变，直到它不再容易改变为止。那时所有的代码已经变成了糟糕的代码。</p><p><br/></p><p><strong>2. 移除死代码和注释掉的代码</strong></p><p><br/></p><p>在开发中，往往会遇到一些无用的或注释掉的代码，你可能不愿意删除，因为你不知道它们以后会不会排上用场。</p><p><br/></p><p>立刻删除了吧！因为有版本管理工具来负责记住这些代码。现实中太多的项目充斥着大量注释掉的代码，如果不需要，就删除吧，不要害怕。</p><p><br/></p><p>完美，不是在没有东西需要补充的时候，而是在没有东西需要去掉的时候。</p><p><br/></p><p><strong>3. 犯错误</strong></p><p><br/></p><p>没有人是完美的，每个人都会犯错误。犯错是一个学习的过程。如果你不承认任何错误，你将不会有任何改善。</p><p><br/></p><p>所以，每当你犯了一个错误的时候，你要从中学到一些新的东西，来提高你的知识。此外，不要隐藏自己的错误，或为它们感到羞愧，诚实、坦率地说出你的错误，为自己或他人作前车之鉴。批评与自我批评是推动一个成功团队向前的重要工具。</p><p><br/></p><p>从未犯过错误的人，是没有机会尝试新东西的。</p><p><br/></p><p><strong>4. 向其他人展示你的代码</strong></p><p><br/></p><p>你是不是害怕其他人审查你的代码？为什么呢？你没有尽全力写好吗？你害怕犯任何错误吗？</p><p><br/></p><p>你不应该这样，代码审查中发现的每一处错误都可以为你积累一些经验，在以后的编码中，你将不会再犯同样的错误。因此，你应该为你写的代码感到骄傲，不要害怕别人看到。</p><p><br/></p><p><strong>5. 失败</strong></p><p><br/></p><p>这是最重要的一个。如果你害怕失败，那么你将永远无法解决手头的问题。永远不要放弃希望，把它当作是一个挑战。尝试从另一个角度看东西。成功地解决难题之后，会让你更加强大。</p><p><br/></p><p>我并没有失败，我刚刚发现了1万种无法正常工作的方式。——托马斯?爱迪生</p><p><br/></p><p><strong>6. 你自己代码的稳定性</strong></p><p><br/></p><p>你向你的老板或客户展示你的项目时，你开始担心“能正常运行吗？希望我在开发过程中没有遗漏什么。”</p><p><br/></p><p>这是一个不好的征兆，你不应该担心。你应该尽早测试你的项目。当然，你无法100％肯定你的作品是完美的，但通过编写自动化测试，可以大大提高你对你的代码的信任度。</p><p><br/></p><p><strong>7. 新的、复杂的技术</strong></p><p><br/></p><p>有些开发人员很懒惰，经常沉浸在他们的“Good Old”技术中。要知道，IT正在以令人难以置信的速度发展，每一天都会有新的、更好的技术出现。</p><p><br/></p><p>因此，开发人员要以开放的态度，多学习一些东西，阅读一些博客，使你不至于与新技术脱节。如果技术/框架满足你的需求，尝试一下也无妨。</p><p><br/></p><p><strong>8. 项目时间压力</strong></p><p><br/></p><p>别让时间压力毁了项目的质量。保证你的代码干净、稳定，这是你的工作。高质量也意味着需要深思熟虑的决策和开发时间，有时你需要争取一下。你的客 户期待你用100%（甚至120%）的努力来完成一个可维护的、最先进的产品，如果最终你交付一个次品，那么你后面的时间将被各种需求变更、维护工作占 用，并且老板和客户对你的信任度也会降低。</p><p><br/></p><p>在开发中，你节省的时间往往会为你带来更多的技术债务。因此，当涉及到项目质量时，拿出你的勇气，诚实地与你的老板谈谈。</p><p><br/></p><p>编程就像性一样：一次犯错，终生维护。——Michael Sinz</p><p><br/></p>','2014-04-20 14:00:38','2014-04-20 15:28:47',0,1,6),(2,'CDN（内容分发网络）技术原理','CDN,内容,分发,网络','CDN的全称是Content Delivery Network，即内容分发网络。','WEB开发者','<h3><strong>1. 前言</strong></h3><p>Internet的高速发展，给人们的工作和生活带来了极大的便利，对Internet的服务品质和访问速度要求越来越高，虽然带宽不断增加，用户数量也在不断增加，受Web服务器的负荷和传输距离等因数的影响，响应速度慢还是经常抱怨和困扰。解决方案就是在网络传输上利用缓存技术使得Web服务数据流能就近访问，是优化网络数据传输非常有效的技术，从而获得高速的体验和品质保证。</p><p><br/></p><p>网络缓存技术，其目的就是减少网络中冗余数据的重复传输，使之最小化，将广域传输转为本地或就近访问。互联网上传递的内容，大部分为重复的Web/FTP数据，Cache服务器及应用Caching技术的网络设备，可大大优化数据链路性能，消除数据峰值访问造成的结点设备阻塞。Cache服务器具有缓存功能，所以大部分网页对象（Web page object），如html, htm, php等页面文件，gif,tif, png, bmp等图片文件，以及其他格式的文件，在有效期（TTL）内，对于重复的访问，不必从原始网站重新传送文件实体，只需通过简单的认证（Freshness Validation）- 传送几十字节的Header，即可将本地的副本直接传送给访问者。由于缓存服务器通常部署在靠近用户端，所以能获得近似局域网的响应速度，并有效减少广域带宽的消耗。据统计，Internet上超过80%的用户重复访问20%的信息资源，给缓存技术的应用提供了先决的条件。缓存服务器的体系结构与Web服务器不同，缓存服务器能比Web服务器获得更高的性能，缓存服务器不仅能提高响应速度，节约带宽，对于加速Web服务器，有效减轻源服务器的负荷是非常有效的。</p><p><br/></p><p>高速缓存服务器（Cache Server）是软硬件高度集成的专业功能服务器，主要做高速缓存加速服务，一般部署在网络边缘。根据加速对象不同，分为客户端加速和服务器加速，客户端加速Cache部署在网络出口处，把常访问的内容缓存在本地，提高响应速度和节约带宽；服务器加速，Cache部署在服务器前端，作为Web服务器的前置机，提高Web服务器的性能，加速访问速度。如果多台Cache加速服务器且分布在不同地域，需要通过有效地机制管理Cache网络，引导用户就近访问，全局负载均衡流量，这就是CDN内容传输网络的基本思想。</p><p><img src=\"http://note.youdao.com/yws/res/3442/03C49BB3970D4C4DA667C7F3F4BE25AB\" data-ke-src=\"http://note.youdao.com/yws/res/3442/03C49BB3970D4C4DA667C7F3F4BE25AB\"/></p><p><br/></p><h3><strong>2．什么是CDN？</strong></h3><p><strong><br/></strong></p><p>CDN的全称是Content Delivery Network，即内容分发网络。其目的是通过在现有的Internet中增加一层新的网络架构，将网站的内容发布到最接近用户的网络”边缘”，使用户可以就近取得所需的内容，解决Internet网络拥塞状况，提高用户访问网站的响应速度。从技术上全面解决由于网络带宽小、用户访问量大、网点分布不均等原因，解决用户访问网站的响应速度慢的根本原因。</p><p><br/></p><p>狭义地讲，内容分发布网络(CDN)是一种新型的网络构建方式，它是为能在传统的IP网发布宽带丰富媒体而特别优化的网络覆盖层；而从广义的角度，CDN代表了一种基于质量与秩序的网络服务模式。简单地说，内容发布网络(CDN)是一个经策略性部署的整体系统，包括分布式存储、负载均衡、网络请求的重定向和内容管理４个要件，而内容管理和全局的网络流量管理(Traffic Management)是CDN的核心所在。通过用户就近性和服务器负载的判断，CDN确保内容以一种极为高效的方式为用户的请求提供服务。总的来说，内容服务基于缓存服务器，也称作代理缓存(Surrogate)，它位于网络的边缘，距用户仅有”一跳”(Single Hop)之遥。同时，代理缓存是内容提供商源服务器（通常位于CDN服务提供商的数据中心）的一个透明镜像。这样的架构使得CDN服务提供商能够代表他们客户，即内容供应商，向最终用户提供尽可能好的体验，而这些用户是不能容忍请求响应时间有任何延迟的。据统计，采用CDN技术，能处理整个网站页面的70%～95％的内容访问量，减轻服务器的压力，提升了网站的性能和可扩展性。</p><p><br/></p><p>与目前现有的内容发布模式相比较，CDN强调了网络在内容发布中的重要性。通过引入主动的内容管理层的和全局负载均衡，CDN从根本上区别于传统的内容发布模式。在传统的内容发布模式中，内容的发布由ICP的应用服务器完成，而网络只表现为一个透明的数据传输通道，这种透明性表现在网络的质量保证仅仅停留在数据包的层面，而不能根据内容对象的不同区分服务质量。此外，由于IP网的”尽力而为”的特性使得其质量保证是依靠在用户和应用服务器之间端到端地提供充分的、远大于实际所需的带宽通量来实现的。在这样的内容发布模式下，不仅大量宝贵的骨干带宽被占用，同时ICP的应用服务器的负载也变得非常重，而且不可预计。当发生一些热点事件和出现浪涌流量时，会产生局部热点效应，从而使应用服务器过载退出服务。这种基于中心的应用服务器的内容发布模式的另外一个缺陷在于个性化服务的缺失和对宽带服务价值链的扭曲，内容提供商承担了他们不该干也干不好的内容发布服务。</p><p><br/></p><p>纵观整个宽带服务的价值链，内容提供商和用户位于整个价值链的两端，中间依靠网络服务提供商将其串接起来。随着互联网工业的成熟和商业模式的变革，在这条价值链上的角色越来越多也越来越细分。比如内容／应用的运营商、托管服务提供商、骨干网络服务提供商、接入服务提供商等等。在这一条价值链上的每一个角色都要分工合作、各司其职才能为客户提供良好的服务，从而带来多赢的局面。从内容与网络的结合模式上看，内容的发布已经走过了ICP的内容（应用）服务器和IDC这两个阶段。IDC的热潮也催生了托管服务提供商这一角色。但是，IDC并不能解决内容的有效发布问题。内容位于网络的中心并不能解决骨干带宽的占用和建立IP网络上的流量秩序。因此将内容推到网络的边缘，为用户提供就近性的边缘服务，从而保证服务的质量和整个网络上的访问秩序就成了一种显而易见的选择。而这就是内容发布网(CDN)服务模式。CDN的建立解决了困扰内容运营商的内容”集中与分散”的两难选择。无疑对于构建良好的互联网价值链是有价值的，也是不可或缺的。</p><p><br/></p><h3><strong>3．CDN新应用和客户</strong></h3><p><strong><br/></strong></p><p>目前的CDN服务主要应用于证券、金融保险、ISP、ICP、网上交易、门户网站、大中型公司、网络教学等领域。另外在行业专网、互联网中都可以用到，甚至可以对局域网进行网络优化。利用CDN，这些网站无需投资昂贵的各类服务器、设立分站点，特别是流媒体信息的广泛应用、远程教学课件等消耗带宽资源多的媒体信息，应用CDN网络，把内容复制到网络的最边缘，使内容请求点和交付点之间的距离缩至最小，从而促进Web站点性能的提高，具有重要的意义。CDN网络的建设主要有企业建设的CDN网络，为企业服务；IDC的CDN网络，主要服务于IDC和增值服务；网络运营上主建的CDN网络，主要提供内容推送服务；CDN网络服务商，专门建设的CDN用于做服务，用户通过与CDN机构进行合作，CDN负责信息传递工作，保证信息正常传输，维护传送网络，而网站只需要内容维护，不再需要考虑流量问题。</p><p><br/></p><p>CDN能够为网络的快速、安全、稳定、可扩展等方面提供保障。</p><p>IDC建立CDN网络，IDC运营商一般需要有分部各地的多个IDC中心，服务对象是托管在IDC中心的客户，利用现有的网络资源，投资较少，容易建设。例如某IDC全国有10个机房，加入IDC的CDN网络，托管在一个节点的Web服务器，相当于有了10个镜像服务器，就近供客户访问。宽带城域网，域内网络速度很快，出城带宽一般就会瓶颈，为了体现城域网的高速体验，解决方案就是将Internet网上内容高速缓存到本地，将Cache部署在城域网各POP点上，这样形成高效有序的网络，用户仅一跳就能访问大部分的内容，这也是一种加速所有网站CDN的应用。</p><p><br/></p><h3><strong>4．CDN 的工作原理</strong></h3><p><strong><br/></strong></p><p>在描述CDN的实现原理，让我们先看传统的未加缓存服务的访问过程，以便了解CDN缓存访问方式与未加缓存访问方式的差别：</p><p><img title=\"CDN（内容分发网络）技术原理\" src=\"http://note.youdao.com/yws/res/3440/77E34FB339664FA589AF295D599DC6E4\" data-ke-src=\"http://note.youdao.com/yws/res/3440/77E34FB339664FA589AF295D599DC6E4\" alt=\"CDN（内容分发网络）技术原理\"/></p><p>由上图可见，用户访问未使用CDN缓存网站的过程为:</p><p>1)、用户向浏览器提供要访问的域名；</p><p>2)、浏览器调用域名解析函数库对域名进行解析，以得到此域名对应的IP地址；</p><p>3)、浏览器使用所得到的IP地址，域名的服务主机发出数据访问请求；</p><p>4)、浏览器根据域名主机返回的数据显示网页的内容。</p><p><br/></p><p>通过以上四个步骤，浏览器完成从用户处接收用户要访问的域名到从域名服务主机处获取数据的整个过程。CDN网络是在用户和服务器之间增加Cache层，如何将用户的请求引导到Cache上获得源服务器的数据，主要是通过接管DNS实现，下面让我们看看访问使用CDN缓存后的网站的过程：</p><p><img title=\"CDN（内容分发网络）技术原理\" src=\"http://note.youdao.com/yws/res/3441/25A7D19B9CB14F1CA64587EB2EB74D7E\" data-ke-src=\"http://note.youdao.com/yws/res/3441/25A7D19B9CB14F1CA64587EB2EB74D7E\" alt=\"CDN（内容分发网络）技术原理\"/></p><p>通过上图，我们可以了解到，使用了CDN缓存后的网站的访问过程变为：</p><p>1)、用户向浏览器提供要访问的域名；</p><p>2)、浏览器调用域名解析库对域名进行解析，由于CDN对域名解析过程进行了调整，所以解析函数库一般得到的是该域名对应的CNAME记录，为了得到实际IP地址，浏览器需要再次对获得的CNAME域名进行解析以得到实际的IP地址；在此过程中，使用的全局负载均衡DNS解析，如根据地理位置信息解析对应的IP地址，使得用户能就近访问。</p><p>3)、此次解析得到CDN缓存服务器的IP地址，浏览器在得到实际的IP地址以后，向缓存服务器发出访问请求；</p><p>4)、缓存服务器根据浏览器提供的要访问的域名，通过Cache内部专用DNS解析得到此域名的实际IP地址，再由缓存服务器向此实际IP地址提交访问请求；</p><p>5)、缓存服务器从实际IP地址得得到内容以后，一方面在本地进行保存，以备以后使用，二方面把获取的数据返回给客户端，完成数据服务过程；</p><p>6)、客户端得到由缓存服务器返回的数据以后显示出来并完成整个浏览的数据请求过程。</p><p><br/></p><p>通过以上的分析我们可以得到，为了实现既要对普通用户透明(即加入缓存以后用户客户端无需进行任何设置，直接使用被加速网站原有的域名即可访问)，又要在为指定的网站提供加速服务的同时降低对ICP的影响，只要修改整个访问过程中的域名解析部分，以实现透明的加速服务，下面是CDN网络实现的具体操作过程。</p><p>1)、作为ICP，只需要把域名解释权交给CDN运营商，其他方面不需要进行任何的修改；操作时，ICP修改自己域名的解析记录，一般用cname方式指向CDN网络Cache服务器的地址。</p><p>2)、作为CDN运营商，首先需要为ICP的域名提供公开的解析，为了实现sortlist，一般是把ICP的域名解释结果指向一个CNAME记录；</p><p>3)、当需要进行sorlist时，CDN运营商可以利用DNS对CNAME指向的域名解析过程进行特殊处理，使DNS服务器在接收到客户端请求时可以根据客户端的IP地址，返回相同域名的不同IP地址；</p><p>4)、由于从cname获得的IP地址，并且带有hostname信息，请求到达Cache之后，Cache必须知道源服务器的IP地址，所以在CDN运营商内部维护一个内部DNS服务器，用于解释用户所访问的域名的真实IP地址；</p><p>5)、在维护内部DNS服务器时，还需要维护一台授权服务器，控制哪些域名可以进行缓存，而哪些又不进行缓存，以免发生开放代理的情况。</p><p><br/></p><h3><strong>5．CDN的技术手段</strong></h3><p><strong><br/></strong></p><p>实现CDN的主要技术手段是高速缓存、镜像服务器。可工作于DNS解析或HTTP重定向两种方式，通过Cache服务器，或异地的镜像站点完成内容的传送与同步更新。DNS方式用户位置判断准确率大于85%，HTTP方式准确率为99%以上；一般情况下，各Cache服务器群的用户访问流入数据量与Cache服务器到原始网站取内容的数据量之比在2：1到3：1之间，即分担50%到70%的到原始网站重复访问数据量（主要是图片，流媒体文件等内容）；对于镜像，除数据同步的流量，其余均在本地完成，不访问原始服务器。</p><p><br/></p><p>镜像站点（Mirror Site）服务器是我们经常可以看到的，它让内容直截了当地进行分布，适用于静态和准动态的数据同步。但是购买和维护新服务器的费用较高，另外还必须在各个地区设置镜像服务器，配备专业技术人员进行管理与维护。大型网站在随时更新各地服务器的同时，对带宽的需求也会显著增加，因此一般的互联网公司不会建立太多的镜像服务器。</p><p><br/></p><p>高速缓存手段的成本较低，适用于静态内容。Internet的统计表明，超过80%的用户经常访问的是20%的网站的内容，在这个规律下，缓存服务器可以处理大部分客户的静态请求，而原始的WWW服务器只需处理约20%左右的非缓存请求和动态请求，于是大大加快了客户请求的响应时间，并降低了原始WWW服务器的负载。根据美国IDC公司的调查，作为CDN的一项重要指标 —— 缓存的市场正在以每年近100%的速度增长，全球的营业额在2004年将达到45亿美元。网络流媒体的发展还将剌激这个市场的需求。</p><p><br/></p><h3><strong>6．CDN的网络架构</strong></h3><p><strong><br/></strong></p><p>CDN网络架构主要由两大部分，分为中心和边缘两部分，中心指CDN网管中心和DNS重定向解析中心，负责全局负载均衡，设备系统安装在管理中心机房，边缘主要指异地节点，CDN分发的载体，主要由Cache和负载均衡器等组成。</p><p>当用户访问加入CDN服务的网站时，域名解析请求将最终交给全局负载均衡DNS进行处理。全局负载均衡DNS通过一组预先定义好的策略，将当时最接近用户的节点地址提供给用户，使用户能够得到快速的服务。同时，它还与分布在世界各地的所有CDNC节点保持通信，搜集各节点的通信状态，确保不将用户的请求分配到不可用的CDN节点上，实际上是通过DNS做全局负载均衡。</p><p><br/></p><p>对于普通的Internet用户来讲，每个CDN节点就相当于一个放置在它周围的WEB。通过全局负载均衡DNS的控制，用户的请求被透明地指向离他最近的节点，节点中CDN服务器会像网站的原始服务器一样，响应用户的请求。由于它离用户更近，因而响应时间必然更快。</p><p><br/></p><p>每个CDN节点由两部分组成：负载均衡设备和高速缓存服务器</p><p>负载均衡设备负责每个节点中各个Cache的负载均衡，保证节点的工作效率；同时，负载均衡设备还负责收集节点与周围环境的信息，保持与全局负载DNS的通信，实现整个系统的负载均衡。</p><p><br/></p><p>高速缓存服务器（Cache）负责存储客户网站的大量信息，就像一个靠近用户的网站服务器一样响应本地用户的访问请求。</p><p><br/></p><p>CDN的管理系统是整个系统能够正常运转的保证。它不仅能对系统中的各个子系统和设备进行实时监控，对各种故障产生相应的告警，还可以实时监测到系统中总的流量和各节点的流量，并保存在系统的数据库中，使网管人员能够方便地进行进一步分析。通过完善的网管系统，用户可以对系统配置进行修改。</p><p><br/></p><p>理论上，最简单的CDN网络有一个负责全局负载均衡的DNS和各节点一台Cache，即可运行。DNS支持根据用户源IP地址解析不同的IP，实现就近访问。为了保证高可用性等，需要监视各节点的流量、健康状况等。一个节点的单台Cache承载数量不够时，才需要多台Cache，多台Cache同时工作，才需要负载均衡器，使Cache群协同工作。</p><p><br/></p><h3><strong>7. CDN 示例</strong></h3><p><strong><br/></strong></p><p>商业化的CDN网络是用于服务性质的，高可用性等要求非常高，有专业产品和CDN网络解决方案，本文主要从理论角度，理解CDN的实现过程，并利用已有网络环境和开源软件做实际配置，更深刻理解CDN的具体工作过程。</p><p><br/></p><p>Linux 是开放源代码的免费操作系统，已经成功应用于许多关键领域。Bind是Unix/FreeBSD/Linux等类Unix平台上非常有名DNS服务程序，Internet上超过60％的DNS运行的是bind。Bind的最新版本是9.x，用的比较多的是8.x，bind 9有很多新特性，其中一项是根据用户端源地址对同一域名解析不同的IP地址，有了这种特性，能把用户对同一域名的访问，引导到不同地域节点的服务器上去访问。Squid是Linux等操作系统上有名的Cache引擎，与商业Cache引擎相比，Squid的性能比较低，基本功能工作原理与商业Cache产品是一致的，作为试验，是非常容易配置运行起来。以下简要介绍CDN的配置流程。</p><p><br/></p><p>1、要加入CDN服务的网站，需要域名(如www.linuxaid.com.cn, 地址202.99.11.120)解析权提供给CDN运营商，Linuxaid的域名解析记录只要把www主机的A记录改为CNAME并指向cache.cdn.com即可。cache.cdn.com是CDN网络自定义的缓存服务器的标识。在/var/named/linuxaid.com.cn域名解析记录中，由：</p><div><p><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td><div>1</div><div>2</div><div>3</div></td><td style=\"line-height: 1.5;\"><div>www&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 202.99.11.120</div><div>改为</div><div>www&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CNAME&nbsp;&nbsp; cache.cdn.com.</div></td></tr></tbody></table><br/></p></div><p>2、CDN运营商得到域名解析权以后，得到域名的CNAME记录，指向CDN网络属下缓存服务器的域名，如cache.cdn.com，CDN网络的全局负载均衡DNS，需要把CNAME记录根据策略解析出IP地址，一般是给出就近访问的Cache地址。</p><p>Bind 9的基本功能可以根据不同的源IP地址段解析对应的IP，实现根据地域就近访问的负载均衡，一般可以通过Bind 9的sortlist选项实现根据用户端IP地址返回最近的节点IP地址，具体的过程为：</p><p>1) 为cache.cdn.com设置多个A记录，/var/named/cdn.com 的内容如下：</p><div><div><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"line-height: 1.5;\"><div>1</div><div>2</div><div>3</div><div>4</div><div>5</div><div>6</div><div>7</div><div>8</div><div>9</div><div>10</div><div>11</div><div>12</div><div>13</div><div>14</div></td><td style=\"line-height: 1.5;\"><div>$TTL 3600</div><div>@&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SOA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ns.cdn.com.&nbsp;&nbsp;&nbsp;&nbsp; root.ns.cdn.com. (</div><div>2002090201&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;Serial num</div><div>10800&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;Refresh after 3 hours</div><div>3600&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;Retry</div><div>604800&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;Expire</div><div>1800&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;Time to live</div><div>)</div><div>IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ns</div><div>www&nbsp;&nbsp;&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 210.33.21.168</div><div>ns&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 202.96.128.68</div><div>cache&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 202.93.22.13&nbsp;&nbsp;&nbsp; ;有多少个CACHE地址</div><div>cache&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 210.21.30.90&nbsp;&nbsp;&nbsp; ;就有多少个CACHE的A记录</div><div>cache&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 211.99.13.47</div></td></tr></tbody></table></div></div><p>2) /etc/named.conf中的内容为：</p><div><p><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\"><tbody consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\"><tr consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\"><td consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\" style=\"line-height: 1.5;\"><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">1</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">2</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">3</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">4</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">5</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">6</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">7</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">8</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">9</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">10</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">11</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">12</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">13</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">14</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">15</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">16</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">17</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">18</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">19</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">20</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">21</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">22</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">23</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">24</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">25</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">26</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">27</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">28</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">29</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">30</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">31</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">32</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">33</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">34</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">43</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">44</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">45</div></td><td consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\" style=\"line-height: 1.5;\"><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\"><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">options {</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">directory&nbsp;&quot;/var/named&quot;;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">sortlist {</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">#这一段表示当在本地执行查询时</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">#将按照202.93.22.13,210.21.30.90,211.99.13.47的顺序返回地址</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ localhost;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ localnets;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">202.93.22.13;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 210.21.30.90; 211.99.13.47; };</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">#这一段表示当在202/8地址段进行DNS查询时</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">#将按照202.93.22.13,210.21.30.90,211.99.13.47的顺序返回地址</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 202/8;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 202.93.22.13;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 210.21.30.90; 211.99.13.47; };</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">#这一段表示当在211/8地址段进行DNS查询时</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">#将按照211.99.13.47,202.93.22.13,210.21.30.90的顺序返回地址，</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">#也就是211.99.13.47是最靠近查询地点的节点</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 211/8;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 211.99.13.47;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 202.93.22.13; 210.21.30.90; };</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 61/8;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 202.93.22.13;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">{ 210.21.30.90; 211.99.13.47; };</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">zone&nbsp;&quot;.&quot;{</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">typehint;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">file&quot;root.cache&quot;;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">zone&nbsp;&quot;localhost&quot;{</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">typemaster;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">file&quot;localhost&quot;;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">zone&nbsp;&quot;cdn.com&quot;{</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">typemaster;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">file&quot;cdn.com&quot;;</div><div consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\">};</div></div></td></tr></tbody></table><br/></p></div><p>3、Cache在CDN网络中如果工作在服务器加速模式，因为配置里已经写明加速服务器的url，所以Cache直接匹配用户请求，到源服务器获得内容并缓存供下次使用；如果Cache工作在客户端加速模式，Cache需要知道源服务器的IP地址，所以CDN网络维护和运行一个供Cache使用的DNS服务器，解析域名的真实IP地址，如202.99.11.120 ，各域名的解析记录与未加入CDN网络之前一样。</p><p><br/></p><p>4、工作在CDN网络中缓存服务器必须工作在透明方式，对于Squid来说，需要设置以下参数：</p><div><div><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\"><tbody consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\"><tr consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\"><td consolasbitstream=\"\" vera=\"\" sans=\"\" monocourier=\"\" newcouriermonospacecolorrgb=\"\" style=\"line-height: 1.5;\"><div>1</div><div>2</div><div>3</div><div>4</div></td><td style=\"line-height: 1.5;\"><div>httpd_accel_host virtual</div><div>httpd_accel_port 80</div><div>httpd_accel_with_proxy on</div><div>httpd_accel_uses_host_header on</div></td></tr></tbody></table></div></div>','2014-04-20 14:28:51','2014-04-20 15:58:50',0,1,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='语录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shared`
--

LOCK TABLES `shared` WRITE;
/*!40000 ALTER TABLE `shared` DISABLE KEYS */;
INSERT INTO `shared` VALUES (1,'世上并没有那么多冷漠无情的人，多的只是不擅表达的人。谁都希望遇到一个人，能读懂自己冷漠下的热情、微笑中的忧伤。奈何再近的两颗心，也难免有误读，那些言不由衷，常常被误以为真。人们总固执的认为，最好的沟通是不说也懂。很多人就是这样彼此错过。','2014-04-20 14:12:45',2,0),(2,'不会游泳的人，老换游泳池是不能解决问题的；不懂经营爱情的人，老换男女朋友是解决不了问题的；不懂经营家庭的人，怎么换爱人都解决不了问题；不懂管理基本功，老换员工和客户是无事于补的；不懂正确养生的人，补品再好，吃得再好都是解决不了问题的。自己是一切问题的根源，蜕变自己。','2014-04-20 14:37:41',1,0),(3,'那一天我停下脚步，不是看不清路，而是动人的美景让人不由的驻足。闻一丝花香、品一滴甘露。恋着春雨、护着寒暑。满心的温暖，只有这一刻才不感到孤独。','2014-04-20 14:40:13',3,0),(4,'Instead of someone else\'s life play a small role, as wonderful do it yourself.\r\n与其在别人的生活里跑龙套，不如精彩做自己。','2014-04-20 14:47:13',1,0),(5,'有些事不懂，就先放下，不急，假以时日，像是枝头的葡萄，自然会熟，落下来，尝了，就懂了。','2014-04-21 01:55:42',1,0),(6,'去庙里烧香，遇见一个老和尚让他给我算一挂，老和尚从口袋里拿出了两个鸡蛋，一个是生的，还有一个咸鸭蛋，在我头上砸了一下，问我哪个疼，我说咸的，和尚笑了一下，说到，你也知道咸的蛋疼啊！','2014-04-21 02:13:19',5,0);
/*!40000 ALTER TABLE `shared` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour`
--

DROP TABLE IF EXISTS `tour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tour` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `comeform` varchar(90) NOT NULL DEFAULT '' COMMENT '来源',
  `face_url` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `bg_url` varchar(255) NOT NULL DEFAULT '' COMMENT '背景图',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `access_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0 不公开，1 公开',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='旅游主题';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour`
--

LOCK TABLES `tour` WRITE;
/*!40000 ALTER TABLE `tour` DISABLE KEYS */;
INSERT INTO `tour` VALUES (1,'乌镇.浙江','乌镇,古镇,鱼米之乡,丝绸之府','乌镇保存着原有晚清和民国时期水乡古镇的风貌。以河成街，街桥相连，依河筑屋，水镇一体，组织起水阁、桥梁、石板巷等独具江南韵味的建筑因素。与周庄、同里、甪直、西塘、南浔并称为江南六大古镇。素有“鱼米之乡，丝绸之府”美称。','','201404210038089953.jpg','20140421005534868.jpg','2014-04-20 16:31:35','2014-04-21 04:24:35',18,1,1);
/*!40000 ALTER TABLE `tour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_photo`
--

DROP TABLE IF EXISTS `tour_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tour_photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tour_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属旅游主题',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片URL',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `tour_id` (`tour_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='旅游相册';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_photo`
--

LOCK TABLES `tour_photo` WRITE;
/*!40000 ALTER TABLE `tour_photo` DISABLE KEYS */;
INSERT INTO `tour_photo` VALUES (2,1,'201404210039505171.jpg','水市场',2),(3,1,'201404210039475125.jpg','乌镇牌楼',1),(4,1,'201404210038448178.jpg','茶楼',3),(5,1,'201404210038477316.jpg','',4),(6,1,'201404210038497175.jpg','泛舟',5),(7,1,'201404210039102633.jpg','皮影戏幕后',6),(8,1,'201404210039073209.jpg','皮影戏，又称“影子戏”或“灯影戏”，是一种以兽皮或纸板做成的人物剪影，在灯光照射下用隔亮布进行演戏，是我国民间广为流传的傀儡戏之一。',7),(9,1,'201404210039533133.jpg','乌镇码头',8),(10,1,'201404210039091060.jpg','水市场夜景',9),(11,1,'201404210039495324.jpg','夜晚的油纸伞，谁为谁撑起伞，又会又怎样的故事...',10),(12,1,'20140421003905775.jpg','西市河夜景',11),(13,1,'201404210038426053.jpg','花鼓大戏',12);
/*!40000 ALTER TABLE `tour_photo` ENABLE KEYS */;
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
INSERT INTO `user_account` VALUES (1,'bigo','$2a$08$DNkdmGhFlTSymVL.oHtNgeZHOHGrZO4tOUI3VjV.FA6mabD9KoCHC','bigo','201404202229548567.jpeg','M','1985-09-12','上海，浦东新区','不去评判，只观照自我，积极行动，尽量圆满，至于结果得失，来了便是要接受的。');
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

-- Dump completed on 2014-04-21 13:58:28
