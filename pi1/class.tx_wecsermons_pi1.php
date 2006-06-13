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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   69: class tx_wecsermons_pi1 extends tslib_pibase
 *   83:     function init($conf)
 *   99:     function main($content,$conf)
 *  251:     function singleView($content,$lConf)
 *  351:     function searchView($content,$lConf)
 *  364:     function pi_list_searchbox($lConf)
 *  415:     function listView($content,$lConf)
 *  502:     function pi_list_makelist($lConf, $template)
 *  659:     function pi_list_row($lConf, $markerArray = array(), $rowTemplate, $row ='', $c = 2)
 * 1228:     function pi_list_header()
 * 1243:     function getMarkerArray( $tableName = '' )
 * 1342:     function getFieldHeader($fN)
 * 1359:     function getFieldHeader_sortLink($fN)
 * 1369:     function formatStr($str)
 * 1383:     function getTemplateKey($tableName)
 * 1424:     function getFeAdminList( $tableName = '' )
 * 1443:     function getNamedTemplateContent($keyName = 'sermon', $view = 'single')
 * 1496:     function getNamedSubpart( $subpartName, $content )
 * 1509:     function loadTemplate()
 * 1535:     function getTemplateFile()
 * 1555:     function getResourceContent()
 * 1564:     function registerResource()
 * 1575:     function uniqueCsv()
 * 1590:     function unique_array()
 * 1608:     function get_foreign_column( $currentTable, $relatedTable )
 * 1634:     function getConfigVal( &$Obj, $ffField, $ffSheet, $TSfieldname, $lConf, $default = '' )
 *
 * TOTAL FUNCTIONS: 25
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

require_once(PATH_tslib.'class.tslib_pibase.php');
#require_once(PATH_typo3conf . 'ext/wec_api/class.wec_xml.php' );

class tx_wecsermons_pi1 extends tslib_pibase {
	var $prefixId = 'tx_wecsermons_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_wecsermons_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'wec_sermons';	// The extension key.
	var $pi_checkCHash = TRUE;
	var $template = null;


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
			//	TODO: Determine if we need a layout code logic block or not
		$this->internal['layoutCode'] = getConfigVal( $this, 'layout', 'sDEF', 'layoutCode', $lConf, 1 );	//	Set layoutCode into internal storage
// ( $this->internal['layoutCode'] );
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

