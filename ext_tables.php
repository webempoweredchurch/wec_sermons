<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_wecsermons_resources"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wecsermons_resources.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, fe_group, description, title, graphic, type",
	)
);

$TCA["tx_wecsermons_resource_type"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_type",		
		"label" => "name",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wecsermons_resource_type.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, fe_group, description, name, graphic",
	)
);


t3lib_extMgm::allowTableOnStandardPages("tx_wecsermons_sermons");


t3lib_extMgm::addToInsertRecords("tx_wecsermons_sermons");

$TCA["tx_wecsermons_sermons"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		'dividers2tabs' => $confArr['noTabDividers']?FALSE:TRUE,
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wecsermons_sermons.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title, occurance_date, description, related_scripture, keywords, graphic, series_uid, topic_uid, record_type, resources_uid, speakers_uid",
	)
);

$TCA["tx_wecsermons_series"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wecsermons_series.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, title, description, scripture, startdate, enddate, liturgical_season_uid, topics_uid, graphic",
	)
);

$TCA["tx_wecsermons_topics"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_topics",		
		"label" => "name",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wecsermons_topics.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, description, title",
	)
);

$TCA["tx_wecsermons_liturgical_season"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_liturgical_season",		
		"label" => "season_name",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wecsermons_liturgical_season.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, season_name",
	)
);

$TCA["tx_wecsermons_speakers"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_speakers",		
		"label" => "firstname",	
		"label_alt" => "lastname, uid",
		"label_alt_force" => TRUE,
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wecsermons_speakers.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, firstname, lastname, email, url, photo",
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';


t3lib_extMgm::addPlugin(Array('LLL:EXT:wec_sermons/locallang_db.php:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY,'pi1/static/','Sermon Repository');
t3lib_extMgm::addPiFlexFormValue($_EXTKEY .'_pi1', 'FILE:EXT:wec_sermons/flexform_ds_pi1.xml');

if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_wecsermons_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_wecsermons_pi1_wizicon.php';
?>