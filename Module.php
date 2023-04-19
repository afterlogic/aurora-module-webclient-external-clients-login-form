<?php
/**
 * This code is licensed under AGPLv3 license or Afterlogic Software License
 * if commercial version of the product was purchased.
 * For full statements of the licenses see LICENSE-AFTERLOGIC and LICENSE-AGPL3 files.
 */

namespace Aurora\Modules\ExternalClientsLoginFormWebclient;

/**
 * Provides login form for external clients.
 *
 * @license https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0
 * @license https://afterlogic.com/products/common-licensing Afterlogic Software License
 * @copyright Copyright (c) 2023, Afterlogic Corp.
 *
 * @property Settings $oModuleSettings
 *
 * @package Modules
 */
class Module extends \Aurora\System\Module\AbstractWebclientModule
{
    /**
     * @return Module
     */
    public static function Decorator()
    {
        return parent::Decorator();
    }

    /**
     *
     * @return Settings
     */
    public function getModuleSettings()
    {
        return $this->oModuleSettings;
    }

    /***** private functions *****/
    /**
     * Initializes OAuthIntegratorMobileWebclient Module.
     *
     * @ignore
     */
    public function init()
    {
        parent::init();

        $this->AddEntries(
            array(
                'external-clients-login-form' => 'EntryExternalClientsLoginForm',
            )
        );
    }

    private function getLanguageName($sLocale)
    {
        $aLocales = array(
            'ru-RU' => 'Russian',
            'en-GB' => 'English'
        );

        $mLanguage = false;

        if (isset($aLocales[(string)$sLocale])) {
            $mLanguage = $aLocales[(string)$sLocale];
        }

        return $mLanguage;
    }

    /***** private functions *****/

    /***** public functions *****/
    /**
     * @ignore
     * @return string
     */
    public function EntryExternalClientsLoginForm()
    {
        $sLocale = $this->oHttp->GetQuery('locale', 'en-GB');

        $sLanguage = $this->getLanguageName($sLocale);

        if ($sLanguage) {
            \Aurora\System\Api::SetLanguage($sLanguage);
        }

        $sResult = \file_get_contents($this->GetPath().'/templates/ExternalClientsLoginForm.html');
        $oOAuthModuleDecorator = \Aurora\Modules\OAuthIntegratorWebclient\Module::Decorator();
        $aServices = $oOAuthModuleDecorator->GetServices();

        $sResult = strtr($sResult, array(
            '{{OAUTHINTEGRATORWEBCLIENT/LABEL_ES_SETTINGS_TAB}}' => $oOAuthModuleDecorator->i18N('LABEL_ES_SETTINGS_TAB'),
            '{{OAUTHINTEGRATORWEBCLIENT/LABEL_SIGN_IN}}' => $oOAuthModuleDecorator->i18N('LABEL_SIGN_IN'),
            '{{OAUTHINTEGRATORWEBCLIENT/LABEL_SIGN_BUTTONS}}' => $oOAuthModuleDecorator->i18N('LABEL_SIGN_BUTTONS'),
            '{{EXTERNALCLIENTSLOGINFORMWEBCLIENT/FORM_INTRO}}' => $this->i18N('FORM_INTRO'),
            '{{ServicesArray}}' => json_encode($aServices),
        ));

        return $sResult;
    }
    /***** public functions *****/

    /***** public functions might be called with web API *****/
    public function IsAvailable()
    {
        $oOAuthModuleDecorator = \Aurora\Modules\OAuthIntegratorWebclient\Module::Decorator();
        $aServices = $oOAuthModuleDecorator->GetServices();

        return (bool)$aServices;
    }
    /***** /public functions might be called with web API *****/
}
