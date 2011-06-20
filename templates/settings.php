<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
  die(__('You are not allowed to call this page directly.')); 
}
      ?><div class="wrap">
          <div id="icon-options-general" class="icon32"></div>
            <h2>XC1 Helper</h2>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;action=update" id="xc1_helper_settings">
            <table class="form-table">
                <tr>
                  <th scope="row">
                    <label for="xc1_helper_maintenance"><?php _e('Maintenance mode');?></label>
                  </th>
                  <td>
										<input type="checkbox" value="1" id="xc1_helper_maintenance" name="xc1_helper_maintenance"<?php echo ((int)get_option('xc1_helper_maintenance') == 1 ? ' checked="checked"' : '')?> />
										<span class="description"><?php _e('Going for 503.php in your theme directory, or fallback to XC1 Helpers 503.php');?></span>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="xc1_helper_static"><?php _e('Use static structure');?></label>
                  </th>
                  <td>
										<input type="checkbox" value="1" id="xc1_helper_static" name="xc1_helper_static"<?php echo ((int)get_option('xc1_helper_static') == 1 ? ' checked="checked"' : '')?> />
                    <span class="description"><?php _e('Use a static directory for e.g. nginx to use');?></span>
                  </td>
                </tr>
								<tr class="xc1_static">
                  <th scope="row">
                    <label for="xc1_helper_static_path"><?php _e('Path to static directory');?></label>
                  </th>
                  <td>
										<input type="text" name="xc1_helper_static_path" id="xc1_helper_static_path" value="<?php echo get_option('xc1_helper_static_path'); ?>" /><br />
                    <span class="description"><?php _e('Relative path to static directory. Example: <em>static/sitename.com/</em>');?></span>
                  </td>
                </tr>
								<tr class="xc1_static">
                  <th scope="row">
                    <label for="xc1_helper_static_url"><?php _e('URI to static directory');?></label>
                  </th>
                  <td>
										<input type="text" id="xc1_helper_static_url" name="xc1_helper_static_url" value="<?php echo get_option('xc1_helper_static_url'); ?>" /><br />
                    <span class="description"><?php _e('Full URI to static directory. Example: <em>/static/sitename.com/</em>');?></span>
                  </td>
                </tr>
							  <tr>
                  <th scope="row">
                    <label for="xc1_helper_admin"><?php _e('Custom admin styling');?></label>
                  </th>
                  <td>
										<input type="checkbox" value="1" id="xc1_helper_admin" name="xc1_helper_custom_admin"<?php echo (int)get_option('xc1_helper_custom_admin') == 1 ? ' checked="checked"' : ''?>/>
                    <span class="description"><?php _e('Going for <em>assets/stylesheets/admin.css</em>');?></span>
                  </td> 
                </tr>
                <tr class="xc1_admin">
                  <th scope="row">
                    <label for="xc1_helper_custom_admin_footer"><?php _e('Custom footer text');?></label>
                  </th>
                  <td>
										<input type="text" value="<?php echo str_replace("\"", '&quot;', get_option('xc1_helper_custom_admin_footer')); ?>" name="xc1_helper_custom_admin_footer" id="xc1_helper_custom_admin_footer" />
                  </td>
                </tr>
								<tr>
                  <th scope="row">
                    <label for="xc1_helper_custom_favicon"><?php _e('Custom favicons');?></label>
                  </th>
                  <td>
										<input type="checkbox" value="1" id="xc1_helper_custom_favicon" name="xc1_helper_custom_favicon"<?php echo (int)get_option('xc1_helper_custom_favicon') == 1 ? ' checked="checked"' : ''?>/>
                    <span class="description"><?php _e('Going for <em>xc1-favicon.png, xc1-iphone.png</em>');?></span>
                  </td>
                </tr>
								<tr>
                  <th scope="row">
                    <label for="xc1_helper_custom_gravatar"><?php _e('Custom gravatar');?></label>
                  </th>
                  <td>
										<input type="checkbox" value="1" id="xc1_helper_custom_gravatar" name="xc1_helper_custom_gravatar"<?php echo (int)get_option('xc1_helper_custom_gravatar') == 1 ? ' checked="checked"' : ''?>/>
                    <span class="description"><?php _e('Going for <em>xc1-avatar.png</em>');?></span>
                  </td>
                </tr>
								<tr>
                  <th scope="row">
                    <label for="map_form_group"><?php _e('Extend bodyclass');?></label>
                  </th>
                  <td>
										<input type="checkbox" value="1" id="xc1_helper_extend_bodyclass" name="xc1_helper_extend_bodyclass"<?php echo (int)get_option('xc1_helper_extend_bodyclass') == 1 ? ' checked="checked"' : ''?> />
										<span class="description"><?php _e('Hooks into the body-class and adds browsers');?></em></span>
                  </td>
                </tr>
															
            </table>
          <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
          </p>
        </form>
      </div>
