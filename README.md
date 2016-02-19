# Alternate Mailing Server

Extension provides handling alternate mailing servers in CiviCRM.

Assumptions:

* each alternate server has own setting `mailing_backend_alternate[1-9]`,
    * first at `mailing_backend_alternate1`,
    * second at `mailing_backend_alternate2`,
* in session variable is stored which server will be used,
* server is changed by `hook_civicrm_alterMailer()`.

## How to switch on

There are two ways for switch on:

* set up params for hook_civicrm_alterMailParams():
```php
$params['ams'] = 1; // during preparing params
```
* set up directly session variable:
```php
$session = CRM_Core_Session::singleton();
$session->set('ams', 1, 'ams');
```

## Meaning of value

Thanks to value of session variable `ams` extension decides which alternate server will be used.

* `0` - use default mailing server,
* `1` - use first alternate mailing server,
* `2` - use second alternate mailing server.
