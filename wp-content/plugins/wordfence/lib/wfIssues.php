<?php
require_once('wfUtils.php');
class wfIssues {
	private $db = false;

	//Properties that are serialized on sleep:
	private $updateCalled = false;
	private $issuesTable = '';
	private $pendingIssuesTable = '';
	private $maxIssues = 0;
	private $newIssues = array();
	public $totalIssues = 0;
	public $totalCriticalIssues = 0;
	public $totalWarningIssues = 0;
	public function __sleep(){ //Same order here as vars above
		return array('updateCalled', 'issuesTable', 'pendingIssuesTable', 'maxIssues', 'newIssues', 'totalIssues', 'totalCriticalIssues', 'totalWarningIssues');
	}
	public function __construct(){
		global $wpdb;
		$this->issuesTable = $wpdb->base_prefix . 'wfIssues';
		$this->pendingIssuesTable = $wpdb->base_prefix . 'wfPendingIssues';
		$this->maxIssues = wfConfig::get('scan_maxIssues', 0);
	}
	public function __wakeup(){
		$this->db = new wfDB();
	}
	public function addIssue($type, $severity,  $ignoreP, $ignoreC, $shortMsg, $longMsg, $templateData, $alreadyHashed = false) {
		return $this->_addIssue('issue', $type, $severity, $ignoreP, $ignoreC, $shortMsg, $longMsg, $templateData, $alreadyHashed);
	}
	public function addPendingIssue($type, $severity,  $ignoreP, $ignoreC, $shortMsg, $longMsg, $templateData) {
		return $this->_addIssue('pending', $type, $severity, $ignoreP, $ignoreC, $shortMsg, $longMsg, $templateData);
	}
	private function _addIssue($group, $type, $severity,
		$ignoreP, /* some piece of data used for md5 for permanent ignores */ 
		$ignoreC, /* some piece of data used for md5 for ignoring until something changes */
		$shortMsg, $longMsg, $templateData, $alreadyHashed = false
		){
		
		if ($group == 'pending') {
			$table = $this->pendingIssuesTable;
		}
		else {
			$table = $this->issuesTable;
		}
		
		if (!$alreadyHashed) {
			$ignoreP = md5($ignoreP);
			$ignoreC = md5($ignoreC);
		}
		
		$rec = $this->getDB()->querySingleRec("select status, ignoreP, ignoreC from {$this->issuesTable} where (ignoreP = '%s' OR ignoreC = '%s')", $ignoreP, $ignoreC);
		if($rec){
			if($rec['status'] == 'new' && ($rec['ignoreC'] == $ignoreC || $rec['ignoreP'] == $ignoreP)){ 
				if($type != 'file' && $type != 'database'){ //Filter out duplicate new issues but not infected files because we want to see all infections even if file contents are identical
					return false; 
				}
			}

			if($rec['status'] == 'ignoreC' && $rec['ignoreC'] == $ignoreC){ return false; }
			if($rec['status'] == 'ignoreP' && $rec['ignoreP'] == $ignoreP){ return false; }
		}
		
		if ($group != 'pending') {
			if ($severity == 1) {
				$this->totalCriticalIssues++;
			}
			else if ($severity == 2) {
				$this->totalWarningIssues++;
			}
			$this->totalIssues++;
			if (empty($this->maxIssues) || $this->totalIssues <= $this->maxIssues)
			{
				$this->newIssues[] = array(
					'type' => $type,
					'severity' => $severity,
					'ignoreP' => $ignoreP,
					'ignoreC' => $ignoreC,
					'shortMsg' => $shortMsg,
					'longMsg' => $longMsg,
					'tmplData' => $templateData
					);
			}
		}
			
		$this->getDB()->queryWrite("insert into {$table} (time, status, type, severity, ignoreP, ignoreC, shortMsg, longMsg, data) values (unix_timestamp(), '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s')",
			'new',
			$type,
			$severity,
			$ignoreP,
			$ignoreC,
			$shortMsg,
			$longMsg,
			serialize($templateData)
			);
		return true;
	}
	public function deleteIgnored(){
		$this->getDB()->queryWrite("delete from " . $this->issuesTable . " where status='ignoreP' or status='ignoreC'");
	}
	public function deleteNew(){
		$this->getDB()->queryWrite("delete from " . $this->issuesTable . " where status='new'");
	}
	public function ignoreAllNew(){
		$this->getDB()->queryWrite("update " . $this->issuesTable . " set status='ignoreC' where status='new'");
	}
	public function emailNewIssues($timeLimitReached = false){
		$level = wfConfig::getAlertLevel();
		$emails = wfConfig::getAlertEmails();
		$shortSiteURL = preg_replace('/^https?:\/\//i', '', site_url());
		$subject = "[Wordfence Alert] Problems found on $shortSiteURL";

		if(sizeof($emails) < 1){ return; }
		if($level < 1){ return; }
		if($level == 2 && $this->totalCriticalIssues < 1 && $this->totalWarningIssues < 1){ return; }
		if($level == 1 && $this->totalCriticalIssues < 1){ return; }
		$emailedIssues = wfConfig::get_ser('emailedIssuesList', array());
		if(! is_array($emailedIssues)){
			$emailedIssues = array();
		}
		$overflowCount = $this->totalIssues - count($this->newIssues);
		$finalIssues = array();
		foreach($this->newIssues as $newIssue){
			$alreadyEmailed = false;
			foreach($emailedIssues as $emailedIssue){
				if($newIssue['ignoreP'] == $emailedIssue['ignoreP'] || $newIssue['ignoreC'] == $emailedIssue['ignoreC']){
					$alreadyEmailed = true;
					break;
				}
			}
			if(! $alreadyEmailed){
				$finalIssues[] = $newIssue;
			}
			else {
				$overflowCount--;
			}
		}
		if(sizeof($finalIssues) < 1){ return; }
		
		$this->newIssues = array();
		$this->totalIssues = 0;

		$totalWarningIssues = 0;
		$totalCriticalIssues = 0;
		foreach($finalIssues as $i){
			$emailedIssues[] = array( 'ignoreC' => $i['ignoreC'], 'ignoreP' => $i['ignoreP'] );
			if($i['severity'] == 1){
				$totalCriticalIssues++;
			} else if($i['severity'] == 2){
				$totalWarningIssues++;
			}
		}
		wfConfig::set_ser('emailedIssuesList', $emailedIssues);
		if($level == 2 && $totalCriticalIssues < 1 && $totalWarningIssues < 1){ return; }
		if($level == 1 && $totalCriticalIssues < 1){ return; }
		$content = wfUtils::tmpl('email_newIssues.php', array(
			'isPaid' => wfConfig::get('isPaid'),
			'issues' => $finalIssues,
			'totalCriticalIssues' => $totalCriticalIssues,
			'totalWarningIssues' => $totalWarningIssues,
			'level' => $level,
			'issuesNotShown' => $overflowCount,
			'adminURL' => get_admin_url(),
			'timeLimitReached' => $timeLimitReached,
			));
		
		wp_mail(implode(',', $emails), $subject, $content, 'Content-type: text/html');
	}
	public function deleteIssue($id){ 
		$this->getDB()->queryWrite("delete from " . $this->issuesTable . " where id=%d", $id);
	}
	public function updateIssue($id, $status){ //ignoreC, ignoreP, delete or new
		if($status == 'delete'){
			$this->getDB()->queryWrite("delete from " . $this->issuesTable . " where id=%d", $id);
		} else if($status == 'ignoreC' || $status == 'ignoreP' || $status == 'new'){
			$this->getDB()->queryWrite("update " . $this->issuesTable . " set status='%s' where id=%d", $status, $id);
		}
	}
	public function getIssueByID($id){
		$rec = $this->getDB()->querySingleRec("select * from " . $this->issuesTable . " where id=%d", $id);
		$rec['data'] = unserialize($rec['data']);
		return $rec;
	}
	public function getIssues($offset = 0, $limit = 100){
		/** @var wpdb $wpdb */
		global $wpdb;
		$ret = array(
			'new' => array(),
			'ignored' => array()
			);
		$userIni = ini_get('user_ini.filename');
		$q1 = $this->getDB()->querySelect("select * from " . $this->issuesTable . " order by time desc LIMIT %d,%d", $offset, $limit);
		foreach($q1 as $i){
			$i['data'] = unserialize($i['data']);
			$i['timeAgo'] = wfUtils::makeTimeAgo(time() - $i['time']);
			$i['longMsg'] = wp_kses($i['longMsg'], 'post');
			if($i['status'] == 'new'){
				$ret['new'][] = $i;
			} else if($i['status'] == 'ignoreP' || $i['status'] == 'ignoreC'){
				$ret['ignored'][] = $i;
			} else {
				error_log("Issue has bad status: " . $i['status']);
				continue;
			}
		}
		foreach($ret as $status => &$issueList){
			for($i = 0; $i < sizeof($issueList); $i++){
				if ($issueList[$i]['type'] == 'file' || $issueList[$i]['type'] == 'knownfile') {
					$localFile = $issueList[$i]['data']['file'];
					if ($localFile != '.htaccess' && $localFile != $userIni) {
						$localFile = ABSPATH . '/' . preg_replace('/^[\.\/]+/', '', $localFile);
					}
					else {
						$localFile = ABSPATH . '/' . $localFile;
					}
					
					if(file_exists($localFile)){
						$issueList[$i]['data']['fileExists'] = true;
					} else {
						$issueList[$i]['data']['fileExists'] = '';
					}
				}
				if ($issueList[$i]['type'] == 'database') {
					$issueList[$i]['data']['optionExists'] = false;
					if (!empty($issueList[$i]['data']['site_id'])) {
						$prefix = $wpdb->get_blog_prefix($issueList[$i]['data']['site_id']);
						$issueList[$i]['data']['optionExists'] = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$prefix}options WHERE option_name = %s", $issueList[$i]['data']['option_name'])) > 0;
					}
				}
				$issueList[$i]['issueIDX'] = $i;
			}
		}
		return $ret; //array of lists of issues by status
	}
	public function getPendingIssues($offset = 0, $limit = 100){
		/** @var wpdb $wpdb */
		global $wpdb;
		$issues = $this->getDB()->querySelect("SELECT * FROM {$this->pendingIssuesTable} ORDER BY id ASC LIMIT %d,%d", $offset, $limit);
		foreach($issues as &$i){
			$i['data'] = unserialize($i['data']);
		}
		return $issues;
	}
	public function getIssueCount() {
		return (int) $this->getDB()->querySingle("select COUNT(*) from " . $this->issuesTable . " WHERE status = 'new'");
	}
	public function getPendingIssueCount() {
		return (int) $this->getDB()->querySingle("select COUNT(*) from " . $this->pendingIssuesTable . " WHERE status = 'new'");
	}
	public function reconcileUpgradeIssues($report = null, $useCachedValued = false) {
		if ($report === null) {
			$report = new wfActivityReport();
		}
		
		$updatesNeeded = $report->getUpdatesNeeded($useCachedValued);
		if ($updatesNeeded) {
			if (!$updatesNeeded['core']) {
				$this->getDB()->queryWrite("DELETE FROM {$this->issuesTable} WHERE status = 'new' AND type = 'wfUpgrade'");
			}
			
			if ($updatesNeeded['plugins']) {
				$upgradeNames = array();
				foreach ($updatesNeeded['plugins'] as $p) {
					$name = $p['Name'];
					$upgradeNames[$name] = 1;
				}
				$upgradeIssues = $this->getDB()->querySelect("SELECT * FROM {$this->issuesTable} WHERE status = 'new' AND type = 'wfPluginUpgrade'");
				foreach ($upgradeIssues as $issue) {
					$data = unserialize($issue['data']);
					$name = $data['Name'];
					if (!isset($upgradeNames[$name])) { //Some plugins don't have a slug associated with them, so we anchor on the name
						$this->deleteIssue($issue['id']);
					}
				}
			}
			else {
				$this->getDB()->queryWrite("DELETE FROM {$this->issuesTable} WHERE status = 'new' AND type = 'wfPluginUpgrade'");
			}
			
			if ($updatesNeeded['themes']) {
				$upgradeNames = array();
				foreach ($updatesNeeded['themes'] as $t) {
					$name = $t['Name'];
					$upgradeNames[$name] = 1;
				}
				$upgradeIssues = $this->getDB()->querySelect("SELECT * FROM {$this->issuesTable} WHERE status = 'new' AND type = 'wfThemeUpgrade'");
				foreach ($upgradeIssues as $issue) {
					$data = unserialize($issue['data']);
					$name = $data['Name'];
					if (!isset($upgradeNames[$name])) { //Some themes don't have a slug associated with them, so we anchor on the name
						$this->deleteIssue($issue['id']);
					}
				}
			}
			else {
				$this->getDB()->queryWrite("DELETE FROM {$this->issuesTable} WHERE status = 'new' AND type = 'wfThemeUpgrade'");
			}
		}
		else {
			$this->getDB()->queryWrite("DELETE FROM {$this->issuesTable} WHERE status = 'new' AND (type = 'wfUpgrade' OR type = 'wfPluginUpgrade' OR type = 'wfThemeUpgrade')");
		}
		
		wfScanEngine::refreshScanNotification($this);
	}
	public function updateSummaryItem($key, $val){
		$arr = wfConfig::get_ser('wf_summaryItems', array());
		$arr[$key] = $val;
		$arr['lastUpdate'] = time();
		wfConfig::set_ser('wf_summaryItems', $arr);
	}
	public function getSummaryItem($key){
		$arr = wfConfig::get_ser('wf_summaryItems', array());
		if(array_key_exists($key, $arr)){
			return $arr[$key];
		} else { return ''; }
	}
	public function summaryUpdateRequired(){
		$last = $this->getSummaryItem('lastUpdate');
		if( (! $last) || (time() - $last > (86400 * 7))){
			return true;
		}
		return false;
	}
	public function getSummaryItems(){
		if(! $this->updateCalled){
			$this->updateCalled = true;
			$this->updateSummaryItems();
		}
		$arr = wfConfig::get_ser('wf_summaryItems', array());
		//$arr['scanTimeAgo'] = wfUtils::makeTimeAgo(sprintf('%.0f', time() - $arr['scanTime']));
		$arr['scanRunning'] = wfUtils::isScanRunning() ? '1' : '0';
		$arr['scheduledScansEnabled'] = wfConfig::get('scheduledScansEnabled');
		$secsToGo = wp_next_scheduled('wordfence_scheduled_scan') - time();
		if($secsToGo < 1){
			$nextRun = 'now';
		} else {
			$nextRun = wfUtils::makeTimeAgo($secsToGo) . ' from now';
		}
		$arr['nextRun'] = $nextRun;

		$arr['totalCritical'] = $this->getDB()->querySingle("select count(*) as cnt from " . $this->issuesTable . " where status='new' and severity=1");
		$arr['totalWarning'] = $this->getDB()->querySingle("select count(*) as cnt from " . $this->issuesTable . " where status='new' and severity=2");

		return $arr;
	}
	private function updateSummaryItems(){
		global $wpdb;
		$dat = array();
		$users = $wpdb->get_col("SELECT $wpdb->users.ID FROM $wpdb->users");
		$dat['totalUsers'] = sizeof($users);
		$res1 = $wpdb->get_col("SELECT count(*) as cnt FROM $wpdb->posts where post_type='page' and post_status NOT IN ('auto-draft')"); $dat['totalPages'] = $res1['0'];
		$res1 = $wpdb->get_col("SELECT count(*) as cnt FROM $wpdb->posts where post_type='post' and post_status NOT IN ('auto-draft')"); $dat['totalPosts'] = $res1['0'];
		$res1 = $wpdb->get_col("SELECT count(*) as cnt FROM $wpdb->comments"); $dat['totalComments'] = $res1['0'];
		$res1 = $wpdb->get_col("SELECT count(*) as cnt FROM $wpdb->term_taxonomy where taxonomy='category'"); $dat['totalCategories'] = $res1['0'];
		$res1 = $wpdb->get_col("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE()"); $dat['totalTables'] = sizeof($res1);
		$totalRows = 0;
		foreach($res1 as $table){
			$res2 = $wpdb->get_col("select count(*) from `$table`");
			if(isset($res2[0]) ){
				$totalRows += $res2[0];
			}
		}
		$dat['totalRows'] = $totalRows;
		$arr = wfConfig::get_ser('wf_summaryItems', array());
		foreach($dat as $key => $val){
			$arr[$key] = $val;
		}
		wfConfig::set_ser('wf_summaryItems', $arr);
	}
	public function setScanTimeNow(){
		$this->updateSummaryItem('scanTime', microtime(true));
	}
	public function getScanTime(){
		return $this->getSummaryItem('scanTime');
	}
	private function getDB(){
		if(! $this->db){
			$this->db = new wfDB();
		}
		return $this->db;
	}
}

?>
