<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
	die(__('You are not allowed to call this page directly.')); 
}

class XC1_Maintenance_Helper {
	public $msg = '';
	
	public function XC1_Maintenance_Helper() {		
		add_action('send_headers', array(&$this, 'activateMaintenancePage'));
		add_action('admin_notices', array(&$this, 'adminNoticeMsg') );
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
	
	public function isAuthorized() {
		return current_user_can('edit_posts');
	}

	public function msgBox() {		
		if( $this->msg != NULL ) : ?>
			<div id="message" class="updated fade"><p><?php echo $this->msg; ?></p></div>
		<?php endif; 
	}
	
	public function adminNoticeMsg() {		
		if( $this->isAuthorized() && (int)get_option('xc1_helper_maintenance') ) : ?>
			<div class="error">
				<p>
					<?php printf(__('<strong>Maintenance mode</strong> is active. Don\'t forget to %sdeactivate%s it as soon as you\'re done.'), '<a href="options-general.php?page=xc1.php">', '</a>'); ?>
				</p>
			</div>
		<?php endif;
	}
	
	public function activateMaintenancePage() {		
		if ( (int)get_option('xc1_helper_maintenance') && !$this->isAuthorized() ) {
			add_filter('status_header', array(&$this, 'maintenance_header', 10, 4) );
			$this->add_feed_actions();
	
	//die(get_theme_root() . ' ' . get_bloginfo('template_directory')  . '/503.php');
			if (file_exists(TEMPLATEPATH . '/503.php'))
				$file = TEMPLATEPATH . '/503.php';
			else 
				$file = dirname(__FILE__) . '/../templates/503.php';

			include_once( $file );
			exit();
		}
	}
}  