<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Web Empowered Church Team, Foundation For Evangelism (wec_sermons@webempoweredchurch.org)
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
 * class 'XML View' for the 'WEC Sermons' library
 *
 * @author	Web Empowered Church Team, Foundation For Evangelism <wec_sermons@webempoweredchurch.org>
 */

require_once(PATH_t3lib.'class.t3lib_div.php');

class tx_wecsermons_xmlView {
	
	function preProcessContentRow( $pObj, $row ) {
		
			//	Make a callback to get the URL to this record. Parent object of tx_wecapi_list must support getUrlToSingle function call!
		$row['item_link'] = $pObj->cObj->getUrlToSingle( true, $tableName, $row['uid'] );

	}
	
	function preProcessPageArray( $pObj, $dataArray, $pageArray ) {

			//	Make a callback to get the URL to the list view. Parent object of tx_wecapi_list must support getUrlToList function call!
		$pageArray['channel_link'] = $pObj->cObj->getUrlToList( true, $tableName );
	
	}
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/class.tx_wecsermons_xmlView.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/class.tx_wecsermons_xmlView.php']);
}
?>