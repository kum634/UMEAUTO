/**
 * LIB PHP Framework 3.2 Initial database
 *
 * @charset    UTF-8N
 * @package    Lib
 * @copyright  Copyright (c) 2019 Barman Soft, Inc.
 * @license    https://libframework.org/license.html The Clear BSD License
 * @version    LIB PHP Framework v3.2.191226
 */

CREATE TABLE IF NOT EXISTS `t_css` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `css_name` varchar(100) NOT NULL,
  `n_min` mediumint(9) NOT NULL,
  `n_max` mediumint(9) NOT NULL,
  `content` text NOT NULL,
  `tm_create` datetime NOT NULL,
  `tm_update` datetime NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `t_css` (`ROWID`, `css_name`, `n_min`, `n_max`, `content`, `tm_create`, `tm_update`, `user_id`, `is_locked`, `file_path`) VALUES
(1, 'sample_default', 0, 0, '@charset "utf-8";\n/**\n * lib_default.css\n *\n * @copyright  Copyright (c) \n * @version    \n */\n* {\n  margin: 0px;\n  padding: 0px;\n  font-family: ''Open Sans'', ''ヒラギノ角ゴ ProN W3'', ''Hiragino Kaku Gothic ProN'', ''メイリオ'', Meiryo, ''ＭＳ Ｐゴシック'', Sans-serif;\n  box-sizing: border-box;\n}\nbody {\n  height: 100%;\n  line-height: 1.6;\n  background-color: #fff;\n  font-family: ''Open Sans'', ''ヒラギノ角ゴ ProN W3'', ''Hiragino Kaku Gothic ProN'', ''メイリオ'', Meiryo, ''ＭＳ Ｐゴシック'', Sans-serif;\n  font-size: 13px;\n  color: #333333;\n}\nimg {\n  max-width: 100%;\n  height: auto;\n  border: 0px;\n}\na {\n  color: #575757;\n  text-decoration: none;\n}\ninput[type="text"], input[type="password"] {\n  padding: 5px 5px;\n  width: 100%;\n  border: 1px solid #ccc;\n  border-radius: 4px;\n  vertical-align: middle;\n  box-sizing: border-box;\n  -moz-box-sizing: border-box;\n  -webkit-box-sizing: border-box;\n}\nbutton, input[type="text"] {\n  appearance: none;\n  -webkit-appearance: none;\n  -moz-appearance: none;\n}\nul li {\n  list-style-type: none;\n}\n* html .clearfix {\n  height: 1%;\n}\n.clearfix {\n  display: block;\n}\n.clearfix:after {\n  clear: both;\n  display: block;\n  height: 0px;\n  line-height: 0px;\n  content: ".";\n  visibility: hidden;\n}\n/*----------------------------------------------------------------------\nwrapping size\n------------------------------------------------------------------------*/\ndiv.wrap {\n  margin: 0 auto;\n  min-width: 1000px;\n}\n/*----------------------------------------------------------------------\nheader\n------------------------------------------------------------------------*/\nheader {\n  width: 100%;\n  height: auto;\n  background-color: #000;\n}\nheader div.wrap {\n  padding: 0 20px;\n  height: 60px;\n  background-color: #000;\n  display: flex;\n  align-items: center;\n  justify-content: left;\n}\nheader div.wrap img {\n  width: 250px;\n  height: 60px;\n  cursor: pointer;\n}\n/*----------------------------------------------------------------------\nfooter\n------------------------------------------------------------------------*/\nfooter {\n  width: 100%;\n  height: auto;\n  background-color: #eee;\n}\nfooter div.wrap {\n  height: 30px;\n  background-color: #eee;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n}\n/*----------------------------------------------------------------------\nsection\n------------------------------------------------------------------------*/\nsection {\n  width: 100%;\n  min-height: calc(100vh - 90px);\n  background-color: #fff;\n}\nsection div.wrap {\n  padding: 0 20px;\n  display: flex;\n}\nsection div.wrap > nav {\n  min-width: 200px;\n}\nsection div.wrap > article {\n  padding-left: 20px;\n  width: 100%;\n}\n/*----------------------------------------------------------------------\nnav\n------------------------------------------------------------------------*/\nsection div.wrap > nav ul li a {\n  display: block;\n  margin-top: 20px;\n  width: 100%;\n  height: 60px;\n  background: #eee;\n  border-radius: 4px;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n}\nsection div.wrap > nav ul li a:hover {\n  opacity: 0.8;\n}\n/*----------------------------------------------------------------------\narticle\n------------------------------------------------------------------------*/\nsection div.wrap > article h1 {\n  margin-top: 20px;\n  font-size: 38px;\n  border-bottom: 1px solid #ccc;\n}\nsection div.wrap > article p {\n  padding: 20px 0;\n}', '2018-05-15 00:00:00', '2019-06-16 19:09:43', 'administrator', 1, 'css'),
(2, 'sample_landscape', 601, 768, '@charset "utf-8";\n/**\n * lib_landscape.css\n *\n * @copyright  Copyright (c) \n * @version    \n */\nbody {\n  font-size: 15px;\n}\ndiv.wrap {\n  min-width: initial;\n}\n/*----------------------------------------------------------------------\nsection\n------------------------------------------------------------------------*/\nsection div.wrap {\n  flex-direction: column-reverse;\n}\n/*----------------------------------------------------------------------\narticle\n------------------------------------------------------------------------*/\nsection div.wrap > article {\n  padding-left: 0;\n}', '2018-05-15 00:00:00', '2019-06-16 19:25:54', 'administrator', 1, 'css'),
(3, 'sample_portrate', 0, 600, '@charset "utf-8";\n/**\n * lib_landscape.css\n *\n * @copyright  Copyright (c) \n * @version    \n */\nbody {\n  font-size: 15px;\n}\ndiv.wrap {\n  min-width: 360px;\n}\n/*----------------------------------------------------------------------\nsection\n------------------------------------------------------------------------*/\nsection div.wrap {\n  flex-direction: column-reverse;\n}\n/*----------------------------------------------------------------------\narticle\n------------------------------------------------------------------------*/\nsection div.wrap > article {\n  padding-left: 0;\n}', '2018-05-15 00:00:00', '2019-06-16 19:26:03', 'administrator', 1, 'css');


