<?php

if ( !class_exists( 'ICWP_Maid_Processor_BaseMaid', false ) ):

	require_once( dirname(__FILE__).ICWP_DS.'base.php' );

	abstract class ICWP_Maid_Processor_BaseMaid extends ICWP_Maid_Processor_Base {

		/**
		 */
		public function init() { }
	}

endif;