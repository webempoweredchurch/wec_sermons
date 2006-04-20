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
				
				//	Store the name of the template file, for retrieval later
			$this->internal['templateFile'] = $templateFile;
			
				//	Load the Layout code, which chooses between templates
				//	TODO: Determine if we need a layout code logic block or not
			$layoutCode = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'layoutCode', 'sDEF');
			if( !$layoutCode ) $layoutCode = '2';	//	LayoutCode default = 3

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

			//	TODO: Refactor Group code to use new pi_list_row code and marker arrays
			
			//	 Gather all our output into $content
		$content = '';
		$subpartArray = array();
		$groupTable = getConfigVal( $this, 'group_table', 'sDEF', 'group_table', $lConf );

			//	If we grouping was specified, branch to process group list
		if( $groupTable ) {
	
			$detailTable = getConfigVal( $this, 'detail_table', 'sDEF', 'detail_table', $lConf );
			$this->template['group'] = $this->cObj->getSubpart( $template, '###GROUP###' );
	
				//Run a series of checks before branching to grouping logic, return error if necessary
			if( $groupTable == '' && ! $this->template['group'] ) {
				
				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( ' "group_table" option was specified, but no ###GROUP### tag was found in the template.' );
				$error['detail'] = htmlspecialchars( 'Template file: ' . $this->internal['templateFile'] );
				
				$format =  sprintf( '<p>%s<br/> %s</p>
				<p>%s</p>
				', $error['type'], $error['message'], $error['detail'] );
				
				return $format;
			}
				//	Check if group_table is in list of allowed tables
			if( ! t3lib_div::inList( $lConf['allowedTables'], $groupTable ) ) {
	
				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( 'Table specified in "group_table" option is not in the list of allowed tables option, ".allowedTables"' );
				$error['detail'] = '';
				
				$format =  sprintf( '<p>%s<br/> %s</p>
				<p>%s</p>
				', $error['type'], $error['message'], $error['detail'] );
				
				return $format;
	
			}
			
			if( ! t3lib_div::inList( $lConf['allowedTables'], $detailTable ) ) {
				
				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( 'Table specified in "detail_table" option is not in the list of allowed tables option, ".allowedTables"' );
				$error['detail'] = '';
				
				$format =  sprintf( '<p>%s<br/> %s</p>
				<p>%s</p>
				', $error['type'], $error['message'], $error['detail'] );
				
				return $format;
	
			}

			$markerArray = $this->getMarkerArray( $groupTable );
			$groupTemplate = $this->template['group'];
			$groupContent = '';

			$this->internal['currentTable'] = $this->internal['groupTable'] = $groupTable;
			$res = $this->pi_exec_query($groupTable);
				
				//	Search TCA for relation to previous table where columns.[colName].config.foreign_table = $this->internal['groupTable']
				//	TODO: Provide more friendly error handling
			$foreign_column = get_foreign_column( $detailTable, $this->internal['groupTable'] );
			if( ! $foreign_column )
				return '<p>WEC Sermons Error!<br/> Grouping tag, &quot;###GROUP###&quot; was found in template, but was not related to &quot;table_to_list&quot;</p>';

				//	Retreive marker array and template for the detail table
			$detailMarkArray = $this->getMarkerArray( $detailTable );
			$detailTemplate = $this->template['item'] = $this->cObj->getSubpart( $template, '###DETAIL###' );

				//	Iterate every record in groupTable
			while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) ) {
				
					//	Process the current row
				$groupContent .= $this->pi_list_row( $lConf, $markerArray, $groupTemplate, $this->internal['currentRow'] );
			
					//	Store previous row and table as we switch to retreiving detail		
				$this->internal['previousRow'] = $this->internal['currentRow'];
				$this->internal['previousTable'] = $this->internal['currentTable'];
				
				$this->internal['currentTable'] = $detailTable;

					//	Exec query on detail table, for every record related to our group record
				$detailRes = $this->pi_exec_query( $detailTable, 0, ' AND ' . $foreign_column . ' in (' . $this->internal['previousRow']['uid'] . ')' );

				$detailCount = 0;
				while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $detailRes ) ) {
					$groupContent .= $this->pi_list_row( $lConf, $detailMarkArray, $detailTemplate, $this->internal['currentRow'] );
					$detailCount++;
				}
				
				//	Restore row and table to internal storage
				$this->internal['currentRow'] = $this->internal['previousRow'];
				$this->internal['currentTable'] = $this->internal['previousTable'];
				
					//	Aggregate groupContent into content if detail records exist.
				if( $detailCount > 0 )
					$content .= $groupContent;
				
				$groupContent = '';
			}
			
			return $content;
							
				switch( $key ) {
					
					case '###SERMON_SERIES###':
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
//			}	// End foreach

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
	function pi_list_row($lConf, $markerArray = array(), $rowTemplate, $row, $c = 2)	{
		$wrappedSubpartArray = array();
		$subpartArray = array();

			//	Get Editpanel for $this->internal['currentRow']
		$editPanel = $this->pi_getEditPanel();
		if ($editPanel)	$editPanel='<TD>'.$editPanel.'</TD>';
			
			//	Using passed markerArray, process each key and insert field content
			//	The reason we are have this looping structure is for future off-loading of this logic
		foreach( $markerArray as $key => $value ) {

				$fieldName = $value;
				$markerArray[$key] = '';
	
				switch( $key ) {
					
				case '###SERMON_TITLE###':
					if( $row[$fieldName] )				
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['sermons.']['title_stdWrap.'] );
				break;
					
				case '###SERMON_OCCURANCE_DATE###':
					if( $row[$fieldName] )				
					{
							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['sermons.']['occurance_stdWrap.'] ? $lConf['sermons.']['occurance_stdWrap.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
		
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $dateWrap);
					}
				break;
	
				case '###SERMON_DESCRIPTION###':
					if( $row[$fieldName] )				
						$markerArray[$key] =  $this->cObj->stdWrap( $row[$fieldName], $lConf['sermons.']['description_stdWrap.'] );
				break;
					
				case '###SERMON_SCRIPTURE###':
					if( $row[$fieldName] )				
						$markerArray[$key] =  $this->cObj->stdWrap( $row[$fieldName], $lConf['sermons.']['scripture_stdWrap.'] );

				break;  
				
				case '###SERMON_GRAPHIC###':
					if( $row[$fieldName] )				
					{
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$image = t3lib_div::makeInstance('tslib_cObj');
				
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
							'altText' => 'AltText',
						);
		
							//	Merge our local config with typoscript config
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['sermons.']['graphic_IMAGE.'] );
					
							//	Render the image object
						$markerArray[$key] = $image->IMAGE( $imageConf );			
					}
					break;
		
	
				case '###SERMON_LINK###':
					$wrappedSubpartArray[$key] = explode( 
						'|',
						$this->pi_list_linkSingle(
							'|', 
							$row['uid'], 
							$this->conf['allowCaching'],
							array(
								'record' => 'tx_wecsermons_sermons',
							), 
							FALSE, 
							$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0 
							)
					);
				break;
				
				case '###SERMON_SPEAKERS###':
		
					$subpartArray[$key] = '';
					if( $row[$fieldName] ) {

							//	Get the speakers subpart
						$speakerTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$speakerMarkerArray = $this->getMarkerArray('tx_wecsermons_speakers');
						$speakerContent = '';

							//	Retrieve all speaker records that are related to this sermon
						$speakerRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery( 
							'tx_wecsermons_speakers.*', 
							'tx_wecsermons_speakers',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_speakers' )
						);

						$count = 0;
						while( $speakerRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $speakerRes ) ) {
		
								//	Recursive call to $this->pi_list_row() to populate each speaker marker
							$speakerContent .= $this->pi_list_row( $lConf, $speakerMarkerArray, $speakerTemplate, $speakerRow );
							$count++;
						}
			
							//	Replace marker content with subpart, wrapping stdWrap
						$subpartArray[$key] = $this->cObj->stdWrap( $speakerContent, $lConf['sermons.']['speakers_stdWrap.'] );

					}
				break;
								
				case '###SERMON_TOPICS###':

					$subpartArray[$key] = '';

					if( $row[$fieldName] ) {

							//	TODO: Load the topics template
						$topicTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$topicMarkerArray = $this->getMarkerArray('tx_wecsermons_topics');
						$topicContent = '';
						
						$topicRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery( 
							'tx_wecsermons_topics.*', 
							'tx_wecsermons_topics',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_topics' )
						);

						$count = 0;
						while( $topicRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $topicRes ) ) {
		
								//	Recursive call to $this->pi_list_row() to populate each speaker marker
							$topicContent .= $this->pi_list_row( $lConf, $topicMarkerArray, $topicTemplate, $topicRow );
							$count++;
						}
			
							//	Replace marker content with subpart
						$subpartArray[$key] = $this->cObj->stdWrap( $topicContent, $lConf['sermons.']['topics_stdWrap.'] );

					}

				break;

				case '###ALTERNATING_CLASS###':
					$markerArray['###ALTERNATING_CLASS###'] = $c % 2 ? $this->pi_classParam( $lConf['alternatingClass'] ) : '';
				break;
				
				case '###SERMON_RESOURCES###':
				break;
						//	Select the related resources and the resource type			
					$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query(
						'tx_wecsermons_resources.*',
						'tx_wecsermons_sermons',
						'tx_wecsermons_sermons_resources_uid_mm',
						'tx_wecsermons_resources',
						' AND tx_wecsermons_sermons_resources_uid_mm.uid_local in (' . $row['uid'] . ')'
					);

					$count = 0;
					while( $resource = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res ) ) {
						
						//	TODO: For any resource type, define a particular rendering method
						
						if( ! $resource['file'] && $resource['url'] )	{	//	No file attached and URL location given
							
							// TODO: simply wrap the url in an anchor tag
						}
					}
				break;
				
				case '###RESOURCE_TITLE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['resources.']['title_stdWrap.'] );
				break;

				case '###RESOURCE_DESCRIPTION###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['resources.']['description_stdWrap.'] );
				break;
				
				case '###RESOURCE_GRAPHIC###':
					if( $row[$fieldName] ) {
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$image = t3lib_div::makeInstance('tslib_cObj');
				
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
						);
						
							//	Merge our local config with typoscript config, typoscript overriding
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['resources.']['graphic_IMAGE.'] );
					
							//	Render the image object
						$markerArray[$key] = $image->IMAGE( $imageConf );			
					}
				break;
				
				case '###RESOURCE_CONTENT###':
						//	Branch if file exists, otherwise look for a url alternate location
					if( $row['file'] ) {
						//	TODO: Generate view to file, depending on file type and other criteria
					}
					else if( $row['url'] ) {
						//	TODO: Link to the resource
					}
				break;
					
				case '###RESOURCE_GRAPHIC###':
					if( $row[$fieldName] ) {
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$image = t3lib_div::makeInstance('tslib_cObj');
				
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
						);
						
							//	Merge our local config with typoscript config, typoscript overriding
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['series.']['graphic_IMAGE.'] );
					
							//	Render the image object
						$markerArray[$key] = $image->IMAGE( $imageConf );			
					}
				break;
				
				case '###SERIES_TITLE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['series.']['title_stdWrap.'] );
					
				break;
					
				case '###SERIES_DESCRIPTION###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['series.']['description_stdWrap.'] );
					
				break;
					
				case '###SERIES_SCRIPTURE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['series.']['scripture_stdWrap.'] );
					
				break;
					
				case '###SERIES_STARTDATE###':
							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['series.']['startdate_stdWrap.'] ? $lConf['series.']['startdate_stdWrap.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
		
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $dateWrap);
					
				break;
					
				case '###SERIES_ENDDATE###':
							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['series.']['enddate_stdWrap.'] ? $lConf['series.']['enddate_stdWrap.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
		
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $dateWrap);
					
				break;
				
				case '###SERIES_SEASON###':
				
						//	TODO: Check for related season and insert season subpart
					if( $row[$fieldName] > 0 ) {
						
						
						
					}
					
				break;
					
				case '###SERIES_TOPICS###':
				
						// TODO: Check for related topics and insert topic subpart
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['series.']['season_stdWrap.'] );
					
				break;
				
				case '###SERIES_LINK###':
				
					$wrappedSubpartArray[$key] = explode( 
						'|',
						$this->pi_list_linkSingle(
							'|', 
							$row['uid'], 
							$this->conf['allowCaching'],
							array(
								'record' => 'tx_wecsermons_series',
							), 
							FALSE, 
							$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0 
							)
					);
				
				break;
					
				case '###TOPIC_TITLE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['topics.']['title_stdWrap.'] );
					
				break;
					
				case '###TOPIC_DESCRIPTION###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['topics.']['description_stdWrap.'] );
					
				break;
					
				case '###SEASON_TITLE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['seasons.']['title_stdWrap.'] );
					
				break;
					
				case '###SPEAKER_FIRSTNAME###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['speakers.']['firstname_stdWrap.'] );
					
				break;
					
				case '###SPEAKER_LASTNAME###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['speakers.']['lastname_stdWrap.'] );
					
				break;
					
				case '###SPEAKER_URL###':
				
						//	TODO: Create a link out of this content
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['speakers.']['url_stdWrap.'] );
					
				break;
					
				case '###SPEAKER_EMAIL###':
						
						//	TODO: Create link, making sure it is spam protected
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['speakers.']['email_stdWrap.'] );
					
				break;
					
				case '###SPEAKER_PHOTO###':
					if( $row[$fieldName] ) {
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$image = t3lib_div::makeInstance('tslib_cObj');
				
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
						);
						
							//	Merge our local config with typoscript config, typoscript overriding
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['speakers.']['photo_IMAGE.'] );
					
							//	Render the image object
						$markerArray[$key] = $image->IMAGE( $imageConf );			
					}
				break;

				case '###SPEAKER_LINK###':
				
						//	TODO: Create option to use 'url' field instead of link to single view?
					$wrappedSubpartArray[$key] = explode( 
						'|',
						$this->pi_list_linkSingle(
							'|', 
							$row['uid'], 
							$this->conf['allowCaching'],
							array(
								'record' => 'tx_wecsermons_speakers',
							), 
							FALSE, 
							$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0 
							)
					);
				break;

				}	// End Switch
				
				//	TODO: Add a hook here for processing extra markers

