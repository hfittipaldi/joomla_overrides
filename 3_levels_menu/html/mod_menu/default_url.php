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
if ($item->deeper)
{
    $class  = 'class="';
    $class .= $item->anchor_css ? $item->anchor_css . ' ' : '';
    $class .= 'dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ';
    
    $caret = ' <span class="caret"></span>';
}
else
{
    $class = $item->anchor_css ? 'class="' . $item->anchor_css . '" ' : '';
}

// Note. It is important to remove spaces between elements.
//$class = $item->anchor_css ? 'class="' . $item->anchor_css . '" ' : '';
$title = $item->anchor_title ? 'title="' . $item->anchor_title . '" ' : '';
$rel   = $item->anchor_rel ? 'rel="' . $item->anchor_rel . '" ' : '';

if ($item->menu_image)
{
	$item->params->get('menu_text', 1) ?
	$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' :
	$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}
else
{
	$linktype = $item->title;
}

$flink = $item->flink;
$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));

switch ($item->browserNav) :
	default:
	case 0:
?><a href="<?php echo $flink; ?>" <?php echo $class . $title . $rel; ?>><?php echo $linktype . $caret; ?></a><?php
		break;
	case 1:
		// _blank
?><a href="<?php echo $flink; ?>" <?php echo $class . $title . $rel; ?>target="_blank"><?php echo $linktype; ?></a><?php
		break;
	case 2:
		// Use JavaScript "window.open"
		$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');
			?><a href="<?php echo $flink; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;" <?php echo $class . $title; ?>><?php echo $linktype; ?></a><?php
		break;
endswitch;
