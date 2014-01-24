<script type="text/javascript" src="<?php print_unescaped(OC_Helper::linkTo('calendar/js', 'l10n.php'));?>"></script>

<div id="notification" style="display:none;"></div>
<?php
  /* 
   * if the calendar is link-shared -- display the info
   * the existence of #linksharedinfo is also used in calendar.js to determine if the calendar is link-shared
   */
  if (isset($_['link_shared_calendar_name'])) {
?>
<div id="linksharedinfo">User <?php p($_['link_shared_calendar_owner'])?> shared &quot;<?php p($_['link_shared_calendar_name'])?>&quot; calendar with you; explore below or download using this link:<br/><a href="<?php p($_['link_shared_calendar_url'])?>&amp;download"><?php p($_['link_shared_calendar_url'])?>&amp;download</a></div>
<?php } ?>
<div id="controls">
	<form id="view">
		<input type="button" value="<?php p($l->t('Day'));?>" id="onedayview_radio"/>
		<input type="button" value="<?php p($l->t('Week'));?>" id="oneweekview_radio"/>
		<input type="button" value="<?php p($l->t('Month'));?>" id="onemonthview_radio"/>&nbsp;&nbsp;
		<img id="loading" src="<?php print_unescaped(OCP\Util::imagePath('calendar', 'loading.gif')); ?>" />
	</form>
	<?php
	// this is not needed when we're in a publicly link-shared calendar display
	if (!array_key_exists('link_shared_calendar_name', $_)) { ?><form id="choosecalendar">
		<!--<input type="button" id="today_input" value="<?php p($l->t("Today"));?>"/>-->
		<button class="settings generalsettings" title="<?php p($l->t('Settings')); ?>"><img class="svg" src="<?php print_unescaped(OCP\Util::imagePath('core', 'actions/settings.svg')); ?>" alt="<?php p($l->t('Settings')); ?>" /></button>
	</form><?php } ?>
	<form id="datecontrol">
		<input type="button" value="&nbsp;&lt;&nbsp;" id="datecontrol_left"/>
		<input type="button" value="" id="datecontrol_date"/>
		<input type="button" value="<?php p($l->t('Today'));?>" id="datecontrol_today"/>
		<input type="button" value="&nbsp;&gt;&nbsp;" id="datecontrol_right"/>
	</form>
</div>
<div id="fullcalendar"></div>
<div id="dialog_holder"></div>
<div id="appsettings" class="popup topright hidden"></div>
<input type="hidden" name="allowShareWithLink" id="allowShareWithLink" value="<?php p($_['allowShareWithLink']) ?>" />