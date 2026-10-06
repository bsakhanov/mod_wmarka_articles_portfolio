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
use Joomla\CMS\Language\Text;
use Webmarka\Module\ArticlesPortfolio\Site\Helper\ArticlesPortfolioHelper as Helper;

/**
 * @var \stdClass                 $module
 * @var \Joomla\Registry\Registry $params
 * @var array                     $items        articles of the current group
 * @var object|null               $juImg
 * @var string                    $blendMode
 * @var string                    $overlayRgba
 * @var int                       $modalSeq
 * @var object|null               $juImg
 */

$esc      = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$headings = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div'];
$modalSeq ??= 0;

$wrapperTag    = $params->get('portfolio_layout', 'grid') === 'slider' ? 'li' : 'div';
$cardStructure = (string) $params->get('card_structure', 'body-only');
$hasHeader     = \in_array($cardStructure, ['header-body', 'header-body-footer'], true);
$hasFooter     = \in_array($cardStructure, ['body-footer', 'header-body-footer'], true);
$itemTag       = \in_array($params->get('item_heading_tag', 'h3'), $headings, true) ? $params->get('item_heading_tag', 'h3') : 'h3';
$titleClass    = Helper::titleClass($params);
$introAttr     = Helper::introAttributes($params, 'uk-margin-small-top');
$showIntro     = (bool) $params->get('show_introtext', 1);
$microdata     = $params->get('structured_data', 'jsonld') === 'microdata';

// The cover keeps the img_w × img_h ratio on every screen, with JUImage or with the original file.
$ratioW = max(1, (int) $params->get('img_w', 800));
$ratioH = max(1, (int) $params->get('img_h', 500));
$sizes  = Helper::sizes([$params->get('cols_s', 'uk-child-width-1-2@s'), $params->get('cols_m', 'uk-child-width-1-3@m'), $params->get('cols_l', 'uk-child-width-1-3@l')]);

$modalPath = ModuleHelper::getLayoutPath($module->module, 'default_modal');

foreach ($items as $item) :
    $modalId = 'modal-portfolio-' . $module->id . '-' . $item->id . '-' . (++$modalSeq);
    $picture = Helper::picture($item, $params, $juImg, $sizes, 'intro', ['img_h' => 500, 'mob_w' => 400, 'mob_h' => 300]);
    $title   = $esc($item->title);
    ?>
    <<?php echo $wrapperTag; ?> class="<?php echo Helper::filterClasses($item); ?>">
        <div class="uk-card uk-card-default uk-link-toggle uk-overflow-hidden uk-flex uk-flex-column"<?php echo $microdata ? ' itemscope itemtype="https://schema.org/CreativeWork"' : ''; ?>>

            <?php // The whole card opens the modal: the link lies above the image and the text. ?>
            <a href="#<?php echo $modalId; ?>" uk-toggle class="uk-position-cover uk-position-z-index" aria-label="<?php echo $title; ?>"></a>

            <?php if ($picture) : ?>
                <div class="uk-card-media-top uk-cover-container"<?php echo $microdata ? ' itemprop="image" itemscope itemtype="https://schema.org/ImageObject"' : ''; ?>>
                    <?php echo Helper::pictureTag($picture, ['uk-cover' => true, 'itemprop' => $microdata ? 'contentUrl' : null]); ?>
                    <canvas width="<?php echo $ratioW; ?>" height="<?php echo $ratioH; ?>"></canvas>
                    <?php if ($blendMode !== '' && $overlayRgba !== '') : ?>
                        <div class="uk-position-cover <?php echo $esc($blendMode); ?>" style="background-color: <?php echo $overlayRgba; ?>;"></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="uk-flex uk-flex-column uk-flex-1">
                <?php if ($hasHeader) : ?>
                    <div class="uk-card-header">
                        <<?php echo $itemTag; ?> class="<?php echo $esc($titleClass); ?> uk-margin-remove"<?php echo $microdata ? ' itemprop="name"' : ''; ?>><?php echo $title; ?></<?php echo $itemTag; ?>>
                    </div>
                <?php endif; ?>

                <div class="uk-card-body uk-flex-1">
                    <?php if (!$hasHeader) : ?>
                        <<?php echo $itemTag; ?> class="<?php echo $esc($titleClass); ?> uk-margin-remove-top"<?php echo $microdata ? ' itemprop="name"' : ''; ?>><?php echo $title; ?></<?php echo $itemTag; ?>>
                    <?php endif; ?>

                    <?php if ($showIntro && !empty($item->displayIntrotext)) : ?>
                        <div<?php echo $introAttr; ?><?php echo $microdata ? ' itemprop="abstract"' : ''; ?>><?php echo $item->displayIntrotext; ?></div>
                    <?php endif; ?>
                </div>

                <?php if ($hasFooter) : ?>
                    <div class="uk-card-footer">
                        <span class="uk-button uk-button-text"><?php echo Text::_('MOD_WMARKA_ARTICLES_PORTFOLIO_VIEW_PROJECT'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php require $modalPath; ?>
    </<?php echo $wrapperTag; ?>>
<?php endforeach; ?>
