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
#require_once(PATH_typo3conf . 'ext/wec_api/class.wec_xml.php' );

class tx_wecsermons_pi1 extends tslib_pibase {
	var $prefixId = 'tx_wecsermons_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_wecsermons_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'wec_sermons';	// The extension key.
	var $pi_checkCHash = TRUE;


	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function init($conf)	{
		$this->conf=$conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_initPIflexForm(); // Init FlexForm configuration for plugin
		$this->pi_setPiVarDefaults(); // Set default piVars from TS
		$this->pi_loadLL();		// Loading the LOCAL_LANG values
		$this->enableFields = $this->cObj->enableFields('tx_wecsermons_sermons');
	}

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function main($content,$conf)	{
		
		$this->local_cObj = t3lib_div::makeInstance('tslib_cObj'); // Local cObj.
		$this->init($conf);


			//	Check if typoscript config 'tutorial' is an integer, otherwise set to 0
		if( t3lib_div::testInt( $this->conf['tutorial'] ) == false ) $this->conf['tutorial'] = 0;

		$tutorial = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'tutorial','sDEF');

			//	If tutorial enabled, walk through tutorial
		if( $tutorial > 0 || $this->conf['tutorial'] > 0 ) {

				//	If tutorial specified through fe plugin, this overrides setting of typoscript.
			$tutorial  = ($tutorial > 0) ?
				$tutorial
				: $this->conf['tutorial'];

			$content = '';

				//	Check which tutorial was chosen, and pull in the content from the apporpriate static HTML file
			switch( $tutorial )
			{
				case '1':	//	Ginghamsburg tutorial

					switch($this->piVars['page']) {
						case '2' :
							$content .="<H1>Example page of a view on study material</H1>";
							$content .= t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/ging/study_view.htm');
						break;

						case '3':
							$content .="<H1>Example page of another view on study material</H1>";
							$content .= t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons') .'tut/ging/study_exp.htm');
						break;

						default:
							$content .="<H1>Example page of a view on a sermon listing</H1>";
							$content .= t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons') .'tut/ging/list_view.htm');

					}

					//	Replace existing relative paths to files
				$content = str_replace( 'images/', t3lib_extMgm::siteRelPath('wec_sermons').'tut/ging/images/', $content );

				break;

				case '2':	//	Living Water tutorial

					switch($this->piVars['page']) {
						case '2' :
							$content .="<H1>Example page of a view on sermon series</H1>";
							$content .= t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/living_water/series_view.htm');
						break;

						case '3':
							$content .="<H1>Example page of a view on sermons archive</H1>";
							$content .= t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/living_water/archive_view.htm');
						break;

						default:
							$content .="<H1>Example page of a view on a single sermon</H1>";
							$content .= t3lib_div::getURL(t3lib_extMgm::extPath('wec_sermons').'tut/living_water/single_view.htm');

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
		}	// End tutorial block

			//	Get the 'what to display' value from plugin or typoscript, plugin overriding
		$display = is_null( $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'display','sDEF') ) ?
			$this->conf['code'] :
			$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'display','sDEF');

		$codes = t3lib_div::trimExplode(',',$display,0);

		foreach( $codes as $code ) {
			switch( $code ) {	//	Primary switch for this plugin
				case 'single':
					$content .= '<h1>single case reached</h1><br/>';
					break;

				case 'list':
					$content .= $this->listView($content, $this->conf['listView.']);
					break;

				case 'rss':
					$content .= '<h1>rss case reached</h1><br/>';
					break;

				case 'archive':
					$content .= '<h1>archive case reached</h1><br/>';
					break;

				case 'search':
					$content .= '<h1>search case reached</h1><br/>';
					break;
 
				default:
					$content .= '<h1>Please configure \'what to display\' in plugin or typoscript</h1><br/>';
					break;
			}	//	End Primary switch
		}	//	End Primary foreach loop

