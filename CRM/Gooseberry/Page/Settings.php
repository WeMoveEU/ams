<?php
use CRM_Gooseberry_ExtensionUtil as E;

class CRM_Gooseberry_Page_Settings extends CRM_Core_Page {

  public function run() {
    $backendAlternate1 = CRM_Gooseberry_Settings::backendAlternate1();
    $backendAlternate2 = CRM_Gooseberry_Settings::backendAlternate2();
    $reGroupName1 = CRM_Gooseberry_Settings::reGroupName1();
    $reGroupName2 = CRM_Gooseberry_Settings::reGroupName2('');

    $reTab1 = explode("||", $reGroupName1);
    $reTab2 = explode("||", $reGroupName2);

    $this->assign('backendAlternate1', $backendAlternate1);
    $this->assign('backendAlternate2', $backendAlternate2);
    $this->assign('reTab1', $reTab1);
    $this->assign('reTab2', $reTab2);

    parent::run();
  }

}
