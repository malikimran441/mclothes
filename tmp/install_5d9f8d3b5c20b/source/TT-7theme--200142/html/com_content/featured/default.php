<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$columnwidth=((100)/$this->columns).'%';
?>
<?php if ( $this->params->get('show_page_heading')!=0) : ?>
<h1>
<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>
<div class="row">
<?php $flag=0;?>
<?php $leadingcount=0 ; ?>
<?php if (!empty($this->lead_items)) : ?>
<?php $flag=1;?>
<?php foreach ($this->lead_items as &$item) : ?>
<div class="col-xl-12 col-lg-12">
<article class="ttr_post">
<div class="ttr_post_content_inner">
<?php
$this->item = &$item;
echo $this->loadTemplate('item');
?>
</div>
</article>
</div>
<?php
$leadingcount++;
?>
<?php endforeach; ?>
<?php endif; ?>
<?php
$class_suffix_lg  = round((12 / $this->columns));
if(empty($class_suffix_lg)){ 
$class_suffix_lg  =4;
}
 $md =4;
$class_suffix_md  = round((12 / $md));
 $xs =1;
$class_suffix_xs  = round((12 / $xs));
$columncounter=0;
?>
<?php if (!empty($this->intro_items)) :
 if($flag == 1) { ?>
</div>
<div class="row">
<?php }
foreach ($this->intro_items as $key => &$item) : 
$columncounter++; ?>
<div class="col-xl-<?php echo $class_suffix_lg;?> col-lg-<?php echo $class_suffix_lg;?> col-md-<?php echo $class_suffix_md;?> col-sm-<?php echo $class_suffix_xs;?> col-xs-<?php echo $class_suffix_xs;?> col-<?php echo $class_suffix_xs;?> <?php echo $this->pageclass_sfx;?>">
<article class="ttr_post">
<div class ="ttr_post_content_inner">
<?php
$this->item = &$item;
echo $this->loadTemplate('item');
?>
</div>
</article>
</div>
<?php if(($columncounter) % $xs == 0){ echo '<div class="clearfix visible-xs-block d-block"></div>';}
if(($columncounter) % $md == 0){ echo '<div class="clearfix visible-md-block d-md-block"></div>';
echo '<div class="clearfix visible-lg-block d-lg-block"></div>';}
if(($columncounter) % $this->columns == 0){ echo '<div class="clearfix visible-lg-block d-lg-block d-xl-block"></div>';}?>
<?php endforeach; ?>
<?php endif; ?>
</div>
<?php if (!empty($this->link_items)) : ?>
<div class="items-more">
<?php echo $this->loadTemplate('links'); ?>
</div>
<?php endif; ?>
<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
<div class="pagination" style="clear:both">
<?php if ($this->params->def('show_pagination_results', 1)) : ?>
<p class="counter">
<?php echo $this->pagination->getPagesCounter(); ?>
</p>
<?php  endif; ?>
<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php endif; ?>