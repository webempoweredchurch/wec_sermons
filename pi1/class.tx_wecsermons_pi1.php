<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Web Empowered Church Team, Foundation For Evangelism (wec_sermons@webempoweredchurch.org)
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
 * Plugin 'Sermon Repository' for the 'wec_sermons' extension.
 *
 * @author	Web Empowered Church Team, Foundation For Evangelism <wec_sermons@webempoweredchurch.org>
 */


require_once(PATH_tslib.'class.tslib_pibase.php');

class tx_wecsermons_pi1 extends tslib_pibase {
	var $prefixId = 'tx_wecsermons_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_wecsermons_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'wec_sermons';	// The extension key.
	var $pi_checkCHash = TRUE;
	
	
	/**
	 * [Put your description here]
	 */
	function init()	{
	}	
	
	/**
	 * [Put your description here]
	 */
	function main($content,$conf)	{
		$this->pi_initPIflexForm();
//		debug( $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'prototype','sDEF') );
	
			//	If Prototype enabled, walk through tutorial
		if( $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'prototype','sDEF') > 0 ) {	

				//	Pull in the content from the apporpriate static HTML file
			switch( $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'prototype','sDEF') )
			{
				case '1':	//	Ginghamsburg Proto
					
					switch($this->piVars['page']) {
						case '2' :
							$content = t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/ging/study_view.htm');
						break;
						
						case '3':
							$content = t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons') .'tut/ging/study_exp.htm');
						break;
						
						default:
							$content = t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons') .'tut/ging/list_view.htm');
					
					}

					//	Replace existing relative paths to files
				$content = str_replace( 'images/', t3lib_extMgm::siteRelPath('wec_sermons').'tut/ging/images/', $content );
					
				break;

				case '2':	//	Living Water Proto
					
					switch($this->piVars['page']) {
						case '2' :
							$content = t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/living_water/series_view.htm');
						break;
						
						case '3':
							$content = t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/living_water/archive_view.htm');
						break;
						
						default:
							$content = t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/living_water/single_view.htm');
						
					}
				

						//	Replace existing relative paths
					$content = str_replace( 'images/', t3lib_extMgm::siteRelPath('wec_sermons').'tut/living_water/images/', $content );
				break;
				default:
				
			}
			
				//	set piVar['page'] = 1, or increment to next page
			is_null( $this->piVars['page'] ) ? $this->piVars['page'] = 2 : $this->piVars['page']++;
			
				//	reset counter to 1 when > 3
			if( $this->piVars['page'] > 3 ) $this->piVars['page'] = 1;
			