CREATE TABLE IF NOT EXISTS `t_event` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `t_page_ROWID` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `callback` varchar(50) NOT NULL,
  `move_to` varchar(200) DEFAULT NULL,
  `use_session` tinyint(1) DEFAULT '0',
  `content` text NOT NULL,
  `comment` text,
  `is_event` tinyint(1) NOT NULL DEFAULT '1',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `t_fixed` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(200) NOT NULL,
  `function` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL,
  `n_index` smallint(6) NOT NULL,
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;


INSERT INTO `t_fixed` (`ROWID`, `comment`, `function`, `key`, `value`, `n_index`) VALUES
(1, '都道府県', 'pref', '北海道', '北海道', 1),
(2, '都道府県', 'pref', '青森県', '青森県', 2),
(3, '都道府県', 'pref', '岩手県', '岩手県', 3),
(4, '都道府県', 'pref', '宮城県', '宮城県', 4),
(5, '都道府県', 'pref', '秋田県', '秋田県', 5),
(6, '都道府県', 'pref', '山形県', '山形県', 6),
(7, '都道府県', 'pref', '福島県', '福島県', 7),
(8, '都道府県', 'pref', '茨城県', '茨城県', 8),
(9, '都道府県', 'pref', '栃木県', '栃木県', 9),
(10, '都道府県', 'pref', '群馬県', '群馬県', 10),
(11, '都道府県', 'pref', '埼玉県', '埼玉県', 11),
(12, '都道府県', 'pref', '千葉県', '千葉県', 12),
(13, '都道府県', 'pref', '東京都', '東京都', 13),
(14, '都道府県', 'pref', '神奈川県', '神奈川県', 14),
(15, '都道府県', 'pref', '新潟県', '新潟県', 15),
(16, '都道府県', 'pref', '富山県', '富山県', 16),
(17, '都道府県', 'pref', '石川県', '石川県', 17),
(18, '都道府県', 'pref', '福井県', '福井県', 18),
(19, '都道府県', 'pref', '山梨県', '山梨県', 19),
(20, '都道府県', 'pref', '長野県', '長野県', 20),
(21, '都道府県', 'pref', '岐阜県', '岐阜県', 21),
(22, '都道府県', 'pref', '静岡県', '静岡県', 22),
(23, '都道府県', 'pref', '愛知県', '愛知県', 23),
(24, '都道府県', 'pref', '三重県', '三重県', 24),
(25, '都道府県', 'pref', '滋賀県', '滋賀県', 25),
(26, '都道府県', 'pref', '京都府', '京都府', 26),
(27, '都道府県', 'pref', '大阪府', '大阪府', 27),
(28, '都道府県', 'pref', '兵庫県', '兵庫県', 28),
(29, '都道府県', 'pref', '奈良県', '奈良県', 29),
(30, '都道府県', 'pref', '和歌山県', '和歌山県', 30),
(31, '都道府県', 'pref', '鳥取県', '鳥取県', 31),
(32, '都道府県', 'pref', '島根県', '島根県', 32),
(33, '都道府県', 'pref', '岡山県', '岡山県', 33),
(34, '都道府県', 'pref', '広島県', '広島県', 34),
(35, '都道府県', 'pref', '山口県', '山口県', 35),
(36, '都道府県', 'pref', '徳島県', '徳島県', 36),
(37, '都道府県', 'pref', '香川県', '香川県', 37),
(38, '都道府県', 'pref', '愛媛県', '愛媛県', 38),
(39, '都道府県', 'pref', '高知県', '高知県', 39),
(40, '都道府県', 'pref', '福岡県', '福岡県', 40),
(41, '都道府県', 'pref', '佐賀県', '佐賀県', 41),
(42, '都道府県', 'pref', '長崎県', '長崎県', 42),
(43, '都道府県', 'pref', '熊本県', '熊本県', 43),
(44, '都道府県', 'pref', '大分県', '大分県', 44),
(45, '都道府県', 'pref', '宮崎県', '宮崎県', 45),
(46, '都道府県', 'pref', '鹿児島県', '鹿児島県', 46),
(47, '都道府県', 'pref', '沖縄県', '沖縄県', 47),
(48, 'week', 'week', '0', '日', 1),
(49, 'week', 'week', '1', '月', 2),
(50, 'week', 'week', '2', '火', 3),
(51, 'week', 'week', '3', '水', 4),
(52, 'week', 'week', '4', '木', 5),
(53, 'week', 'week', '5', '金', 6),
(54, 'week', 'week', '6', '土', 7),
(55, 'category', 'category', '1', 'category 01', 1),
(56, 'category', 'category', '2', 'category 02', 2),
(57, 'Image folder', 'folder', 'sample', 'sample', 1);