		return $content;


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
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function searchView($content,$lConf)	{
		
		if( $this->piVar['sword'] == '' )
			return $this->cObj->stdWrap($lConf['searchError.'], htmlspecialchars( $lConf['groupByError'] ));
			
		$swords = explode(' ', $this->piVar['sword'] );
		
		
	}
	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function listView($content,$lConf)	{


		if ($this->piVars['showUid'])	{	// If a single element should be displayed, jump to single view
			$this->internal['currentTable'] = 'tx_wecsermons_sermons';
			$this->internal['currentRow'] = $this->pi_getRecord('tx_wecsermons_sermons',$this->piVars['showUid']);

			$content = $this->singleView($content,$lConf);
			return $content;

		} else {	//	Otherwise continue with list view

				//	List View Modes
			$items=array(
				'1'=> $this->pi_getLL('list_mode_1','Mode 1'),
				'2'=> $this->pi_getLL('list_mode_2','Mode 2'),
				'3'=> $this->pi_getLL('list_mode_3','Mode 3'),
			);
			
				//	Intialize query params if not set
			if (!isset($this->piVars['pointer']))	$this->piVars['pointer']=0;
			//if (!isset($this->piVars['mode']))	$this->piVars['mode']=1;	//	Mode not used in this extension

				// Initializing the query parameters:
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=t3lib_div::intInRange($lConf['results_at_a_time'],0,1000,3);		// Number of results to show in a listing.
			$this->internal['maxPages']=t3lib_div::intInRange($lConf['maxPages'],0,1000,2);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']=$lConf['searchFieldList'];		//	This should not be needed with templates
			$this->internal['orderByList']=$lConf['orderByList'];


				//	Recursive setting from plugin overrides typoscript
			$this->conf['recursive'] = getConfigVal( $this, 'recursive', 'sDEF', 'recursive', $lConf, 0 );


			$startingPoint =$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'startingpoint', 'sDEF');

				//	If configured to use the General Storage Folder of the site, include that in the list of pids
			if( $this->conf['useStoragePid'] ) {

				//	Retrieve the general storage pid for this site
				$rootPids = $GLOBALS['TSFE']->getStorageSiterootPids();
				$storagePid = (string) $rootPids['_STORAGE_PID'];

					//	Merge all lists from typoscript, storagePid, and startingpoint specified at plugin
				$this->conf['pidList'] .= ','. $storagePid . ','. $startingPoint;
			}
			else {
					//	Merge lists from typoscript and startingpoint specified at plugin
				$this->conf['pidList'] .= ','. $startingPoint;

			}

				//	Load the HTML template from either plugin or typoscript configuration, plugin overrides
			$templateFile = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'templateFile', 'sDEF');

			$templateFile = $templateFile ? 'uploads/tx_wecsermons/'.$templateFile : $this->conf['templateFile'];
			
				//	Load the Layout code, which chooses between templates
				//	TODO: Determine if we need a layout code logic block or not
			$layoutCode = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'layoutCode', 'sDEF');
			if( !$layoutCode ) $layoutCode = '3';	//	LayoutCode default = 3

			$template['total'] = $this->cObj->fileResource($templateFile);


			$template['list'] = $this->cObj->getSubpart( $template['total'], '###TEMPLATE_LIST'.$layoutCode.'###' );
			$template['content'] = $this->cObj->getSubpart( $template['list'], '###CONTENT###' );
		
			return $this->cObj->substituteSubpart( $template['list'], '###CONTENT###', $this->pi_list_makelist($lConf, $template['content'] ) );

