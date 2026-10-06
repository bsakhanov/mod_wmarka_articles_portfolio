<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_wmarka_articles_portfolio
 *
 * @copyright   (C) 2026 Beibit Sakhanov <https://webmarka.kz>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Webmarka\Module\ArticlesPortfolio\Site\Helper\ArticlesPortfolioHelper;

/**
 * Prepared by the Dispatcher:
 *
 * @var \stdClass                 $module
 * @var \Joomla\Registry\Registry $params
 * @var array                     $list         articles, or [group title => articles] when $grouped
 * @var bool                      $grouped
 * @var string                    $moduleClass
 * @var object|null               $juImg
 * @var string                    $blendMode
 * @var string                    $overlayRgba
 */

$esc       = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$headings  = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div'];
$sublayout = static function (string $suffix) use ($module, $params): string {
    $path = ModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default') . '_' . $suffix);

    // An alternative layout without its own sublayout falls back to the default one, never to default.php itself.
    return basename($path) === 'default.php' ? ModuleHelper::getLayoutPath($module->module, 'default_' . $suffix) : $path;
};

$customHeader = trim((string) $params->get('custom_header', ''));
$headerTag    = \in_array($params->get('header_tag', 'h2'), $headings, true) ? $params->get('header_tag', 'h2') : 'h2';
$headerClass  = trim($params->get('header_class', 'uk-heading-line') . ' ' . $params->get('header_size', ''));

$isSlider    = $params->get('portfolio_layout', 'grid') === 'slider';
$itemsPath   = $sublayout($params->get('articles_layout', 'items') === 'titles' ? 'titles' : 'items');
$colsClasses = 'uk-child-width-1-1 ' . $params->get('cols_s', 'uk-child-width-1-2@s') . ' ' . $params->get('cols_m', 'uk-child-width-1-3@m') . ' ' . $params->get('cols_l', 'uk-child-width-1-3@l');
$gridClass   = trim(implode(' ', array_filter([
    $params->get('grid_gutter', 'uk-grid-medium'),
    $params->get('grid_match', 1) ? 'uk-grid-match' : '',
    $colsClasses,
])));
$gridAttr      = $params->get('grid_masonry', 0) ? 'uk-grid="masonry: true"' : 'uk-grid';
$slidenavClass = (string) $params->get('slidenav_class', 'uk-slidenav-large');

// UIkit front-end filter: grid only (a slider cannot hide items on the fly) and a flat list only.
$filterBy      = (string) $params->get('frontend_filter_by', 'category');
$filterBy      = \in_array($filterBy, ['category', 'tag', 'author', 'year', 'month'], true) ? $filterBy : 'category';
$filterOptions = $params->get('frontend_filter', 0) && !$isSlider && !$grouped ? ArticlesPortfolioHelper::filterOptions($list, $filterBy) : [];
$filterStyle   = (string) $params->get('frontend_filter_style', 'uk-subnav uk-subnav-pill');
$filterAlign   = (string) $params->get('frontend_filter_align', 'uk-flex-center');
$filterAll     = Text::_(trim((string) $params->get('frontend_filter_all', '')) ?: 'MOD_WMARKA_ARTICLES_PORTFOLIO_FILTER_ALL_DEFAULT');
$filterAnim    = (string) $params->get('frontend_filter_anim', 'slide');

if ($isSlider && $params->get('slidenav', 1)) {
    // Arrows placed outside the slider take about 60px a side: the slider leaves that room inside the module.
    Factory::getApplication()->getDocument()->getWebAssetManager()->addInlineStyle(
        '@media (min-width:640px){.wmarka-portfolio .wmarka-slider-out{padding-left:60px;padding-right:60px}}',
        ['name' => 'mod_wmarka_articles_portfolio.slider']
    );
}

// Modal ids stay unique even when one article appears in several tag groups.
$modalSeq = 0;
$groups   = $grouped ? $list : [$list];
?>
<div class="wmarka-portfolio<?php echo $moduleClass !== '' ? ' ' . $esc($moduleClass) : ''; ?>">

    <?php if ($customHeader !== '') : ?>
        <div class="uk-margin-medium-bottom uk-text-center">
            <<?php echo $headerTag; ?> class="<?php echo $esc($headerClass); ?>">
                <span><?php echo $esc($customHeader); ?></span>
            </<?php echo $headerTag; ?>>
        </div>
    <?php endif; ?>

    <?php if ($filterOptions) : ?>
    <div uk-filter="target: .js-filter; animation: <?php echo $esc($filterAnim); ?>">

        <?php if ($filterStyle === 'uk-button-group') : ?>
            <div class="uk-margin-medium-bottom uk-flex <?php echo $esc($filterAlign); ?>">
                <div class="uk-button-group">
                    <button type="button" class="uk-button uk-button-default uk-active" uk-filter-control><?php echo $esc($filterAll); ?></button>
                    <?php foreach ($filterOptions as $key => $label) : ?>
                        <button type="button" class="uk-button uk-button-default" uk-filter-control=".f-<?php echo $filterBy; ?>-<?php echo $esc($key); ?>"><?php echo $esc($label); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <ul class="<?php echo $esc($filterStyle . ' ' . $filterAlign); ?> uk-margin-medium-bottom">
                <li class="uk-active" uk-filter-control><a href="#"><?php echo $esc($filterAll); ?></a></li>
                <?php foreach ($filterOptions as $key => $label) : ?>
                    <li uk-filter-control=".f-<?php echo $filterBy; ?>-<?php echo $esc($key); ?>"><a href="#"><?php echo $esc($label); ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>

    <?php foreach ($groups as $groupTitle => $items) : ?>
        <?php if ($grouped) : ?>
            <h3 class="uk-h4 uk-margin-medium-top uk-margin-bottom wmarka-articles-group"><?php echo $esc($groupTitle === 'MOD_WMARKA_ARTICLES_PORTFOLIO_UNTAGGED' ? Text::_($groupTitle) : $groupTitle); ?></h3>
        <?php endif; ?>

        <?php if ($isSlider) : ?>
            <div<?php echo $params->get('slidenav', 1) ? ' class="wmarka-slider-out"' : ''; ?> uk-slider="finite: false; autoplay: true; pause-on-hover: true">
                <div class="uk-position-relative uk-visible-toggle" tabindex="-1">
                    <div class="uk-slider-container uk-padding-small">
                        <ul class="uk-slider-items uk-grid-match uk-grid-medium <?php echo $esc($colsClasses); ?>" uk-grid>
                            <?php require $itemsPath; ?>
                        </ul>
                    </div>

                    <?php // Arrows outside the slider would stick out of a phone screen: hidden there, swipe works. ?>
                    <?php if ($params->get('slidenav', 1)) : ?>
                        <a class="uk-position-center-left-out uk-position-small uk-visible@s <?php echo $esc($slidenavClass); ?>" href uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right-out uk-position-small uk-visible@s <?php echo $esc($slidenavClass); ?>" href uk-slidenav-next uk-slider-item="next"></a>
                    <?php endif; ?>
                </div>

                <?php if ($params->get('dotnav', 0)) : ?>
                    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="<?php echo $filterOptions ? 'js-filter ' : ''; ?><?php echo $esc($gridClass); ?>" <?php echo $gridAttr; ?>>
                <?php require $itemsPath; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($filterOptions) : ?>
    </div>
    <?php endif; ?>

</div>