CREATE TABLE IF NOT EXISTS `t_item` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `category` tinyint(4) NOT NULL,
  `title` varchar(200) NOT NULL,
  `tag` varchar(200) NOT NULL,
  `tm_write` datetime NOT NULL,
  `text1` text NOT NULL,
  `text2` text NOT NULL,
  `uri_image` varchar(200) NOT NULL,
  `uri_link` varchar(200) NOT NULL,
  `is_open` tinyint(1) NOT NULL,
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `t_js` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `js_name` varchar(100) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `tm_create` datetime NOT NULL,
  `tm_update` datetime NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `t_note` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `tm_work` datetime NOT NULL,
  `content` text NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `is_released` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `t_page` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `tm_create` datetime NOT NULL,
  `tm_update` datetime NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `header_temp` int(11) NOT NULL,
  `footer_temp` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `keyword` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `page_session` varchar(100) NOT NULL,
  `dir` varchar(200) NOT NULL,
  `variable` varchar(200) NOT NULL,
  `cross_page` tinyint(1) NOT NULL,
  `post_files` tinyint(1) NOT NULL,
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `t_page` (`ROWID`, `tm_create`, `tm_update`, `user_id`, `is_locked`, `page_name`, `url`, `header_temp`, `footer_temp`, `title`, `keyword`, `description`, `content`, `page_session`, `dir`, `variable`, `cross_page`, `post_files`) VALUES
(1, '2019-07-01 00:00:00', '2019-07-01 00:00:00', 'administrator', 0, 'Sample Page', 'sample.html', 1, 2, 'Sample Page', '', '', '<h1>Hello world!</h1>\n<p>\n  Installation of Lib framework is complete.<br>\n  This page is a sample page included in the setup.\n</p>', '', '', '', 0, 0);


