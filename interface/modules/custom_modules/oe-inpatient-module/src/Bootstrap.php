<?php

/**
 * This bootstrap file connects the module to the OpenEMR system hooking to the API, api scopes, and event notifications
 *
 * @package openemr
 * @link      http://www.open-emr.org
 * @author    Kofi Appiah <kkappiah@medsov.com>
 * @copyright Copyright (c) 2022 Omega Systems Group <https://omegasystemsgroup.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Modules\InpatientModule;

use OpenEMR\Common\Logging\SystemLogger;
use OpenEMR\Common\Twig\TwigContainer;
use OpenEMR\Common\Utils\CacheUtils;
use OpenEMR\Core\Kernel;
use OpenEMR\Events\Appointments\AppointmentSetEvent;
use OpenEMR\Events\Core\TwigEnvironmentEvent;
use OpenEMR\Events\Globals\GlobalsInitializedEvent;
use OpenEMR\Events\Main\Tabs\RenderEvent;
use OpenEMR\Services\Globals\GlobalSetting;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use OpenEMR\Common\Logging\System;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use OpenEMR\Menu\MenuEvent;

class Bootstrap
{
  const OPENEMR_GLOBALS_LOCATION = "../../../../globals.php";
  const MODULE_INSTALLATION_PATH = "/interface/modules/custom_modules/";
  const MODULE_NAME = "";
  const MODULE_MENU_NAME = "Inpatient";

  /**
   * @var EventDispatcherInterface The object responsible for sending and subscribing to events through the OpenEMR system
   */
  private $eventDispatcher;

  private $moduleDirectoryName;

  /**
   * @var SystemLogger
   */
  private $logger;

  /**
   * The OpenEMR Twig Environment
   * @var Environment
   */
  private $twig;

  /**
   * @var InpatientGlobalConfig
   */
  private $globalsConfig;

  public function __construct(EventDispatcher $dispatcher, ?Kernel $kernel = null)
  {
    global $GLOBALS;

    if (empty($kernel)) {
      $kernel = new Kernel();
    }
    $this->eventDispatcher = $dispatcher;

    $this->globalsConfig = new InpatientGlobalConfig($GLOBALS);
    $this->moduleDirectoryName = basename(dirname(__DIR__));
    $this->logger = new SystemLogger();
  }

  public function getTemplatePath()
  {
    return \dirname(__DIR__) . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR;
  }

  public function getURLPath()
  {
    return $GLOBALS['webroot'] . self::MODULE_INSTALLATION_PATH . $this->moduleDirectoryName . "/public/";
  }

  public function subscribeToEvents()
  {
    $this->addGlobalSettings();
    $this->registerMenuItems();
    // $this->createAdmitPatientFile();
  }

  public function getCurrentLoggedInUser()
  {
    return $_SESSION['authUserID'] ?? null;
  }

  public function addGlobalSettings()
  {
    $this->eventDispatcher->addListener(GlobalsInitializedEvent::EVENT_HANDLE, [$this, 'addGlobalInpatientSettings']);
  }

  public function addGlobalInpatientSettings(GlobalsInitializedEvent $event)
  {
    global $GLOBALS;

    $service = $event->getGlobalsService();
    $section = xlt("Inpatient Module");
    $service->createSection($section, 'Portal');

    $settings = $this->globalsConfig->getGlobalSettingSectionConfiguration();

    foreach ($settings as $key => $config) {
      $value = $GLOBALS[$key] ?? $config['default'];
      $service->appendToSection(
        $section,
        $key,
        new GlobalSetting(
          xlt($config['title']),
          $config['type'],
          $value,
          xlt($config['description']),
          true
        )
      );
    }
  }

  public function registerMenuItems()
  {
    $this->eventDispatcher->addListener(MenuEvent::MENU_UPDATE, [$this, 'addInpatientMenuItem']);

    //if ($this->globalsConfig->getGlobalSetting(VehrGlobalConfig::CONFIG_ENABLE_MENU)) {
    /**
     * @var EventDispatcherInterface $eventDispatcher
     * @var array $module
     * @global                       $eventDispatcher @see ModulesApplication::loadCustomModule
     * @global                       $module @see ModulesApplication::loadCustomModule
     */
    //    $this->eventDispatcher->addListener(MenuEvent::MENU_UPDATE, [$this, 'addCustomMenuItem']);
    //} 
  }

  public function addInpatientMenuItem(MenuEvent $event)
  {
    $menu = $event->getMenu();

    $menuJson = '{
            "label": "Inpatient",
            "menu_id": "inpmgd",
            "target": "inp",
            "children": [
              {
                "label": "Visitor Registry",
                "menu_id": "inpMdl",
                "target": "inpTa",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/visits.php",
                "children": [],
                "requirement": 0,
                "acl_req": ["patients", "appt"]
              },
              {
                "label": "Inpatient Finder",
                "menu_id": "inpMdl",
                "target": "inpTa",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/inpatient.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["encounters", "coding", "write"],
                  ["encounters", "coding_a", "write"]
                ]
              },
              {
                "label": "Admission Queue",
                "menu_id": "inpMdl",
                "target": "inpTa",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/index.php",
                "children": [],
                "requirement": 2,
                "acl_req": [
                  ["encounters", "coding", "write"],
                  ["encounters", "coding_a", "write"]
                ]
              },
              {
                "label": "Bed Managament",
                "menu_id": "inpMdl",
                "target": "inpTa",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/beds.php",
                "children": [],
                "requirement": 0,
                "acl_req": ["admin", "manage_modules"]
              },
              {
                "label": "Ward Managament",
                "menu_id": "inpMdl",
                "target": "inpTa",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/wards.php",
                "children": [],
                "requirement": 0,
                "acl_req": ["admin", "manage_modules"]
              },
              {
                "label": "Theater",
                "menu_id": "inpTh",
                "target": "inpTh",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/theater.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["encounters", "coding", "write"],
                  ["encounters", "coding_a", "write"]
                ]
              },
              {
                "label": "Surgical Procedure",
                "menu_id": "inpSgp",
                "target": "inpSgp",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/surgical_procedure.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["encounters", "coding", "write"],
                  ["encounters", "coding_a", "write"]
                ]
              },
              {
                "label": "Meal Management",
                "icon": "fa-caret-right",
                "children": [
                  {
                    "label": "Meal Requests",
                    "menu_id": "inp1_food",
                    "target": "inp1_food",
                    "url": "/interface/modules/custom_modules/oe-inpatient-module/public/food_requests.php",
                    "children": [],
                    "requirement": 0
                  },
                  {
                    "label": "Meal Menu",
                    "menu_id": "inp1_food",
                    "target": "inp1_food",
                    "url": "/interface/modules/custom_modules/oe-inpatient-module/public/food_menu.php",
                    "children": [],
                    "requirement": 0,
                    "acl_req": [
                      ["admin", "drugs"],
                      ["inventory", "reporting"]
                    ]
                  }
                ],
                "requirement": 0,
                "acl_req": ["admin", "manage_modules"]
              },
              {
                "label": "Surgery",
                "icon": "fa-caret-right",
                "children": [
                  {
                    "label": "Scheduled Surgeries",
                    "menu_id": "inp1_food",
                    "target": "inp1_food",
                    "url": "/interface/modules/custom_modules/oe-inpatient-module/public/surgery.php",
                    "children": [],
                    "requirement": 0
                  }
                ],
                "requirement": 0,
                "acl_req": ["admin", "manage_modules"]
              },
              {
                "label": "CSSD",
                "icon": "fa-caret-right",
                "children": [
                  {
                    "label": "CSSD Item",
                    "menu_id": "inp1_cssd",
                    "target": "inp1_cssd",
                    "url": "/interface/modules/custom_modules/oe-inpatient-module/public/CSSDServiceItem.php",
                    "children": [],
                    "requirement": 0
                  },
                  {
                    "label": "CSSD Service",
                    "menu_id": "inp1_cssd",
                    "target": "inp1_cssd",
                    "url": "/interface/modules/custom_modules/oe-inpatient-module/public/CSSDService.php",
                    "children": [],
                    "requirement": 0
                  },
                  {
                    "label": "CSSD Request",
                    "menu_id": "inp1_cssd",
                    "target": "inp1_cssd",
                    "url": "/interface/modules/custom_modules/oe-inpatient-module/public/CSSDServiceRequest.php",
                    "children": [],
                    "requirement": 0
                  }
                ],
                "requirement": 0,
                "acl_req": ["admin", "manage_modules"]
              }
            ],
            "requirement": 0,
            "acl_req": ["menus", "modle"]
          }';

    $menuObject = json_decode($menuJson);
    $menuItem = new \stdClass();
    $menuItem->requirement = $menuObject->requirement;
    $menuItem->target = $menuObject->target;
    $menuItem->menu_id = $menuObject->menu_id;
    $menuItem->label = xlt($menuObject->label);
    $menuItem->children = $menuObject->children ?? [];

    // menu items for rrport
    $repMenuJson = ' {
            "label": "Inpatient Report",
            "icon": "fa-caret-right",
            "children": [
              {
                "label": "Visitors Registry",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/visits.php",
                "children": [],
                "requirement": 0
              },
              {
                "label": "Inpatients",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/inpatients.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              },
              {
                "label": "Ward Transfer",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/ward_transfer.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              },
              {
                "label": "Discharged Patients",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/discharged_patients.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              },
              {
                "label": "Meal Requests",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/food_requests.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              },
              {
                "label": "Clinical Management Plan",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/treatment_plan.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              },
              {
                "label": "CSSD Service",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/CSSDService.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              },
              {
                "label": "CSSD Service Item",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/CSSDServiceItem.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              },
              {
                "label": "CSSD Service Request",
                "menu_id": "inp1_rep",
                "target": "inp1_rep",
                "url": "/interface/modules/custom_modules/oe-inpatient-module/public/reports/CSSDServiceRequest.php",
                "children": [],
                "requirement": 0,
                "acl_req": [
                  ["admin", "drugs"],
                  ["inventory", "reporting"]
                ]
              }
            ],
            "requirement": 0,
            "acl_req": ["admin", "manage_modules"]
          }';

    $repmenuObject = json_decode($repMenuJson);
    $repMenuItem = new \stdClass();
    $repMenuItem->requirement = $repmenuObject->requirement;
    $repMenuItem->icon = $repmenuObject->icon;
    $repMenuItem->label = xlt($repmenuObject->label);
    $repMenuItem->children = $repmenuObject->children ?? [];


    /**
     * This defines the Access Control List properties that are required to use this module.
     * Several examples are provided
     */
    $menuItem->acl_req = [];

    /**
     * If you would like to restrict this menu to only logged in users who have access to see all user data
     */
    //$menuItem->acl_req = ["admin", "users"];

    /**
     * If you would like to restrict this menu to logged in users who can access patient demographic information
     */
    //$menuItem->acl_req = ["users", "demo"];


    /**
     * This menu flag takes a boolean property defined in the $GLOBALS array that OpenEMR populates.
     * It allows a menu item to display if the property is true, and be hidden if the property is false
     */
    //$menuItem->global_req = ["custom_skeleton_module_enable"];

    /**
     * If you want your menu item to allows be shown then leave this property blank.
     */
    $menuItem->global_req = [];

    // set the menu item after the Module item
    $insertIndex = 9;
    array_splice($menu, $insertIndex, 0, [$menuItem]);

    // set the menu items for reports
    foreach ($menu as $item) {
      if ($item->menu_id == 'repimg') {
        $item->children[] = $repMenuItem;
        break;
      }
    }

    $event->setMenu($menu);

    return $event;
  }


  public function createAdmitPatientFile()
  {
    $content = '<?php
require_once("../../globals.php");

header(\'Content-Type: application/json\');

$aResult = array();

if (!isset($_POST[\'functionname\'])) {
    $aResult[\'error\'] = \'No function name!\';
}

if (!isset($aResult[\'error\'])) {

    if (isset($_POST[\'functionname\'])) {

        $aResult[\'result\'] = addmission_queue_add();
    }
}

function addmission_queue_add()
{

    $sets = "patient_id = ?,
        encounter_id = ?, 
        ward_id = ?,
        bed_id = ?,
        opd_case_doctor_id = ?,
        assigned_nurse_id = ?,
        assigned_provider = ?,
        status = ?
    ";

    $bindArray = array(
        $_SESSION["pid"],
        $_SESSION["encounter"],
        0,
        0,
        $_SESSION["authUser"],
        $_SESSION["authUser"],
        $_SESSION["authUser"],
        "in-queue",
    );

    sqlInsert("INSERT INTO inp_patient_admission SET $sets", $bindArray);

    return 1;
}

echo json_encode($aResult);
';

    $file = $GLOBALS['webroot'] . '/interface/patient_file/encounter/admit_patient.php';


    if (file_exists($file)) {
      echo "File already exists, will be overwritten. \n";
    }

    file_put_contents($file, $content);

    // echo "File created at: $file \n";
    return true;
  }
}
