# Alternate Mailing Server

Extension provides handling alternate mailing servers in CiviCRM for transactional emails (not CiviMail!).

Assumptions:

* each alternate server has own setting `mailing_backend_alternate[1-9]`,
    * first at `mailing_backend_alternate1`,
    * second at `mailing_backend_alternate2`,
* in session variable `ams` is stored which server will be used,
* server is changed by `hook_civicrm_alterMailer()`.

## How it works

The extension rewrites `$mailer` object in `hook_civicrm_alterMailParams()`. Remember that CiviMail doesn't use this hook, so it's **not** possible to change setting for CiviMail by this extension. Instead of this use default setting `mailing_backend` provided by page Outbound Mail.

## How to switch on

There are three ways for switch on:

* set up params:
```php
$params['ams'] = 1; // during preparing params for method CRM_Utils_Mail::send()
```
* set up directly session variable:
```php
$session = CRM_Core_Session::singleton();
$session->set('ams', 1, 'ams');
```
* set up `groupName` in settings `reGroupName*`. Use sql query to update, for example:
```sql
UPDATE civicrm_setting
SET value = 's:120:"/Scheduled Reminder Sender/
/Activity Email Sender/
/Scheduled Reminder Sender/
/Report Email Sender/
/Mailing Event .*/";'
WHERE name = 'reGroupName1';

UPDATE civicrm_setting
SET value = 's:0:"";'
WHERE name = 'reGroupName2';
```

Emails from `reGroupName1` uses `mailing_backend_alternate1`.

How to set up first alternate server as a current Outbound Mail:

```sql
UPDATE civicrm_setting
SET value = (SELECT value FROM civicrm_setting WHERE name = 'mailing_backend')
WHERE name = 'mailing_backend_alternate1';
```

## Meaning of value

Thanks to value of session variable `ams` extension decides which alternate server will be used.

* `0` - use default mailing server (this depends on `mailing_backend`),
* `1` - use first alternate mailing server,
* `2` - use second alternate mailing server.
