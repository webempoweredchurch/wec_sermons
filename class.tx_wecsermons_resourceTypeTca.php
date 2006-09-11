<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Web Empowered Church Team, Foundation For Evangelism (sermon@webempoweredchurch.org)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Class/Functions used to modify TCA on the fly. Functions are called by hooks or userFunc declarations. This allows us to change the TCA based on the existence of tx_wecsermons_resource_types backend records. These records become record types for tx_wecsermons_resources, changing how resources are edited in the backend.
 *
 * @author	Web Empowered Church Team, Foundation For Evangelism <wec_sermons@webempoweredchurch.org>
 * @package TYPO3
 * @subpackage tx_wecsermons
 */

 /**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   46: class tx_wecsermons_resourceTypeTca
 *   56:     function getMainFields_preProcess($table,$row,&$pObj)
 *   89:     function resourceType_items( &$params, &$pObj )
 *  121:     function processAvailableFields( $availFields )
 *
 * TOTAL FUNCTIONS: 3
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_wecsermons_resourceTypeTca {

	/**
	 * getMainFields_preProcess: Hook implementation that modifies the TCA on the fly, converting backend records tx_wecsermons_resources_type into a 'types' arrays that change our backend forms
	 *
	 * @param	string		$table: The name of the table where the current record is stored
	 * @param	array		$row:	An associative array of the current record
	 * @param	array		&$pObj:	The backreference to the parent object calling this function
	 * @return	void
	 */
	function getMainFields_preProcess($table,$row,&$pObj) {

		if( $table == 'tx_wecsermons_resources' ) {

			//	Make sure TCA is loaded for our table
			t3lib_div::loadTCA( 'tx_wecsermons_resources' );

			//	Retreive all tx_wecsermons_resource_types records
			$resource = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'*',
				'tx_wecsermons_resource_types',
				' deleted = 0 AND hidden = 0 '
			);

			//	Convert each tx_wecsermons_resource_types record into a 'types' TCA array
			while( $resourceType = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $resource )  ) {

				$GLOBALS['TCA']['tx_wecsermons_resources']['types'][$resourceType['typoscript_object_name']] = array( 'showitem' => "sys_language_uid;;;;1-1-1, l18n_parent, l18n _diffsource, hidden;;1, title;;;;2-2-2, type, " . $this->processAvailableFields( $resourceType['avail_fields'] ) . ($resourceType['type'] == '1' ? ',rendered_record' : '')  );
			}

//debug( $GLOBALS['TCA']['tx_wecsermons_resources']['types'] ,1);

		}

	}

	/**
	 * resourceType_items: A TCA[config][itemsProcFunc] implementation used from tx_wecsermons_resources
	 *
	 * @param	array		&$params: Reference to the 'config' array from our TCA column
	 * @param	array		&$pObj:	The backreference to the parent object calling this function
	 * @return	void
	 */
	function resourceType_items( &$params, &$pObj ) {

			//	Make sure TCA is loaded for our table
			t3lib_div::loadTCA( 'tx_wecsermons_resources' );
			t3lib_div::loadTCA( 'tx_wecsermons_resource_types' );


		//	Retreive all tx_wecsermons_resource_types records
		$resource = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'*',
			'tx_wecsermons_resource_types',
				' deleted = 0 AND hidden = 0 '
		);

		//	Convert each tx_wecsermons_resource_types record into a selectable 'record type' for tx_wecsermons_resource records
		while( $resourceType = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $resource )  ) {

			//	TODO: Resize the given image file to 18x16 via ImageMagick
			$params['items'][] = array(
				$resourceType['title'],
				$resourceType['typoscript_object_name'],
				$resourceType['icon'] ? '../../' . $GLOBALS['TCA']['tx_wecsermons_resource_types']['columns']['icon']['config']['uploadfolder'] . '/' . $resourceType['icon'] : ''
			);

		}

	}

	/**
	 *	processAvailableFields	Function that performs pre-processing of the "types" portion of TCA, enabling RTE functionality and advanced backend form features.
	 *
	 * @param	string		$$availFields: A csv string containing the possible available fields that can be displayed for a SMS resource
	 * @return	[type]		Returns a processed csv string, ready to be appended to the "types" portion of TCA
	 */
	 function processAvailableFields( $availFields ) {

	 	$processedFields = '';
	 	$fieldArray = explode( ',' , $availFields );

	 	foreach( $fieldArray as $field ) {

	 		switch( $field ) {

	 			case 'description':
	 				$processedFields .= 'description;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts];3-3-3';
	 				break;

	 			default:
	 				$processedFields .= $field;
	 				break;

	 		}

	 		$processedFields .= ',';
	 	}

	 	//	Return the processed fields csv string with right-most comma trimmed.
	 	return rtrim( $processedFields, ',' );
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/class.tx_wecsermons_resourceTypeTca.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/class.tx_wecsermons_resourceTypeTca.php']);
}

?>