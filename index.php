<?php
    include './locales/i18n_setup.php';
    $name = "Sébastien";
    $unread = 2;
?>
<div id="header">
  <h1><?=sprintf(gettext('Welcome, %s!'), $name)?></h1>
  <!-- code indented this way only for legibility -->
  <?php if ($unread): ?>
    <h2>
      <?=sprintf(
          ngettext('Only one unread message', '%d unread messages', $unread),
          $unread
      )?>
    </h2>
  <?php endif ?>
</div>

<h1><?=gettext('Introduction')?></h1>
<p><?=gettext('We\'re now translating some strings')?></p>