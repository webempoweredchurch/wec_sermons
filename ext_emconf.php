<?php

########################################################################
# Extension Manager/Repository config file for ext: "wec_sermons"
#
# Auto generated 14-03-2007 16:09
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'WEC Sermon Management System',
	'description' => 'Provides centralized management of online resources associated with a sermon',
	'category' => 'plugin',
	'author' => 'Web-Empowered Church Team',
	'author_company' => 'Foundation For Evangelism',
	'author_email' => 'sermon@webempoweredchurch.org',
	'shy' => '',
	'dependencies' => 'wec_api',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'version' => '0.9.4',
	'_md5_values_when_last_written' => 'a:144:{s:9:"ChangeLog";s:4:"4842";s:10:"README.txt";s:4:"9386";s:9:"Thumbs.db";s:4:"5af3";s:39:"class.tx_wecsermons_resourceTypeTca.php";s:4:"e553";s:31:"class.tx_wecsermons_xmlView.php";s:4:"10bb";s:12:"ext_icon.gif";s:4:"0e1f";s:17:"ext_localconf.php";s:4:"d9ae";s:14:"ext_tables.php";s:4:"d98a";s:14:"ext_tables.sql";s:4:"2c55";s:28:"ext_typoscript_constants.txt";s:4:"d41d";s:24:"ext_typoscript_setup.txt";s:4:"d41d";s:19:"flexform_ds_pi1.xml";s:4:"aa81";s:37:"icon_tx_wecsermons_resource_types.gif";s:4:"3a1a";s:32:"icon_tx_wecsermons_resources.gif";s:4:"86f1";s:30:"icon_tx_wecsermons_seasons.gif";s:4:"c430";s:29:"icon_tx_wecsermons_series.gif";s:4:"67c9";s:30:"icon_tx_wecsermons_sermons.gif";s:4:"d132";s:31:"icon_tx_wecsermons_speakers.gif";s:4:"1435";s:29:"icon_tx_wecsermons_topics.gif";s:4:"4d62";s:13:"locallang.php";s:4:"e737";s:16:"locallang_db.php";s:4:"e92e";s:47:"selicon_tx_wecsermons_sermons_record_type_0.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_1.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_2.gif";s:4:"02b6";s:47:"selicon_tx_wecsermons_sermons_record_type_3.gif";s:4:"02b6";s:7:"tca.php";s:4:"1016";s:16:".svn/all-wcprops";s:4:"dd93";s:12:".svn/entries";s:4:"04fb";s:11:".svn/format";s:4:"c30f";s:36:".svn/prop-base/ext_icon.gif.svn-base";s:4:"1131";s:61:".svn/prop-base/icon_tx_wecsermons_resource_types.gif.svn-base";s:4:"1131";s:56:".svn/prop-base/icon_tx_wecsermons_resources.gif.svn-base";s:4:"1131";s:54:".svn/prop-base/icon_tx_wecsermons_seasons.gif.svn-base";s:4:"1131";s:53:".svn/prop-base/icon_tx_wecsermons_series.gif.svn-base";s:4:"1131";s:54:".svn/prop-base/icon_tx_wecsermons_sermons.gif.svn-base";s:4:"1131";s:55:".svn/prop-base/icon_tx_wecsermons_speakers.gif.svn-base";s:4:"1131";s:53:".svn/prop-base/icon_tx_wecsermons_topics.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_0.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_1.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_2.gif.svn-base";s:4:"1131";s:71:".svn/prop-base/selicon_tx_wecsermons_sermons_record_type_3.gif.svn-base";s:4:"1131";s:33:".svn/text-base/ChangeLog.svn-base";s:4:"4842";s:34:".svn/text-base/README.txt.svn-base";s:4:"9386";s:63:".svn/text-base/class.tx_wecsermons_resourceTypeTca.php.svn-base";s:4:"4d64";s:55:".svn/text-base/class.tx_wecsermons_xmlView.php.svn-base";s:4:"3b4b";s:38:".svn/text-base/ext_emconf.php.svn-base";s:4:"13bb";s:36:".svn/text-base/ext_icon.gif.svn-base";s:4:"0e1f";s:41:".svn/text-base/ext_localconf.php.svn-base";s:4:"d9ae";s:38:".svn/text-base/ext_tables.php.svn-base";s:4:"d98a";s:38:".svn/text-base/ext_tables.sql.svn-base";s:4:"2c55";s:52:".svn/text-base/ext_typoscript_constants.txt.svn-base";s:4:"d41d";s:48:".svn/text-base/ext_typoscript_setup.txt.svn-base";s:4:"d41d";s:43:".svn/text-base/flexform_ds_pi1.xml.svn-base";s:4:"aa81";s:61:".svn/text-base/icon_tx_wecsermons_resource_types.gif.svn-base";s:4:"3a1a";s:56:".svn/text-base/icon_tx_wecsermons_resources.gif.svn-base";s:4:"86f1";s:54:".svn/text-base/icon_tx_wecsermons_seasons.gif.svn-base";s:4:"c430";s:53:".svn/text-base/icon_tx_wecsermons_series.gif.svn-base";s:4:"67c9";s:54:".svn/text-base/icon_tx_wecsermons_sermons.gif.svn-base";s:4:"d132";s:55:".svn/text-base/icon_tx_wecsermons_speakers.gif.svn-base";s:4:"1435";s:53:".svn/text-base/icon_tx_wecsermons_topics.gif.svn-base";s:4:"4d62";s:37:".svn/text-base/locallang.php.svn-base";s:4:"e737";s:40:".svn/text-base/locallang_db.php.svn-base";s:4:"e92e";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_0.gif.svn-base";s:4:"02b6";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_1.gif.svn-base";s:4:"02b6";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_2.gif.svn-base";s:4:"02b6";s:71:".svn/text-base/selicon_tx_wecsermons_sermons_record_type_3.gif.svn-base";s:4:"02b6";s:31:".svn/text-base/tca.php.svn-base";s:4:"1016";s:23:".svn/tmp/tempfile.2.tmp";s:4:"4842";s:23:".svn/tmp/tempfile.3.tmp";s:4:"1016";s:23:".svn/tmp/tempfile.4.tmp";s:4:"123e";s:23:".svn/tmp/tempfile.5.tmp";s:4:"30eb";s:23:".svn/tmp/tempfile.6.tmp";s:4:"4842";s:23:".svn/tmp/tempfile.7.tmp";s:4:"1016";s:23:".svn/tmp/tempfile.8.tmp";s:4:"dfd9";s:36:"csh/locallang_csh_resource_types.xml";s:4:"2a24";s:31:"csh/locallang_csh_resources.xml";s:4:"7bcf";s:29:"csh/locallang_csh_seasons.xml";s:4:"ffa2";s:28:"csh/locallang_csh_series.xml";s:4:"f2fb";s:29:"csh/locallang_csh_sermons.xml";s:4:"8fae";s:30:"csh/locallang_csh_speakers.xml";s:4:"5452";s:28:"csh/locallang_csh_topics.xml";s:4:"ac36";s:16:"csh/.svn/entries";s:4:"4524";s:15:"csh/.svn/format";s:4:"c30f";s:60:"csh/.svn/text-base/locallang_csh_resource_types.xml.svn-base";s:4:"2a24";s:55:"csh/.svn/text-base/locallang_csh_resources.xml.svn-base";s:4:"7bcf";s:53:"csh/.svn/text-base/locallang_csh_seasons.xml.svn-base";s:4:"ffa2";s:52:"csh/.svn/text-base/locallang_csh_series.xml.svn-base";s:4:"f2fb";s:53:"csh/.svn/text-base/locallang_csh_sermons.xml.svn-base";s:4:"8fae";s:54:"csh/.svn/text-base/locallang_csh_speakers.xml.svn-base";s:4:"5452";s:52:"csh/.svn/text-base/locallang_csh_topics.xml.svn-base";s:4:"ac36";s:12:"doc/TODO.txt";s:4:"b550";s:13:"doc/Thumbs.db";s:4:"99f1";s:14:"doc/manual.sxw";s:4:"7beb";s:19:"doc/wizard_form.dat";s:4:"0173";s:20:"doc/wizard_form.html";s:4:"c4ce";s:20:"doc/.svn/all-wcprops";s:4:"7447";s:16:"doc/.svn/entries";s:4:"3a4f";s:15:"doc/.svn/format";s:4:"c30f";s:38:"doc/.svn/prop-base/manual.sxw.svn-base";s:4:"1131";s:36:"doc/.svn/text-base/TODO.txt.svn-base";s:4:"b550";s:38:"doc/.svn/text-base/manual.sxw.svn-base";s:4:"7beb";s:43:"doc/.svn/text-base/wizard_form.dat.svn-base";s:4:"0173";s:44:"doc/.svn/text-base/wizard_form.html.svn-base";s:4:"c4ce";s:13:"pi1/Thumbs.db";s:4:"d41b";s:14:"pi1/ce_wiz.gif";s:4:"085e";s:31:"pi1/class.tx_wecsermons_pi1.php";s:4:"7043";s:39:"pi1/class.tx_wecsermons_pi1_wizicon.php";s:4:"f89a";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.php";s:4:"e270";s:19:"pi1/wecsermons.tmpl";s:4:"152d";s:20:"pi1/.svn/all-wcprops";s:4:"589b";s:16:"pi1/.svn/entries";s:4:"790b";s:15:"pi1/.svn/format";s:4:"c30f";s:38:"pi1/.svn/prop-base/ce_wiz.gif.svn-base";s:4:"1131";s:37:"pi1/.svn/prop-base/clear.gif.svn-base";s:4:"1131";s:38:"pi1/.svn/text-base/ce_wiz.gif.svn-base";s:4:"085e";s:55:"pi1/.svn/text-base/class.tx_wecsermons_pi1.php.svn-base";s:4:"6b26";s:63:"pi1/.svn/text-base/class.tx_wecsermons_pi1_wizicon.php.svn-base";s:4:"f89a";s:37:"pi1/.svn/text-base/clear.gif.svn-base";s:4:"cc11";s:41:"pi1/.svn/text-base/locallang.php.svn-base";s:4:"e270";s:43:"pi1/.svn/text-base/wecsermons.tmpl.svn-base";s:4:"152d";s:27:"pi1/.svn/tmp/tempfile.2.tmp";s:4:"b859";s:27:"pi1/.svn/tmp/tempfile.3.tmp";s:4:"c46a";s:28:"res/tt_news_v2_template.html";s:4:"e9b6";s:37:"res/tx_wec_sermons_resource_types.t3d";s:4:"1b65";s:28:"res/tx_wecsermons_styles.css";s:4:"0782";s:16:"res/.svn/entries";s:4:"0f0b";s:15:"res/.svn/format";s:4:"c30f";s:52:"res/.svn/text-base/tt_news_v2_template.html.svn-base";s:4:"e9b6";s:61:"res/.svn/text-base/tx_wec_sermons_resource_types.t3d.svn-base";s:4:"1b65";s:52:"res/.svn/text-base/tx_wecsermons_styles.css.svn-base";s:4:"0782";s:20:"static/constants.txt";s:4:"46a2";s:16:"static/setup.txt";s:4:"6c1b";s:23:"static/.svn/all-wcprops";s:4:"8574";s:19:"static/.svn/entries";s:4:"416f";s:18:"static/.svn/format";s:4:"c30f";s:44:"static/.svn/text-base/constants.txt.svn-base";s:4:"46a2";s:40:"static/.svn/text-base/setup.txt.svn-base";s:4:"6c1b";s:30:"static/.svn/tmp/tempfile.2.tmp";s:4:"6c1b";s:30:"static/.svn/tmp/tempfile.3.tmp";s:4:"6c1b";s:22:"static/style/setup.txt";s:4:"a1bc";s:25:"static/style/.svn/entries";s:4:"692b";s:24:"static/style/.svn/format";s:4:"c30f";s:46:"static/style/.svn/text-base/setup.txt.svn-base";s:4:"a1bc";}',
	'constraints' => array(
		'depends' => array(
			'php' => '4.3.0-0.0.0',
			'wec_api' => '0.9.1-0.0.0',
			'typo3' => '4.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'cron_rte_cleanenc' => '0.1.0-0.0.0',
		),
	),
	'suggests' => array(
	),
);

?>