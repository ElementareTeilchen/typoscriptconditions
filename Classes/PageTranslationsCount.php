<?php
namespace ElementareTeilchen\Typoscriptconditions;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Franz Kugelmann <franz.kugelmann@elementare-teilchen.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *****************************************************************/

use TYPO3\CMS\Core\Configuration\TypoScript\Exception\InvalidTypoScriptConditionException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * @package ElementareTeilchen
 * @subpackage Typoscriptconditions
 */
class PageTranslationsCount extends \TYPO3\CMS\Core\Configuration\TypoScript\ConditionMatching\AbstractCondition
{
    /**
     * Evaluate condition
     *
     * @param array $conditionParameters
     * @return bool
     * @throws InvalidTypoScriptConditionException
     */
    public function matchCondition(array $conditionParameters)
    {
        if (empty($conditionParameters)) {
            throw new InvalidTypoScriptConditionException('You must give comparator < > or = and a number');
        }

        /** @var $cObj ContentObjectRenderer */
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);

        $pageOverlayTableName = 'pages_language_overlay';
        // todo: use API for enableFields, need correct thing also for backend, cObj and sys_page resulting in exception there
        $count = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows('*', $pageOverlayTableName, 'pid=' . (int)$GLOBALS['TSFE']->id . ' and hidden=0 and deleted=0');
        $comparator = substr($conditionParameters[0], 0, 1);
        $value = trim(substr($conditionParameters[0], 1));

        switch ($comparator) {
            case '<':
                return ($count < $value);
            case '=':
                return ($count == $value);
            case '>':
                return ($count > $value);
            default:
                throw new InvalidTypoScriptConditionException('You must give comparator < > or = and a number');
        }
    }

}
