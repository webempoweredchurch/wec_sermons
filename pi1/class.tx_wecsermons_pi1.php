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
					$content .= $this->singleView( $content, $this->conf['singleView.'] );
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
					$content .= $this->searchView( $content, $this->conf['searchview.'] );
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
	 * Generates the SINGLE view of a SMS record. 
	 *
	 *	Assumes that $this->internal['currentTable'] and $this->internal['currentRow'] are already populated
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		Local typoscript configuration array
	 * @return	[type]		HTML content of an SMS SINGLE view
	 */
	function singleView($content,$lConf)	{
		$this->pi_loadLL();

			// This sets the title of the page for use in indexed search results:
		if ($this->internal['currentRow']['title'])	$GLOBALS['TSFE']->indexedDocTitle=$this->internal['currentRow']['title'];

			//	If currentRow not already loaded by listView
		if( ! $this->internal['currentRow'] ) {	
			
				//	Recursive setting from plugin overrides typoscript
			$this->conf['recursive'] = getConfigVal( $this, 'recursive', 'sDEF', 'recursive', $lConf, 0 );
	
				//	Find the starting point in the page tree to search for the record
			$startingPoint =$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'startingpoint', 'sDEF');
	
				//	If configured to use the General Storage Folder of the site, include that in the list of pids
			if( $this->conf['useStoragePid'] ) {
	
				//	Retrieve the general storage pid for this site
				$rootPids = $GLOBALS['TSFE']->getStorageSiterootPids();
				$storagePid = (string) $rootPids['_STORAGE_PID'];
	
					//	Merge all lists from typoscript, storagePid, and startingpoint specified at plugin and assign to pidList
				$this->conf['pidList'] .= ','. $storagePid . ','. $startingPoint;
			}
			else 	//	Merge lists from typoscript and startingpoint specified at plugin into pidList
				$this->conf['pidList'] .= ','. $startingPoint;

			//	Check if table is in allowedTables
			if( ! t3lib_div::inList( $this->conf['allowedTables'], $this->piVars['recordType'] ) ) {

				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( ' Row from requested table was not listed in the "allowedTables" typoscript configuration.' );
				$error['detail'] = htmlspecialchars( 'Requested Table: ' . $this->piVars['recordType'] . '. allowedTables: ' . $this->conf['allowedTables'] );
				
				return sprintf( '<p>%s<br/> %s</p>
				<p>%s</p>
				', $error['type'], $error['message'], $error['detail'] );
				
			}
			else {
				$this->internal['currentTable'] = $this->piVars['recordType'];
				$this->internal['currentRow'] = $this->pi_getRecord($this->piVars['recordType'],$this->piVars['showUid']);
				
			}

		}

			//	Load the Layout code, which chooses between templates
			//	TODO: Determine if we need a layout code logic block or not
		$layoutCode = $this->internal['layoutCode'] = getConfigVal( $this, 'layoutCode', 'sDEF', 'layoutCode', $lConf, 1 );

		$templateFile = $this->getTemplateFile();
		
		//	TODO: Create a single view template for each table we need to represent
		
		$templateKey = $this->getTemplateKey( $this->internal['currentTable'] );
		
		$template['total'] = $this->cObj->fileResource($templateFile);
		$template['single'] = $this->getNamedTemplateContent( $templateKey, 'single' );

		if(! $template['single'] ) {
			
				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( 'Unable to retrieve content for specified template.' );
				$error['detail'] = htmlspecialchars( 
					sprintf (
						'Requested Template: ###TEMPLATE_%s_%s%s###',
						strtoupper( $templateKey ),
						'SINGLE',
						$layoutCode
					)
				 );
				
				return sprintf( 
					'<p>%s<br/> %s</p>	<p>%s</p>', 
					$error['type'], 
					$error['message'], 
					$error['detail'] 
				);
		}
		
		$template['content'] = $this->cObj->getSubpart( $template['single'], '###CONTENT###' );
	
		$markerArray = $this->getMarkerArray( $this->internal['currentTable'] );

			//	Process row
		$content .= $this->cObj->substituteSubpart( $template['single'], '###CONTENT###', $this->pi_list_row($lConf, $markerArray, $template['content'], $this->internal['currentRow'] ) );
		
			//	Add the Edit Panel to the output
			//	TODO: Determine if edit panel should go here, or at the top?
		$content .= $this->pi_getEditPanel();
		
			//	Parse for additional markers. Browse results, etc.
		$markerArray = $this->getMarkerArray();

			//	Call pi_list_row to substitute last markers and return results
		return $this->pi_list_row( $lConf, $markerArray, $content );

	}

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function searchView($content,$lConf)	{

		return $this->pi_list_searchbox();
		exit;		
			
		$swords = explode(' ', $this->piVars['sword'] );
		
	}
	
	
	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function listView($content,$lConf)	{

			//	Recursive setting from plugin overrides typoscript
		$this->conf['recursive'] = getConfigVal( $this, 'recursive', 'sDEF', 'recursive', $lConf, 0 );

			//	Find the starting point in the page tree to search for the record
		$startingPoint =$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'startingpoint', 'sDEF');

			//	If configured to use the General Storage Folder of the site, include that in the list of pids
		if( $this->conf['useStoragePid'] ) {

			//	Retrieve the general storage pid for this site
			$rootPids = $GLOBALS['TSFE']->getStorageSiterootPids();
			$storagePid = (string) $rootPids['_STORAGE_PID'];

				//	Merge all lists from typoscript, storagePid, and startingpoint specified at plugin and assign to pidList
			$this->conf['pidList'] .= ','. $storagePid . ','. $startingPoint;
		}
		else 	//	Merge lists from typoscript and startingpoint specified at plugin into pidList
			$this->conf['pidList'] .= ','. $startingPoint;

			// If a single element should be displayed, jump to single view
		if ($this->piVars['showUid'])	{	
	
			//	Check if table is in allowedTables
			if( ! t3lib_div::inList( $this->conf['allowedTables'], $this->piVars['recordType'] ) ) {

				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( ' Row from requested table was not listed in the "allowedTables" typoscript configuration.' );
				$error['detail'] = htmlspecialchars( 'Requested Table: ' . $this->piVars['recordType'] . '. allowedTables: ' . $this->conf['allowedTables'] );
				
				return sprintf( '<p>%s<br/> %s</p>
				<p>%s</p>
				', $error['type'], $error['message'], $error['detail'] );
				
			}
			
			$this->internal['currentTable'] = $this->piVars['recordType'];
			$this->internal['currentRow'] = $this->pi_getRecord($this->piVars['recordType'],$this->piVars['showUid']);

			return $this->singleView($content,$this->conf['singleView.']);
			
		} else {	//	Otherwise continue with list view

				//	List View Modes
			$items=array(
				'1'=> $this->pi_getLL('list_mode_1','Mode 1'),
				'2'=> $this->pi_getLL('list_mode_2','Mode 2'),
				'3'=> $this->pi_getLL('list_mode_3','Mode 3'),
			);
			
				//	Intialize query params if not set
			if (!isset($this->piVars['pointer']))	$this->piVars['pointer']=0;
			if( ! isset( $this->piVars['recordType'] ) ) $this->piVars['recordType'] = getConfigVal( $this, 'detail_table', 'sDEF', 'detail_table', $lConf, 'tx_wecsermons_sermons' );			

				// Initializing the query parameters:
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=t3lib_div::intInRange($lConf['results_at_a_time'],0,1000,20);		// Number of results to show in a listing.
			$this->internal['maxPages']=t3lib_div::intInRange($lConf['maxPages'],0,1000,5);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']=$lConf[$this->piVars['recordType'].'.']['searchFieldList'];		
			$this->internal['orderByList']=$lConf['orderByList'];

				//	Get location and name of HTML template file 
			$templateFile = $this->getTemplateFile();
			
				//	Load the Layout code, which chooses between templates
				//	TODO: Determine if we need a layout code logic block or not
			$layoutCode = getConfigVal($this, 'layout', 'sDEF', 'layout', $lConf, 1);

			$template['total'] = $this->cObj->fileResource($templateFile);


			$template['list'] = $this->cObj->getSubpart( $template['total'], '###TEMPLATE_LIST'.$layoutCode.'###' );
			$template['content'] = $this->cObj->getSubpart( $template['list'], '###CONTENT###' );
		
			$content = $this->cObj->substituteSubpart( $template['list'], '###CONTENT###', $this->pi_list_makelist($lConf, $template['content'] ) );
		
				//	Parse for additional markers. Browse results, etc.
			$markerArray = $this->getMarkerArray();

				//	Call pi_list_row to substitute last markers and return results
			return $this->pi_list_row( $lConf, $markerArray, $content );
		}
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
	function pi_list_makelist($lConf, $template)	 {

			//	 Gather all our output into $content
		$content = '';
		$subpartArray = array();
		$groupTable = getConfigVal( $this, 'group_table', 'sDEF', 'group_table', $lConf );

			//	If we grouping was specified, branch to process group list
		if( $groupTable ) {

			$detailTable = getConfigVal( $this, 'detail_table', 'sDEF', 'detail_table', $lConf );
			$this->template['group'] = $this->cObj->getSubpart( $template, '###GROUP###' );

				//Run a series of checks before branching to grouping logic, return error if necessary
			if( $groupTable == '' || ! $this->template['group'] ) {
				
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
			if( ! t3lib_div::inList( $this->conf['allowedTables'], $groupTable ) ) {
	
				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( 'Table specified in "group_table" option is not in the list of allowed tables option, ".allowedTables"' );
				$error['detail'] = '';
				
				$format =  sprintf( '<p>%s<br/> %s</p>
				<p>%s</p>
				', $error['type'], $error['message'], $error['detail'] );
				
				return $format;
	
			}
			
			if( ! t3lib_div::inList( $this->conf['allowedTables'], $detailTable ) ) {
				
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

		}	//	End if group
		else {	//	No group found, just provide a straight list
			
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
	function pi_list_row($lConf, $markerArray = array(), $rowTemplate, $row ='', $c = 2)	{
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
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_sermons.']['title.'] );
				break;
					
				case '###SERMON_OCCURANCE_DATE###':
					if( $row[$fieldName] )				
					{
							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['tx_wecsermons_sermons.']['occurance.'] ? $lConf['tx_wecsermons_sermons.']['occurance.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
		
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $dateWrap);
					}
				break;
	
				case '###SERMON_DESCRIPTION###':
					if( $row[$fieldName] ) {	
						$this->local_cObj->start( $row, 'tx_wecsermons_sermons' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_sermons.']['description'], $lConf['tx_wecsermons_sermons.']['description.'] );
					}
				break;
					
				case '###SERMON_SCRIPTURE###':
					if( $row[$fieldName] )				
						$markerArray[$key] =  $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_sermons.']['scripture.'] );

				break;  
				
				case '###SERMON_GRAPHIC###':
					if( $row[$fieldName] )				
					{
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$image = t3lib_div::makeInstance('tslib_cObj');
				
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
						);
		
							//	Merge our local config with typoscript config
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['tx_wecsermons_sermons.']['graphic.'] );
					
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
								'recordType' => 'tx_wecsermons_sermons',
							), 
							FALSE, 
							$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0 
							)
					);
				break;
				
				case '###SERMON_SERIES###':

					$subpartArray[$key] = '';
					if( $row[$fieldName] ) {						
							//	TODO: Load the topics template
						$seriesTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$seriesMarkerArray = $this->getMarkerArray('tx_wecsermons_series');
						$seriesContent = '';
						
						$seriesRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery( 
							'tx_wecsermons_series.*', 
							'tx_wecsermons_series',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_series' )
						);


						$count = 0;
						while( $seriesRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $seriesRes ) ) {
								//	Recursive call to $this->pi_list_row() to populate each speaker marker
							$seriesContent .= $this->pi_list_row( $lConf, $seriesMarkerArray, $seriesTemplate, $seriesRow );
							$count++;
						}
			

					//	Replace marker content with subpart, wrapping stdWrap
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $seriesContent, $lConf['tx_wecsermons_sermons.']['series.'] );
							
					}
				
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
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $speakerContent, $lConf['tx_wecsermons_sermons.']['speakers.'] );

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
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $topicContent, $lConf['tx_wecsermons_sermons.']['topics.'] );

					}

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
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_resources.']['title.'] );
				break;

				case '###RESOURCE_DESCRIPTION###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_resources.']['description.'] );
				break;
				
				case '###RESOURCE_GRAPHIC###':
					if( $row[$fieldName] ) {
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$image = t3lib_div::makeInstance('tslib_cObj');
				
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
						);
						
							//	Merge our local config with typoscript config, typoscript overriding
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['tx_wecsermons_resources.']['graphic.'] );
					
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
					
				case '###SERIES_TITLE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_series.']['title.'] );
					
				break;
					
				case '###SERIES_DESCRIPTION###':

					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_series.']['description'], $lConf['tx_wecsermons_series.']['description.'] );
					}
				break;
					
				case '###SERIES_GRAPHIC###':
					if( $row[$fieldName] ) {
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$image = t3lib_div::makeInstance('tslib_cObj');
				
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
						);
						
							//	Merge our local config with typoscript config, typoscript overriding
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['tx_wecsermons_series.']['graphic.'] );
					
							//	Render the image object
						$markerArray[$key] = $image->IMAGE( $imageConf );			
					}
				break;
				
				case '###SERIES_SCRIPTURE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_series.']['scripture.'] );
					
				break;
					
				case '###SERIES_STARTDATE###':
					if( $row[$fieldName] ) {
							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['tx_wecsermons_series.']['startdate.'] ? $lConf['tx_wecsermons_series.']['startdate.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
		
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $dateWrap);
					}
				break;
					
				case '###SERIES_ENDDATE###':
					if( $row[$fieldName] ) {

							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['tx_wecsermons_series.']['enddate.'] ? $lConf['tx_wecsermons_series.']['enddate.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];
		
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $dateWrap);
					}
				break;
				
				case '###SERIES_SEASON###':

						//	Check for related season and insert season subpart
					$subpartArray[$key] = '';

					if( $row[$fieldName] ) {

							//	TODO: Load the topics template
						$seasonTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$seasonMarkerArray = $this->getMarkerArray('tx_wecsermons_liturgical_seasons');
						$seasonContent = '';
						
						$seasonRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery( 
							'tx_wecsermons_liturgical_season.*', 
							'tx_wecsermons_liturgical_season',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_liturgical_season' )
						);

						$count = 0;
						while( $seasonRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $seasonRes ) ) {
		
								//	Recursive call to $this->pi_list_row() to populate each speaker marker
							$seasonContent .= $this->pi_list_row( $lConf, $seasonMarkerArray, $seasonTemplate, $seasonRow );
							$count++;
						}
			
							//	Replace marker content with subpart
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $seasonContent, $lConf['tx_wecsermons_liturgical_sermons.']['seasons.'] );

					}

					
				break;
					
				case '###SERIES_TOPICS###':
				
					$subpartArray[$key] = '';

						// Check for related topics and insert topic subpart
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
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $topicContent, $lConf['tx_wecsermons_series.']['topics.'] );

					}
					
				break;
				
				case '###SERIES_LINK###':
				
					$wrappedSubpartArray[$key] = explode( 
						'|',
						$this->pi_list_linkSingle(
							'|', 
							$row['uid'], 
							$this->conf['allowCaching'],
							array(
								'recordType' => 'tx_wecsermons_series',
							), 
							FALSE, 
							$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0 
							)
					);
				
				break;
					
				case '###TOPIC_TITLE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_topics.']['title.'] );
					
				break;
					
				case '###TOPIC_DESCRIPTION###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_topics.']['description.'] );
					
				break;
					
				case '###SEASON_TITLE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_seasons.']['title.'] );
					
				break;
					
				case '###SPEAKER_FIRSTNAME###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_speakers.']['firstname.'] );
					
				break;
					
				case '###SPEAKER_LASTNAME###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_speakers.']['lastname.'] );
					
				break;
					
				case '###SPEAKER_URL###':
				
						//	TODO: Create a link out of this content
					if( $row[$fieldName] ) {
							$markerArray[$key] = $this->cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_speakers.']['url.'] );
					}
				break;
					
				case '###SPEAKER_EMAIL###':
						
						//	TODO: Create link, making sure it is spam protected
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_speakers.']['email'], $lConf['tx_wecsermons_speakers.']['email.'] );
					}
				break;
					
				case '###SPEAKER_PHOTO###':
					if( $row[$fieldName] ) {
						// Use IMAGE object to draw. Implement so we can allow configuration though typoscript
						$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						$imageConf = array(
							'file' => 'uploads/tx_wecsermons/' . $row[$fieldName],
						);
						
							//	Merge our local config with typoscript config, typoscript overriding
						$imageConf = t3lib_div::array_merge( $imageConf, $lConf['tx_wecsermons_speakers.']['photo.'] );
					
							//	Render the image object
						$markerArray[$key] = $this->local_cObj->cObjGetSingle($lConf['tx_wecsermons_speakers.']['photo'], $imageConf );			
					}
				break;

				case '###SPEAKER_LINK###':
				
						//	Create a link out of this content
					$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						//	TODO: Figure out how to use this for all fields.
					$wrappedSubpartArray[$key] = explode( '|', $this->local_cObj->cObjGetSingle($lConf['tx_wecsermons_speakers.']['url'], $lConf['tx_wecsermons_speakers.']['url.'] ) );
