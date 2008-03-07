<?php

class ext_update {
	// NOTE: you have to keep this current with every schema update
	// this isn't exactly a smooth process, so make your schema changes rare ;-)
	var $current = "0.9.6";


	// this method is only invoked if there is need for updating (as determined by access() and getVersion())
	function main() {
		if (t3lib_div::_GP('wecsermons_updateit')) {
			$this->performUpdate();
		} else {
			$codeVersion = $this->current;
			$schemaVersion = $this->getVersion();
			$content = <<<EOT
<p>
Before updating the Sermons extension database layout, please ensure that you've taken
appropriate steps to protect your data (e.g., the "Dump to DB" option in the menu dropdown).
<p>
The update subsystem has detected a likely upgrade that requires user action.  We've
detected that your code and schema definition are out of sync.  Specifically:
<ul>
<li>Code version: {$codeVersion}</li>
<li>Schema version: {$schemaVersion}</li>
</ul>
</p>
Are you ready to perform the database definition update/migration?
<br/>
<form method="POST"> <!-- no action posts back to the same url, iirc -->
<input type="hidden" name="wecsermons_updateit" value="true"/>
<input type="submit" value="Update"/>
</form>
EOT;
			return $content;
		}
	}
	// actually perform the update, after user has explicitly selected to update
	function performUpdate() {
		// detect our schema version
		$version = $this->getVersion();

		if ($version == '0.0.0') {
			return "we detected an error during the update process";
		}
		// implicit else
		

		// branch based on our detected version, then update to current
		$retStr = "";
		switch($version) {
			case '0.9.5':
				$this->upgradeFrom095();
				$retStr .= "Updated from schema v0.9.5 to {$this->current}";
				break;
			case '0.9.3':
				#$this->upgradeFrom093();
				$retStr .= "Updated from schema v0.9.3 to {$this->current}";
				break;
			case '0.9.2':
				#$this->upgradeFrom092();
				$retStr .= "Updated from schema v0.9.2 to {$this->current}";
				break;
			case '0.9.1':
				#$this->upgradeFrom091();
				$retStr .= "Updated from schema v0.9.1 to {$this->current}";
				break;
			case '0.9.0':
				#$this->upgradeFrom090();
				$retStr .= "updated from schema v0.9.0 to {$this->current}";
				break;
			default:
				return "Unhandled schema version: {$version}";
		}

		$this->setCurrentSchemaVersion();
		return $retStr;
	}

	function access() {
		$version = $this->getVersion();
		if ($version != $this->current && $version != "0.0.0") {
			return true;
		} else {
			return false;
		}
	}

	function getVersion() {
		// this method is a bit smelly, but it's a matter of necessity
		// going forward we're storing our schema version in tx_wecsermons_meta
		// (on the row identified by key 'property' = 'version')
	  
		// our strategy is basically a cascade (order matters!) of checks
		// where each check is the difference between successive schema versions

		// we use only two database elements for our determinations:
		// 1) the new table tx_wecsermons_meta
		// 2) the column names in tx_wecsermons_sermons
		//
		// and yes, we're DBAL-compliant!  that is, no mysql direct calls
		// so if the user decides to migrate to postgres, no worries
		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		$sermons_columns = $GLOBALS['TYPO3_DB']->admin_get_fields('tx_wecsermons_sermons');


		// our checks/tests
		if (array_key_exists('tx_wecsermons_meta', $tables)) {
		  $res = $GLOBALS['TYPO3_DB']->sql_query("select value from tx_wecsermons_meta where property = 'version'");
			if ($res) {
				$versionrow = $GLOBALS['TYPO3_DB']->sql_fetch_row ($res);
				$version = $versionrow[0];
				if ($version) {
					return $version;
				} else {
					return "0.9.5"; // we haven't yet initialized things, so it's 0.9.5
				}
			} else {
				return "0.9.5"; // we haven't yet initialized things, so it's 0.9.5
			}
		} else {
			// No tx_wecsermons_meta data, so we have to do some guesswork
			if (array_key_exists('islinked', $sermons_columns)) {
				// we're the version 0.9.3 schema
				return "0.9.3";
			} else {
				// we're lower than 0.9.3, keep guessing
				if (array_key_exists('tx_wecsermons_series_resources_uid_mm', $tables)) {
					// we're the version 0.9.2 schema
					return "0.9.2";
				} else {
					// we're lower than 0.9.2, keep guessing
					if (array_key_exists('alttitle', $sermons_columns)) {
						// we're the version 0.9.1 schema
						return "0.9.1";
					} else {
						// we're lower than 0.9.1, which means we must be 0.9.0 (the first public release)
						return "0.9.0";
					}
				}
			}
		}
	}

