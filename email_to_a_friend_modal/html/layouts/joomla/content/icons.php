<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JHtml::_('bootstrap.framework');

$canEdit = $displayData['params']->get('access-edit');

?>

<div class="icons">
    <?php if (empty($displayData['print'])) : ?>

        <?php if ($canEdit || $displayData['params']->get('show_print_icon') || $displayData['params']->get('show_email_icon')) : ?>
            <div class="btn-group pull-right">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-cog"></span>&#160;<span class="caret"></span></a>
                <?php // Note the actions class is deprecated. Use dropdown-menu instead. ?>
                <ul class="dropdown-menu">
                    <?php if ($displayData['params']->get('show_print_icon')) : ?>
                        <li class="print-icon"><?php echo JHtml::_('icon.print_popup', $displayData['item'], $displayData['params']); ?></li>
                    <?php endif; ?>
                    <?php if ($displayData['params']->get('show_email_icon')) : ?>
                        <li class="email-icon"><?php echo JHtml::_('icon.email', $displayData['item'], $displayData['params']); ?></li>
                    <?php endif; ?>
                    <?php if ($canEdit) : ?>
                        <li class="edit-icon"><?php echo JHtml::_('icon.edit', $displayData['item'], $displayData['params']); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

    <?php else : ?>

        <div class="pull-right">
            <?php echo JHtml::_('icon.print_screen', $displayData['item'], $displayData['params']); ?>
        </div>

    <?php endif; ?>
</div>

<?php
// "Email this link to a friend" bootstrap modal
$uri      = JUri::getInstance();
$base     = $uri->toString(array('scheme', 'host', 'port'));
$template = JFactory::getApplication()->getTemplate();
$link     = $base . JRoute::_(ContentHelperRoute::getArticleRoute($displayData['item']->slug, $displayData['item']->catid, $displayData['item']->language), false);
$url      = 'index.php?option=com_mailto&tmpl=component&template=' . $template . '&link=' . MailToHelper::addLink($link);

echo JHtml::_(
    'bootstrap.renderModal',
    'basicModal-' . MailToHelper::addLink($link),
    array(
        'url' => JRoute::_($url),
        'title' => JText::_('COM_MAILTO_EMAIL_TO_A_FRIEND'),
        'width' => '100%',
        'height' => '400px',
    )
);
