<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

	/**
	 * Facebook
	 */
        'Facebook' => array(
            'client_id'     => '227434434072987',
            'client_secret' => 'eedd99c36b86cc904b5152a4ee8cd0d5',
            'scope'         => array('email'),
        ),

        /**
	 * Twitter
	 */
        'Twitter' => array(
            'client_id'     => 'qIoEyyHNO0rcUUtCPygmIQ',
            'client_secret' => 'Dy53ALzIcBW3l4jo3iZw982gLXAaU90oH1RgBMp2c',
        ),		

	)

);