CREATE TABLE IF NOT EXISTS `t_rule` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `t_page_ROWID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `len` int(11) NOT NULL,
  `pattern` tinyint(4) NOT NULL DEFAULT '4',
  `pattern_input` varchar(100) NOT NULL,
  `pattern_check` varchar(100) DEFAULT NULL,
  `kana` tinyint(4) NOT NULL DEFAULT '3',
  `kana_input` varchar(10) NOT NULL,
  `kana_check` varchar(10) DEFAULT NULL,
  `def` varchar(50) NOT NULL,
  `req` tinyint(1) NOT NULL,
  `use_session` tinyint(1) NOT NULL,
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `t_template` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `tm_create` datetime NOT NULL,
  `tm_update` datetime NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `tl_name` varchar(100) NOT NULL,
  `tl_type` varchar(10) NOT NULL,
  `content` text NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `t_template` (`ROWID`, `tm_create`, `tm_update`, `user_id`, `is_locked`, `tl_name`, `tl_type`, `content`, `file_name`, `file_path`) VALUES
(1, '2019-07-01 00:00:00', '2019-07-01 00:00:00', 'administrator', 1, '01 Common header', 'header', '<!DOCTYPE html>\n<html lang="ja">\n  <head>\n    <meta charset="utf-8">\n    <title>{#title}</title>\n    <meta name="description" content="{#description}">\n    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=10,user-scalable=yes">\n    <link href="<?= $page->path ?>css/sample_default.css" rel="stylesheet" type="text/css" media="all">\n    <link href="<?= $page->path ?>css/sample_landscape.css" rel="stylesheet" type="text/css" media="only screen and (min-width:601px) and (max-width:768px)">\n    <link href="<?= $page->path ?>css/sample_portrate.css" rel="stylesheet" type="text/css" media="only screen and (max-width:600px)">\n    <script type="text/javascript" src="<?= $page->path ?>js/jquery-1.12.0.min.js"></script>\n    <script>\n    $(function() {\n      var resetViewport = function() {\n        if ($(window).width() < 360) $("meta[name=''viewport'']").attr("content", "width=360");\n        else $("meta[name=''viewport'']").attr("content", "width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=10,user-scalable=yes");\n      }\n      $(window).on("resize", resetViewport);\n      resetViewport();\n    });\n    </script>\n  </head>\n  <body>\n    <header>\n      <div class="wrap clearfix top">\n        <img src="<?= $page->path ?>image/sample/title.png">\n      </div>\n    </header>\n    <section>\n      <div class="wrap clearfix">\n        <nav>\n          <ul>\n            <li><a>Home</a></li>\n            <li><a href="<?= $page->path ?>sample.html" title="sample">Sample</a></li>\n          </ul>\n        </nav>\n        <article>', 'sample_header', 'tmp'),
(2, '2019-07-01 00:00:00', '2019-07-01 00:00:00', 'administrator', 1, '02 Common footer', 'footer', '<!-- -->\n        </article>\n      </div><!-- .wrap -->\n    </section>\n    <footer>\n      <div class="wrap">\n        <p>Copyright &copy; <?= date("Y") ?> All Rights Reserved</p>\n      </div><!-- div.wrap -->\n    </footer>\n  </body>\n</html>', 'sample_footer', 'tmp'),
(3, '2019-07-01 00:00:00', '2019-07-01 00:00:00', 'administrator', 1, '03 Empty header', 'header', '', '', ''),
(4, '2019-07-01 00:00:00', '2019-07-01 00:00:00', 'administrator', 1, '04 Empty footer', 'footer', '', '', '');


CREATE TABLE IF NOT EXISTS `t_todo` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `tm_work` datetime NOT NULL,
  `content` text NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `t_user` (
  `ROWID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `is_developer` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ROWID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `t_user` (`ROWID`, `user_id`, `user_name`, `password`, `is_developer`) VALUES
(1, 'administrator', 'Admin', 'password', 1);
