<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$params = &$this->item->params;
$canEdit	= $this->item->params->get('access-edit'); 
$images = json_decode($this->item->images);
$app	= JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$info    = $this->item->params->get('info_block_position', 0);
$templateparams = $app->getTemplate(true)->params;
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));

JHtml::_('behavior.caption');
?>
<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) : ?>
<div class="system-unpublished">
<?php endif; ?>
<?php if ($params->get('show_title')): ?>
<div class="ttr_post_inner_box">
<h2 class="ttr_post_title">
 <?php if ($params->get('link_titles') && $params->get('access-view')) : ?> 
<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>"  itemprop="url">
<?php echo $this->escape($this->item->title); ?></a>
<?php else : ?>
<?php echo $this->escape($this->item->title); ?>
<?php endif; ?>
 </h2> 
</div>
<?php endif; ?>
<div class="ttr_article">
		<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>
	<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>		
	<div class="postedon">			
			<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
	<?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
		<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
	<?php endif; ?>
		</div>
		<?php endif; ?>

<?php if ($this->item->state == 0) : ?>
	<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
<?php endif; ?>
<?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
	<span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
<?php endif; ?>
<?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate()) : ?>
	<span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
<?php endif; ?>
<div class="postcontent">
<?php if ($canEdit) : ?>
<?php echo JHtml::_('icon.edit', $this->item, $params, array(), true); ?>
 <?php endif; ?>
<?php if ($params->get('show_intro')) : ?>
<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
	<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
<?php endif; ?>

<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
<?php echo $this->item->event->beforeDisplayContent; ?>

<?php echo $this->item->introtext; ?>
<?php endif; ?>
<div style="clear:both;"></div>
</div>

<?php echo $this->item->event->beforeDisplayContent; ?>

<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
<div class="postedon">
	<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
	<?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
		<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
	else :
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
		$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
	endif; ?>
<?php echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>
<?php endif; ?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != $this->db->getNullDate() )) : ?>
	</div>
<?php endif; ?>
<div class="item-separator"></div>
<?php echo $this->item->event->afterDisplayContent; ?>
