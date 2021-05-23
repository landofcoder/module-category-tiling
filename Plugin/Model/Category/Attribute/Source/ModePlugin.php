<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_CategoryTiling
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */

declare(strict_types=1);

namespace Lof\CategoryTiling\Plugin\Model\Category\Attribute\Source;

use Magento\Catalog\Model\Category\Attribute\Source\Mode;

class ModePlugin
{
    public const     DM_TILING              = 'TILING';
    public const     DM_TILING_AND_PAGE              = 'TILING_AND_PAGE';
    public const     DM_TILING_AND_PRODUCTS          = 'TILING_AND_PRODUCTS';
    public const     DM_TILING_AND_PAGE_AND_PRODUCTS = 'TILING_AND_PAGE_AND_PRODUCTS';

    /**
     * Add custom options to the category mode options.
     *
     * @param Mode  $subject
     * @param array $result
     *
     * @return array
     */
    public function afterGetAllOptions(Mode $subject, array $result): array
    {
        $tilingOptions = [
            [
                'value' => self::DM_TILING,
                'label' => __('Tiles only')
            ],
            [
                'value' => self::DM_TILING_AND_PAGE,
                'label' => __('Static block and tiles')
            ],
            [
                'value' => self::DM_TILING_AND_PRODUCTS,
                'label' => __('Tiles and products')
            ],
            [
                'value' => self::DM_TILING_AND_PAGE_AND_PRODUCTS,
                'label' => __('Static block products and tiles and products')
            ],
        ];

        return array_merge($result, $tilingOptions);
    }
}