/* Original Code generated by kickstarter			
			$res = $this->pi_exec_query('tx_wecsermons_sermons');
			$this->internal['currentTable'] = 'tx_wecsermons_sermons';

			$this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)	;

			$result = $this->groupByList( $lConf, $template['sermon'] );


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


//	Using $this->internal['res_count'], $this->internal['results_at_a_time'] and $this->internal['maxPages'] for count number, 
//	how many results to show and the max number of pages to include in the browse bar. Using $this->internal['dontLinkActivePage']

				// Adds the result browser:
			$fullTable.=$this->pi_list_browseresults();

				// Returns the content from the plugin.
			return $fullTable;
			
*/
		}
	}
	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function singleView($content,$lConf)	{
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
	 * Returns the list of items based on the input SQL result pointer
	 * For each result row the internal var, $this->internal['currentRow'], is set with the row returned.
	 * $this->pi_list_header() makes the header row for the list
	 * $this->pi_list_row() is used for rendering each row
	 *
	 * @param	pointer		Result pointer to a SQL result which can be traversed.
	 * @param	string		Marker based template, which will be processed and returned with populated data using $this->substituteMarkerArrayCached  ()
	 * @return	string		Output HTML, wrapped in <div>-tags with a class attribute
	 * @see pi_list_row(), pi_list_header()
	 */
	function pi_list_makelist($lConf, $template)	{

			//	Initialize $this->template['group'] with template subpart using predefined tag '###GROUP###', if exists
		$this->template['group'] = $this->cObj->getSubpart( $template, '###GROUP###' );
		$content = '';
		$subpartArray = array();
		
			// TODO: Allow this to be passed as an array for processing.
		$tagList = array( '###SERMON_SERIES###', '###SERMON###', '###RESOURCE###', '###LITURGICAL_SEASON###', '###TOPIC###' );

			//	If we found a grouping declaration, process as such
		if( $this->template['group'] ) {
			$group = null;
			
			foreach( $tagList as $tag ) {
				
				switch( $tag ) {
					
					case '###SERMON_SERIES###':
						$groupTemplate = $this->cObj->getSubpart($template, $tag);
						$this->internal['currentTable'] = $this->internal['groupTable'] = 'tx_wecsermons_series';
						$res = $this->pi_exec_query('tx_wecsermons_series');
						$group = $markerArray = $wrappedSubpartArray = array();

							//	Get the related table entries to the group, using 'tx_wecsermons_sermons' if none specified
							//	TODO: Provide more friendly error handling
						$tableToList = getConfigVal( $this, 'table_to_list', 'sDEF', 'table_to_list', $lConf, 'tx_wecsermons_sermons' );
			
						if( ! t3lib_div::inList( $lConf['allowedTables'], $tableToList ) )
							return  '<p>WEC Sermons Error!<br/> Table given for &quot;table_to_list&quot; is not in the allowed tables to list from, &quot;allowedTables&quot;</p>';

							//	Search TCA for relation to previous table where columns.[colName].config.foreign_table = $this->internal['groupTable']
							//	TODO: Provide more friendly error handling
						$foreign_column = get_foreign_column( $tableToList, $this->internal['groupTable'] );
						if( ! $foreign_column )
							return '<p>WEC Sermons Error!<br/> Grouping tag, &quot;###GROUP###&quot; was found in template, but was not related to &quot;table_to_list&quot;</p>';

							//	Iterate each record, storing in $group array
						while( $group[] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) );


							//	Begin processing each group
						foreach( $group as $row ) {
							if( $row ) {
								$this->internal['currentRow'] = $row;
								
									// TODO: Process every available tag for sermon series
								$markerArray['###SERMON_SERIES_TITLE###'] = $this->internal['currentRow']['title'];
								$wrappedSubpartArray['###SERMON_SERIES_LINK###'] = explode( '|',
									$this->pi_list_linkSingle( '|', $this->internal['currentRow']['uid'], $this->conf['allowCaching'], array(), FALSE, $this->conf['pidSingleView'] ? $this->conf['pidSingleView'] : 0 )
								);
								
									//	Store the processed subpart into subpartArray
								$subpartArray['###GROUP###'] = $this->cObj->substituteMarkerArrayCached(  $groupTemplate, $markerArray, array(), $wrappedSubpartArray );
								
									//	Begin processing detail for this group iteration
								$this->internal['currentTable'] = $tableToList;
								
									//	TODO: Define markers named the same as fields, so easier to process?
								$lMarkerArray = array(
									'###SERMON_TITLE###' => '',
									'###OCCURANCE_DATE###' => '',
									'###SERMON_LINK###' => '',
									'###ALTERNATING_CLASS###' => $lConf['alternatingClass'],
								);

									//	Exec query retrieving related records to the group	record
								$res = $this->pi_exec_query($this->internal['currentTable'], 0, ' AND ' . $foreign_column . '= ' . $this->internal['currentRow']['uid'] );

								$count = 0;
							
									//	Get each row associated with the previous table							
								while( $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res ) ) {
								
									$subpartArray['###ITEM###'] .= $this->pi_list_row( $lConf, $lMarkerArray, $this->cObj->getSubpart( $template, '###ITEM###' ), $row, $count ); 
									$count++;
								}
								
									//	Only append content if group has related records
								if( $count > 0 ) 
									$content .= $this->cObj->substituteMarkerArrayCached( $template, array(), $subpartArray, array() );
								
									// Empty out the item subpart
								$subpartArray['###ITEM###'] = '';

							}

						}
					break;
				}	//	End switch
			}	// End foreach

			return $content;
		}	//	End if group
		
			//	No group found, just provide a straight list
		else {
			
				//	Get the related table entries to the group, using 'tx_wecsermons_sermons' if none specified
			$tableToList = getConfigVal( $this, 'table_to_list', 'sDEF', 'table_to_list', $lConf, 'tx_wecsermons_sermons' );
			$markerArray = $this->getMarkerArray( $tableToList );
		
			$itemTemplate = $this->cObj->getSubpart( $template, '###ITEM###' );
			$this->internal['currentTable'] = $this->internal['groupTable'] = 'tx_wecsermons_series';

				// Get number of records:
			$res = $this->pi_exec_query($tableToList,1);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);

				// Make listing query, pass query to SQL database:
			$res = $this->pi_exec_query($tableToList);
			$this->internal['currentTable'] = $tableToList;

			$count = 1;
			while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) ) {
				$content .= $this->pi_list_row( $lConf, $markerArray, $itemTemplate, $this->internal['currentRow'], $count );
				$count++;
			}
			
		}
		
		return $content;
	}

	/**
	 * [Put your description here]
	 *
	 * @param	string		$lConf: Local typoscript configuration array
	 * @param	string		$markerArray: Array of typo3 tag markers as keys
	 * @param	string		$rowTemplate: A marker based template, needing to be processed
	 * @param	integer		$c: Number of current row, to determine even / odd rows
	 * @return	string		A populated template, filled with data from the row
	 */
	function pi_list_row($lConf, $markerArray = array(), $rowTemplate, $row, $c)	{
		$wrappedMarkerArray = array();

			//	Get Editpanel for $this->internal['currentRow']
		$editPanel = $this->pi_getEditPanel();
		if ($editPanel)	$editPanel='<TD>'.$editPanel.'</TD>';
			
			//	Using passed markerArray, process each key and insert field content
		foreach( $markerArray as $key => $value ) {

		if( is_array( $value ) ) {
				$markerArray[$key] = '';
		}
		 else if( $row[$value] == '' ) {
				$markerArray[$key] = '';
		}
		else if( t3lib_div::testInt( $row[$value] ) && $row[$value] < 1 ) {
				$markerArray[$key] = '';
			
		}
		else {
		
				switch( $key ) {
					
				case '###SERMON_TITLE###':
					$markerArray[$key] = $this->cObj->stdWrap( $row[$value], $lConf['sermons.']['title_stdWrap.'] );
				break;
					
				case '###SERMON_OCCURANCE_DATE###':
						//	Wrap the occurance date, choosing from one of three settings in typoscript
					$dateWrap = $lConf['occurance_dateWrap.'] ? $lConf['occurance_dateWrap.'] : $lConf['general_dateWrap.'];
					if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
					$markerArray[$key] = $this->cObj->stdWrap( $row[$value], $dateWrap);
				break;
	
				case '###SERMON_DESCRIPTION###':
					$markerArray[$key] =  $this->cObj->stdWrap( $row[$value], $lConf['sermons.']['description_stdWrap.'] );
				break;
					
				case '###SERMON_SCRIPTURE###':
					$markerArray[$key] =  $this->cObj->stdWrap( $row[$value], $lConf['sermons.']['scripture_stdWrap.'] );
				break;  
				
				case '###SERMON_GRAPHIC###':
					// TODO: Use IMAGE object to draw? Implement so we can configure though typoscript
					$image = t3lib_div::makeInstance('tslib_cObj');
	
			
					$imageConf = array(
						'file' => 'uploads/tx_wecsermons/' . $row[$value],
						'altText' => 'AltText',
					);
	
						//	Merge our local config with typoscript config
					$imageConf = t3lib_div::array_merge( $imageConf, $lConf['sermons.']['graphic_IMAGE.'] );
				
						//	Render the image object
					$markerArray[$key] = $image->IMAGE( $imageConf );			
	
					break;
		
	
				case '###SERMON_LINK###':
debug('touch');
					$wrappedMarkerArray[$key] = explode( 
						'|',
						$this->pi_list_linkSingle(
							'|', 
							$row['uid'], 
							$this->conf['allowCaching'],
							array(), 
							FALSE, 
							$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0 
							)
					);
				break;
					
				case '###ALTERNATING_CLASS###':
					$markerArray['###ALTERNATING_CLASS###'] = $c % 2 ? $this->pi_classParam( $lConf['alternatingClass'] ) : '';
				break;
					
				}	// End Switch
				
				//	TODO: Add a hook here for processing extra markers
			} // End else
		}	// End Foreach

			//	TODO: Include the edit icons for editing the records from the front end
		$lContent = $this->cObj->substituteMarkerArrayCached($rowTemplate, $markerArray, array(), $wrappedMarkerArray );
		
	return $lContent;
	}
	
