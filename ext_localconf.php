<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_wecsermons_resources=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_wecsermons_resource_type=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_wecsermons_sermons=1
');

  ## Extending TypoScript from static template uid=43 to set up userdefined tag:
t3lib_extMgm::addTypoScript($_EXTKEY,'editorcfg','
	tt_content.CSS_editor.ch.tx_wecsermons_pi1 = < plugin.tx_wecsermons_pi1.CSS_editor
',43);


t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_wecsermons_pi1.php','_pi1','list_type',1);

	//	Load necessary classes and register respective hooks
require_once( t3lib_extMgm::extPath($_EXTKEY) . '/class.tx_wecsermons_resourceTypeTca.php' );
require_once( t3lib_extMgm::extPath($_EXTKEY) . '/class.tx_wecsermons_xmlView.php' );	

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getMainFieldsClass'][] = 'tx_wecsermons_resourceTypeTca';
$TYPO3_CONF_VARS['EXTCONF']['tx_wecapi_list']['preProcessContentRow'][] = 'tx_wecsermons_xmlView';
$TYPO3_CONF_VARS['EXTCONF']['tx_wecapi_list']['preProcessPageArray'][] = 'tx_wecsermons_xmlView';

t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
	tt_content.shortcut.20.0.conf.tx_wecsermons_sermons = < plugin.'.t3lib_extMgm::getCN($_EXTKEY).'_pi1
	tt_content.shortcut.20.0.conf.tx_wecsermons_sermons.CMD = singleView
',43);
?>