		$tutorial = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'tutorial','sMisc');

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
		$display = getConfigVal( $this, 'display', 'sDEF', 'code', $this->conf );

			//	Check codes for 'rss', and if found then we only display the RSS and nothing else.
			//	The XML output of the RSS view can not be output along with any other view.
		$display = strpos( $display, 'rss' ) ? 'rss' : $display;

			//	Check codes for 'list', and if showing only a single record, set codes to a single 'list' code only.
		$display = strpos( $display,'list') && $this->piVars['showUid'] ? 'list' : $display;

		$codes = $this->internal['codes'] = t3lib_div::trimExplode(',',$display,0);

		foreach( $codes as $code ) {
			switch( $code ) {	//	Primary switch for this plugin
				case 'single':
					$this->internal['currentCode'] = 'single';
					$content .= $this->singleView( $content, $this->conf['singleView.'] );
					break;

				case 'list':
					$this->internal['currentCode'] = 'list';
					$content .= $this->listView($content, $this->conf['listView.']);
					break;

				case 'rss':
					$this->internal['currentCode'] = 'rss';
					$content .= '<h1>rss case reached</h1><br/>';
					break;

				case 'archive':
					$this->internal['currentCode'] = 'archive';
					$content .= '<h1>archive case reached</h1><br/>';
					break;

				case 'search':
					$this->internal['currentCode'] = 'search';
					$content .= $this->searchView( $content, $this->conf['searchView.'] );
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
	 * 	Assumes that $this->internal['currentTable'] and $this->internal['currentRow'] are already populated
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		Local typoscript configuration array
	 * @return	[type]		HTML content of an SMS SINGLE view
	 */
	function singleView($content,$lConf)	{
		$this->pi_loadLL();

			// This sets the title of the page for use in indexed search results:
		if ($this->internal['currentRow']['title'])	$GLOBALS['TSFE']->indexedDocTitle=$this->internal['currentRow']['title'];


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

		$this->internal['currentTable'] = $this->piVars['recordType'];

		//	Check if table is in allowedTables
		if( ! t3lib_div::inList( $this->conf['allowedTables'], $this->internal['currentTable']  ) ) {

			$error = array();
			$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
			$error['message'] = htmlspecialchars( ' Row from requested table was not listed in the "allowedTables" typoscript configuration.' );
			$error['detail'] = htmlspecialchars( 'Requested Table: ' . $this->internal['currentTable']  . '. allowedTables: ' . $this->conf['allowedTables'] );

			return sprintf( '<p>%s<br/> %s</p>
			<p>%s</p>
			', $error['type'], $error['message'], $error['detail'] );

		}

		//	Check if showUid is an int
		if( ! t3lib_div::testInt( $this->piVars['showUid'] ) ) {

			$error = array();
			$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
			$error['message'] = htmlspecialchars( ' UID for requested resource was not valid.' );
			$error['detail'] = htmlspecialchars( 'Requested UID: ' . $this->piVars['showUid'] );

			return sprintf( '<p>%s<br/> %s</p>
			<p>%s</p>
			', $error['type'], $error['message'], $error['detail'] );

		}

			//	Retrieve the template key, which is the translation between the real table name and the template naming.
			//	Branch between resource templates and other templates
			//	TODO: What about if record is resource - we have two differnent types, plugin and other.
		if( $this->internal['currentTable'] == 'tx_wecsermons_resources' ) {

				//	TODO: allow specification of what record to draw from TypoScript
			$resource = $this->getResources( '' , $this->piVars['showUid'] ) ;
			$this->internal['currentRow'] = $resource[0];

			$templateName = $this->internal['currentRow']['type'] == 'plugin' ?
				$this->internal['currentRow']['resource_template_name']
				: $this->internal['currentRow']['resource_type_template_name'];

			$this->loadTemplate();
			$this->template['single'] = $this->getNamedSubpart( $templateName, $this->template['total'] );

		}
		else {
			$templateKey = $this->getTemplateKey( $this->internal['currentTable'] );
			$this->template['single'] = $this->getNamedTemplateContent( $templateKey );

				//	TODO: allow specification of what record to draw from TypoScript
			$this->internal['currentRow'] = $this->pi_getRecord($this->piVars['recordType'],$this->piVars['showUid']);
		}

			//	Report an error if we couldn't pull up the template.
		if(! $this->template['single'] ) {

				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( 'Unable to retrieve content for specified template.' );
				$error['detail'] = htmlspecialchars(
					sprintf (
						'Requested Template: ###TEMPLATE_%s_%s%s###',
						strtoupper( $templateKey ),
						'SINGLE',
						$this->internal['layoutCode']
					)
				 );

				return sprintf(
					'<p>%s<br/> %s</p>	<p>%s</p>',
					$error['type'],
					$error['message'],
					$error['detail']
				);
		}

		$this->template['content'] = $this->cObj->getSubpart( $this->template['single'], '###CONTENT###' );

			//	Retrieve the markerArray for the right table
		$markerArray = $this->getMarkerArray( $this->internal['currentTable'] );

			//	Process row
		$content .= $this->cObj->substituteSubpart( $this->template['single'], '###CONTENT###', $this->pi_list_row($lConf, $markerArray, $this->template['content'], $this->internal['currentRow'] ) );

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

		return "\n\n".$this->pi_list_searchbox($lConf);


	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$lConf: ...
	 * @return	[type]		...
	 */
	function pi_list_searchbox($lConf) {

			//	Retrieve searchbox from template
		$searchBoxTemplate = $this->getNamedTemplateContent( 'searchbox', '' );

		$markerArray = $this->getMarkerArray('searchbox');

		$markerArray['###SEARCH_BUTTON_NAME###'] = $this->pi_getLL('pi_list_searchBox_search');

			//	Find the PID that we should post form data to
		$pid = getConfigVal( $this, '', '', 'pidSearchView', $this->conf, $GLOBALS['TSFE']->id );

		$markerArray['###FORM_ACTION###'] = $this->cObj->typolink_URL( array( 'parameter' => $pid ) );


/*	This commented section will enable us to search through multiple tables to perform deeper searches in the future
	
		$tables = t3lib_div::trimExplode( ',', $lConf['searchTables'], 1 );

		$selectContent ='';
		foreach( $tables as $tableName ) {

			//	Grab the tablename from locallang_db
			$llName = $GLOBALS['TSFE']->sL('LLL:EXT:wec_sermons/locallang_db.php:'.$tableName);
			$option = "\n<option value=\"" . $tableName . '">'. $llName. "</option>";
			$selectContent .= $option;
		}

		$markerArray['###SEARCHBOX_OPTIONS###'] = $this->cObj->stdWrap(
			$selectContent,
			array(
				'wrap' => "\n<select class=\"".$this->pi_getClassName('searchbox-select')."\" name=\"tx_wecsermons_pi1[sword_table]\">|\n</select>"
			)
		);
*/
			//	For now we're just going to skip this options section, only searching in tx_wecsermons_sermons
		$markerArray['###SEARCHBOX_OPTIONS###'] = '';

		return $this->cObj->substituteMarkerArrayCached( $searchBoxTemplate, $markerArray );

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
			if( !isset( $this->piVars['recordType'] ) ) $this->piVars['recordType'] = getConfigVal( $this, 'detail_table', 'slistView', 'detail_table', $lConf, 'tx_wecsermons_sermons' );

				// Initialize some query parameters, and internal variables
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=t3lib_div::intInRange($lConf['results_at_a_time'],0,1000,20);		// Number of results to show in a listing.
			$this->internal['maxPages']=t3lib_div::intInRange($lConf['maxPages'],0,1000,5);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['dontLinkActivePage']=$lConf['dontLinkActivePage'];
			$this->internal['showFirstLast']=$lConf['showFirstLast'];
			$this->internal['pagefloat']=$lConf['pagefloat'];
			$this->internal['showRange']=$lConf['showRange'];

			$this->internal['orderByList']=$lConf[$this->piVars['recordType'].'.']['orderByList'];
			$this->internal['orderBy']=$lConf[$this->piVars['recordType'].'.']['orderBy'];
			$this->internal['descFlag']=$lConf[$this->piVars['recordType'].'.']['descFlag'];

/*	This commented section will enable us to search through multiple tables to perform deeper searches in the future

				//	Check if selected table is in list of allowed tables, throw error if necessary
			if($this->piVars['sword_table'] && ! t3lib_div::inList( $this->conf['searchView.']['searchTables'], trim( $this->piVars['sword_table'] ) ) ) {
				return $this->throwError(
					'WEC Sermons Error',
					"The table name '" . $this->piVars['sword_table'] . "' was not in the allowed list of tables: '" . $this->conf['searchView.']['searchTables'],
					"Please check the TypoScript configuration for the setting of 'searchView.searchTables'"
				);
			}
*/

			$this->internal['sword_table'] = 'tx_wecsermons_sermons';	//	Migrate to $this->piVars['sword_table'] in future
			$this->internal['searchFieldList']=$this->conf['searchView.']['searchFieldArray.'][$this->internal['sword_table'].'.']['searchFieldList'];


				//	Load the template file. By default, this populates the $this->template array with the list template from ###TEMPLATE_LIST{layoutCode}###
			$this->loadTemplate();

				//	Report an error if we couldn't pull up the template.
			if(! $this->template['list'] ) {

					$error = array();
					$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
					$error['message'] = htmlspecialchars( 'Unable to retrieve content for specified template.' );
					$error['detail'] = htmlspecialchars(
						sprintf (
							'Requested Template: ###TEMPLATE_LIST%s###',
							$this->internal['layoutCode']
						)
					 );

					return sprintf(
						'<p>%s<br/> %s</p>	<p>%s</p>',
						$error['type'],
						$error['message'],
						$error['detail']
					);
			}

			$content = $this->cObj->substituteSubpart( $this->template['list'], '###CONTENT###', $this->pi_list_makelist($lConf, $this->template['content'] ) );

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
		$groupTable = getConfigVal( $this, 'group_table', 'slistView', 'group_table', $lConf );

			//	If grouping was specified, branch to process group list
		if( $groupTable ) {

			$detailTable = getConfigVal( $this, 'detail_table', 'slistView', 'detail_table', $lConf );
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
			$foreign_column = get_foreign_column( $detailTable, $this->internal['groupTable'] );
			if( ! $foreign_column ) {
				$error = array();
				$error['type'] = htmlspecialchars( 'WEC Sermons Error!' );
				$error['message'] = htmlspecialchars( 'Grouping tag, "###GROUP###" was found in template, but was not related to "' . $groupTable . '"' );
				$error['detail'] = '';

				$format =  sprintf( '<p>%s<br/> %s</p><p>%s</p>',
					$error['type'],
					$error['message'],
					$error['detail']
				);

				return $format;
				return '<p>WEC Sermons Error!<br/> Grouping tag, &quot;###GROUP###&quot; was found in template, but was not related to &quot;detail_table&quot;</p>';
			}
				//	Retreive marker array and template for the detail table
			$detailMarkArray = $this->getMarkerArray( $detailTable );
			$detailTemplate = $this->template['item'] = $this->getNamedSubpart( 'DETAIL', $template );

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
			$tableToList = getConfigVal( $this, 'detail_table', 'slistView', 'detail_table', $lConf, 'tx_wecsermons_sermons' );

				//	Load the correct marker array and load the item template
			$markerArray = $this->getMarkerArray( $tableToList );
			$itemTemplate = $this->cObj->getSubpart( $template, '###ITEM###' );
			$this->internal['currentTable'] = $this->internal['groupTable'] = 'tx_wecsermons_series';

				//	TODO: Modify the date selection to include other tables and date fields

				//	If start or end date was set, then add this to the query WHERE clause.
			$startDate = getConfigVal( $this, 'startDate', 'slistView', 'startDate', $lConf );
			$endDate = getConfigVal( $this, 'endDate', 'slistView', 'endDate', $lConf );
			$where = '';
			$where .= $startDate ? ' AND occurance_date >= ' . $startDate : '';	//	$GLOBALS['TYPO3_DB']->fullQuoteStr( strftime( '%m-%d-%y', $startDate ), $tableToList ) : '';
			$where .= $endDate ? ' AND occurance_date <= ' .  $endDate  : '';

				// Get number of records:
			$res = $this->pi_exec_query($tableToList,1, $where);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);

				// Make listing query, pass query to SQL database:
			$res = $this->pi_exec_query($tableToList,0,$where);

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
	 * @param	[type]		$c: ...
	 * @return	string		A populated template, filled with data from the row
	 */
	function pi_list_row($lConf, $markerArray = array(), $rowTemplate, $row ='', $c = 2)	{
		$wrappedSubpartArray = array();
		$subpartArray = array();

			//	Using passed markerArray, process each key and insert field content
			//	The reason we are have this looping structure is for future off-loading of this logic
		foreach( $markerArray as $key => $value ) {

				$fieldName = $value;
				$markerArray[$key] = '';

				switch( $key ) {

				case '###SERMON_TITLE###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_sermons' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_sermons.']['title'], $lConf['tx_wecsermons_sermons.']['title.'] );


					}
				break;

				case '###SERMON_OCCURANCE_DATE###':
					if( $row[$fieldName] )
					{
							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['tx_wecsermons_sermons.']['occurance.'] ? $lConf['tx_wecsermons_sermons.']['occurance.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];

						$this->local_cObj->start( $row, 'tx_wecsermons_sermons' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_sermons.']['occurance'], $dateWrap);
					}
				break;

				case '###SERMON_DESCRIPTION###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_sermons' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_sermons.']['description'], $lConf['tx_wecsermons_sermons.']['description.'] );
					}
				break;

				case '###SERMON_SCRIPTURE###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_sermons' );
						$markerArray[$key] =  $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_sermons.']['scripture'], $lConf['tx_wecsermons_sermons.']['scripture.'] );
					}
				break;

				case '###SERMON_GRAPHIC###':
					if( $row[$fieldName] ) {

						$this->local_cObj->start( $row, 'tx_wecsermons_sermons' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_sermons.']['graphic'], $lConf['tx_wecsermons_sermons.']['graphic.']);
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

						$seriesTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$seriesMarkerArray = $this->getMarkerArray('tx_wecsermons_series');
						$seriesContent = '';

							//	Store the current table and row while we switch to another table for a moment
						$this->internal['previousTable'] = $this->internal['currentTable'];
						$this->internal['currentTable'] = 'tx_wecsermons_series';
						$this->internal['previousRow'] = $this->internal['currentRow'];

						$seriesRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
							'tx_wecsermons_series.*',
							'tx_wecsermons_series',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_series' )
						);


						$count = 0;
						while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $seriesRes ) ) {
								//	Recursive call to $this->pi_list_row() to populate each series marker
							$seriesContent .= $this->pi_list_row( $lConf, $seriesMarkerArray, $seriesTemplate, $this->internal['currentRow'] );
							$count++;
						}

						//	Restore the preview table and row
					$this->internal['currentTable'] = $this->internal['previousTable'];
					$this->internal['currentRow'] = $this->internal['previousRow'];

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

							//	Store the current table and row while we switch to another table for a moment
						$this->internal['previousTable'] = $this->internal['currentTable'];
						$this->internal['currentTable'] = 'tx_wecsermons_speakers';
						$this->internal['previousRow'] = $this->internal['currentRow'];

							//	Retrieve all speaker records that are related to this sermon
						$speakerRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
							'tx_wecsermons_speakers.*',
							'tx_wecsermons_speakers',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_speakers' )
						);

						$count = 0;
						while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $speakerRes ) ) {

								//	Recursive call to $this->pi_list_row() to populate each speaker marker
							$speakerContent .= $this->pi_list_row( $lConf, $speakerMarkerArray, $speakerTemplate, $this->internal['currentRow'] );
							$count++;
						}

							//	Restore the preview table and row
						$this->internal['currentTable'] = $this->internal['previousTable'];
						$this->internal['currentRow'] = $this->internal['previousRow'];

							//	Replace marker content with subpart, wrapping stdWrap
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $speakerContent, $lConf['tx_wecsermons_sermons.']['speakers.'] );

					}
				break;

				case '###SERMON_TOPICS###':

					$subpartArray[$key] = '';

					if( $row[$fieldName] ) {

							//	Load the topics subpart
						$topicTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$topicMarkerArray = $this->getMarkerArray('tx_wecsermons_topics');
						$topicContent = '';

							//	Store the current table and row while we switch to another table for a moment
						$this->internal['previousTable'] = $this->internal['currentTable'];
						$this->internal['currentTable'] = 'tx_wecsermons_topics';
						$this->internal['previousRow'] = $this->internal['currentRow'];

						$topicRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
							'tx_wecsermons_topics.*',
							'tx_wecsermons_topics',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_topics' )
						);

						$count = 0;
						while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $topicRes ) ) {

								//	Recursive call to $this->pi_list_row() to populate each topic marker
							$topicContent .= $this->pi_list_row( $lConf, $topicMarkerArray, $topicTemplate, $this->internal['currentRow'] );
							$count++;
						}

							//	Restore the preview table and row
						$this->internal['currentTable'] = $this->internal['previousTable'];
						$this->internal['currentRow'] = $this->internal['previousRow'];

							//	Replace marker content with subpart
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $topicContent, $lConf['tx_wecsermons_sermons.']['topics.'] );

					}

				break;

				case '###SERMON_RESOURCES###':

					$marker = '';
					$markerArray[$key] = '';
						//	TODO: Find all the possible markers and set to empty string.
					$this->emptyResourceSubparts( $subpartArray );

					if( $row[$fieldName] ) {

			 			$wrap = array (
			 				'wrap' => '###|###'
			 			);

						$resourceMarkerArray = $this->getMarkerArray('tx_wecsermons_resources');

							//	Store the current table and row while we switch to another table for a moment
						$this->internal['previousTable'] = $this->internal['currentTable'];
						$this->internal['currentTable'] = 'tx_wecsermons_resources';
						$this->internal['previousRow'] = $this->internal['currentRow'];


							//	Retrieve related resources to this sermon
						$resources = $this->getResources( $row['uid'] );

						foreach( $resources as $resource ) {

							$this->internal['currentRow'] = $resource;
							$this->local_cObj->start( $this->internal['currentRow'] );

							//	If resource type = 'plugin', then process differently
							if( $this->internal['currentRow']['type']  == 'plugin') {

									//	Overwrite the resource type field with the resource title. This allows us to pass through to the CASE object which will use the 'title' to determine the custom rendering for this specific resource.
								$this->internal['currentRow']['type'] = $this->internal['currentRow']['title'];

									//	Parse the table_uid string from record into the value for the querystring_param
								list(,$queryStringVal) = array_values( splitTableAndUID($this->internal['currentRow']['rendered_record'] ) );

									//	Break apart our querystring_param from it's stored form of 'plugin[param]'
								$queryString = split( "\[|\]", $this->internal['currentRow']['querystring_param'] );

									//	Push the custom string onto the querystring.
								t3lib_div::_GETset( t3lib_div::array_merge( $_GET, array( $queryString[0] => array( $queryString[1] => $queryStringVal) ) ) );

									//	Use the marker name from the resource record
								$marker = $this->internal['currentRow']['resource_marker_name'];


							}
							else 	//	Resource type is other than 'plugin' so we use the marker name from the resource_type record
								$marker = $this->internal['currentRow']['resource_type_marker_name'];

							$resourceTemplate = $this->cObj->getSubpart( $rowTemplate, $marker );
							if( $resourceTemplate )
								$subpartArray[$marker] = $this->pi_list_row( $lConf, $resourceMarkerArray, $resourceTemplate, $this->internal['currentRow'] );

						}

							//	Restore the preview table and row
						$this->internal['currentTable'] = $this->internal['previousTable'];
						$this->internal['currentRow'] = $this->internal['previousRow'];

					}

				break;

				case '###RESOURCE_TITLE###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_resources.']['title.'] );
					}
				break;

				case '###RESOURCE_DESCRIPTION###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->local_cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_resources.']['description.'] );
				break;

				case '###RESOURCE_GRAPHIC###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->local_cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_resources.']['graphic.'] );
				break;

				case '###RESOURCE_URL###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->local_cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_resources.']['url.'] );
				break;

				case '###RESOURCE_FILE###':
					if( $row[$fieldName] )
						$markerArray[$key] = $this->local_cObj->stdWrap( $row[$fieldName], $lConf['tx_wecsermons_resources.']['file.'] );
				break;

				case '###RESOURCE_CONTENT###':
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $this->conf['resource_types'], $this->conf['resource_types.'] );
				break;

				case '###RESOURCE_LINK###':

						//	If 'typolink' segment is defined for this type, render a link as defined by 'typolink', otherwise render a link to the resources' single view
					if( $lConf['tx_wecsermons_resources.']['resource_types.'][$row['type'].'.']['typolink'] ) {

						$wrappedSubpartArray[$key] = $this->local_cObj->typolinkWrap( $lConf['tx_wecsermons_resources.']['resource_types.'][$row['type'].'.']['typolink.'] );
					}
					else {	//	Render a link to single view

						$wrappedSubpartArray[$key] = explode(
							'|',
							$this->pi_list_linkSingle(
								'|',
								$row['uid'],
								$this->conf['allowCaching'],
								array(
									'recordType' => 'tx_wecsermons_resources',
								),
								FALSE,
								$this->conf['pidSingleView'] ? $this->conf['pidSingleView']:0
								)
						);

					}

				break;

				case '###SERIES_TITLE###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_series.']['title'], $lConf['tx_wecsermons_series.']['title.'] );
					}
				break;

				case '###SERIES_DESCRIPTION###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_series.']['description'], $lConf['tx_wecsermons_series.']['description.'] );
					}
				break;

				case '###SERIES_GRAPHIC###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_series.']['graphic'], $lConf['tx_wecsermons_series.']['graphic.']);
					}
				break;

				case '###SERIES_SCRIPTURE###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_series.']['scripture'], $lConf['tx_wecsermons_series.']['scripture.'] );
					}
				break;

				case '###SERIES_STARTDATE###':
					if( $row[$fieldName] ) {
							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['tx_wecsermons_series.']['startdate.'] ? $lConf['tx_wecsermons_series.']['startdate.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];

						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_series.']['startdate'], $dateWrap );
					}
				break;

				case '###SERIES_ENDDATE###':
					if( $row[$fieldName] ) {

							//	Wrap the date, choosing from one of three settings in typoscript
						$dateWrap = $lConf['tx_wecsermons_series.']['enddate.'] ? $lConf['tx_wecsermons_series.']['enddate.'] : $lConf['general_dateWrap.'];
						if( ! $dateWrap ) $dateWrap = $this->conf['general_dateWrap.'];

						$this->local_cObj->start( $row, 'tx_wecsermons_series' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_series.']['enddate'], $dateWrap );
					}
				break;

				case '###SERIES_SEASON###':

						//	Check for related season and insert season subpart
					$subpartArray[$key] = '';

					if( $row[$fieldName] ) {

							//	Load the season subpart
						$seasonTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$seasonMarkerArray = $this->getMarkerArray('tx_wecsermons_liturgical_seasons');
						$seasonContent = '';

							//	Store the current table and row while we switch to another table for a moment
						$this->internal['previousTable'] = $this->internal['currentTable'];
						$this->internal['currentTable'] = 'tx_wecsermons_liturgical_season';
						$this->internal['previousRow'] = $this->internal['currentRow'];

						$seasonRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
							'tx_wecsermons_liturgical_season.*',
							'tx_wecsermons_liturgical_season',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_liturgical_season' )
						);

						$count = 0;
						while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $seasonRes ) ) {

								//	Recursive call to $this->pi_list_row() to populate each speaker marker
							$seasonContent .= $this->pi_list_row( $lConf, $seasonMarkerArray, $seasonTemplate, $this->internal['currentRow'] );
							$count++;
						}

							//	Restore the preview table and row
						$this->internal['currentTable'] = $this->internal['previousTable'];
						$this->internal['currentRow'] = $this->internal['previousRow'];

							//	Replace marker content with subpart
						if( $count > 0 )
							$subpartArray[$key] = $this->cObj->stdWrap( $seasonContent, $lConf['tx_wecsermons_series.']['season.'] );

					}


				break;

				case '###SERIES_TOPICS###':

					$subpartArray[$key] = '';

						// Check for related topics and insert topic subpart
					if( $row[$fieldName] ) {

							//	Get the series_topics subpart
						$topicTemplate = $this->cObj->getSubpart( $rowTemplate, $key );
						$topicMarkerArray = $this->getMarkerArray('tx_wecsermons_topics');
						$topicContent = '';

							//	Store the current table and row while we switch to another table for a moment
						$this->internal['previousTable'] = $this->internal['currentTable'];
						$this->internal['currentTable'] = 'tx_wecsermons_topics';
						$this->internal['previousRow'] = $this->internal['currentRow'];

						$topicRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
							'tx_wecsermons_topics.*',
							'tx_wecsermons_topics',
							' uid in (' . $row[$fieldName] . ')' . $this->cObj->enableFields( 'tx_wecsermons_topics' )
						);

						$count = 0;
						while( $this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $topicRes ) ) {
								//	Recursive call to $this->pi_list_row() to populate each speaker marker
							$topicContent .= $this->pi_list_row( $lConf, $topicMarkerArray, $topicTemplate, $this->internal['currentRow'] );
							$count++;
						}

							//	Restore the preview table and row
						$this->internal['currentTable'] = $this->internal['previousTable'];
						$this->internal['currentRow'] = $this->internal['previousRow'];

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
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_topics' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_topics.']['title'], $lConf['tx_wecsermons_topics.']['title.'] );
					}

				break;

				case '###TOPIC_DESCRIPTION###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_topics' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_topics.']['description'], $lConf['tx_wecsermons_topics.']['description.'] );
					}

				break;

				case '###SEASON_TITLE###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_liturgical_season' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_liturgical_season.']['title'], $lConf['tx_wecsermons_liturgical_season.']['title.'] );

					}

				break;

				case '###SPEAKER_FIRSTNAME###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_speakers.']['firstname'], $lConf['tx_wecsermons_speakers.']['firstname.'] );
					}

				break;

				case '###SPEAKER_LASTNAME###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_speakers.']['lastname'], $lConf['tx_wecsermons_speakers.']['lastname.'] );
					}

				break;

				case '###SPEAKER_URL###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_speakers.']['url'], $lConf['tx_wecsermons_speakers.']['url.'] );
					}

				break;

				case '###SPEAKER_EMAIL###':

						//	Create link, making sure it is spam protected
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_speakers.']['email'], $lConf['tx_wecsermons_speakers.']['email.'] );

					}
				break;

				case '###SPEAKER_PHOTO###':
					if( $row[$fieldName] ) {
						$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );
						$markerArray[$key] = $this->local_cObj->cObjGetSingle( $lConf['tx_wecsermons_speakers.']['photo'], $lConf['tx_wecsermons_speakers.']['photo.'] );
					}

				break;

				case '###SPEAKER_LINK###':

					$this->local_cObj->start( $row, 'tx_wecsermons_speakers' );

						//	If 'typolink' is set, generate a link as defined by the 'typolink' segment, otherwise link to the speakers single view
					if( $lConf['tx_wecsermons_speakers.']['typolink'] ) {

							//	Generate a link as defined by the 'typolink' segment
						$wrappedSubpartArray[$key] = $this->local_cObj->typolinkWrap( $lConf['tx_wecsermons_speakers.']['typolink.'] );
					}
					else	{ // Generate a link to the Speaker Single view
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
					}

				break;

				case '###ALTERNATING_CLASS###':
					$markerArray['###ALTERNATING_CLASS###'] = $c % 2 ? $this->pi_getClassName( $lConf['alternatingClass'] )  : '';
				break;

				case '###BROWSE_LINKS###':

					$markerArray['###BROWSE_LINKS###'] = $this->pi_list_browseresults($lConf['showResultCount'], '', $lConf['browseBox_linkWraps.'] );
				break;

				case '###BACK_LINK###':

						//	If recordType is not set, retreive value or set it to sermons table. This is in case of hard linking to the single view instead of linking through the list view.
					if( ! isset( $this->piVars['recordType'] ) ) $this->piVars['recordType'] = getConfigVal( $this, 'detail_table', 'slistView', 'detail_table', $lConf, 'tx_wecsermons_sermons' );

					$wrappedSubpartArray[$key] = explode(
						'|',
						$this->pi_linkTP(
							'|',
							array(),
							$this->conf['allowCaching'],
							$this->conf['pidListView']
						)
					);
				break;

				case '###BACK_TO_LIST###':

					$markerArray[$key] =  $this->cObj->stdWrap( $this->pi_getLL('back','Back'), $lConf['back.'] );

				break;

				}	// End Switch

				//	TODO: Add a hook here for processing extra markers

		}	// End Foreach

