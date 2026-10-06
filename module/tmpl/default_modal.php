<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_wmarka_articles_portfolio
 *
 * @copyright   (C) 2026 Beibit Sakhanov <https://webmarka.kz>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Webmarka\Module\ArticlesPortfolio\Site\Helper\ArticlesPortfolioHelper;

/**
 * Modal window of one project; shared by the cards and the titles sublayouts.
 *
 * @var \Joomla\Registry\Registry $params
 * @var object                    $item
 * @var string                    $modalId
 * @var string                    $title    escaped title
 */

$esc       = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$modalSize = (string) $params->get('modal_size', '');
$mediaLeft = $params->get('modal_media_pos', 'top') === 'left';
$fullImage = ArticlesPortfolioHelper::fullImage($item);
$imageTag  = $fullImage['src'] !== ''
    ? '<img src="' . $esc($fullImage['src']) . '"'
        . ($fullImage['width'] && $fullImage['height'] ? ' width="' . $fullImage['width'] . '" height="' . $fullImage['height'] . '"' : '')
        . ' alt="' . $esc($fullImage['alt']) . '" loading="lazy" decoding="async" class="uk-width-1-1 uk-border-rounded' . ($mediaLeft ? '' : ' uk-margin-bottom') . '">'
    : '';
?>
<div id="<?php echo $modalId; ?>" class="<?php echo $esc($modalSize); ?>" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close aria-label="<?php echo Text::_('MOD_WMARKA_ARTICLES_PORTFOLIO_CLOSE'); ?>"></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><?php echo $title; ?></h2>
        </div>
        <div class="uk-modal-body">
            <?php if ($mediaLeft && $imageTag !== '') : ?>
                <div class="uk-grid-medium" uk-grid>
                    <div class="uk-width-1-2@m"><?php echo $imageTag; ?></div>
                    <div class="uk-width-1-2@m"><?php echo $item->introtext_clean; ?></div>
                </div>
            <?php else : ?>
                <?php echo $imageTag; ?>
                <div><?php echo $item->introtext_clean; ?></div>
            <?php endif; ?>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button"><?php echo Text::_('MOD_WMARKA_ARTICLES_PORTFOLIO_CLOSE'); ?></button>
            <a href="<?php echo $item->link; ?>" class="uk-button uk-button-primary"><?php echo Text::_('MOD_WMARKA_ARTICLES_PORTFOLIO_GO_TO_PAGE'); ?></a>
        </div>
    </div>
</div>
