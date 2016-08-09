<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::addIncludePath(JPATH_BASE . '/templates/' . JFactory::getApplication()->getTemplate() . '/code/com_content/helpers');

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items))
{
    foreach ($this->items as $article)
    {
        if ($article->params->get('access-edit'))
        {
            $isEditable = true;
            break;
        }
    }
}
?>

<?php if (empty($this->items)) : ?>

    <?php if ($this->params->get('show_no_articles', 1)) : ?>
    <p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
    <?php endif; ?>

<?php else : ?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
    <?php if ($this->params->get('show_headings') || $this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
    <fieldset class="filters btn-toolbar clearfix">
        <?php if ($this->params->get('filter_field') != 'hide') :?>
            <div class="btn-group">
                <label class="sr-only" for="filter-search">
                    <?php echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '&#160;'; ?>
                </label>
                <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="form-control" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'); ?>" />
            </div>
        <?php endif; ?>
        <?php if ($this->params->get('show_pagination_limit')) : ?>
            <div class="btn-group pull-right" role="group">
                <label for="limit" class="sr-only">
                    <?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
                </label>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="filter_order" value="" />
        <input type="hidden" name="filter_order_Dir" value="" />
        <input type="hidden" name="limitstart" value="" />
        <input type="hidden" name="task" value="" />
    </fieldset>
    <?php endif; ?>

    <div id="accordion" class="panel-group" role="tablist" aria-multiselectable="true">
        <?php $first = $this->params->get('show_first_open');
        $data_parent = $this->params->get('collapse_all') == 1
            ? ' data-parent="#accordion"'
            : '';
        foreach ($this->items as $i => $article) :
            $params = $article->params;
            $in = '';
            $expanded = 'false';

            if ($first == 1 && $i == 0)
            {
                $in = ' in';
                $expanded = 'true';
            }
        ?>
        <article class="panel panel-default">
            <header <?php echo $headerTitle; ?> class="panel-heading" role="tab" id="heading-<?php echo $i; ?>">
                <h3 class="toggler panel-title">
                    <a role="button" data-toggle="collapse"<?php echo $data_parent; ?> href="#collapse-<?php echo $i; ?>" aria-expanded="<?php echo $expanded; ?>" aria-controls="collapse<?php echo $i; ?>"><?php echo $this->escape($article->title); ?></a>
                </h3>
            </header>
            <div id="collapse-<?php echo $i; ?>" class="panel-collapse collapse<?php echo $in; ?>" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
                <div class="panel-body">
                    <?php echo $article->event->beforeDisplayContent; ?>

                    <?php if ($params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
                    <?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $article, 'print' => false)); ?>
                    <?php endif; ?>

                    <?php if ($article->fulltext != '') : ?>
                        <?php if ($params->get('show_intro') == 1) : ?>
                        <?php echo $article->introtext; ?>
                        <?php endif; ?>
                    <?php echo JHtml::_('content.prepare', $article->fulltext); ?>
                    <?php else : ?>
                    <?php echo $article->text; ?>
                    <?php endif; ?>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php // Code to add a link to submit an article. ?>
<?php if ($this->category->getParams()->get('access-create')) : ?>
    <?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?>
<?php  endif; ?>

<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
    <?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
    <div class="pagination">

        <?php if ($this->params->def('show_pagination_results', 1)) : ?>
            <p class="counter pull-right">
                <?php echo $this->pagination->getPagesCounter(); ?>
            </p>
        <?php endif; ?>

        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
    <?php endif; ?>
</form>
<?php  endif; ?>
