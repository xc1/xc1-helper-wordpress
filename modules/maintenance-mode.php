<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
	die('You are not allowed to call this page directly.'); 
}

class XC1_Maintenance_Helper {
	public $err = false;
	public $msg = '';
	public $allSettings = array();
	
	public function XC1_Maintenance_Helper() {
		$this->allSettings = get_option('OfflineModeSettings');
		
		add_action('send_headers', array(&$this, 'activateMaintenancePage'));
		
		$data = array(	'OfflineMode_type' => '',
						'OfflineMode_enable' => '',
						'OfflineMode_startTime' => 0); 
						
		add_option('OfflineModeSettings',$data,'OfflineMode Settings');
		add_action('admin_menu', array(&$this, 'addSettingsPage') );
		add_action('admin_notices', array(&$this, 'adminNoticeMsg') );
	}

	public function addSettingsPage() {
		if (function_exists('add_options_page')) {
			add_options_page('XC1 Maintenance', 'XC1 Maintenance', 'edit_posts', basename(__FILE__), array(&$this, 'optionPage') ) ;
		}
	}
	
	public function maintenance_header($status_header, $header, $text, $protocol) {
		return "$protocol 503 Service Unavailable";
	}
	
	public function maintenance_feed() {
		die('<?xml version="1.0" encoding="UTF-8"?><status>Service unavailable</status>');
	}
	
	public function add_feed_actions() {
		$feeds = array ('rdf', 'rss', 'rss2', 'atom');
		foreach ($feeds as $feed) {
			add_action('do_feed_'.$feed, array(&$this, 'wet_maintenance_feed'), 1, 1);
		} 
	}
	
	public function optionPage() {		
		if( $this->isAuthorized() ) {
			if (isset($_POST['OfflineMode_submit'])) {
				$data = array( 'OfflineMode_enable' => ((int) $_POST['OfflineMode_enable']), 'OfflineMode_startTime' => time() );
				update_option('OfflineModeSettings',$data);
				
				if (isset($_POST['OfflineMode_redirect']))
					$url = $_POST['OfflineMode_redirect'];
				else
					$url = $_SERVER['REQUEST_URI'];
				
				echo "<div id=\"message\" class=\"updated fade\"><p>Inställningar uppdaterade.</p> <a href=\"".$url."\">Gå tillbaka</a>.</div>";
				die();
			}			

			# Fill the settings to the form
			if( $this->allSettings['OfflineMode_enable'] ) {
				$enabled = ' checked="checked"';
			}
						
			# Got msg to display?
			$this->msgBox();

		?>
<div class="wrap">
	<h2>XC1 Maintenance</h2>
	
	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
				
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Aktivera XC1 Maintenance</th>
				<td>
					<input type="checkbox" id="OfflineMode_enable" name="OfflineMode_enable" value="1"<?php echo $enabled; ?> />
					<label for="OfflineMode_enable">Stänger av webbplatsen och visar 503.php i ditt tema.</label>
					<input type="hidden" name="OfflineMode_redirect" value="<?php echo $_SERVER['REQUEST_URI'];?>" />
				</td>
			</tr>
		</table>
		
		<p class="submit">
			<input type="submit" name="OfflineMode_submit" value="Uppdatera" class="button" />
		</p>
		
	</form>
</div><?php
		}
	}
	
	public function isAuthorized() {
		return current_user_can('edit_posts');
	}

	public function msgBox() {		
		if( $this->msg != NULL ) { ?>
			<div id="message" class="updated fade"><p><?php echo $this->msg; ?></p></div>
		<?php
		}
	}
	
	public function adminNoticeMsg() {		
		if( $this->isAuthorized() && $this->allSettings['OfflineMode_enable'] ) {
		?>
			<div class="error">
				<p>
				<strong>XC1 Maintenance</strong> är aktivt. Glöm inte att <a href="admin.php?page=<?php echo basename(__FILE__); ?>">inaktivera</a> det så fort du är klar.
				</p>
			</div>
		<?php
		}
	}
	
	public function activateMaintenancePage() {		
		if ( $this->allSettings['OfflineMode_enable'] && !$this->isAuthorized() ) {
			add_filter('status_header', array(&$this, 'maintenance_header', 10, 4) );
			$this->add_feed_actions();
	
			if (file_exists(CHILD_THEME_PATH . '503.php'))
				$file = CHILD_THEME_PATH . '503.php';
			else 
				$file = plugins_dir($xc1_helper->folder.'/templates/503.php');
				
			include_once( $file );
			exit();
		}
	}
	
}  