/*
				<td><p>'.$this->getFieldContent('uid').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('related_scripture').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('graphic').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('series_uid').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('topic_uid').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('record_type').'</p></td>
				<td valign="top"><p>'.$this->getFieldContent('resources_uid').'</p></td>
*/

/*
				<th><p>'.$this->getFieldHeader_sortLink('uid').'</p></th>
				<th><p>'.$this->getFieldHeader_sortLink('related_scripture').'</p></th>
				<th nowrap><p>'.$this->getFieldHeader('graphic').'</p></th>
				<th nowrap><p>'.$this->getFieldHeader('series_uid').'</p></th>
				<th nowrap><p>'.$this->getFieldHeader('topic_uid').'</p></th>
				<th nowrap><p>'.$this->getFieldHeader('record_type').'</p></th>
				<th nowrap><p>'.$this->getFieldHeader('resources_uid').'</p></th>

*/

	/**
	 * [Put your description here]
	 *
	 * @return	[type]		...
	 */
	function pi_list_header()	{
		return '<tr'.$this->pi_classParam('listrow-header').'>
				<th><p>'.$this->getFieldHeader_sortLink('title').'</p></th>
				<th nowrap><p>'.$this->getFieldHeader('occurance_date').'</p></th>
				<th><p>'.$this->getFieldHeader_sortLink('description').'</p></th>
			</tr>';
	}


	/**
	 *	Returns the markerArray for a specific table
	 *
	 *	@param	string	Table name to retrieve markers for
	 *	@return	array	Array filled with markers as keys, with empty values
	 */
	 function getMarkerArray( $tableName ) {
	 	
	 		$markerArray = array();
	 		
	 	switch ( $tableName ) {
	 		case 'tx_wecsermons_sermons':
	 			$markerArray = array (
	 				'###SERMON_TITLE###' => 'title',
	 				'###SERMON_OCCURANCE_DATE###' => 'occurance_date',
	 				'###SERMON_DESCRIPTION###' => 'description',
	 				'###SERMON_SCRIPTURE###' => 'related_scripture',
	 				'###SERMON_TOPICS###' => 'topic_uid',
	 				'###SERMON_SERIES###' => 'series_uid',
	 				'###SERMON_RESOURCES###' => 'resources_uid',
	 				'###SERMON_SPEAKERS###' => 'speakers_uid',
					'###SERMON_GRAPHIC###' => 'graphic',
					'###SERMON_LINK###' => array(
						0 => '',
						1 => '',
					),
	 			);
	 		break;
	 		
	 		case 'tx_wecsermons_series':
	 			$markerArray = array (
					'###SERIES_TITLE###' => '',
					'###SERIES_STARTDATE###' => '',
					'###SERIES_ENDDATE###' => '',
					'###SERIES_DESCRIPTION###' => '',
					'###SERIES_SCRIPTURE###' => '',
					'###SERIES_SEASON###' => '',
					'###SERIES_TOPICS###' => '',
					'###SERIES_GRAPHIC###' => '',
					
				);	 		
	 		break;
	 		
	 		case 'tx_wecsermons_topics':
	 			$markerArray = array (
					'###TOPIC_NAME###' => '',
					'###TOPIC_DESCRIPTION###' => '',
				);
	 		break;
	 		
	 		case 'tx_wecsermons_speakers':
	 			$markerArray = array (
					'###SPEAKER_FIRSTNAME###' => '',
					'###SPEAKER_LASTNAME###' => '',
					'###SPEAKER_EMAIL###' => '',
					'###SPEAKER_HOMEPAGE###' => '',
					'###SPEAKER_PHOTO###' => '',
				);
	 		break;

	 		case 'tx_wecsermons_resources':
	 			$markerArray = array (
					'###RESOURCE_TITLE###' => '',
					'###RESOURCE_DESCRIPTION###' => '',
					'###RESOURCE_GRAPHIC###' => '',
					'###RESOURCE_CONTENT###' => '',
				);
	 		break;
	 		
	 		case 'tx_wecsermons_liturgical_seasons':
	 			$markerArray = array (
					'###SEASON_NAME###' => '',
				);
	 		break;
	 		
	 	}	
	 	
	 	return $markerArray;
	}
	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$fN: ...
	 * @return	[type]		...
	 */
	function getFieldContent($lConf, $fN)	{
		switch($fN) {

			case '###SERMON_LINK###' :
					return explode (
					'|',
					$this->pi_list_linkSingle(
						'|',
						$row['uid'],
						$this->conf['allowCaching'],
						array (
							'recordType' => 'sermons'
						),
						FALSE,
						$this->conf['pidSingleView'] ? $this->conf['pidSingleView'] : 0
					)
				);
			break;
			
			case 'uid':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
			break;

			case "title":
					// This will wrap the title in a link.
				return $this->pi_list_linkSingle($this->internal['currentRow']['title'],$this->internal['currentRow']['uid'],1);
			break;

			case "occurance_date":
					//	Wrap the occurance date, choosing from one of three settings in typoscript
				$dateWrap = $lConf['occurance_dateWrap.'] ? $lConf['occurance_dateWrap.'] : $lConf['general_dateWrap.'];
				if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
				
				return $this->cObj->stdWrap( $this->internal['currentRow']['occurance_date'], $dateWrap);
			break;

			default:
				return $this->internal['currentRow'][$fN];
			break;
		}
	}
	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$fN: ...
	 * @return	[type]		...
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
	 *
	 * @param	[type]		$fN: ...
	 * @return	[type]		...
	 */
	function getFieldHeader_sortLink($fN)	{
		return $this->pi_linkTP_keepPIvars($this->getFieldHeader($fN),array('sort'=>$fN.':'.($this->internal['descFlag']?0:1)));
	}

	/**
	 * Format string with general_stdWrap from configuration
	 *
	 * @param	string		$string to wrap
	 * @return	string		wrapped string
	 */
	function formatStr($str) {

		if (is_array($this->conf['general_stdWrap.'])) 
			return $this->local_cObj->stdWrap($str, $this->conf['general_stdWrap.']);
		else
			return $str;
	}
	
}	// End class tx_wecsermons_pi1

