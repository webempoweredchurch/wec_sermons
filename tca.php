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
				"type" => "select",
				"items" => Array (
					Array('LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.type.I.0',0),
					Array('LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.type.I.1','plugin'),
				),
				"size" => 1,	
				"maxitems" => 1,
				"itemsProcFunc" => 'tx_wecsermons_resourceTypeTca->resourceType_items',
			)
		),
		'file' => Array (
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.file',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	// Must be empty for disallowed to work.
				'disallowed' => 'php,php3',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/tx_wecsermons',
				'show_thumbs' => '1',
				'size' => 1,
				'autoSizeMax' => 1,
				'maxitems' => 1,
				'minitems' => 0,
			)
		),
		"url" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.url",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				'wizards' => Array(
					'_PADDING' => 2,
					'link' => Array(
						'type' => 'popup',
						'title' => 'Link',
						'icon' => 'link_popup.gif',
						'script' => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
		"querystring_param" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.querystring_param",		
			"config" => Array (
				"type" => "input",
				"size" => "30",	
			)
		),
		"rendered_record" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.rendered_record",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "db",
				"allowed" => "*",	
				"prepend_tname" => 0,
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
			),
		),	
		"marker_name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.marker_name",		
			"config" => Array (
				"type" => "input",
				"size" => "30",	
				"eval" => "required,upper,nospace",
			)
		),
		"template_name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.template_name",		
			"config" => Array (
				"type" => "input",
				"size" => "30",	
				"eval" => "required,upper,nospace",
			)
		),
		"mime_type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resources.mime_type",		
			"config" => Array (
				"type" => "input",
				"size" => "30",	
				"eval" => "required",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n _diffsource, hidden;;1, title;;;;2-2-2, type, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts],  graphic;;;;3-3-3, file;;;;4-4-4,url"),
		"plugin" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n _diffsource, hidden;;1, title;;;;2-2-2, type, querystring_param, rendered_record, marker_name, template_name"),
	),
	"palettes" => Array (
		"1" => Array("showitem" => "fe_group")
	)
);



$TCA["tx_wecsermons_resource_types"] = Array (
	"ctrl" => $TCA["tx_wecsermons_resource_types"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,fe_group,description,title,graphic"
	),
	"feInterface" => $TCA["tx_wecsermons_resource_types"]["feInterface"],
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
				'foreign_table' => 'tx_wecsermons_resource_types',
				'foreign_table_where' => 'AND tx_wecsermons_resource_types.pid=###CURRENT_PID### AND tx_wecsermons_resource_types.sys_language_uid IN (-1,0)',
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
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.description",		
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
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.title",		
			"config" => Array (
				"type" => "input",
				"size" => "30",	
				"eval" => "required",
			)
		),
		"icon" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.icon",		
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
		"marker_name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.marker_name",		
			"config" => Array (
				"type" => "input",
				"size" => "30",	
				"eval" => "required,upper,nospace",
			)
		),
		"template_name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.template_name",		
			"config" => Array (
				"type" => "input",
				"size" => "30",	
				"eval" => "required,upper,nospace",
			)
		),
		"avail_fields" => Array (
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.avail_fields",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.avail_fields.I.0", "description"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.avail_fields.I.1", "graphic"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.avail_fields.I.2", "file"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.avail_fields.I.4", "mime_type"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_resource_types.avail_fields.I.3", "url"),
				),
				"size" => 5,	
				"minitems" => 0,
				"maxitems" => 100,	
				
			),
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, marker_name, template_name, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts];3-3-3, icon, avail_fields")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "fe_group")
	)
);



$TCA["tx_wecsermons_sermons"] = Array (
	"ctrl" => $TCA["tx_wecsermons_sermons"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title,occurance_date,description,scripture,keywords,graphic,series_uid,topics_uid,record_type,resources_uid"
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
		"scripture" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.scripture",		
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
                "show_thumbs" => 1,    
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
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 100,
				'wizards' => Array(
					'_VALIGN' => 'top',
					'add' => Array(
						'type' => 'script',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.add',
						'icon' => 'add.gif',
						'params' => Array(
							'table'=>'tx_wecsermons_series',
							'pid' => '###STORAGE_PID###',
							'setValue' => 'set'
						),
						'script' => 'wizard_add.php',
					),
					'edit' => Array(
						'type' => 'popup',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.edit',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'edit2.gif',
						'JSopenParams' => 'height=450,width=580,status=0,menubar=0,scrollbars=1',
					)
				),
			)
		),
		"topics_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.topics_uid",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wecsermons_topics",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 10,
				'wizards' => Array(
					'_VALIGN' => 'top',
					'add' => Array(
						'type' => 'script',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.add',
						'icon' => 'add.gif',
						'params' => Array(
							'table'=>'tx_wecsermons_topics',
							'pid' => '###STORAGE_PID###',
							'setValue' => 'set'
						),
						'script' => 'wizard_add.php',
					),
					'edit' => Array(
						'type' => 'popup',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.edit',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'edit2.gif',
						'JSopenParams' => 'height=450,width=580,status=0,menubar=0,scrollbars=1',
					)
				),
			)
		),
