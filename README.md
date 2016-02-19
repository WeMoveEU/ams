# Alternate Mailing Server

Extension provides handling alternate mailing servers in CiviCRM.

## How to switch on

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