				//	Modify all links in the static HTML file, linking to the next screen
			$content = preg_replace('/href="#"/',  'href="'.$this->pi_linkTP_keepPIvars_url(array() , 1 ).'"', $content);
			
				
				return $content;
		}
		switch((string)$conf['CMD'])	{
			case 'singleView':
				list($t) = explode(':',$this->cObj->currentRecord);
				$this->internal['currentTable']=$t;
				$this->internal['currentRow']=$this->cObj->data;
				return $this->pi_wrapInBaseClass($this->singleView($content,$conf));
			break;
			default:
				if (strstr($this->cObj->currentRecord,'tt_content'))	{
					$conf['pidList'] = $this->cObj->data['pages'];
					$conf['recursive'] = $this->cObj->data['recursive'];
				}
				return $this->pi_wrapInBaseClass($this->listView($content,$conf));
			break;
		}
	}
	
	/**
	 * [Put your description here]
	 */
	function listView($content,$conf)	{
		$this->conf=$conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();		// Loading the LOCAL_LANG values
		
		$lConf = $this->conf['listView.'];	// Local settings for the listView function
	
		if ($this->piVars['showUid'])	{	// If a single element should be displayed:
			$this->internal['currentTable'] = 'tx_wecsermons_sermons';
			$this->internal['currentRow'] = $this->pi_getRecord('tx_wecsermons_sermons',$this->piVars['showUid']);
	
			$content = $this->singleView($content,$conf);
			return $content;
		} else {
			$items=array(
				'1'=> $this->pi_getLL('list_mode_1','Mode 1'),
				'2'=> $this->pi_getLL('list_mode_2','Mode 2'),
				'3'=> $this->pi_getLL('list_mode_3','Mode 3'),
			);
			if (!isset($this->piVars['pointer']))	$this->piVars['pointer']=0;
			if (!isset($this->piVars['mode']))	$this->piVars['mode']=1;
	
				// Initializing the query parameters:
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=t3lib_div::intInRange($lConf['results_at_a_time'],0,1000,3);		// Number of results to show in a listing.
			$this->internal['maxPages']=t3lib_div::intInRange($lConf['maxPages'],0,1000,2);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='title,description,related_scripture,keywords';
			$this->internal['orderByList']='uid,title,related_scripture,keywords';
	
				// Get number of records:
			$res = $this->pi_exec_query('tx_wecsermons_sermons',1);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
	
				// Make listing query, pass query to SQL database:
			$res = $this->pi_exec_query('tx_wecsermons_sermons');
			$this->internal['currentTable'] = 'tx_wecsermons_sermons';
	
				// Put the whole list together:
			$fullTable='';	// Clear var;
		#	$fullTable.=t3lib_div::view_array($this->piVars);	// DEBUG: Output the content of $this->piVars for debug purposes. REMEMBER to comment out the IP-lock in the debug() function in t3lib/config_default.php if nothing happens when you un-comment this line!
	
				// Adds the mode selector.
			$fullTable.=$this->pi_list_modeSelector($items);
	
				// Adds the whole list table
			$fullTable.=$this->pi_list_makelist($res);
	
				// Adds the search box:
			$fullTable.=$this->pi_list_searchBox();
	
				// Adds the result browser:
			$fullTable.=$this->pi_list_browseresults();
	
				// Returns the content from the plugin.
			return $fullTable;
		}
	}
	/**
	 * [Put your description here]
	 */
	function singleView($content,$conf)	{
		$this->conf=$conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
	
			// This sets the title of the page for use in indexed search results:
		if ($this->internal['currentRow']['title'])	$GLOBALS['TSFE']->indexedDocTitle=$this->internal['currentRow']['title'];
	
		$content='<div'.$this->pi_classParam('singleView').'>
			<H2>Record "'.$this->internal['currentRow']['uid'].'" from table "'.$this->internal['currentTable'].'":</H2>
			<table>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('title').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('title').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('occurance_date').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('occurance_date').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('description').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('description').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('related_scripture').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('related_scripture').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('keywords').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('keywords').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('graphic').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('graphic').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('series_uid').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('series_uid').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('topic_uid').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('topic_uid').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('record_type').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('record_type').'</p></td>
				</tr>
				<tr>
					<td nowrap valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('resources_uid').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('resources_uid').'</p></td>
				</tr>
				<tr>
					<td nowrap'.$this->pi_classParam('singleView-HCell').'><p>Last updated:</p></td>
					<td valign="top"><p>'.date('d-m-Y H:i',$this->internal['currentRow']['tstamp']).'</p></td>
				</tr>
				<tr>
					<td nowrap'.$this->pi_classParam('singleView-HCell').'><p>Created:</p></td>
					<td valign="top"><p>'.date('d-m-Y H:i',$this->internal['currentRow']['crdate']).'</p></td>
				</tr>
			</table>
		<p>'.$this->pi_list_linkSingle($this->pi_getLL('back','Back'),0).'</p></div>'.
		$this->pi_getEditPanel();
	
		return $content;
	}
	/**
	 * [Put your description here]
	 */
	function pi_list_row($c)	{
		$editPanel = $this->pi_getEditPanel();
		if ($editPanel)	$editPanel='<TD>'.$editPanel.'</TD>';
	
		return '<tr'.($c%2 ? $this->pi_classParam('listrow-odd') : '').'>
				<td><p>'.$this->getFieldContent('uid').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('title').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('occurance_date').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('related_scripture').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('keywords').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('graphic').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('series_uid').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('topic_uid').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('record_type').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('resources_uid').'</p></td>
			</tr>';
	}
	/**
	 * [Put your description here]
	 */
	function pi_list_header()	{
		return '<tr'.$this->pi_classParam('listrow-header').'>
				<td><p>'.$this->getFieldHeader_sortLink('uid').'</p></td>
				<td><p>'.$this->getFieldHeader_sortLink('title').'</p></td>
				<td nowrap><p>'.$this->getFieldHeader('occurance_date').'</p></td>
				<td><p>'.$this->getFieldHeader_sortLink('related_scripture').'</p></td>
				<td><p>'.$this->getFieldHeader_sortLink('keywords').'</p></td>
				<td nowrap><p>'.$this->getFieldHeader('graphic').'</p></td>
				<td nowrap><p>'.$this->getFieldHeader('series_uid').'</p></td>
				<td nowrap><p>'.$this->getFieldHeader('topic_uid').'</p></td>
				<td nowrap><p>'.$this->getFieldHeader('record_type').'</p></td>
				<td nowrap><p>'.$this->getFieldHeader('resources_uid').'</p></td>
			</tr>';
	}
	/**
	 * [Put your description here]
	 */
	function getFieldContent($fN)	{
		switch($fN) {
			case 'uid':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
			break;
			case "title":
					// This will wrap the title in a link.
				return $this->pi_list_linkSingle($this->internal['currentRow']['title'],$this->internal['currentRow']['uid'],1);
			break;
			case "occurance_date":
					// For a numbers-only date, use something like: %d-%m-%y
				return strftime('%A %e. %B %Y',$this->internal['currentRow']['occurance_date']);
			break;
			default:
				return $this->internal['currentRow'][$fN];
			break;
		}
	}
	/**
	 * [Put your description here]
	 */
	function getFieldHeader($fN)	{
		switch($fN) {
			case "title":
				return $this->pi_getLL('listFieldHeader_title','<em>title</em>');
			break;
			default:
				return $this->pi_getLL('listFieldHeader_'.$fN,'['.$fN.']');
			break;
		}
	}
	
	/**
	 * [Put your description here]
	 */
	function getFieldHeader_sortLink($fN)	{
		return $this->pi_linkTP_keepPIvars($this->getFieldHeader($fN),array('sort'=>$fN.':'.($this->internal['descFlag']?0:1)));
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php']);
}

?>