	function setCurrentSchemaVersion() {
		$stmt = "select count(*) from tx_wecsermons_meta where property = 'version'";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		$row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
		$count = $row[0];

		if ($count == 0) {
			$stmt = "insert into tx_wecsermons_meta (property, value) values ('version', '{$this->current}')";
			$GLOBALS['TYPO3_DB']->sql_query($stmt);
		} else {
			$stmt = "update tx_wecsermons_meta set value = '{$this->current}' where property = 'version'";
			$GLOBALS['TYPO3_DB']->sql_query($stmt);
		}
	}
	
	// our methods that actually perform the updating
	// note that the updates aren't 100% complete
	// they just touch the changes i've (mjb) introduced [irre intermediate tables]

	function upgradeFrom095() {
		// same schema as 0.9.3, just different in the fact that tx_wecsermons_meta exists, which we populate for all schema versions
		$this->upgradeFrom093();
	}

	function upgradeFrom093() {
		// get our timestamps
		$time = time();


		//
		// first up... resources
		//

		// commenting out our previous (non working stuff)
		/*
		$stmt = "insert into tx_wecsermons_sermons_resources_rel (uid,pid,tstamp,crdate,cruser_id,sermonid,resourceid,sorting)
		         select null,pid,{$time},{$time},1,uid_local,uid_foreign,sorting from tx_wecsermons_sermons_resources_uid_mm";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);

		$stmt = "insert into tx_wecsermons_series_resources_rel (uid,pid,tstamp,crdate,cruser_id,sermonid,resourceid,sorting)
		         select null,pid,{$time},{$time},1,uid_local,uid_foreign,sorting from tx_wecsermons_series_resources_uid_mm";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);

		*/

		// the new hawtness
		$stmt = "insert into tx_wecsermons_sermons_resources_rel
                         (uid,pid,tstamp,crdate,cruser_id,sermonid,resourceid,sorting)
                         select null,s.pid,null,null,1,m.uid_local,m.uid_foreign,m.sorting
                          from tx_wecsermons_sermons_resources_uid_mm m
                           inner join tx_wecsermons_sermons s
                            on m.uid_local = s.uid";

		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);

		$stmt = "insert into tx_wecsermons_series_resources_rel
                         (uid,pid,tstamp,crdate,cruser_id,seriesid,resourceid,sorting)
                         select null,s.pid,null,null,1,m.uid_local,m.uid_foreign,m.sorting
                          from tx_wecsermons_series_resources_uid_mm m
                           inner join tx_wecsermons_series s
                            on m.uid_local = s.uid";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);