break;
					$markerArray[$key] = explode( '|', $this->cObj->stdWrap( $marker, $lConf['tx_wecsermons_speakers.']['url.'] ) );
	
						//	TODO: Create option to use 'url' field instead of link to single view?
					$wrappedSubpartArray[$key] = explode( 
						'|',
						$this->pi_list_linkSingle(
							'|', 
							$row['uid'], 
							$this->conf['allowCaching'],
							array(
								'recordType' => 'tx_wecsermons_speakers',
							), 
							FALSE, 
							$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0 
						)
					);
				break;

				case '###ALTERNATING_CLASS###':
					$markerArray['###ALTERNATING_CLASS###'] = $c % 2 ? $this->pi_getClassName( $lConf['alternatingClass'] )  : '';
				break;
				
				case '###BROWSE_LINKS###':
					$markerArray['###BROWSE_LINKS###'] = $this->pi_list_browseresults();
				break;
				
				case '###BACK_LINK###':
					
						//	If recordType is not set, retreive value or set it to sermons table. This is in case of hard linking to the single view instead of linking through the list view.					
					if( ! isset( $this->piVars['recordType'] ) ) $this->piVars['recordType'] = getConfigVal( $this, 'detail_table', 'sDEF', 'detail_table', $lConf, 'tx_wecsermons_sermons' );

					$wrappedSubpartArray[$key] = explode( 
						'|',
						$this->pi_list_linkSingle(
							'|', 
							$lConf['pidListView'], 
							$this->conf['allowCaching'],
							array(
								'recordType' => $this->piVars['recordType'],
							), 
							FALSE 
							)
					);
				break;
				
				case '###BACK_TO_LIST###':
				
					$markerArray[$key] =  $this->cObj->stdWrap( $this->pi_getLL('back','Back'), $lConf['back.'] );
			
				break;
				
				}	// End Switch
				
				//	TODO: Add a hook here for processing extra markers

		}	// End Foreach

			//	TODO: Include the edit icons for editing the records from the front end

		$lContent = $this->cObj->substituteMarkerArrayCached($rowTemplate, $markerArray, $subpartArray, $wrappedSubpartArray );
		
	return $lContent;
	}

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
	 function getMarkerArray( $tableName = '' ) {
	 	
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
	 		
	 		default:
	 			$markerArray = array (
	 				'###BROWSE_LINKS###' => '',
	 				'###BACK_TO_LIST###' => '',
	 				'###BACK_LINK###' => '',
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
	function getFieldHeader($fN)	 {
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

		if ( is_array( $this->conf['general_stdWrap.'] ) ) 
			return $this->local_cObj->stdWrap($str, $this->conf['general_stdWrap.']);
		else
			return $str;
	}
		
	/**
	 *		Retrieves the content for a named template. Used to pull a template subpart from a template file
	 *
	 * @param	string		$tableName. This is the tablename to retrieve the keyname for.
	 */
	function getTemplateKey($tableName) {
		
		switch( $tableName ) {
			case 'tx_wecsermons_sermons':
				$key = 'sermon';
			break;
			
			case 'tx_wecsermons_resources':
				$key = 'resource';
			break;
			
			case 'tx_wecsermons_topics':
				$key = 'topic';		
			break;
			
			case 'tx_wecsermons_liturgical_season':
				$key = 'season';
			break;
	
			case 'tx_wecsermons_series':
				$key = 'series';
			break;
	
			case 'tx_wecsermons_speakers':
				$key = 'speaker';
			break;
			
			}
			
			//	TODO: Add hook for custom tables
			
			return $key;

	}
	
	/**
	 *		Retrieves the content for a named template. Used to pull a template subpart from a template file
	 *
	 * @param	string		$key. This is the keyname of the type of template to retrieve such as SERMON, SERIES, TOPIC, etc.
	 * @return	string		$view. This is the name of the view to retrieve, SINGLE, LIST, etc.
	 */
	function getNamedTemplateContent($key = 'sermon', $view = 'single') {
		
		if( !$this->internal['templateFile'] ) $this->getTemplateFile();
		if( !$this->internal['layoutCode'] ) getConfigVal( $this, 'layoutCode', 'sDEF', 'layoutCode', $lConf, 1 );
		
		$template = $this->cObj->fileResource($this->internal['templateFile'] );
		$key = strtoupper( $key );
		$view = strtoupper( $view );
		
		$templateContent = $this->cObj->getSubpart( 
			$template, 
			sprintf( '###TEMPLATE_%s_%s%s###', 
				$key,
				$view,
				$this->internal['layoutCode']
			)
		);
		
		return $templateContent;
	}
	
	function getTemplateFile() {

			//	Load the HTML template from either plugin or typoscript configuration, plugin overrides
		$templateFile = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'templateFile', 'sDEF');

		$templateFile = $templateFile ? 'uploads/tx_wecsermons/'.$templateFile : $this->conf['templateFile'];
				
			//	Store the name of the template file, for retrieval later
		$this->internal['templateFile'] = $templateFile;
		
		return $templateFile;

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

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php']);
}

?>
