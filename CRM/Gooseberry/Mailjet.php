<?php

class CRM_Gooseberry_Mailjet {

  /**
   * Check if email is testing
   *
   * @param array $params Definition of email
   *
   * @return bool
   */
  public static function isTest($params) {
    if (
      array_key_exists('headers', $params) &&
      array_key_exists('X-Mailjet-Prio', $params['headers'])
    ) {
      if ($params['headers']['X-Mailjet-Prio'] == 3) {
        return TRUE;
      };
    }

    return FALSE;
  }

}
