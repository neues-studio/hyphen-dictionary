<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\ViewHelpers\Format;

use NeuesStudio\HyphenDictionary\Service\HyphenateService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class HyphenateViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('content', 'string', 'The content that should be hyphened', false, null);
        $this->registerArgument('minWordLength', 'int', 'Minimum word length that should be hyphened.', false, 0);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $hyphenateService = GeneralUtility::makeInstance(HyphenateService::class);
        $content = $arguments['content'];

        if (empty($arguments['content'])) {
            $content = $renderChildrenClosure();
        }

        if (empty($content) || !is_string($content)) {
            return '';
        }

        return $hyphenateService->hyphenate($content, $arguments['minWordLength']);
    }
}