/**
 * [Describe function...]
 *
 * @return	[type]		...
 */
function uniqueCsv()	{
	$max = func_num_args();
	$ttlString = '';
	for( $i =0; $i < $max; $i++ )  {
		$ttlString .=func_get_arg($i) .  ',';

	}
	return implode(',', array_unique( t3lib_div::trimExplode(',', $ttlString, 1) ) );
}

/**
 * [Describe function...]
 *
 * @return	[type]		...
 */
function unique_array() {
	$max = func_num_args();
	$ttlString = '';
	for( $i =0; $i < $max; $i++ )  {
		$ttlString .=func_get_arg($i) .  ',';

	}
	return array_unique( t3lib_div::trimExplode(',', $ttlString, 1) ) ;

}

/**
 * [Describe function...]
 *
 * @param	string	Table name to search through
 * @param	string	Related table to search for
 * @return	string	The column name that relates currentTable to relatedTable. Returns null if no relation is found.
 */
function get_foreign_column( $currentTable, $relatedTable ) {
	
		//	Load up the tca for given table
	$GLOBALS['TSFE']->includeTCA($TCAloaded = 1);		
	t3lib_div::loadTCA( $currentTable );
	
	foreach( $GLOBALS['TCA'][$currentTable]['columns'] as $columnName => $value ) {
			if( $value['config']['foreign_table'] == $relatedTable )
				return $columnName;
	}
	
	return '';

}

