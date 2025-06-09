<?php

/**
 * Contains all of the TeleHealth global settings and configuration
 *
 * @package openemr
 * @link      http://www.open-emr.org
 * @author    Kofi Appiah <kkappiah@medsov.com>
 * @copyright Copyright (c) 2022 Visual EHR <https://visualehr.com/>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Modules\InpatientModule;

use OpenEMR\Common\Crypto\CryptoGen;
use OpenEMR\Services\Globals\GlobalSetting;

class InpatientGlobalConfig
{
    const CONFIG_ENABLE_MENU = "inpatient_enable_menu_item";

    /**
     * @var CryptoGen
     */
    private $cryptoGen;

    public function __construct()
    {
        $this->cryptoGen = new CryptoGen();
    }

    /**
     * Returns true if all of the inpatient modules settings have been configured.  Otherwise it returns false.
     * @return bool
     */
    public function isTelehealthConfigured()
    {
        $config = $this->getGlobalSettingSectionConfiguration();
        $keys = array_keys($config);
        foreach ($keys as $key) {
            if ($key == $this->isOptionalSetting($key)) {
                continue;
            }
            $value = $this->getGlobalSetting($key);

            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    public function shouldAutoProvisionProviders(): bool
    {
        $setting = $this->getGlobalSetting(self::CONFIG_ENABLE_MENU);
        return $setting !== "";
    }

    public function getGlobalSetting($settingKey)
    {
        global $GLOBALS;
        return $GLOBALS[$settingKey] ?? null;
    }

    public function getGlobalSettingSectionConfiguration()
    {
        $settings = [
            self::CONFIG_ENABLE_MENU => [
                'title' => 'Enable Inpatient Menu'
                ,'description' => 'Disable this and the Inpatient Menu Item will be hidden in the menu'
                ,'type' => GlobalSetting::DATA_TYPE_BOOL
                ,'default' => '1'
            ]
        ];
        return $settings;
    }

    private function isOptionalSetting($key)
    {
        return $key == self::CONFIG_ENABLE_MENU;
    }
}
