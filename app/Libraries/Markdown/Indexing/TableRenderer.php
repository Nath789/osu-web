<?php

// Copyright (c) ppy Pty Ltd <contact@ppy.sh>. Licensed under the GNU Affero General Public License v3.0.
// See the LICENCE file in the repository root for full licence text.

namespace App\Libraries\Markdown\Indexing;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Ext\Table\TableCell;
use League\CommonMark\Ext\Table\TableRow;
use League\CommonMark\Ext\Table\TableSection;

class TableRenderer extends BlockRenderer
{
    const INLINE_CLASSES = [TableCell::class, TableRow::class];

    /**
     * @param AbstractBlock $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool $inTightList
     *
     * @return string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $renderer, $inTightList = false)
    {
        if (!$block->hasChildren()) {
            return '';
        }

        // skip header
        if ($block instanceof TableSection && $block->isHead()) {
            return '';
        }

        $blockClass = get_class($block);
        $inTightList = !in_array($blockClass, static::INLINE_CLASSES, true);

        return parent::render($block, $renderer, $inTightList);
    }
}
