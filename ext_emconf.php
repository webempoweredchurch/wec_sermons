<?php

########################################################################
# Extension Manager/Repository config file for ext: "wec_sermons"
#
# Auto generated 03-01-2007 13:38
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'WEC Sermon Management System',
	'description' => 'Provides centralized management of online resources associated with a sermon',
	'category' => 'plugin',
	'author' => 'Web Empowered Church Team, Foundation For Evangelism',
	'author_email' => 'sermon@webempoweredchurch.org',
	'shy' => '',
	'dependencies' => 'wec_api',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.9.0',
	'_md5_values_when_last_written' => 'a:248:{s:9:"ChangeLog";s:4:"7633";s:10:"README.txt";s:4:"9386";s:39:"class.tx_wecsermons_resourceTypeTca.php";s:4:"d2df";s:31:"class.tx_wecsermons_xmlView.php";s:4:"3b4b";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"79ca";s:14:"ext_tables.php";s:4:"76fd";s:14:"ext_tables.sql";s:4:"073f";s:28:"ext_typoscript_constants.txt";s:4:"d41d";s:24:"ext_typoscript_setup.txt";s:4:"d41d";s:19:"flexform_ds_pi1.xml";s:4:"c958";s:37:"icon_tx_wecsermons_resource_types.gif";s:4:"475a";s:32:"icon_tx_wecsermons_resources.gif";s:4:"78eb";s:30:"icon_tx_wecsermons_seasons.gif";s:4:"475a";s:29:"icon_tx_wecsermons_series.gif";s:4:"475a";s:30:"icon_tx_wecsermons_sermons.gif";s:4:"475a";s:31:"icon_tx_wecsermons_speakers.gif";s:4:"475a";s:29:"icon_tx_wecsermons_topics.gif";s:4:"475a";s:13:"locallang.php";s:4:"e209";s:16:"locallang_db.php";s:4:"d2e7";s:47:"selicon_tx_wecsermons_sermons_record_type_0.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_1.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_2.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_3.gif";s:4:"02b6";s:7:"tca.php";s:4:"e7fc";s:16:".svn/all-wcprops";s:4:"71bc";s:12:".svn/entries";s:4:"6244";s:11:".svn/format";s:4:"c30f";s:36:".svn/prop-base/ext_icon.gif.svn-base";s:4:"1131";s:61:".svn/prop-base/icon_tx_wecsermons_resource_types.gif.svn-base";s:4:"1131";s:56:".svn/prop-base/icon_tx_wecsermons_resources.gif.svn-base";s:4:"1131";s:54:".svn/prop-base/icon_tx_wecsermons_seasons.gif.svn-base";s:4:"1131";s:53:".svn/prop-base/icon_tx_wecsermons_series.gif.svn-base";s:4:"1131";s:54:".svn/prop-base/icon_tx_wecsermons_sermons.gif.svn-base";s:4:"1131";s:55:".svn/prop-base/icon_tx_wecsermons_speakers.gif.svn-base";s:4:"1131";s:53:".svn/prop-base/icon_tx_wecsermons_topics.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_0.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_1.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_2.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_3.gif.svn-base";s:4:"1131";s:33:".svn/text-base/ChangeLog.svn-base";s:4:"7633";s:34:".svn/text-base/README.txt.svn-base";s:4:"9386";s:63:".svn/text-base/class.tx_wecsermons_resourceTypeTca.php.svn-base";s:4:"d2df";s:55:".svn/text-base/class.tx_wecsermons_xmlView.php.svn-base";s:4:"3b4b";s:38:".svn/text-base/ext_emconf.php.svn-base";s:4:"86c0";s:36:".svn/text-base/ext_icon.gif.svn-base";s:4:"1bdc";s:41:".svn/text-base/ext_localconf.php.svn-base";s:4:"79ca";s:38:".svn/text-base/ext_tables.php.svn-base";s:4:"76fd";s:38:".svn/text-base/ext_tables.sql.svn-base";s:4:"21b7";s:52:".svn/text-base/ext_typoscript_constants.txt.svn-base";s:4:"d41d";s:48:".svn/text-base/ext_typoscript_setup.txt.svn-base";s:4:"d41d";s:43:".svn/text-base/flexform_ds_pi1.xml.svn-base";s:4:"c958";s:61:".svn/text-base/icon_tx_wecsermons_resource_types.gif.svn-base";s:4:"475a";s:56:".svn/text-base/icon_tx_wecsermons_resources.gif.svn-base";s:4:"78eb";s:54:".svn/text-base/icon_tx_wecsermons_seasons.gif.svn-base";s:4:"475a";s:53:".svn/text-base/icon_tx_wecsermons_series.gif.svn-base";s:4:"475a";s:54:".svn/text-base/icon_tx_wecsermons_sermons.gif.svn-base";s:4:"475a";s:55:".svn/text-base/icon_tx_wecsermons_speakers.gif.svn-base";s:4:"475a";s:53:".svn/text-base/icon_tx_wecsermons_topics.gif.svn-base";s:4:"475a";s:37:".svn/text-base/locallang.php.svn-base";s:4:"e209";s:40:".svn/text-base/locallang_db.php.svn-base";s:4:"b0cf";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_0.gif.svn-base";s:4:"02b6";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_1.gif.svn-base";s:4:"02b6";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_2.gif.svn-base";s:4:"02b6";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_3.gif.svn-base";s:4:"02b6";s:31:".svn/text-base/tca.php.svn-base";s:4:"941c";s:36:"csh/locallang_csh_resource_types.xml";s:4:"61c8";s:31:"csh/locallang_csh_resources.xml";s:4:"7bcf";s:29:"csh/locallang_csh_seasons.xml";s:4:"ffa2";s:28:"csh/locallang_csh_series.xml";s:4:"f2fb";s:29:"csh/locallang_csh_sermons.xml";s:4:"8fae";s:30:"csh/locallang_csh_speakers.xml";s:4:"5452";s:28:"csh/locallang_csh_topics.xml";s:4:"ac36";s:20:"csh/.svn/all-wcprops";s:4:"5c77";s:16:"csh/.svn/entries";s:4:"5fa5";s:15:"csh/.svn/format";s:4:"c30f";s:60:"csh/.svn/text-base/locallang_csh_resource_types.xml.svn-base";s:4:"61c8";s:55:"csh/.svn/text-base/locallang_csh_resources.xml.svn-base";s:4:"7bcf";s:53:"csh/.svn/text-base/locallang_csh_seasons.xml.svn-base";s:4:"ffa2";s:52:"csh/.svn/text-base/locallang_csh_series.xml.svn-base";s:4:"f2fb";s:53:"csh/.svn/text-base/locallang_csh_sermons.xml.svn-base";s:4:"8fae";s:54:"csh/.svn/text-base/locallang_csh_speakers.xml.svn-base";s:4:"5452";s:52:"csh/.svn/text-base/locallang_csh_topics.xml.svn-base";s:4:"ac36";s:12:"doc/TODO.txt";s:4:"5dbe";s:14:"doc/manual.sxw";s:4:"a1b4";s:19:"doc/wizard_form.dat";s:4:"0173";s:20:"doc/wizard_form.html";s:4:"c4ce";s:16:"doc/.svn/entries";s:4:"573a";s:15:"doc/.svn/format";s:4:"c30f";s:38:"doc/.svn/prop-base/manual.sxw.svn-base";s:4:"1131";s:36:"doc/.svn/text-base/TODO.txt.svn-base";s:4:"5dbe";s:38:"doc/.svn/text-base/manual.sxw.svn-base";s:4:"a1b4";s:43:"doc/.svn/text-base/wizard_form.dat.svn-base";s:4:"0173";s:44:"doc/.svn/text-base/wizard_form.html.svn-base";s:4:"c4ce";s:14:"pi1/ce_wiz.gif";s:4:"6155";s:31:"pi1/class.tx_wecsermons_pi1.php";s:4:"4b23";s:39:"pi1/class.tx_wecsermons_pi1_wizicon.php";s:4:"f89a";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.php";s:4:"e270";s:19:"pi1/wecsermons.tmpl";s:4:"596f";s:20:"pi1/.svn/all-wcprops";s:4:"b4a2";s:16:"pi1/.svn/entries";s:4:"24f4";s:15:"pi1/.svn/format";s:4:"c30f";s:38:"pi1/.svn/prop-base/ce_wiz.gif.svn-base";s:4:"1131";s:37:"pi1/.svn/prop-base/clear.gif.svn-base";s:4:"1131";s:38:"pi1/.svn/text-base/ce_wiz.gif.svn-base";s:4:"6155";s:55:"pi1/.svn/text-base/class.tx_wecsermons_pi1.php.svn-base";s:4:"4b23";s:63:"pi1/.svn/text-base/class.tx_wecsermons_pi1_wizicon.php.svn-base";s:4:"f89a";s:37:"pi1/.svn/text-base/clear.gif.svn-base";s:4:"cc11";s:41:"pi1/.svn/text-base/locallang.php.svn-base";s:4:"e270";s:43:"pi1/.svn/text-base/wecsermons.tmpl.svn-base";s:4:"596f";s:28:"res/tt_news_v2_template.html";s:4:"e9b6";s:37:"res/tx_wec_sermons_resource_types.t3d";s:4:"645a";s:28:"res/tx_wecsermons_styles.css";s:4:"6ce8";s:20:"res/.svn/all-wcprops";s:4:"8ba5";s:16:"res/.svn/entries";s:4:"be93";s:15:"res/.svn/format";s:4:"c30f";s:52:"res/.svn/text-base/tt_news_v2_template.html.svn-base";s:4:"e9b6";s:61:"res/.svn/text-base/tx_wec_sermons_resource_types.t3d.svn-base";s:4:"645a";s:52:"res/.svn/text-base/tx_wecsermons_styles.css.svn-base";s:4:"6ce8";s:20:"static/constants.txt";s:4:"abbc";s:16:"static/setup.txt";s:4:"190d";s:23:"static/.svn/all-wcprops";s:4:"3e00";s:19:"static/.svn/entries";s:4:"8f01";s:18:"static/.svn/format";s:4:"c30f";s:44:"static/.svn/text-base/constants.txt.svn-base";s:4:"abbc";s:40:"static/.svn/text-base/setup.txt.svn-base";s:4:"1aa6";s:28:"static/podcast/constants.txt";s:4:"d41d";s:24:"static/podcast/setup.txt";s:4:"d41d";s:16:"tut/.svn/entries";s:4:"fcee";s:15:"tut/.svn/format";s:4:"c30f";s:22:"tut/ging/list_view.htm";s:4:"d020";s:22:"tut/ging/study_exp.htm";s:4:"c030";s:23:"tut/ging/study_view.htm";s:4:"63b2";s:21:"tut/ging/.svn/entries";s:4:"3e89";s:20:"tut/ging/.svn/format";s:4:"c30f";s:46:"tut/ging/.svn/text-base/list_view.htm.svn-base";s:4:"d020";s:46:"tut/ging/.svn/text-base/study_exp.htm.svn-base";s:4:"c030";s:47:"tut/ging/.svn/text-base/study_view.htm.svn-base";s:4:"63b2";s:26:"tut/ging/images/bbbook.gif";s:4:"5991";s:26:"tut/ging/images/bbfind.gif";s:4:"39be";s:26:"tut/ging/images/bbmain.gif";s:4:"0815";s:28:"tut/ging/images/bbminist.gif";s:4:"cb06";s:27:"tut/ging/images/bbwhats.gif";s:4:"58ba";s:27:"tut/ging/images/bbwhowe.gif";s:4:"a351";s:27:"tut/ging/images/header3.jpg";s:4:"360c";s:31:"tut/ging/images/mar0506a_01.jpg";s:4:"9b84";s:25:"tut/ging/images/pixel.gif";s:4:"41c9";s:27:"tut/ging/images/podcast.jpg";s:4:"3e40";s:26:"tut/ging/images/sermon.css";s:4:"67ad";s:26:"tut/ging/images/styles.css";s:4:"074f";s:23:"tut/ging/images/xml.gif";s:4:"e67c";s:28:"tut/ging/images/.svn/entries";s:4:"244b";s:27:"tut/ging/images/.svn/format";s:4:"c30f";s:50:"tut/ging/images/.svn/prop-base/bbbook.gif.svn-base";s:4:"1131";s:50:"tut/ging/images/.svn/prop-base/bbfind.gif.svn-base";s:4:"1131";s:50:"tut/ging/images/.svn/prop-base/bbmain.gif.svn-base";s:4:"1131";s:52:"tut/ging/images/.svn/prop-base/bbminist.gif.svn-base";s:4:"1131";s:51:"tut/ging/images/.svn/prop-base/bbwhats.gif.svn-base";s:4:"1131";s:51:"tut/ging/images/.svn/prop-base/bbwhowe.gif.svn-base";s:4:"1131";s:51:"tut/ging/images/.svn/prop-base/header3.jpg.svn-base";s:4:"1131";s:55:"tut/ging/images/.svn/prop-base/mar0506a_01.jpg.svn-base";s:4:"1131";s:49:"tut/ging/images/.svn/prop-base/pixel.gif.svn-base";s:4:"1131";s:51:"tut/ging/images/.svn/prop-base/podcast.jpg.svn-base";s:4:"1131";s:47:"tut/ging/images/.svn/prop-base/xml.gif.svn-base";s:4:"1131";s:50:"tut/ging/images/.svn/text-base/bbbook.gif.svn-base";s:4:"5991";s:50:"tut/ging/images/.svn/text-base/bbfind.gif.svn-base";s:4:"39be";s:50:"tut/ging/images/.svn/text-base/bbmain.gif.svn-base";s:4:"0815";s:52:"tut/ging/images/.svn/text-base/bbminist.gif.svn-base";s:4:"cb06";s:51:"tut/ging/images/.svn/text-base/bbwhats.gif.svn-base";s:4:"58ba";s:51:"tut/ging/images/.svn/text-base/bbwhowe.gif.svn-base";s:4:"a351";s:51:"tut/ging/images/.svn/text-base/header3.jpg.svn-base";s:4:"360c";s:55:"tut/ging/images/.svn/text-base/mar0506a_01.jpg.svn-base";s:4:"9b84";s:49:"tut/ging/images/.svn/text-base/pixel.gif.svn-base";s:4:"41c9";s:51:"tut/ging/images/.svn/text-base/podcast.jpg.svn-base";s:4:"3e40";s:50:"tut/ging/images/.svn/text-base/sermon.css.svn-base";s:4:"67ad";s:50:"tut/ging/images/.svn/text-base/styles.css.svn-base";s:4:"074f";s:47:"tut/ging/images/.svn/text-base/xml.gif.svn-base";s:4:"e67c";s:33:"tut/living_water/archive_view.htm";s:4:"681c";s:32:"tut/living_water/series_view.htm";s:4:"67a0";s:32:"tut/living_water/single_view.htm";s:4:"0394";s:29:"tut/living_water/.svn/entries";s:4:"a40b";s:28:"tut/living_water/.svn/format";s:4:"c30f";s:57:"tut/living_water/.svn/text-base/archive_view.htm.svn-base";s:4:"681c";s:56:"tut/living_water/.svn/text-base/series_view.htm.svn-base";s:4:"67a0";s:56:"tut/living_water/.svn/text-base/single_view.htm.svn-base";s:4:"0394";s:36:"tut/living_water/images/Jesusweb.jpg";s:4:"cc5e";s:35:"tut/living_water/images/Markweb.jpg";s:4:"c548";s:36:"tut/living_water/images/calendar.gif";s:4:"46ca";s:35:"tut/living_water/images/connect.gif";s:4:"6b05";s:32:"tut/living_water/images/food.jpg";s:4:"1895";s:34:"tut/living_water/images/global.css";s:4:"f45f";s:33:"tut/living_water/images/global.js";s:4:"7541";s:34:"tut/living_water/images/header.jpg";s:4:"95da";s:36:"tut/living_water/images/icon_mp3.gif";s:4:"0401";s:40:"tut/living_water/images/icon_podcast.gif";s:4:"4447";s:40:"tut/living_water/images/icon_speaker.gif";s:4:"4499";s:33:"tut/living_water/images/oasis.gif";s:4:"ee96";s:33:"tut/living_water/images/serve.gif";s:4:"dcb1";s:38:"tut/living_water/images/sub_footer.gif";s:4:"63f5";s:39:"tut/living_water/images/sub_worship.gif";s:4:"c0b4";s:31:"tut/living_water/images/who.gif";s:4:"e2be";s:35:"tut/living_water/images/worship.gif";s:4:"a661";s:36:"tut/living_water/images/.svn/entries";s:4:"e53c";s:35:"tut/living_water/images/.svn/format";s:4:"c30f";s:60:"tut/living_water/images/.svn/prop-base/Jesusweb.jpg.svn-base";s:4:"1131";s:59:"tut/living_water/images/.svn/prop-base/Markweb.jpg.svn-base";s:4:"1131";s:60:"tut/living_water/images/.svn/prop-base/calendar.gif.svn-base";s:4:"1131";s:59:"tut/living_water/images/.svn/prop-base/connect.gif.svn-base";s:4:"1131";s:56:"tut/living_water/images/.svn/prop-base/food.jpg.svn-base";s:4:"1131";s:58:"tut/living_water/images/.svn/prop-base/header.jpg.svn-base";s:4:"1131";s:60:"tut/living_water/images/.svn/prop-base/icon_mp3.gif.svn-base";s:4:"1131";s:64:"tut/living_water/images/.svn/prop-base/icon_podcast.gif.svn-base";s:4:"1131";s:64:"tut/living_water/images/.svn/prop-base/icon_speaker.gif.svn-base";s:4:"1131";s:57:"tut/living_water/images/.svn/prop-base/oasis.gif.svn-base";s:4:"1131";s:57:"tut/living_water/images/.svn/prop-base/serve.gif.svn-base";s:4:"1131";s:62:"tut/living_water/images/.svn/prop-base/sub_footer.gif.svn-base";s:4:"1131";s:63:"tut/living_water/images/.svn/prop-base/sub_worship.gif.svn-base";s:4:"1131";s:55:"tut/living_water/images/.svn/prop-base/who.gif.svn-base";s:4:"1131";s:59:"tut/living_water/images/.svn/prop-base/worship.gif.svn-base";s:4:"1131";s:60:"tut/living_water/images/.svn/text-base/Jesusweb.jpg.svn-base";s:4:"cc5e";s:59:"tut/living_water/images/.svn/text-base/Markweb.jpg.svn-base";s:4:"c548";s:60:"tut/living_water/images/.svn/text-base/calendar.gif.svn-base";s:4:"46ca";s:59:"tut/living_water/images/.svn/text-base/connect.gif.svn-base";s:4:"6b05";s:56:"tut/living_water/images/.svn/text-base/food.jpg.svn-base";s:4:"1895";s:58:"tut/living_water/images/.svn/text-base/global.css.svn-base";s:4:"f45f";s:57:"tut/living_water/images/.svn/text-base/global.js.svn-base";s:4:"7541";s:58:"tut/living_water/images/.svn/text-base/header.jpg.svn-base";s:4:"95da";s:60:"tut/living_water/images/.svn/text-base/icon_mp3.gif.svn-base";s:4:"0401";s:64:"tut/living_water/images/.svn/text-base/icon_podcast.gif.svn-base";s:4:"4447";s:64:"tut/living_water/images/.svn/text-base/icon_speaker.gif.svn-base";s:4:"4499";s:57:"tut/living_water/images/.svn/text-base/oasis.gif.svn-base";s:4:"ee96";s:57:"tut/living_water/images/.svn/text-base/serve.gif.svn-base";s:4:"dcb1";s:62:"tut/living_water/images/.svn/text-base/sub_footer.gif.svn-base";s:4:"63f5";s:63:"tut/living_water/images/.svn/text-base/sub_worship.gif.svn-base";s:4:"c0b4";s:55:"tut/living_water/images/.svn/text-base/who.gif.svn-base";s:4:"e2be";s:59:"tut/living_water/images/.svn/text-base/worship.gif.svn-base";s:4:"a661";s:41:"tut/living_water/images/interface/bkg.jpg";s:4:"a95e";s:45:"tut/living_water/images/interface/sub_bkg.gif";s:4:"85f7";s:48:"tut/living_water/images/interface/sub_bullet.gif";s:4:"6d0d";s:46:"tut/living_water/images/interface/.svn/entries";s:4:"3430";s:45:"tut/living_water/images/interface/.svn/format";s:4:"c30f";s:65:"tut/living_water/images/interface/.svn/prop-base/bkg.jpg.svn-base";s:4:"1131";s:69:"tut/living_water/images/interface/.svn/prop-base/sub_bkg.gif.svn-base";s:4:"1131";s:72:"tut/living_water/images/interface/.svn/prop-base/sub_bullet.gif.svn-base";s:4:"1131";s:65:"tut/living_water/images/interface/.svn/text-base/bkg.jpg.svn-base";s:4:"a95e";s:69:"tut/living_water/images/interface/.svn/text-base/sub_bkg.gif.svn-base";s:4:"85f7";s:72:"tut/living_water/images/interface/.svn/text-base/sub_bullet.gif.svn-base";s:4:"6d0d";}',
	'constraints' => array(
		'depends' => array(
			'wec_api' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'cron_rte_cleanenc' => '',
		),
	),
	'suggests' => array(
	),
);

?>