//			} // End else

		}	// End Foreach

			//	TODO: Include the edit icons for editing the records from the front end

		$lContent = $this->cObj->substituteMarkerArrayCached($rowTemplate, $markerArray, $subpartArray, $wrappedSubpartArray );
		
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
					'###SERMON_LINK###' => '',
					'###ALTERNATING_CLASS###' => '',
	 			);
	 		break;
	 		
	 		case 'tx_wecsermons_series':
	 			$markerArray = array (
					'###SERIES_TITLE###' => 'title',
					'###SERIES_STARTDATE###' => 'startdate',
					'###SERIES_ENDDATE###' => 'enddate',
					'###SERIES_DESCRIPTION###' => 'description',
					'###SERIES_SCRIPTURE###' => 'scripture',
					'###SERIES_SEASON###' => 'liturgical_season_uid',
					'###SERIES_TOPICS###' => 'topics_uid',
					'###SERIES_GRAPHIC###' => 'graphic',
					'###SERIES_LINK###' => '',
					'###ALTERNATING_CLASS###' => '',
					
				);	 		
	 		break;
	 		
	 		case 'tx_wecsermons_topics':
	 			$markerArray = array (
					'###TOPIC_TITLE###' => 'name',
					'###TOPIC_DESCRIPTION###' => 'description',
					'###ALTERNATING_CLASS###' => '',
				);
	 		break;
	 		
	 		case 'tx_wecsermons_speakers':
	 			$markerArray = array (
					'###SPEAKER_FIRSTNAME###' => 'firstname',
					'###SPEAKER_LASTNAME###' => 'lastname',
					'###SPEAKER_EMAIL###' => 'email',
					'###SPEAKER_URL###' => 'url',
					'###SPEAKER_PHOTO###' => 'photo',
					'###SPEAKER_LINK###' => '',
					'###ALTERNATING_CLASS###' => '',
				);
	 		break;

	 		case 'tx_wecsermons_resources':
	 			$markerArray = array (
					'###RESOURCE_TITLE###' => 'title',
					'###RESOURCE_DESCRIPTION###' => 'description',
					'###RESOURCE_GRAPHIC###' => 'graphic',
					'###RESOURCE_CONTENT###' => '',
					'###ALTERNATING_CLASS###' => '',
				);
	 		break;
	 		
	 		case 'tx_wecsermons_liturgical_seasons':
	 			$markerArray = array (
					'###SEASON_TITLE###' => 'season_name',
					'###ALTERNATING_CLASS###' => '',
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
 *		@param	array	TypoScript configuration array from local scope
 *		@param	mixed	Default if no other values are assigned from TypoScript or Plugin Flexform
 *
 *		@return	mixed	Value found in any config, or default
 */
function getConfigVal( &$Obj, $ffField, $ffSheet, $TSfieldname, $lConf, $default = '' ) {
		
		//	Retrieve values stored in flexform and typoscript
	$ffValue = $Obj->pi_getFFvalue($Obj->cObj->data['pi_flexform'], $ffField, $ffSheet);
	$tsValue = $lConf[$TSfieldname];
	
		//	Use flexform value if present, otherwise typoscript value
	$retVal = $ffValue ? $ffValue : $tsValue;

		//	Return value if found, otherwise default
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
