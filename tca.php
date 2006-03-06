<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_wecsermons_resources"] = Array (
	"ctrl" => $TCA["tx_wecsermons_resources"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,fe_group,description,title,graphic,type"
	),
	"feInterface" => $TCA["tx_wecsermons_resources"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_wecsermons_resources',
				'foreign_table_where' => 'AND tx_wecsermons_resources.pid=###CURRENT_PID### AND tx_wecsermons_resources.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"description" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.description",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"graphic" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.graphic",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 500,	
				"uploadfolder" => "uploads/tx_wecsermons",
				"show_thumbs" => 1,	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.type",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wecsermons_resource_type",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], title;;;;2-2-2, graphic;;;;3-3-3, type")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "fe_group")
	)
);



$TCA["tx_wecsermons_resource_type"] = Array (
	"ctrl" => $TCA["tx_wecsermons_resource_type"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,fe_group,description,name,graphic"
	),
	"feInterface" => $TCA["tx_wecsermons_resource_type"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_wecsermons_resource_type',
				'foreign_table_where' => 'AND tx_wecsermons_resource_type.pid=###CURRENT_PID### AND tx_wecsermons_resource_type.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"description" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_type.description",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_type.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"graphic" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_type.graphic",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 500,	
				"uploadfolder" => "uploads/tx_wecsermons",
				"show_thumbs" => 1,	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], name, graphic")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "fe_group")
	)
);



$TCA["tx_wecsermons_sermons"] = Array (
	"ctrl" => $TCA["tx_wecsermons_sermons"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title,occurance_date,description,related_scripture,keywords,graphic,series_uid,topic_uid,entry_type,resources_uid"
	),
	"feInterface" => $TCA["tx_wecsermons_sermons"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_wecsermons_sermons',
				'foreign_table_where' => 'AND tx_wecsermons_sermons.pid=###CURRENT_PID### AND tx_wecsermons_sermons.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"occurance_date" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.occurance_date",		
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"description" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.description",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"related_scripture" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.related_scripture",		
			"config" => Array (
				"type" => "input",	
				"size" => "48",
			)
		),
		"keywords" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.keywords",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"graphic" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.graphic",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 500,	
				"uploadfolder" => "uploads/tx_wecsermons",
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"series_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.series_uid",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wecsermons_series",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"topic_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.topic_uid",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_wecsermons_topics",	
				"foreign_table_where" => "AND tx_wecsermons_topics.pid=###STORAGE_PID### ORDER BY tx_wecsermons_topics.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"entry_type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.entry_type",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.entry_type.I.0", "0"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.entry_type.I.1", "1"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.entry_type.I.2", "2"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"resources_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.resources_uid",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wecsermons_resources",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 100,	
				"MM" => "tx_wecsermons_sermons_resources_uid_mm",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, occurance_date;;;;3-3-3, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], related_scripture, keywords, graphic, series_uid, topic_uid, entry_type, resources_uid")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_wecsermons_series"] = Array (
	"ctrl" => $TCA["tx_wecsermons_series"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,title,description,scripture,startdate,enddate,graphic,liturgical_season_uid"
	),
	"feInterface" => $TCA["tx_wecsermons_series"]["feInterface"],
	"columns" => Array (
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"description" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.description",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"scripture" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.scripture",		
			"config" => Array (
				"type" => "input",	
				"size" => "48",
			)
		),
		"startdate" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.startdate",		
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"enddate" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.enddate",		
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"graphic" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.graphic",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 500,	
				"uploadfolder" => "uploads/tx_wecsermons",
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"liturgical_season_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.liturgical_season_uid",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_wecsermons_liturgical_season",	
				"foreign_table_where" => "AND tx_wecsermons_liturgical_season.pid=###STORAGE_PID### ORDER BY tx_wecsermons_liturgical_season.uid",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 10,
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, title;;;;2-2-2, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts];3-3-3, scripture, startdate, enddate, graphic, liturgical_season_uid")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wecsermons_topics"] = Array (
	"ctrl" => $TCA["tx_wecsermons_topics"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,description,name"
	),
	"feInterface" => $TCA["tx_wecsermons_topics"]["feInterface"],
	"columns" => Array (
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"description" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_topics.description",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_topics.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], name")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wecsermons_liturgical_season"] = Array (
	"ctrl" => $TCA["tx_wecsermons_liturgical_season"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,season_name"
	),
	"feInterface" => $TCA["tx_wecsermons_liturgical_season"]["feInterface"],
	"columns" => Array (
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"season_name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_liturgical_season.season_name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, season_name")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);
?>