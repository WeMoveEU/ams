<?php

class CRM_Gooseberry_Settings {

  /**
   * Mailing Backend configuration - default for CiviMail
   *
   * @return mixed
   */
  public static function mailingBackend() {
    return Civi::settings()->get(self::mailingBackendKey());
  }

  /**
   * Mailing Backend Alternate 1 (first) configuration
   *
   * @param string $value config array in JSON format
   *
   * @return mixed
   */
  public static function backendAlternate1($value = '') {
    if ($value) {
      Civi::settings()->set(self::backendAlternate1Key(), $value);
      return $value;
    }
    $value = Civi::settings()->get(self::backendAlternate1Key());

    return $value;
  }

  /**
   * Mailing Backend Alternate 2 (second) configuration
   *
   * @param string $value config array in JSON format
   *
   * @return mixed
   */
  public static function backendAlternate2($value = '') {
    if ($value) {
      Civi::settings()->set(self::backendAlternate2Key(), $value);
      return $value;
    }
    $value = Civi::settings()->get(self::backendAlternate2Key());

    return $value;
  }

  /**
   * Regular expressions for First Mailing Backend Alternate
   *
   * @param string $value
   *
   * @return mixed|string
   */
  public static function reGroupName1($value = '') {
    if ($value) {
      Civi::settings()->set(self::reGroupName1Key(), $value);
      return $value;
    }
    $value = Civi::settings()->get(self::reGroupName1Key());

    return $value;
  }

  /**
   * Regular expressions for Second Mailing Backend Alternate
   *
   * @param string $value
   *
   * @return mixed|string
   */
  public static function reGroupName2($value = '') {
    if ($value) {
      Civi::settings()->set(self::reGroupName2Key(), $value);
      return $value;
    }
    $value = Civi::settings()->get(self::reGroupName2Key());

    return $value;
  }

  private static function mailingBackendKey() {
    return 'mailing_backend';
  }

  private static function backendAlternate1Key() {
    return 'mailing_backend_alternate1';
  }

  private static function backendAlternate2Key() {
    return 'mailing_backend_alternate2';
  }

  private static function reGroupName1Key() {
    return 'reGroupName1';
  }

  private static function reGroupName2Key() {
    return 'reGroupName2';
  }

}