/**
 *		Return the value from either plugin flexform, typoscript, or default value, in that order
 *
 *		@param	object	Parent object passes itself
 *		@param	string	Field name of the flexform value
 *		@param	string	Sheet name where flexform value is located
 *		@param	string	Field name of typoscript value
 *		@param	array	TypoScript parameters from local scope
 *		@param	mixed	Default if no other values are assigned from TypoScript or Plugin Flexform
 *
 *		@return	mixed	Value found in any config, or default
 */
function getConfigVal( &$Obj, $ffField, $ffSheet, $TSfieldname, $lConf, $default = '' ) {
		
		//	Retrieve values stored in flexform and typoscript
	$ffValue = $Obj->pi_getFFvalue($Obj->cObj->data['pi_flexform'], $ffField, $ffSheet);
	$tsValue = $lConf[$TSfieldname];
	
	$retVal = $ffValue ? $ffValue : $tsValue;

	return $retVal ? $retVal : $default;
}

/**
 * Returns a subpart from the input content stream.
 * Enables pre-/post-processing of templates/templatefiles
 *
 * @param	string		$Content stream, typically HTML template content.
 * @param	string		$Marker string, typically on the form "###...###"
 * @param	array		$Optional: the active row of data - if available
 * @return	string		The subpart found, if found.
 */
function getTemplateSubpart($myTemplate, $myKey, $row = Array()) {
	return ($this->cObj->getSubpart($myTemplate, $myKey));
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php']);
}

?>
