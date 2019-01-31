<h3>SMTP servers</h3>

<table>
  <tr>
    <th>Key</th>
    <th>Default</th>
    <th>First</th>
    <th>Second</th>
  </tr>
  <tr class="odd-row">
    <td><strong>smtpServer</strong></td>
    <td>{$mailingBackend.smtpServer}</td>
    <td>{$backendAlternate1.smtpServer}</td>
    <td>{$backendAlternate2.smtpServer}</td>
  </tr>
  <tr class="even-row">
    <td><strong>smtpPort</strong></td>
    <td>{$mailingBackend.smtpPort}</td>
    <td>{$backendAlternate1.smtpPort}</td>
    <td>{$backendAlternate2.smtpPort}</td>
  </tr>
  <tr class="odd-row">
    <td><strong>smtpAuth</strong></td>
    <td>{$mailingBackend.smtpAuth}</td>
    <td>{$backendAlternate1.smtpAuth}</td>
    <td>{$backendAlternate2.smtpAuth}</td>
  </tr>
  <tr class="even-row">
    <td><strong>smtpUsername</strong></td>
    <td>{$mailingBackend.smtpUsername}</td>
    <td>{$backendAlternate1.smtpUsername}</td>
    <td>{$backendAlternate2.smtpUsername}</td>
  </tr>
  <tr class="odd-row">
    <td><strong>smtpPassword</strong></td>
    <td>******</td>
    <td>******</td>
    <td>******</td>
  </tr>
  <tr class="even-row">
    <td><strong>groupName</strong></td>
    <td>...</td>
    <td>
      {foreach from=$reTab1 item=foo}
        {$foo}<br/>
      {/foreach}
    </td>
    <td>
      {foreach from=$reTab2 item=foo}
        {$foo}<br/>
      {/foreach}
    </td>
  </tr>
</table>

<p><a href="https://github.com/WeMoveEU/eu.wemove.gooseberry/blob/master/README.md">Documentation is here</a></p>
