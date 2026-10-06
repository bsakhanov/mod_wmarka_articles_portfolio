<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_wmarka_articles_portfolio
 *
 * @copyright   (C) 2026 Beibit Sakhanov <https://webmarka.kz>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Webmarka\Module\ArticlesPortfolio\Site\Helper\ArticlesPortfolioHelper as Helper;

/**
 * @var \stdClass                 $module
 * @var \Joomla\Registry\Registry $params
 * @var array                     $items     articles of the current group
 * @var int                       $modalSeq
 */

$esc      = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$headings = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div'];
$modalSeq ??= 0;

$wrapperTag   = $params->get('portfolio_layout', 'grid') === 'slider' ? 'li' : 'div';
$itemTag      = \in_array($params->get('item_heading_tag', 'h3'), $headings, true) ? $params->get('item_heading_tag', 'h3') : 'h3';
$titleClass   = Helper::titleClass($params);
$introAttr    = Helper::introAttributes($params, 'uk-margin-small-top');
$showIntro    = (bool) $params->get('show_introtext', 1);
$microdata    = $params->get('structured_data', 'jsonld') === 'microdata';
$modalPath    = ModuleHelper::getLayoutPath($module->module, 'default_modal');

foreach ($items as $item) :
    $modalId = 'modal-portfolio-' . $module->id . '-' . $item->id . '-' . (++$modalSeq);
    $title   = $esc($item->title);
    ?>
    <<?php echo $wrapperTag; ?> class="<?php echo Helper::filterClasses($item); ?>">
        <article class="uk-card uk-card-default uk-card-body uk-card-hover uk-link-toggle"<?php echo $microdata ? ' itemscope itemtype="https://schema.org/CreativeWork"' : ''; ?>>
            <a href="#<?php echo $modalId; ?>" uk-toggle class="uk-position-cover uk-position-z-index" aria-label="<?php echo $title; ?>"></a>

            <<?php echo $itemTag; ?> class="<?php echo $esc($titleClass); ?> uk-margin-remove"<?php echo $microdata ? ' itemprop="name"' : ''; ?>><?php echo $title; ?></<?php echo $itemTag; ?>>

            <?php if ($showIntro && !empty($item->displayIntrotext)) : ?>
                <div<?php echo $introAttr; ?><?php echo $microdata ? ' itemprop="abstract"' : ''; ?>><?php echo $item->displayIntrotext; ?></div>
            <?php endif; ?>

        </article>

        <?php require $modalPath; ?>
    </<?php echo $wrapperTag; ?>>
<?php endforeach; ?>
