<?php

if ( !class_exists( 'ICWP_Maid_FeatureHandler_Plugin', false ) ):

	require_once( dirname( __FILE__ ) . ICWP_DS . 'base_maid.php' );

	class ICWP_Maid_FeatureHandler_Plugin extends ICWP_Maid_FeatureHandler_BaseWpsf {

		protected function doPostConstruction() {
			add_action( 'deactivate_plugin', array( $this, 'onWpHookDeactivatePlugin' ), 1, 1 );
			add_filter( $this->doPluginPrefix( 'report_email_address' ), array( $this, 'getPluginReportEmail' ) );
			add_filter( $this->doPluginPrefix( 'globally_disabled' ), array( $this, 'filter_IsPluginGloballyDisabled' ) );
		}

		/**
		 * @param boolean $bGloballyDisabled
		 * @return boolean
		 */
		public function filter_IsPluginGloballyDisabled( $bGloballyDisabled ) {
			return $bGloballyDisabled || !$this->getOptIs( 'global_enable_plugin_features', 'Y' );
		}

		public function doExtraSubmitProcessing() {
			$this->loadAdminNoticesProcessor()->addFlashMessage( sprintf( _wpmaid__( '%s Plugin options updated successfully.' ), $this->getController()->getHumanName() ) );
		}

		/**
		 * @return array
		 */
		public function getActivePluginFeatures() {
			$aActiveFeatures = $this->getOptionsVo()->getRawData_SingleOption( 'active_plugin_features' );
			$aPluginFeatures = array();
			if ( empty( $aActiveFeatures['value'] ) || !is_array( $aActiveFeatures['value'] ) ) {
				return $aPluginFeatures;
			}

			foreach( $aActiveFeatures['value'] as $nPosition => $aFeature ) {
				if ( isset( $aFeature['hidden'] ) && $aFeature['hidden'] ) {
					continue;
				}
				$aPluginFeatures[ $aFeature['slug'] ] = $aFeature;
			}
			return $aPluginFeatures;
		}

		/**
		 * @return mixed
		 */
		public function getIsMainFeatureEnabled() {
			return true;
		}

		/**
		 * Hooked to 'deactivate_plugin' and can be used to interrupt the deactivation of this plugin.
		 *
		 * @param string $sPlugin
		 */
		public function onWpHookDeactivatePlugin( $sPlugin ) {
			if ( strpos( $this->getController()->getRootFile(), $sPlugin ) !== false ) {
				if ( !apply_filters( $this->doPluginPrefix( 'has_permission_to_submit' ), true ) ) {
					$this->loadWpFunctionsProcessor()->wpDie(
						_wpmaid__( 'Sorry, you do not have permission to disable this plugin.')
						. _wpmaid__( 'You need to authenticate first.' )
					);
				}
			}
		}

		/**
		 * @param $sEmail
		 * @return string
		 */
		public function getPluginReportEmail( $sEmail ) {
			$sReportEmail = $this->getOpt( 'block_send_email_address' );
			if ( !empty( $sReportEmail ) && is_email( $sReportEmail ) ) {
				$sEmail = $sReportEmail;
			}
			return $sEmail;
		}

		/**
		 * @param array $aOptionsParams
		 * @return array
		 * @throws Exception
		 */
		protected function loadStrings_SectionTitles( $aOptionsParams ) {

			$sSectionSlug = $aOptionsParams['section_slug'];
			switch( $aOptionsParams['section_slug'] ) {

				case 'section_global_security_options' :
					$sTitle = _wpmaid__( 'Global Plugin Security Options' );
					$sTitleShort = _wpmaid__( 'Global Options' );
					break;

				case 'section_general_plugin_options' :
					$sTitle = _wpmaid__( 'General Plugin Options' );
					$sTitleShort = _wpmaid__( 'General Options' );
					break;

				case 'section_third_party' :
					$sTitle = _wpmaid__( 'Third Party Services' );
					$sTitleShort = _wpmaid__( 'Third Party Services' );
					break;

				default:
					throw new Exception( sprintf( 'A section slug was defined but with no associated strings. Slug: "%s".', $sSectionSlug ) );
			}
			$aOptionsParams['section_title'] = $sTitle;
			$aOptionsParams['section_summary'] = ( isset( $aSummary ) && is_array( $aSummary ) ) ? $aSummary : array();
			$aOptionsParams['section_title_short'] = $sTitleShort;
			return $aOptionsParams;
		}

		/**
		 * @param array $aOptionsParams
		 * @return array
		 * @throws Exception
		 */
		protected function loadStrings_Options( $aOptionsParams ) {

			$sKey = $aOptionsParams['key'];
			switch( $sKey ) {

				case 'global_enable_plugin_features' :
					$sName = _wpmaid__( 'Enable Features' );
					$sSummary = _wpmaid__( 'Global Plugin On/Off Switch' );
					$sDescription = sprintf( _wpmaid__( 'Uncheck this option to disable all %s features.' ), $this->getController()->getHumanName() );
					break;

				case 'enable_upgrade_admin_notice' :
					$sName = _wpmaid__( 'In-Plugin Notices' );
					$sSummary = _wpmaid__( 'Display Plugin Specific Notices' );
					$sDescription = _wpmaid__( 'Disable this option to hide certain plugin admin notices about available updates and post-update notices.' );
					break;

				case 'unique_installation_id' :
					$sName = _wpmaid__( 'Installation ID' );
					$sSummary = _wpmaid__( 'Unique Plugin Installation ID' );
					$sDescription = _wpmaid__( 'Keep this ID private.' );
					break;

				case 'delete_on_deactivate' :
					$sName = _wpmaid__( 'Delete Plugin Settings' );
					$sSummary = _wpmaid__( 'Delete All Plugin Settings Upon Plugin Deactivation' );
					$sDescription = _wpmaid__( 'Careful: Removes all plugin options when you deactivate the plugin' );
					break;

				default:
					throw new Exception( sprintf( 'An option has been defined but without strings assigned to it. Option key: "%s".', $sKey ) );
			}

			$aOptionsParams['name'] = $sName;
			$aOptionsParams['summary'] = $sSummary;
			$aOptionsParams['description'] = $sDescription;
			return $aOptionsParams;
		}

		/**
		 * This is the point where you would want to do any options verification
		 */
		protected function doPrePluginOptionsSave() {

			$nInstalledAt = $this->getPluginInstallationTime();
			if ( empty( $nInstalledAt ) || $nInstalledAt <= 0 ) {
				$this->setOpt( 'installation_time', $this->loadDataProcessor()->time() );
			}

			$sUniqueId = $this->getPluginInstallationId();
			if ( empty( $sUniqueId ) || !is_string( $sUniqueId ) || strlen( $sUniqueId ) != 32 ) {
				$this->setPluginInstallationId();
			}
		}

		/**
		 * @return string
		 */
		public function getPluginInstallationId() {
			return $this->getOpt( 'unique_installation_id', '' );
		}

		/**
		 * @param string $sNewId - leave empty to reset
		 * @return bool
		 */
		public function setPluginInstallationId( $sNewId = null ) {
			if ( empty( $sNewId ) ) {
				$sNewId = md5( $this->getOpt( 'installation_time' ) . $this->loadWpFunctionsProcessor()->getHomeUrl() . rand( 0, 1000 ) );
			}
			return $this->setOpt( 'unique_installation_id', $sNewId );
		}
	}

endif;