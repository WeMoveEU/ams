<?php

require_once 'gooseberry.civix.php';
use CRM_Gooseberry_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function gooseberry_civicrm_config(&$config) {
  _gooseberry_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function gooseberry_civicrm_xmlMenu(&$files) {
  _gooseberry_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function gooseberry_civicrm_install() {
  _gooseberry_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function gooseberry_civicrm_uninstall() {
  _gooseberry_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function gooseberry_civicrm_enable() {
  _gooseberry_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function gooseberry_civicrm_disable() {
  _gooseberry_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function gooseberry_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _gooseberry_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function gooseberry_civicrm_managed(&$entities) {
  _gooseberry_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function gooseberry_civicrm_caseTypes(&$caseTypes) {
  _gooseberry_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function gooseberry_civicrm_angularModules(&$angularModules) {
  _gooseberry_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function gooseberry_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _gooseberry_civix_civicrm_alterSettingsFolders($metaDataFolders);
}


/**
 * Implements hook_civicrm_alterMailParams().
 */
function gooseberry_civicrm_alterMailParams(&$params, $context) {
  if ($context == 'singleEmail') {
    if (array_key_exists('gooseberry', $params) && $params['gooseberry']) {
      $session = CRM_Core_Session::singleton();
      $session->set('gooseberry', $params['gooseberry'], E::LONG_NAME);
    }
    elseif (array_key_exists('groupName', $params)) {
      foreach (range(1, 2, 1) as $key) {
        $setting = CRM_Core_BAO_Setting::getItem(CRM_Core_BAO_Setting::MAILING_PREFERENCES_NAME, 'reGroupName' . $key);
        if ($setting) {
          $reTab = explode("||", $setting);
          if (is_array($reTab) && count($reTab) > 0) {
            foreach ($reTab as $re) {
              if (preg_match(trim($re), $params['groupName'])) {
                $session = CRM_Core_Session::singleton();
                $session->set('gooseberry', $key, E::LONG_NAME);
                CRM_Utils_Mail::createMailer();
                break;
              }
            }
          }
        }
      }
    }
  }
}


/**
 * Implements hook_civicrm_alterMailer().
 */
function gooseberry_civicrm_alterMailer(&$mailer, $driver, $params) {
  $session = CRM_Core_Session::singleton();
  $gooseberry = $session->get('gooseberry', E::LONG_NAME);
  if ($gooseberry) {
    $name = 'mailing_backend_alternate' . (int) $gooseberry;
    $setting = CRM_Core_BAO_Setting::getItem(CRM_Core_BAO_Setting::MAILING_PREFERENCES_NAME, $name);
    if ($setting['outBound_option'] == CRM_Mailing_Config::OUTBOUND_OPTION_SMTP) {
      $params['host'] = $setting['smtpServer'] ? $setting['smtpServer'] : 'localhost';
      $params['port'] = $setting['smtpPort'] ? $setting['smtpPort'] : 25;
      $mailer->host = $params['host'];
      $mailer->port = $params['port'];
      if ($setting['smtpAuth']) {
        $params['username'] = $setting['smtpUsername'];
        $params['password'] = CRM_Utils_Crypt::decrypt($setting['smtpPassword']);
        $params['auth'] = TRUE;
        $mailer->username = $params['username'];
        $mailer->password = $params['password'];
      }
      else {
        $params['auth'] = FALSE;
      }
      $mailer->auth = $params['auth'];
    }
  }
}


/**
 * Implements hook_civicrm_postEmailSend().
 */
function gooseberry_civicrm_postEmailSend(&$params) {
  $session = CRM_Core_Session::singleton();
  $gooseberry = $session->get('gooseberry', E::LONG_NAME);
  if ($gooseberry) {
    $session->set('gooseberry', NULL, E::LONG_NAME);
    CRM_Utils_Mail::createMailer();
  }
}
