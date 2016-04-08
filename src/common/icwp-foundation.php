<?php
if ( !class_exists( 'ICWP_Maid_Foundation', false ) ) :

	class ICWP_Maid_Foundation {
		/**
		 * @var ICWP_Maid_DataProcessor
		 */
		private static $oDp;
		/**
		 * @var ICWP_Maid_WpFilesystem
		 */
		private static $oFs;
		/**
		 * @var ICWP_Maid_WpCron
		 */
		private static $oWpCron;
		/**
		 * @var ICWP_Maid_WpFunctions
		 */
		private static $oWp;
		/**
		 * @var ICWP_Maid_WpDb
		 */
		private static $oWpDb;
		/**
		 * @var ICWP_Maid_Render
		 */
		private static $oRender;
		/**
		 * @var ICWP_Maid_YamlProcessor
		 */
		private static $oYaml;
		/**
		 * @var ICWP_Maid_Ip
		 */
		private static $oIp;
		/**
		 * @var ICWP_Maid_GoogleAuthenticator
		 */
		private static $oGA;
		/**
		 * @var ICWP_Maid_WpAdminNotices
		 */
		private static $oAdminNotices;
		/**
		 * @var ICWP_Maid_WpUsers
		 */
		private static $oWpUsers;
		/**
		 * @var ICWP_Maid_WpComments
		 */
		private static $oWpComments;
		/**
		 * @var ICWP_Maid_GoogleRecaptcha
		 */
		private static $oGR;

		/**
		 * @return ICWP_Maid_DataProcessor
		 */
		static public function loadDataProcessor() {
			if ( !isset( self::$oDp ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-data.php' );
				self::$oDp = ICWP_Maid_DataProcessor::GetInstance();
			}
			return self::$oDp;
		}

		/**
		 * @return ICWP_Maid_WpFilesystem
		 */
		static public function loadFileSystemProcessor() {
			if ( !isset( self::$oFs ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-wpfilesystem.php' );
				self::$oFs = ICWP_Maid_WpFilesystem::GetInstance();
			}
			return self::$oFs;
		}

		/**
		 * @return ICWP_Maid_WpFunctions
		 */
		static public function loadWpFunctionsProcessor() {
			if ( !isset( self::$oWp ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-wpfunctions.php' );
				self::$oWp = ICWP_Maid_WpFunctions::GetInstance();
			}
			return self::$oWp;
		}

		/**
		 * @return ICWP_Maid_WpCron
		 */
		static public function loadWpCronProcessor() {
			if ( !isset( self::$oWpCron ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-wpcron.php' );
				self::$oWpCron = ICWP_Maid_WpCron::GetInstance();
			}
			return self::$oWpCron;
		}

		/**
		 * @return void
		 */
		static public function loadWpWidgets() {
			require_once( dirname( __FILE__ ).ICWP_DS.'wp-widget.php' );
		}

		/**
		 * @return ICWP_Maid_WpDb
		 */
		static public function loadDbProcessor() {
			if ( !isset( self::$oWpDb ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-wpdb.php' );
				self::$oWpDb = ICWP_Maid_WpDb::GetInstance();
			}
			return self::$oWpDb;
		}

		/**
		 * @return ICWP_Maid_Ip
		 */
		static public function loadIpProcessor() {
			if ( !isset( self::$oIp ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-ip.php' );
				self::$oIp = ICWP_Maid_Ip::GetInstance();
			}
			return self::$oIp;
		}

		/**
		 * @return ICWP_Maid_GoogleAuthenticator
		 */
		static public function loadGoogleAuthenticatorProcessor() {
			if ( !isset( self::$oGA ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-googleauthenticator.php' );
				self::$oGA = ICWP_Maid_GoogleAuthenticator::GetInstance();
			}
			return self::$oGA;
		}

		/**
		 * @return ICWP_Maid_GoogleRecaptcha
		 */
		static public function loadGoogleRecaptcha() {
			if ( !isset( self::$oGR ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-googlearecaptcha.php' );
				self::$oGR = ICWP_Maid_GoogleRecaptcha::GetInstance();
			}
			return self::$oGR;
		}

		/**
		 * @param string $sTemplatePath
		 * @return ICWP_Maid_Render
		 */
		static public function loadRenderer( $sTemplatePath = '' ) {
			if ( !isset( self::$oRender ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-render.php' );
				self::$oRender = ICWP_Maid_Render::GetInstance()
					->setAutoloaderPath( dirname( __FILE__ ) . ICWP_DS . 'Twig' . ICWP_DS . 'Autoloader.php' );
			}
			if ( !empty( $sTemplatePath ) ) {
				self::$oRender->setTemplateRoot( $sTemplatePath );
			}
			return self::$oRender;
		}

		/**
		 * @return ICWP_Maid_YamlProcessor
		 */
		static public function loadYamlProcessor() {
			if ( !isset( self::$oYaml ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'icwp-yaml.php' );
				self::$oYaml = ICWP_Maid_YamlProcessor::GetInstance();
			}
			return self::$oYaml;
		}

		/**
		 * @return ICWP_Maid_WpAdminNotices
		 */
		static public function loadAdminNoticesProcessor() {
			if ( !isset( self::$oAdminNotices ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'wp-admin-notices.php' );
				self::$oAdminNotices = ICWP_Maid_WpAdminNotices::GetInstance();
			}
			return self::$oAdminNotices;
		}

		/**
		 * @return ICWP_Maid_WpUsers
		 */
		static public function loadWpUsersProcessor() {
			if ( !isset( self::$oWpUsers ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'wp-users.php' );
				self::$oWpUsers = ICWP_Maid_WpUsers::GetInstance();
			}
			return self::$oWpUsers;
		}

		/**
		 * @return ICWP_Maid_WpComments
		 */
		static public function loadWpCommentsProcessor() {
			if ( !isset( self::$oWpComments ) ) {
				require_once( dirname(__FILE__).ICWP_DS.'wp-comments.php' );
				self::$oWpComments = ICWP_Maid_WpComments::GetInstance();
			}
			return self::$oWpComments;
		}

		/**
		 * @return ICWP_Stats_WPSF
		 */
		public function loadStatsProcessor() {
			require_once( dirname(__FILE__).ICWP_DS.'icwp-stats.php' );
		}
	}

endif;