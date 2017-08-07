<?php
/**
 * @copyright Copyright (c) 2017, Afterlogic Corp.
 * @license AGPL-3.0 or AfterLogic Software License
 *
 * This code is licensed under AGPLv3 license or AfterLogic Software License
 * if commercial version of the product was purchased.
 * For full statements of the licenses see LICENSE-AFTERLOGIC and LICENSE-AGPL3 files.
 */

namespace Aurora\Modules\ExternalClientsLoginFormWebclient;

/**
 * @package Modules
 */
class Module extends \Aurora\System\Module\AbstractWebclientModule
{
	/***** private functions *****/
	/**
	 * Initializes OAuthIntegratorMobileWebclient Module.
	 * 
	 * @ignore
	 */
	public function init() 
	{
		parent::init();
		
		$this->AddEntries(array(
				'external-clients-login-form' => 'EntryExternalClientsLoginForm',
			)
		);
	}
	/***** private functions *****/
	
	/***** public functions *****/
	/**
	 * @ignore
	 * @return string
	 */
	public function EntryExternalClientsLoginForm()
	{
		$sResult = \file_get_contents($this->GetPath().'/templates/ExternalClientsLoginForm.html');
		$oOAuthModuleDecorator = \Aurora\Modules\OAuthIntegratorWebclient\Module::Decorator();
		$aServices = $oOAuthModuleDecorator->GetServices();
		$sResult = strtr($sResult, array(
			'{{OAUTHINTEGRATORWEBCLIENT/LABEL_ES_SETTINGS_TAB}}' => $oOAuthModuleDecorator->i18N('LABEL_ES_SETTINGS_TAB'),
			'{{OAUTHINTEGRATORWEBCLIENT/LABEL_SIGN_IN}}' => $oOAuthModuleDecorator->i18N('LABEL_SIGN_IN'),
			'{{ServicesArray}}' => json_encode($aServices),
		));
			
		return $sResult;
	}
	/***** public functions *****/
}
