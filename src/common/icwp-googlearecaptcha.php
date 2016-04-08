<?php
if ( !class_exists( 'ICWP_Maid_GoogleRecaptcha', false ) ):

	class ICWP_Maid_GoogleRecaptcha {

		/**
		 * @var ICWP_Maid_GoogleRecaptcha
		 */
		protected static $oInstance = NULL;

		/**
		 * @var \ReCaptcha\ReCaptcha
		 */
		protected static $oGR;

		/**
		 * @return ICWP_Maid_GoogleRecaptcha
		 */
		public static function GetInstance() {
			if ( is_null( self::$oInstance ) ) {
				self::$oInstance = new self();
			}
			return self::$oInstance;
		}

		/**
		 */
		protected function loadGoogleRecaptchaLib() {
			return require_once( dirname(__FILE__).ICWP_DS.'googlerecaptcha/autoload.php' );
		}

		/**
		 * @param string $sSecret
		 * @return \ReCaptcha\ReCaptcha
		 */
		public function getGoogleRecaptchaLib( $sSecret ) {
			if ( !isset( self::$oGR ) ) {
				if ( $this->loadGoogleRecaptchaLib() ) {
					self::$oGR = new \ReCaptcha\ReCaptcha( $sSecret );
				}
			}
			return self::$oGR;
		}
	}
endif;