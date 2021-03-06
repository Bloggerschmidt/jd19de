<?php
/**
 * conferenceplus
 * @author Robert Deutz <rdeutz@googlemail.com>
 * @package conferenceplus
 **/

// No direct access
defined('_JEXEC') or die;

$displayData = new StdClass;

$headerlevel    = $this->params->get('headerlevel', 1);
$shl1 			= $headerlevel + 1;
$shl11 			= $headerlevel + 2;
$shl111			= $headerlevel + 3;
$items          = $this->items;

$baseLayoutPath = JPATH_ROOT . '/media/conferenceplus/layouts';
$title = JLayoutHelper::render('html.title', $displayData, $baseLayoutPath);

$base = JUri::base(true);

$doc = JFactory::getDocument()->setTitle($title);

$Itemid = Conferenceplus\Route\Helper::getItemid('speakers');

$uri       = JUri::getInstance();
$returnurl = base64_encode($uri->toString(['path', 'query', 'fragment']));

$script ='

	$(document).ready(function() {
	});
';
//$doc->addScriptDeclaration($script);
$itemcount = count($items);
$odd = $itemcount % 2 != 0;
?>

<!-- ************************** START: conferenceplus ************************** -->
<div class="conferenceplus speakerslist item-page">

	<div class="page-header">
		<h<?php echo $headerlevel; ?>><?php echo $title; ?></h<?php echo $headerlevel; ?>>
	</div>

	<div class="listitems">
	<?php if ($itemcount > 0)	: ?>
		<?php for ($i = 0;$i < $itemcount; $i++) : ?>
		<?php $item = $items[$i]; ?>

		<div class="col-xs-6 speakersblock">
			<div class="col-xs-12 image">
				<?php // if(file_exists(JPATH_SITE . $base . '/' . $item->imagefile) && is_file(JPATH_SITE . $base . '/' . $item->imagefile)): ?>
				<img src="<?php echo $base . '/' . $item->imagefile; ?>" class="img-responsive maxheight" />
				<?php //endif; ?>
			</div>
			<div class="col-xs-12 info">
				<span class="speakername"><?php echo $item->firstname . ' ' . $item->lastname; ?><br /></span>
				<?php echo JHtml::_('string.truncate', $item->bio, 80); ?><br />
				<?php
					$speakerLink = 'index.php?option=com_conferenceplus&view=speaker&id='
						. $item->conferenceplus_speaker_id . '&Itemid=' . $Itemid;
				?>
				<a href="<?php echo $speakerLink; ?>"><?php echo JText::_('COM_CONFERENCEPLUS_SPEAKERS_MORE_ABOUT'); ?> <?php echo $item->firstname; ?> <?php echo $item->lastname; ?></a>
			</div>
		</div>

		<?php endfor; ?>
	</div>

	<?php else : ?>
		<p>no speakers published</p>
	<?php endif; ?>

</div>
<!-- ************************** END: conferenceplus ************************** -->