/*		"record_type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.record_type",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.record_type.I.0", "0", t3lib_extMgm::extRelPath("wec_sermons")."selicon_tx_wecsermons_sermons_record_type_0.gif"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.record_type.I.1", "1", t3lib_extMgm::extRelPath("wec_sermons")."selicon_tx_wecsermons_sermons_record_type_1.gif"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.record_type.I.2", "2", t3lib_extMgm::extRelPath("wec_sermons")."selicon_tx_wecsermons_sermons_record_type_2.gif"),
					Array("LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.record_type.I.3", "3", t3lib_extMgm::extRelPath("wec_sermons")."selicon_tx_wecsermons_sermons_record_type_3.gif"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
*/		"resources_uid" => Array (		
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
				'wizards' => Array(
					'_VALIGN' => 'top',
					'add' => Array(
						'type' => 'script',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.add',
						'icon' => 'add.gif',
						'params' => Array(
							'table'=>'tx_wecsermons_resources',
							'pid' => '###STORAGE_PID###',
							'setValue' => 'set'
						),
						'script' => 'wizard_add.php',
					),
					'edit' => Array(
						'type' => 'popup',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.edit',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'edit2.gif',
						'JSopenParams' => 'height=450,width=580,status=0,menubar=0,scrollbars=1',
					)
				),
			)
		),
		"speakers_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.speakers_uid",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wecsermons_speakers",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 100,	
				'wizards' => Array(
					'_VALIGN' => 'top',
					'add' => Array(
						'type' => 'script',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.add',
						'icon' => 'add.gif',
						'params' => Array(
							'table'=>'tx_wecsermons_speakers',
							'pid' => '###STORAGE_PID###',
							'setValue' => 'set'
						),
						'script' => 'wizard_add.php',
					),
					'edit' => Array(
						'type' => 'popup',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.edit',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'edit2.gif',
						'JSopenParams' => 'height=450,width=580,status=0,menubar=0,scrollbars=1',
					)
				),
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, hidden;;1, l18n_parent, l18n_diffsource, title;;;;2-2-2, occurance_date;;;;3-3-3, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts];4-4-4,scripture;;;;5-5-5, series_uid, topics_uid, resources_uid, speakers_uid, graphic, keywords"),
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_wecsermons_series"] = Array (
	"ctrl" => $TCA["tx_wecsermons_series"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,title,description,scripture,startdate,enddate,graphic,seasons_uid"
	),
	"feInterface" => $TCA["tx_wecsermons_series"]["feInterface"],
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
                "show_thumbs" => 1,    
				"uploadfolder" => "uploads/tx_wecsermons",
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"seasons_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_series.seasons_uid",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_wecsermons_seasons",	
				"foreign_table_where" => "AND tx_wecsermons_seasons.pid=###STORAGE_PID### ORDER BY tx_wecsermons_seasons.uid",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 10,
				'wizards' => Array(
					'_VALIGN' => 'top',
					'add' => Array(
						'type' => 'script',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.add',
						'icon' => 'add.gif',
						'params' => Array(
							'table'=>'tx_wecsermons_seasons',
							'pid' => '###STORAGE_PID###',
							'setValue' => 'set'
						),
						'script' => 'wizard_add.php',
					),
					'edit' => Array(
						'type' => 'popup',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.edit',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'edit2.gif',
						'JSopenParams' => 'height=450,width=580,status=0,menubar=0,scrollbars=1',
					)
				),
			)
		),
		"topics_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.topics_uid",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wecsermons_topics",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 10,
				'wizards' => Array(
					'_VALIGN' => 'top',
					'add' => Array(
						'type' => 'script',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.add',
						'icon' => 'add.gif',
						'params' => Array(
							'table'=>'tx_wecsermons_topics',
							'pid' => '###STORAGE_PID###',
							'setValue' => 'set'
						),
						'script' => 'wizard_add.php',
					),
					'edit' => Array(
						'type' => 'popup',
						'title' => 'LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_sermons.edit',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'edit2.gif',
						'JSopenParams' => 'height=450,width=580,status=0,menubar=0,scrollbars=1',
					)
				),
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
		
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid,hidden;;1;;1-1-1, title;;;;2-2-2, startdate;;;;3-3-3, enddate, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts];4-4-4, scripture;;;;5-5-5, keywords, seasons_uid, topics_uid, graphic")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wecsermons_topics"] = Array (
	"ctrl" => $TCA["tx_wecsermons_topics"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,description,title"
	),
	"feInterface" => $TCA["tx_wecsermons_topics"]["feInterface"],
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
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_topics.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1,hidden;;1;;1-1-1, title;;;;2-2-2, description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts]")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wecsermons_seasons"] = Array (
	"ctrl" => $TCA["tx_wecsermons_seasons"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,season_name"
	),
	"feInterface" => $TCA["tx_wecsermons_seasons"]["feInterface"],
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
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_seasons.season_name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1,hidden;;1, season_name;;;;2-2-2")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);

$TCA["tx_wecsermons_speakers"] = Array (
	"ctrl" => $TCA["tx_wecsermons_speakers"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,season_name"
	),
	"feInterface" => $TCA["tx_wecsermons_speakers"]["feInterface"],
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
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"firstname" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_speakers.firstname",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"lastname" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_speakers.lastname",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"email" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_speakers.email",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"photo" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_speakers.photo",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 500,	
                "show_thumbs" => 1,    
				"uploadfolder" => "uploads/tx_wecsermons",
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"url" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wec_sermons/locallang_db.php:tx_wecsermons_speakers.url",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),


	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, lastname;;;;2-2-2, firstname, email, url, photo")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);
?>