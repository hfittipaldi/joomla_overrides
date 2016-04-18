<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$caret = '';
// Note. It is important to remove spaces between elements.
if ($item->level == 1)
{
    $class  = $item->anchor_css ? $item->anchor_css . ' ' : '';
    $class .= $item->deeper ? 'dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false' : '';
    
    $caret .= $item->deeper ? ' <span class="caret"></span>' : '';
}
else
{
    $class  = 'separator';
    $class .= $item->anchor_css ? ' ' . $item->anchor_css : '';
}

$title  = $item->anchor_title ? ' title="' . $item->anchor_title . '"' : '';

$linktype = $item->title;

if ($item->menu_image)
{
	$linktype = JHtml::_('image', $item->menu_image, $item->title);

	if ($item->params->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
	}
}

?>
<span class="<?php echo $class; ?>"<?php echo $title; ?>><?php echo $linktype . $caret; ?></span>