//debug( $subpartArray );
		$lContent = $this->cObj->substituteMarkerArrayCached($rowTemplate, $markerArray, $subpartArray, $wrappedSubpartArray );

			//	Only add edit UI if there is a row of data we're processing
		if( $row ) {

				//	Get editIcon using $this->internal['currentRow'] and $this->internal['currentTable']
			$lContent = $this->pi_getEditIcon( $lContent, $this->getFeAdminList() );

				//	Get Editpanel using $this->internal['currentRow'] and $this->internal['currentTable']
			$lContent .= $this->pi_getEditPanel();

		}
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
	 * Returns the markerArray for a specific table
	 *
	 * @param	string		Table name to retrieve markers for
	 * @return	array		Array filled with markers as keys, with empty values
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
	 				'###SERMON_SPEAKERS###' => 'speakers_uid',
					'###SERMON_GRAPHIC###' => 'graphic',
					'###SERMON_LINK###' => '',
					'###ALTERNATING_CLASS###' => '',
	 				'###SERMON_RESOURCES###' => 'resources_uid',		//	Only included to kick off the processing of resources. Resource markers are defined in the resource_type records or resource record if of type 'plugin'
	 			);

/*
	 			$wrap = array (
	 				'wrap' => '###|###'
	 			);
	 				//	TODO: Search for additional marker types that could be present for a sermon resource, include those in the array
	 			$query = "
					select distinct marker_name
					from tx_wecsermons_resources
					where marker_name != '' " . $this->cObj->enableFields('tx_wecsermons_resources');

				$res = $GLOBALS['TYPO3_DB']->sql_query( $query );
				while( $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) ) {

					$offset =  $this->cObj->stdWrap( $record['marker_name'], $wrap );
					$markerArray[$offset] = '';
				}


	 			$query = "
					select distinct marker_name
					from tx_wecsermons_resource_type
					where marker_name != '' " . $this->cObj->enableFields('tx_wecsermons_resource_type');

				$res = $GLOBALS['TYPO3_DB']->sql_query( $query );
				while( $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) ) {

					$offset =  $this->cObj->stdWrap( $record['marker_name'], $wrap );
					$markerArray[$offset] = '';
				}
*/
	 		break;

	 		case 'tx_wecsermons_series':
	 			$markerArray = array (
					'###SERIES_TITLE###' => 'title',
					'###SERIES_STARTDATE###' => 'startdate',
					'###SERIES_ENDDATE###' => 'enddate',
					'###SERIES_DESCRIPTION###' => 'description',
					'###SERIES_SCRIPTURE###' => 'scripture',
					'###SERIES_GRAPHIC###' => 'graphic',
					'###SERIES_SEASON###' => 'liturgical_season_uid',
					'###SERIES_TOPICS###' => 'topics_uid',
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
					'###RESOURCE_FILE###' => 'file',
					'###RESOURCE_URL###' => 'url',
					'###RESOURCE_CONTENT###' => '',
					'###ALTERNATING_CLASS###' => '',
					'###RESOURCE_LINK###' => '',
				);
	 		break;

	 		case 'tx_wecsermons_liturgical_seasons':
	 			$markerArray = array (
					'###SEASON_TITLE###' => 'season_name',
					'###ALTERNATING_CLASS###' => '',
				);
	 		break;

	 		case 'searchbox':
	 			$markerArray = array(
	 				'###FORM_ACTION###' => '',
	 				'###SEARCHBOX_OPTIONS###' => '',
	 				'###SEARCH_BUTTON_NAME###' => '',
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
	 * Retrieves the content for a named template. Used to pull a template subpart from a template file
	 *
	 * @param	string		$tableName. This is the tablename to retrieve the keyname for.
	 * @return	[type]		...
	 */
	function getTemplateKey($tableName) {

		switch( $tableName ) {
			case 'tx_wecsermons_sermons':
				$key = 'Sermon';
			break;

			case 'tx_wecsermons_resources':


				$key = 'Resource';
			break;

			case 'tx_wecsermons_topics':
				$key = 'Topic';
			break;

			case 'tx_wecsermons_liturgical_season':
				$key = 'Season';
			break;

			case 'tx_wecsermons_series':
				$key = 'Series';
			break;

			case 'tx_wecsermons_speakers':
				$key = 'Speaker';
			break;

			}

			//	TODO: Add hook for custom tables

			return $key;

	}

	/**
	 * Retrieves the 'fe_admin_fieldList' for a given data table, used for generating the fe editIcon.
	 *
	 * @param	string		$tableName.	The name of the table to retrieve the field list for.
	 * @return	string		Returns a CSV string of fieldnames used in the editIcon fieldlist
	 */
	function getFeAdminList( $tableName = '' ) {

		if( ! $tableName ) $tableName = $this->internal['currentTable'];

			//	Load up the tca for given table
		$GLOBALS['TSFE']->includeTCA($TCAloaded = 1);
		t3lib_div::loadTCA( $tableName );

		return $GLOBALS['TCA'][$tableName]['feInterface']['fe_admin_fieldList'];

	}

	/**
	 * Retrieves the content for a named template. Used to pull a template subpart from a template file
	 *
	 * @param	string		$key. This is the keyname of the type of template to retrieve such as SERMON, SERIES, TOPIC, etc.
	 * @param	string		$view. This is the name of the view to retrieve, SINGLE, LIST, etc.
	 * @return	string		Returns the content of a specfic marker-based template
	 */
	function getNamedTemplateContent($keyName = 'sermon', $view = 'single') {

			// Make sure template is loaded into instance of our class
		$this->loadTemplate();

		$keyName = strtoupper( $keyName );
		$view = strtoupper( $view );

		switch( $view ) {

			case 'LIST':
				$templateContent = $this->cObj->getSubpart(
					$this->template['total'],
					sprintf( '###TEMPLATE_%s%s###',
						$view,
						$this->internal['layoutCode']
					)
				);
			break;

			case '':
				$templateContent = $this->cObj->getSubpart(
					$this->template['total'],
					sprintf( '###TEMPLATE_%s%s###',
						$keyName,
						$this->internal['layoutCode']
					)
				);

			break;

			default:
			$templateContent = $this->cObj->getSubpart(
				$this->template['total'],
				sprintf( '###TEMPLATE_%s_%s%s###',
					$keyName,
					$view,
					$this->internal['layoutCode']
				)
			);

		}

		return $templateContent;
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$$subpartName: ...
	 * @param	[type]		$content: ...
	 * @return	[type]		...
	 */
	function getNamedSubpart( $subpartName, $content ) {
			// Make sure template is loaded into instance of our class
		$this->loadTemplate();

			//	Fix subpart name if TYPO tags were not inserted
		$subpartName = strrpos( $subpartName, '###') ? strtoupper( $subpartName ) :  '###'.strtoupper( $subpartName ).'###';

		return $this->cObj->getSubpart( $content, $subpartName );

	}

	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function loadTemplate() {

		if( ! $this->template ) {
			$this->template = array(
				'total' => '',
				'single' => '',
				'list' => '',
				'item' => '',
				'content' => ''
			);

				//	Get the file location and name of our template file
			$templateFile = $this->getTemplateFile();
			$this->template['total'] = $this->cObj->fileResource( $this->internal['templateFile'] );
			$this->template['list'] =  $this->getNamedTemplateContent('', 'list');
			$this->template['content'] = $this->getNamedSubpart('CONTENT', $this->template['list'] );
			$this->template['item'] = $this->getNamedSubpart('ITEM', $this->template['content'] );

		}
	}

	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function getTemplateFile() {

			//	Load the HTML template from either plugin or typoscript configuration, plugin overrides
		$templateFile = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'templateFile', 'sDEF');

			//	TODO: Double check this works with a template file stored in a BE template record.
		$templateFile = $templateFile ? 'uploads/tx_wecsermons/'.$templateFile : $this->conf['templateFile'];

			//	Store the name of the template file, for retrieval later
		$this->internal['templateFile'] = $templateFile;

		return $templateFile;

	}

	function getResources( $sermonUid = '', $resourceUid = '') {

		if( ! $this->internal['resources'] ) {
				//	Build query to select resource attributes along with resource type name
			$WHERE = $sermonUid ? 'AND tx_wecsermons_sermons.uid = ' . $sermonUid . ' ' :'';
			$WHERE = $resourceUid ? 'AND tx_wecsermons_resources.uid = ' . $resourceUid . ' ' : $WHERE;
			$WHERE .= $this->cObj->enableFields('tx_wecsermons_resources');
			$query = 'select distinct
			tx_wecsermons_resources.uid,
			tx_wecsermons_resources.type,
			tx_wecsermons_resources.title,
			tx_wecsermons_resources.description,
			tx_wecsermons_resources.graphic,
			tx_wecsermons_resources.file,
			tx_wecsermons_resources.url,
			tx_wecsermons_resources.querystring_param,
			tx_wecsermons_resources.rendered_record,
			tx_wecsermons_resources.marker_name resource_marker_name,
			tx_wecsermons_resources.template_name resource_template_name,
			tx_wecsermons_resource_type.name,
			tx_wecsermons_resource_type.description,
			tx_wecsermons_resource_type.icon,
			tx_wecsermons_resource_type.marker_name resource_type_marker_name	,
			tx_wecsermons_resource_type.template_name resource_type_template_name
			from tx_wecsermons_resources
					join tx_wecsermons_sermons_resources_uid_mm on tx_wecsermons_resources.uid=tx_wecsermons_sermons_resources_uid_mm.uid_foreign
			join tx_wecsermons_sermons on tx_wecsermons_sermons.uid=tx_wecsermons_sermons_resources_uid_mm.uid_local
			left join tx_wecsermons_resource_type on tx_wecsermons_resources.type=tx_wecsermons_resource_type.uid
		 			where 1=1 ' . $WHERE;

			$res = $GLOBALS['TYPO3_DB']->sql_query( $query );

			$resources = array();

				//	TODO: What if none found?
				//	For each related resource, determine the type and render it
			while( $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) )
				$resources[] = $record;
		}

		return $resources;

	}

	function emptyResourceSubparts( &$subpartArray ) {

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'distinct marker_name',
			'tx_wecsermons_resources',
			 'marker_name != \'\' '.$this->cObj->enableFields( 'tx_wecsermons_resources' )
		);

		while( $marker = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) ) {
			$subpartArray[$marker['marker_name']] = '';
		}

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'distinct marker_name',
			'tx_wecsermons_resource_type',
			  'marker_name != \'\' '.$this->cObj->enableFields( 'tx_wecsermons_resource_type' )
		);

		while( $marker = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) )
			$subpartArray[$marker['marker_name']] = '';


	}

	/**
	 *	throwError	Function that returns an HTML formatted error message for display on the front-end. ** MUST be user friendly!! **
	 *
	 *	@param	string	$type	A given type or category of the error message we are displaying
	 *	@param	string	$message	The message of the error
	 *	@param	string	$detail	Any detail we'd like to include, such as the variable name that caused the error and it's value at the time.
	 *
	 *	@return	string	An HTML formatted error message
	 */
	function throwError( $type, $message, $detail = '' ) {

		//	TODO: Possibly add logic to fire an e-mail off with detail, or log the error.
		
		$format =  sprintf(
		'<p>%s<br/> %s</p>
		<p>%s</p>
		',
		htmlspecialchars( $type ), htmlspecialchars( $message ), htmlspecialchars( $detail ) );

		return $format;

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
 * @param	string		Table name to search through
 * @param	string		Related table to search for
 * @return	string		The column name that relates currentTable to relatedTable. Returns null if no relation is found.
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
 * Return the value from either plugin flexform, typoscript, or default value, in that order
 *
 * @param	object		Parent object passes itself
 * @param	string		Field name of the flexform value
 * @param	string		Sheet name where flexform value is located
 * @param	string		Field name of typoscript value
 * @param	array		TypoScript configuration array from local scope
 * @param	mixed		Default if no other values are assigned from TypoScript or Plugin Flexform
 * @return	mixed		Value found in any config, or default
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

function splitTableAndUID($record) {
	$break = strrpos($record, "_");
	$uid = substr($record, $break+1);
	$table = substr($record, 0, $break);


	return array("table" => $table, "uid" => $uid);
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wec_sermons/pi1/class.tx_wecsermons_pi1.php']);
}

?>