		// doesn't it suck that mysql v4 lacks subquery support... this could have been one query, alas.
		// probably could have cleaned up a bit by using aggregate functions, but alas
		$stmt = "select uid from tx_wecsermons_sermons";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res)) {
		  $uid = $row[0];
		  $stmtCount = "select count(*)
                                from tx_wecsermons_sermons_resources_rel m
                                 inner join tx_wecsermons_resources r on m.resourceid = r.uid
                                where r.deleted = 0
                                  and m.sermonid = {$uid}";
		  $resCount = $GLOBALS['TYPO3_DB']->sql_query($stmtCount);
		  $rowCount = $GLOBALS['TYPO3_DB']->sql_fetch_row($resCount);
		  $sermonResourceCount = $rowCount[0];

		  $stmtUpdate = "update tx_wecsermons_sermons set resources = {$sermonResourceCount} where uid = {$uid}";
		  $GLOBALS['TYPO3_DB']->sql_query($stmtUpdate);
		}
		$stmt = "select uid from tx_wecsermons_series";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res)) {
		  $uid = $row[0];
		  $stmtCount = "select count(*)
                                from tx_wecsermons_series_resources_rel m
                                 inner join tx_wecsermons_resources r on m.resourceid = r.uid
                                where r.deleted = 0
                                  and m.seriesid = {$uid}";
		  $resCount = $GLOBALS['TYPO3_DB']->sql_query($stmtCount);
		  $rowCount = $GLOBALS['TYPO3_DB']->sql_fetch_row($resCount);
		  $sermonResourceCount = $rowCount[0];

		  $stmtUpdate = "update tx_wecsermons_series set resources = {$sermonResourceCount} where uid = {$uid}";
		  $GLOBALS['TYPO3_DB']->sql_query($stmtUpdate);
		}

		//
		// second... series (relation to sermons)
		//

		// again, subqueries would be nice.  too bad i'm supporting MySQL v4.0  :-(
		$stmt = "select uid,pid,series_uid from tx_wecsermons_sermons where series_uid is not null and series_uid <> ''";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res)) {
			$sermonid = $row[0];
			$pid = $row[1];
			$series_ids = explode(',', $row[2]);

			foreach ($series_ids as $seriesid) {
				$stmtInsert = "insert into tx_wecsermons_sermons_series_rel (uid,pid,tstamp,crdate,cruser_id,sermonid,seriesid)
				               values (null,{$pid},{$time},{$time},1,{$sermonid},{$seriesid})";
				$GLOBALS['TYPO3_DB']->sql_query($stmtInsert);
			}

			$seriesCount = count($series_ids);
			$stmtUpdate = "update tx_wecsermons_sermons set series = {$seriesCount} where uid = {$sermonid}";
			$GLOBALS['TYPO3_DB']->sql_query($stmtUpdate);
		}

		//
		// third... topics (relations to both sermons and series)
		//

		$stmt = "select uid,pid,topics_uid from tx_wecsermons_sermons where topics_uid is not null and topics_uid <> ''";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res)) {
			$sermonid = $row[0];
			$pid = $row[1];
			$topic_ids = explode(',', $row[2]);

			foreach ($topic_ids as $topicid) {
				$stmtInsert = "insert into tx_wecsermons_sermons_topics_rel (uid,pid,tstamp,crdate,cruser_id,sermonid,topicid)
				               values (null,{$pid},{$time},{$time},1,{$sermonid},{$topicid})";
				$GLOBALS['TYPO3_DB']->sql_query($stmtInsert);
			}

			$topicCount = count($topic_ids);
			$stmtUpdate = "update tx_wecsermons_sermons set topics = {$topicCount} where uid = ${sermonid}";
			$GLOBALS['TYPO3_DB']->sql_query($stmtUpdate);
		}
		$stmt = "select uid,pid,topics_uid from tx_wecsermons_series where topics_uid is not null and topics_uid <> ''";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res)) {
			$seriesid = $row[0];
			$pid = $row[1];
			$topic_ids = explode(',', $row[2]);

			foreach ($topic_ids as $topicid) {
				$stmtInsert = "insert into tx_wecsermons_series_topics_rel (uid,pid,tstamp,crdate,cruser_id,sermonid,topicid)
				               values (null,{$pid},{$time},{$time},1,{$seriesid},{$topicid})";
				$GLOBALS['TYPO3_DB']->sql_query($stmtInsert);
			}

			$topicCount = count($topic_ids);
			$stmtUpdate = "update tx_wecsermons_series set topics = {$topicCount} where uid = {$seriesid}";
			$GLOBALS['TYPO3_DB']->sql_query($stmtUpdate);
		}

		//
		// fourth... seasons (just for series)
		//

		$stmt = "select uid,pid,seasons_uid from tx_wecsermons_series where seasons_uid is not null and seasons_uid <> ''";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res)) {
			$seriesid = $row[0];
			$pid = $row[1];
			$season_ids = explode(',', $row[2]);

			foreach ($season_ids as $seasonid) {
				$stmtInsert = "insert into tx_wecsermons_series_seasons_rel (uid,pid,tstamp,crdate,cruser_id,seriesid,seasonid)
				               values (null,{$pid},{$time},{$time},1,{$seriesid},{$seasonid})";
				$GLOBALS['TYPO3_DB']->sql_query($stmtInsert);
			}

			$seasonCount = count($season_ids);
			$stmtUpdate = "update tx_wecsermons_series set seasons = {$seasonCount} where uid = {$seriesid}";
			$GLOBALS['TYPO3_DB']->sql_query($stmtUpdate);
		}

		//
		// fifth and final (for now)... speakers (just sermons)
		//

		$stmt = "select uid,pid,speakers_uid from tx_wecsermons_sermons where speakers_uid is not null and speakers_uid <> ''";
		$res = $GLOBALS['TYPO3_DB']->sql_query($stmt);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res)) {
			$sermonid = $row[0];
			$pid = $row[1];
			$speaker_ids = explode(',', $row[2]);

			foreach ($speaker_ids as $speakerid) {
				$stmtInsert = "insert into tx_wecsermons_sermons_speakers_rel (uid,pid,tstamp,crdate,cruser_id,sermonid,speakerid)
				               values (null,{$pid},{$time},{$time},1,{$sermonid},{$speakerid})";
				$GLOBALS['TYPO3_DB']->sql_query($stmtInsert);
			}

			$speakerCount = count($speaker_ids);
			$stmtUpdate = "update tx_wecsermons_sermons set speakers = {$speakerCount} where uid = {$sermonid}";
			$GLOBALS['TYPO3_DB']->sql_query($stmtUpdate);
		}

		// all done... yay.
	}

	function upgradeFrom092() {
		$this->upgradeFrom093(); // close enough
	}

	function upgradeFrom091() {
		$this->upgradeFrom093(); // close enough
	}

	function upgradeFrom090() {
		$this->upgradeFrom093(); // close enough
	}
}

?>
