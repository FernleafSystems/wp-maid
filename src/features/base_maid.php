<?php

if ( !class_exists( 'ICWP_Maid_FeatureHandler_BaseWpsf', false ) ):

	require_once( dirname(__FILE__).ICWP_DS.'base.php' );

	class ICWP_Maid_FeatureHandler_BaseWpsf extends ICWP_Maid_FeatureHandler_Base {

		/**
		 * Overriden in the plugin handler getting the option value
		 * @return string
		 */
		public function getGoogleRecaptchaSecretKey() {
			return apply_filters( $this->doPluginPrefix( 'google_recaptcha_secret_key' ), '' );
		}

		/**
		 * Overriden in the plugin handler getting the option value
		 * @return string
		 */
		public function getGoogleRecaptchaSiteKey() {
			return apply_filters( $this->doPluginPrefix( 'google_recaptcha_site_key' ), '' );
		}

		/**
		 * @return bool
		 */
		public function getIsGoogleRecaptchaReady() {
			$sKey = $this->getGoogleRecaptchaSiteKey();
			$sSecret = $this->getGoogleRecaptchaSecretKey();
			return ( !empty( $sSecret ) && !empty( $sKey ) && $this->loadDataProcessor()->getPhpSupportsNamespaces() );
		}

		/**
		 * @return array
		 */
		protected function getBaseDisplayData() {
			$aData = parent::getBaseDisplayData();
			$aData['strings'] = array_merge(
				$aData['strings'],
				array(
					'go_to_settings' => _wpmaid__( 'Settings' ),
					'on' => _wpmaid__( 'On' ),
					'off' => _wpmaid__( 'Off' ),
					'more_info' => _wpmaid__( 'More Info' ),
					'blog' => _wpmaid__( 'Blog' ),
					'plugin_activated_features_summary' => _wpmaid__( 'Plugin Activated Features Summary:' ),
					'save_all_settings' => _wpmaid__( 'Save All Settings' ),

					'aar_what_should_you_enter' => _wpmaid__( 'What should you enter here?' ),
					'aar_must_supply_key_first' => _wpmaid__( 'At some point you entered a Security Admin Access Key - to manage this plugin, you must supply it here first.' ),
					'aar_to_manage_must_enter_key' => _wpmaid__( 'To manage this plugin you must enter the access key.' ),
					'aar_enter_access_key' => _wpmaid__( 'Enter Access Key' ),
					'aar_submit_access_key' => _wpmaid__( 'Submit Access Key' )
				)
			);
			$aData[ 'bShowStateSummary' ] = true;
			return $aData;
		}

		protected function getTranslatedString( $sKey, $sDefault ) {
			$aStrings = array(
				'nonce_failed_empty' => _wpmaid__( 'Nonce security checking failed - the nonce value was empty.' ),
				'nonce_failed_supplied' => _wpmaid__( 'Nonce security checking failed - the nonce supplied was "%s".' ),
			);
			return ( isset( $aStrings[ $sKey ] ) ? $aStrings[ $sKey ] : $sDefault );
		}
	}
endif;