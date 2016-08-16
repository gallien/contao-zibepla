<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Seleos UG (haftungsbeschränkt)
 * @author     Andreas Gallien
 * @package    Availability
 * @license    http://www.zibepla.com/license.php
 */


/**
 * Class ContentAvailability
 *
 * @copyright  Seleos UG (haftungsbeschränkt)
 * @author     Andreas Gallien
 * @package    Availability
 */
class ContentAvailability extends ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_availability';

    /**
     * Return if the file does not exist
     * @return string
     */
    public function generate()
    {
	// Return if there are no availabilities
	if (empty($this->arrData['zibepla_availability']))
	{
	    return '';
	}

	return parent::generate();
    }

    /**
     * Generate module
     */
    protected function compile()
    {
	$pid = $this->zibepla_availability;
        $calendar = new AvailabilityCalendar();
        $calendar->initialize();
        $calendar->addItems($this->getItems($pid));

        $zibepla = $this->Database->prepare("SELECT title, maxMonths, monthsPerRow " .
                                            "FROM tl_zibepla_availability " .
                                            "WHERE id = ?")
	                ->execute($pid);
        $this->Template->calendar = $calendar->getCalendar($zibepla->maxMonths, $zibepla->monthsPerRow, false, false);

        $this->Template->copyright = '<a href="http://www.zibepla.com/zibepla-contao.php" title="'.$GLOBALS['TL_LANG']['ZIBEPLA']['copyright_title_1'].'" onclick="window.open(this.href); return false;">'.$GLOBALS['TL_LANG']['ZIBEPLA']['copyright_anchor_1'].'</a> powered by <a href="http://www.zibepla.com" title="'.$GLOBALS['TL_LANG']['ZIBEPLA']['copyright_title_2'].'" onclick="window.open(this.href); return false;">'.$GLOBALS['TL_LANG']['ZIBEPLA']['copyright_anchor_2'].'</a>';

	$GLOBALS['TL_CSS'][] = 'system/modules/zibepla/html/style.css';
    }

    private function getItems($pid)
    {
        $items = array();

	$objItems = $this->Database->prepare('SELECT startDate, endDate, status ' .
	                                     'FROM tl_zibepla_availability_item ' .
	                                     'WHERE pid = ? ' .
	                                     'ORDER BY startDate ')
	                           ->execute($pid);
        while ($objItems->next()) {
            $item = array();
            $item['startDate'] = $objItems->startDate;
            $item['endDate'] = $objItems->endDate;
            $item['status'] = $objItems->status;
            $items[] = $item;
        }

        return $items;
    }
}

?>
