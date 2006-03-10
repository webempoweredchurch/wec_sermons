<?php

########################################################################
# Extension Manager/Repository config file for ext: "wec_sermons"
# 
# Auto generated 06-03-2006 12:18
# 
# Manual updates:
# Only the data in the array - anything else is removed by next write
########################################################################

$EM_CONF[$_EXTKEY] = Array (
	'title' => 'WEC Sermons Mangement',
	'description' => 'Provides centralized management of online resources associated with a sermon',
	'category' => 'plugin',
	'author' => 'Web Empowered Church Team, Foundation For Evangelism',
	'author_email' => 'wec_sermons@webempoweredchurch.org',
	'shy' => '',
	'dependencies' => '',
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
	'private' => '',
	'download_password' => '',
	'version' => '0.0.0',	// Don't modify this! Managed automatically during upload to repository.
	'_md5_values_when_last_written' => 'a:103:{s:9:"ChangeLog";s:4:"aba6";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"5871";s:14:"ext_tables.php";s:4:"7c75";s:14:"ext_tables.sql";s:4:"20db";s:19:"flexform_ds_pi1.xml";s:4:"9924";s:40:"icon_tx_wecsermons_liturgical_season.gif";s:4:"475a";s:36:"icon_tx_wecsermons_resource_type.gif";s:4:"475a";s:32:"icon_tx_wecsermons_resources.gif";s:4:"78eb";s:29:"icon_tx_wecsermons_series.gif";s:4:"475a";s:30:"icon_tx_wecsermons_sermons.gif";s:4:"475a";s:31:"icon_tx_wecsermons_speakers.gif";s:4:"475a";s:29:"icon_tx_wecsermons_topics.gif";s:4:"475a";s:13:"locallang.php";s:4:"b6c1";s:16:"locallang_db.php";s:4:"5b1c";s:47:"selicon_tx_wecsermons_sermons_record_type_0.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_1.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_2.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_3.gif";s:4:"02b6";s:7:"tca.php";s:4:"a786";s:15:".svn/README.txt";s:4:"feca";s:15:".svn/empty-file";s:4:"d41d";s:12:".svn/entries";s:4:"f44e";s:11:".svn/format";s:4:"48a2";s:33:".svn/prop-base/ChangeLog.svn-base";s:4:"d41d";s:34:".svn/prop-base/README.txt.svn-base";s:4:"d41d";s:38:".svn/prop-base/ext_emconf.php.svn-base";s:4:"d41d";s:36:".svn/prop-base/ext_icon.gif.svn-base";s:4:"1131";s:64:".svn/prop-base/icon_tx_wecsermons_liturgical_season.gif.svn-base";s:4:"1131";s:60:".svn/prop-base/icon_tx_wecsermons_resource_type.gif.svn-base";s:4:"1131";s:56:".svn/prop-base/icon_tx_wecsermons_resources.gif.svn-base";s:4:"1131";s:53:".svn/prop-base/icon_tx_wecsermons_series.gif.svn-base";s:4:"1131";s:54:".svn/prop-base/icon_tx_wecsermons_sermons.gif.svn-base";s:4:"1131";s:55:".svn/prop-base/icon_tx_wecsermons_speakers.gif.svn-base";s:4:"1131";s:53:".svn/prop-base/icon_tx_wecsermons_topics.gif.svn-base";s:4:"1131";s:29:".svn/props/ChangeLog.svn-work";s:4:"d41d";s:30:".svn/props/README.txt.svn-work";s:4:"d41d";s:34:".svn/props/ext_emconf.php.svn-work";s:4:"d41d";s:32:".svn/props/ext_icon.gif.svn-work";s:4:"1131";s:60:".svn/props/icon_tx_wecsermons_liturgical_season.gif.svn-work";s:4:"1131";s:56:".svn/props/icon_tx_wecsermons_resource_type.gif.svn-work";s:4:"1131";s:52:".svn/props/icon_tx_wecsermons_resources.gif.svn-work";s:4:"1131";s:49:".svn/props/icon_tx_wecsermons_series.gif.svn-work";s:4:"1131";s:50:".svn/props/icon_tx_wecsermons_sermons.gif.svn-work";s:4:"1131";s:51:".svn/props/icon_tx_wecsermons_speakers.gif.svn-work";s:4:"1131";s:49:".svn/props/icon_tx_wecsermons_topics.gif.svn-work";s:4:"1131";s:33:".svn/text-base/ChangeLog.svn-base";s:4:"9ff3";s:34:".svn/text-base/README.txt.svn-base";s:4:"ee2d";s:38:".svn/text-base/ext_emconf.php.svn-base";s:4:"5bba";s:36:".svn/text-base/ext_icon.gif.svn-base";s:4:"1bdc";s:41:".svn/text-base/ext_localconf.php.svn-base";s:4:"5871";s:38:".svn/text-base/ext_tables.php.svn-base";s:4:"3c41";s:38:".svn/text-base/ext_tables.sql.svn-base";s:4:"eeb3";s:43:".svn/text-base/flexform_ds_pi1.xml.svn-base";s:4:"9924";s:64:".svn/text-base/icon_tx_wecsermons_liturgical_season.gif.svn-base";s:4:"475a";s:60:".svn/text-base/icon_tx_wecsermons_resource_type.gif.svn-base";s:4:"475a";s:56:".svn/text-base/icon_tx_wecsermons_resources.gif.svn-base";s:4:"78eb";s:53:".svn/text-base/icon_tx_wecsermons_series.gif.svn-base";s:4:"475a";s:54:".svn/text-base/icon_tx_wecsermons_sermons.gif.svn-base";s:4:"475a";s:55:".svn/text-base/icon_tx_wecsermons_speakers.gif.svn-base";s:4:"475a";s:53:".svn/text-base/icon_tx_wecsermons_topics.gif.svn-base";s:4:"475a";s:37:".svn/text-base/locallang.php.svn-base";s:4:"b6c1";s:40:".svn/text-base/locallang_db.php.svn-base";s:4:"b581";s:31:".svn/text-base/tca.php.svn-base";s:4:"8144";s:14:"doc/manual.sxw";s:4:"656f";s:19:"doc/wizard_form.dat";s:4:"0173";s:20:"doc/wizard_form.html";s:4:"c4ce";s:19:"doc/.svn/README.txt";s:4:"feca";s:19:"doc/.svn/empty-file";s:4:"d41d";s:16:"doc/.svn/entries";s:4:"3990";s:15:"doc/.svn/format";s:4:"48a2";s:38:"doc/.svn/prop-base/manual.sxw.svn-base";s:4:"1131";s:34:"doc/.svn/props/manual.sxw.svn-work";s:4:"1131";s:38:"doc/.svn/text-base/manual.sxw.svn-base";s:4:"656f";s:43:"doc/.svn/text-base/wizard_form.dat.svn-base";s:4:"2ae2";s:44:"doc/.svn/text-base/wizard_form.html.svn-base";s:4:"d810";s:14:"pi1/ce_wiz.gif";s:4:"02b6";s:31:"pi1/class.tx_wecsermons_pi1.php";s:4:"bb45";s:39:"pi1/class.tx_wecsermons_pi1_wizicon.php";s:4:"f89a";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.php";s:4:"646f";s:19:"pi1/.svn/README.txt";s:4:"feca";s:19:"pi1/.svn/empty-file";s:4:"d41d";s:16:"pi1/.svn/entries";s:4:"7f9d";s:15:"pi1/.svn/format";s:4:"48a2";s:38:"pi1/.svn/prop-base/ce_wiz.gif.svn-base";s:4:"1131";s:37:"pi1/.svn/prop-base/clear.gif.svn-base";s:4:"1131";s:34:"pi1/.svn/props/ce_wiz.gif.svn-work";s:4:"1131";s:33:"pi1/.svn/props/clear.gif.svn-work";s:4:"1131";s:38:"pi1/.svn/text-base/ce_wiz.gif.svn-base";s:4:"02b6";s:55:"pi1/.svn/text-base/class.tx_wecsermons_pi1.php.svn-base";s:4:"10d8";s:63:"pi1/.svn/text-base/class.tx_wecsermons_pi1_wizicon.php.svn-base";s:4:"f89a";s:37:"pi1/.svn/text-base/clear.gif.svn-base";s:4:"cc11";s:41:"pi1/.svn/text-base/locallang.php.svn-base";s:4:"68bf";s:24:"pi1/static/editorcfg.txt";s:4:"63a1";s:20:"pi1/static/setup.txt";s:4:"c791";s:26:"pi1/static/.svn/README.txt";s:4:"feca";s:26:"pi1/static/.svn/empty-file";s:4:"d41d";s:23:"pi1/static/.svn/entries";s:4:"3cfa";s:22:"pi1/static/.svn/format";s:4:"48a2";s:48:"pi1/static/.svn/text-base/editorcfg.txt.svn-base";s:4:"63a1";s:44:"pi1/static/.svn/text-base/setup.txt.svn-base";s:4:"c791";}',
);

?>