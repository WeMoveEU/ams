# Gooseberry - Alternative Mailer for CiviCRM

Extension provides handling mailer objects in CiviCRM for transactional emails (not CiviMail!).

There is no user interface, yet.

Assumptions:

* each alternative mailer has own setting `mailing_backend_alternate[1-2]`,
    * first at `mailing_backend_alternate1`,
    * second at `mailing_backend_alternate2`,
* in session variable `gooseberry` is stored which mailer will be used,
* mailer is changed by `hook_civicrm_alterMailer()`.

## How it works

The extension rewrites `$mailer` object in `hook_civicrm_alterMailParams()`. Remember that CiviMail doesn't use this hook, so it's **not** possible to change setting for CiviMail by this extension. Instead of this CiviMail uses default setting `mailing_backend` provided by page Outbound Mail.

This works only when Outbound Mail is set to any STMP server.

## How to add alternative mailer

* set your alternative SMTP at "Outbound Mail" page
* run sql query

```sql
INSERT INTO civicrm_setting (name, value, domain_id, contact_id, is_domain, component_id, created_date, created_id)
  SELECT 'mailing_backend_alternate1', value, domain_id, contact_id, is_domain, component_id, created_date, created_id
  FROM civicrm_setting WHERE name = 'mailing_backend';
```

* set your default SMTP at "Outbound Mail" page

## How to switch on

There are three ways for switch on:

* set up params:
```php
$params['gooseberry'] = 1; // during preparing params for method CRM_Utils_Mail::send()
```
* set up `groupName` in settings `reGroupName*` as a list of regular expressions. Use sql query to insert or update, for example:
```sql
INSERT INTO civicrm_setting (name, value, domain_id, contact_id, is_domain, component_id, created_date, created_id)
SELECT 'reGroupName1', 's:52:"/Scheduled Reminder Sender/||/Activity Email Sender/";', domain_id, contact_id, is_domain, component_id, created_date, created_id
FROM civicrm_setting WHERE name = 'mailing_backend';

UPDATE civicrm_setting
SET value = 's:95:"/Scheduled Reminder Sender/||/Activity Email Sender/||/Report Email Sender/||/Mailing Event .*/";'
WHERE name = 'reGroupName1';

UPDATE civicrm_setting
SET value = 's:0:"";'
WHERE name = 'reGroupName1';
```

Emails from `reGroupName1` uses `mailing_backend_alternate1` configuration.

### List of groupNames

* /Scheduled Reminder Sender/
* /Mailing Event .*/
* /Activity Email Sender/
* /Report Email Sender/
* /SpeakCivi Email Sender/ - confirmation emails in SpeakCivi extension
* /SEPA Email Sender/ - emails in SEPA extension

## Meaning of session variable

Thanks to value of session variable `gooseberry` extension decides which alternative mailer will be used.

* `0` - use default SMTP server (this depends on `mailing_backend`),
* `1` - use first alternative SMTP server,
* `2` - use second alternative SMTP server.
