<?php
/*
  Plugin Name: XC1 Helper
  Description: Sail smoothly, adds functionality to style administration, maintenance mode, directories for static content etc.
  Author: Anders Hassis, XC1 Group
  Version: 1.0
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
  die(__('You are not allowed to call this page directly.')); 
} 
 
class XC1_Helper {  
  public $basename = '';
  public $folder = '';
  public $pluginPath = '';
  public $pluginURI = '';
  public $version = '1.0';
  private $__defaultValues = array(
    'xc1_helper_installed'                => 1, 
    'xc1_helper_maintenance'              => 0,
    'xc1_helper_static'                   => 0,
    'xc1_helper_static_path'              => '/home/username/www/static/sitename.com/',
    'xc1_helper_static_url'               => '/static/sitename.com/',
    'xc1_helper_custom_admin'             => 1,
    'xc1_helper_custom_favicon'           => 1,
    'xc1_helper_custom_gravatar'          => 1,
    'xc1_helper_extend_bodyclass'         => 1,
    'xc1_helper_custom_admin_footer'      => 'Producerad av <a href=\"http://www.xc1.se\">XC1 Group</a>. <br />Support: <a href=\"mailto:info@xc1.se\">info@xc1.se</a>'
  );
  
  public function __construct() {
    $this->basename = plugin_basename(__FILE__);
    $this->folder = dirname($this->basename);
    
    register_activation_hook(__FILE__, array(&$this, 'activate'));
    register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));
    
    add_action( 'init', array( &$this, 'init' ));
  }
  
  public function init() {
    add_action('admin_init', array(&$this, 'admin_init'));
    add_action('admin_menu', array(&$this, 'admin_menu'));
    
    // Fix for filtering input from custom footer text
    add_filter('option_xc1_helper_custom_admin_footer', 'stripslashes');
    
		$this->pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"", plugin_basename(__FILE__));
		$this->pluginURI  = plugins_url( $this->folder); 
		
    $this->actions();
    $this->filters();
    
    define('THEME_ROOT', get_theme_root() );
    define('THEME_PATH', get_bloginfo('template_directory') );
    
    if ( (int)get_option('xc1_helper_maintenance') ) {
      require_once('modules/maintenance-mode.php');
      $maintenance = new XC1_Maintenance_Helper();
    }
  }
  
  public function admin_init() {
    wp_register_script('xc1_helper', plugins_url( $this->folder . '/assets/javascripts/xc1_helper.js' ), array('jquery'), $this->version);
    wp_register_style ('xc1_helper', plugins_url( $this->folder . '/assets/stylesheets/xc1_helper.css' ), array(), $this->version);
    
    wp_enqueue_script('xc1_helper');
    wp_enqueue_style('xc1_helper');
  }
  
  public function admin_menu() {
    add_options_page('XC1 Helper', 'XC1 Helper', 'edit_users', basename(__FILE__), array(&$this, 'route') ) ;
  }
  
  public function activate () { 
    if ( !get_option('xc1_helper_installed') ) { 
      foreach ($this->__defaultValues as $k => $v) {
        update_option($k, $v);
      }
    }    
  }
  
  public function deactivate () { 
    foreach ($this->__defaultValues as $k => $v) {
      delete_option($k);
    }
  }
  
  public function route() {
    global $wpdb;
    
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    
    switch($action) {
      default:
      case 'index': 
    		if ( !current_user_can('edit_users') ) {
          die(__("Access denied"));
        }
        
				$this->render('index');
      break;

      case 'update':
        if ( !current_user_can('edit_users') ) {
          die(__("Access denied"));
        }
        
        foreach ($this->__defaultValues as $k => $v) {
          if (array_key_exists($k, $_POST)) {
            update_option($k, $_POST[$k]);
          } else {
            update_option($k, 0);
          }
        }
        // @TODO: Bad redirect
				?>
					<script type="text/javascript">
				   <!--
				      window.location= "?page=xc1.php";
				   //-->
				   </script>
				<?php
      break;
    }
  }
  
  public function render($page) {
    switch($page) {
      default:
      case 'index': 
      	include('templates/settings.php');
      break;
    }
  }
  
  public function filters() {
    if ( (int)get_option('xc1_helper_custom_admin') ) {
      add_filter( 'admin_footer_text', array(&$this, 'custom_footer') ); 
    }
    
    if ( (int)get_option('xc1_helper_extend_bodyclass') ) {
      add_filter( 'body_class', array(&$this, 'modify_body_class') );
    }
    
    if ( (int)get_option('xc1_helper_custom_gravatar') ) {
      add_filter( 'avatar_defaults', array(&$this, 'newgravatar') );
    }

    // Remove updates from administration
    if (!current_user_can('edit_users')) {
      add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
      add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
    }
  }
  
 private function actions() {
   if ( (int)get_option('xc1_helper_custom_favicon') ) {
		add_action( 'wp_head', array(&$this, 'favicon') );
		add_action( 'admin_head', array(&$this, 'favicon') );
     	add_action( 'rss_head', array(&$this, 'add_feed_logo') );
     	add_action( 'rss2_head', array(&$this, 'add_feed_logo') );
   }
   
   if ( (int)get_option('xc1_helper_custom_admin') ) {
     add_action( 'login_head', array(&$this, 'custom_login') );
     add_action( 'admin_head', array(&$this, 'custom_header') ); 
   }
   
   // Remove generator from header
   remove_action( 'wp_head', 'wp_generator' );
   

   if ( (int)get_option('xc1_helper_static') ) {
     define('XC1_THEME_STATIC_PATH', ABSPATH . get_option('xc1_helper_static_path') );
     define('XC1_THEME_STATIC_URI', get_option('xc1_helper_static_url') );
   } else {
     define('XC1_THEME_STATIC_PATH', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"", plugin_basename(__FILE__)) );
     define('XC1_THEME_STATIC_URI', plugins_url( $this->folder) ); 
   }

   define('XC1_THEME_CSS_PATH', XC1_THEME_STATIC_PATH . 'assets/stylesheets' );
   define('XC1_THEME_CSS_URI', XC1_THEME_STATIC_URI . 'assets/stylesheets' );

   define('XC1_THEME_JS_PATH', XC1_THEME_STATIC_PATH . 'assets/javascripts' );
   define('XC1_THEME_JS_URI', XC1_THEME_STATIC_URI . 'assets/javascripts' );

   define('XC1_THEME_IMAGES_PATH', XC1_THEME_STATIC_PATH . 'assets/images' );
   define('XC1_THEME_IMAGES_URI', XC1_THEME_STATIC_URI . 'assets/images' );
 }
  
  /*
   * Modify body class
   */
  function modify_body_class($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    
	// Browser
    if ($is_lynx)
      $classes [] = 'lynx';
    elseif ($is_gecko)
      $classes [] = 'gecko';
    elseif ($is_opera)
      $classes [] = 'opera';
    elseif ($is_NS4)
      $classes [] = 'ns4';
    elseif ($is_safari)
      $classes [] = 'safari';
    elseif ($is_chrome)
      $classes [] = 'chrome';
    elseif ($is_IE)
      $classes [] = 'ie';
    else
      $classes [] = 'unknown';

    if ($is_iphone)
      $classes [] = 'iphone';

	// Page slug
	$post_data = get_post($post->ID, ARRAY_A);
	$classes [] = 'page-' . $post_data['post_name'];

    return $classes;
  }

  function newgravatar($avatar_defaults) {
    if (file_exists ( XC1_THEME_IMAGES_PATH . '/xc1-avatar.jpg' ))
      $myavatar = XC1_THEME_IMAGES_URI . '/xc1-avatar.jpg';
    else
      $myavatar = plugins_url( $this->folder . '/assets/images/xc1-avatar.jpg' );

    $avatar_defaults [$myavatar] = "XC1 avatar";

    return $avatar_defaults;
  }

  function favicon() {
    if (file_exists ( XC1_THEME_IMAGES_PATH . '/xc1-iphone.png' )) {
      $apple_icon = XC1_THEME_IMAGES_URI . '/xc1-iphone.png';
    } else {
      $apple_icon = plugins_url( $this->folder . '/assets/images/xc1-iphone.png' );
    }
    
    if (file_exists ( XC1_THEME_IMAGES_PATH . '/xc1-favicon.png' ))
      $favicon_icon = XC1_THEME_IMAGES_URI . '/xc1-favicon.png';
    else
      $favicon_icon = plugins_url( $this->folder . '/assets/images/xc1-favicon.png' );

    if (get_option ( 'show_avatars' )) {
      echo "<link rel=\"apple-touch-icon\" href=\"$apple_icon\" />\n";
      echo "<link rel=\"shortcut icon\" type=\"image/png\" href=\"$favicon_icon\" />\n";
    }
  }

  function add_feed_logo() {
    $feed_logo = plugins_url( $this->folder . '/assets/images/xc1-avatar.jpg' );
    echo " 
      <image>
        <title>" . get_bloginfo ( 'name' ) . "</title>
        <url>" . $feed_logo . "</url>
        <link>" . get_bloginfo ( 'siteurl' ) . "</link>
      </image>\n";
  }

  function gravatar($size = 96, $attributes = '', $author_email = '') {
    global $comment, $settings;
    if (dp_settings ( 'gravatar' ) == 'enabled') {
      if (empty ( $author_email )) {
        ob_start ();
        comment_author_email ();
        $author_email = ob_get_clean ();
      }
      
      $gravatar_url = 'http://www.gravatar.com/avatar/' . md5 ( strtolower ( $author_email ) ) . '?s=' . $size . '&amp;d=' . dp_settings ( 'gravatar_fallback' );
      
      printf("<img src=\"%s\" %s />", $gravatar_url, $attributes );
    }
  }

  function custom_login() {
    if (file_exists ( XC1_THEME_CSS_PATH . '/admin.css' ))
      echo '<link rel="stylesheet" type="text/css" href="' . XC1_THEME_CSS_URI . '/admin.css" />'; // Child template admin css 
    else
      echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( $this->folder . '/assets/stylesheets/admin.css' ).'" />'; // Template admin css
  }

  function custom_header() {
    if (file_exists ( XC1_THEME_CSS_PATH . '/admin.css' )) {
      echo '<link rel="stylesheet" type="text/css" href="' . XC1_THEME_CSS_URI . '/admin.css" />'; // Child template admin css
    } else {
      echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( $this->folder . '/assets/stylesheets/admin.css' ).'" />'; // Template admin css
    }
  }

  function custom_footer() {
  	return get_option('xc1_helper_custom_admin_footer');
  }
  
  public static function _naturalizeBoolean($value) {
    return $value == '1' ? 'Yes' : 'No';
  }
}

$xc1_helper = new XC1_Helper(); 