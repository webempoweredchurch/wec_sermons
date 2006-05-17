<?php

class tx_resourceTypeTca {
	
	function processDatamap_preProcessFieldArray($incomingFieldArray, $table, $id, $pObj) {


	}
	
	function getMainFields_preProcess($table,$row,$pObj) {
		
		if( $table == 'tx_wecsermons_resources' ) {

			$defaultString = 'sys_language_uid;;;;1-1-1, l18n_parent, l18n _diffsource, hidden;;1, title;;;;2-2-2, type,';
			$resourceType = array();

				//	Search for tx_wecsermons_resource_type records
			$resource = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'*',
				'tx_wecsermons_resource_type',
				''
			);
			
			while( $resourceType = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $resource )  ) {
				
				$GLOBALS['TCA']['tx_wecsermons_resources']['columns']['type']['config']['items'][] = array( 
					0 => 'PDF',
					1 => '3',
				);
				
				$GLOBALS['TCA']['tx_wecsermons_resources']['types'][] = Array("showitem" =>	 $defaultString . $resourceType['avail_filelds'] );			
			}
			t3lib_div::loadTCA( 'tx_wecsermons_resources' );
		
			$GLOBALS['TCA']['tx_wecsermons_resources']['columns']['type']['config']['items'][] = array( 
				0 => 'PDF',
				1 => '3',
			);
			$GLOBALS['TCA']['tx_wecsermons_resources']['types'][] = Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n _diffsource, hidden;;1, title;;;;2-2-2, type,  graphic;;;;3-3-3, file;;;;4-4-4" );
//	debug( $GLOBALS['TCA']['tx_wecsermons_resources']['types'] );
		}
	}
	
}

?>