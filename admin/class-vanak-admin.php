<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mehrdaddindar.ir
 * @since      1.0.0
 *
 * @package    Vanak
 * @subpackage Vanak/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vanak
 * @subpackage Vanak/admin
 * @author     Mehrdad Dindar <mehrdad.dindar@live.com>
 */
class Vanak_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vanak_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vanak_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vanak-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vanak_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vanak_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vanak-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function options_page($setups)
    {
        $ssl = false;
        if (!empty($_SERVER['HTTPS'])) {
            $ssl = true;
        }

        $setups[] = array(
            /*
             * Here we specify option name. It will be a key for storing in wp_options table
             */
            'option_name' => 'vanak_settings',
            'admin_bar_title' => esc_html__('Vanak', 'vanak'),
            'title' => esc_html__("Vanak", "vanak"),
            'sub_title' => esc_html__('by Mehrdad Dindar', 'vanak'),
            'logo' => BALE_WOO_URL . 'admin/img/bot.svg',

            /*
             * Next we add a page to display our awesome settings.
             * All parameters are required and same as WordPress add_menu_page.
             */
            'page' => array(
                'page_title' => esc_html__("Vanak Dashboard", "vanak"),
                'menu_title' => esc_html__("Vanak", "vanak"),
                'menu_slug' => 'vanak-dashboard',
                'icon' => 'dashicons-smiley',
                'position' => 59,
            ),

            /*
             * And Our fields to display on a page. We use tabs to separate settings on groups.
             */
            'fields' => array(
                // Even single tab should be specified
                'bot_connection' => array(
                    // And its name obviously
                    'name' => esc_html__('Connection', 'vanak'),
                    'icon' => 'fas fa-ethernet',
                    'fields' => array(
                        'notification_message' => array(
                            'type' => 'notification_message',
                            'image' => VANAK_URL . 'admin/img/bot.svg',
                            'description' =>
                                sprintf(
                                    '<h1>%s</h1><p>%s</p><p>%s<ol><li>%s</li><li>%s</li><li>%s</li></ol></p>',
                                    __('Welcome to Vanak', 'vanak'),
                                    __('By using this plugin, you will be informed about the details of the order as soon as the order is placed', 'vanak'),
                                    __('To do this, follow the steps below:', 'vanak'),
                                    __('Create a new bot with the help of <code>BotFather</code>', 'vanak'),
                                    __('Enter the chat page with the bot and send the token', 'vanak'),
                                    __('In the last step, to communicate between the bot and the plugin, enter and save the token in the field below', 'vanak')
                                ),
                        ),
                        'token' => array(
                            'type' => 'text',
                            'label' => esc_html__("Token", "vanak"),
                            'value' => get_option("vanak_token"),
/*                            'placeholder' => ''*/
                            'description' => __("Please enter the token received from the <code>BotFather</code> here.", "vanak"),
                        ),
                    )
                ),
                'bot_options' => array(
                    // And its name obviously
                    'name' => esc_html__('Options', 'vanak'),
                    'icon' => 'fas fa-tasks',
                    'fields' => array(
                        'admin_login' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__("Admin Login", "vanak"),
                            'description' => __("Find out about the login of managers to the management counter.", "vanak"),
                            'group' => 'started'
                        ),
                        'order_submitted' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__("Order Submitted", "vanak"),
                            'description' => __("Get notified as soon as you place a new order.", "vanak"),
                            'group' => 'ended'
                        ),
                    )
                ),
                'bot_status' => array(
                    // And its name obviously
                    'name' => esc_html__('Status', 'vanak'),
                    'icon' => 'fas fa-compass',
                    'fields' => array(
                        'notification_message' => array(
                            'type' => 'notification_message',
                            'image' => VANAK_URL . 'admin/img/ssl.svg',
                            'description' =>
                                sprintf(
                                    '<h1>%s</h1><p class="alert %s">%s</p>',
                                    __('Check SSL', 'vanak'),
                                    $ssl ? "alert-success" : "alert-warning",
                                    $ssl ? __('your connection is secure', 'vanak') : __('your connection is not secure', 'vanak')
                                ),
                        ),
                    )
                ),


                /*
                 * Other tabs you can add below
                 */
            )
        );

        return $setups;
    }

}