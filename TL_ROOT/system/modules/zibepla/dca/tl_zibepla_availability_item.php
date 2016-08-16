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
 * Load tl_content language file
 */
$this->loadLanguageFile('tl_content');


/**
 * Table tl_zibepla_availability_item
 */
$GLOBALS['TL_DCA']['tl_zibepla_availability_item'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'                   => 'Table',
		'ptable'                          => 'tl_zibepla_availability',
		'enableVersioning'                => false,
		'onload_callback' 		  => array
		(
			array('tl_zibepla_availability_item', 'load')
		),
		'onsubmit_callback' => array
		(
			array('tl_zibepla_availability_item', 'save')
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                         => '{availability_period_legend},startDate,endDate,status;{availability_calendar_legend},calendar'
	),

	// Fields
	'fields' => array
	(
		'startDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_zibepla_availability_item']['startDate'],
			'exclude'                 => true,
			'default'                 => time(),
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'endDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_zibepla_availability_item']['endDate'],
			'exclude'                 => true,
			'default'                 => time(),
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_zibepla_availability_item']['status'],
			'exclude'                 => true,
			'default'                 => 'F',
			'inputType'               => 'select',
			'options'		  => array('F' => &$GLOBALS['TL_LANG']['tl_zibepla_availability_item']['free'],
			                                   'O' => &$GLOBALS['TL_LANG']['tl_zibepla_availability_item']['occupied']),
			'eval'                    => array('tl_class' => 'w50')
		),
		'calendar' => array
		(
		        'input_field_callback'    => array('tl_zibepla_availability_item', 'showCalendar'),
		        'eval'                    => array('tl_class' => 'long')
		)
	)
);


/**
 * Class tl_zibepla_availability_item
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Seleos UG (haftungsbeschränkt)
 * @author     Andreas Gallien
 * @package    Availability
 */
class tl_zibepla_availability_item extends Backend
{

    public function load(DataContainer $dc) {
	$act = $this->Input->get('act');
	if ($act == 'create') {
	    $session = $this->Session->getData();
	    $id = $this->Input->get('id');
	    if (! empty($id)) {
	        $session['zibepla_availability']['id'] = $this->Input->get('id');
	    }
	    $this->Session->setData($session);
        }
    }

    public function save(DataContainer $dc)
    {
        $session = $this->Session->getData();
	$pid = $session['zibepla_availability']['id'];

	$startDate = $dc->Input->post('startDate');
	$endDate = $dc->Input->post('endDate');
	$status = $dc->Input->post('status');
	$occupied = $dc->Input->post('occupied');

	if (! in_array($status, array('F', 'O'))) {
	    $status = 'F';
	}
	if (! is_array($occupied)) {
	    $occupied = array();
	}

	$calendar = new AvailabilityCalendar();
	$calendar->initialize();

	foreach ($occupied as $o) {
	    $calendar->addItem(
	        array('startDate' => $calendar->days2date($o),
		      'endDate' => $calendar->days2date($o + 1) - 1,
		      'status' => 'O')
            );
	}

	$startDate = (int) strtotime($startDate);
	$endDate = (int) strtotime($endDate) - 1;
	if (is_numeric($startDate) && is_numeric($endDate)) {
	    $calendar->addItem(
		array('startDate' => $startDate,
		      'endDate' => $endDate,
		      'status' => $status)
            );
	}

	$this->saveItems($pid, $calendar->getItems());
    }

    public function showCalendar(DataContainer $dc)
    {
        $session = $this->Session->getData();
	$pid = $session['zibepla_availability']['id'];

        $calendar = new AvailabilityCalendar();
        $calendar->initialize();
        $calendar->addItems($this->getItems($pid));

        return $calendar->getCalendar(16, 4, false, true);
    }

    private function saveItems($pid, $items)
    {
	$this->deleteItems($pid);

	foreach ($items as $item) {
	    $arrSet = array();
	    $arrSet['pid'] = $pid;
	    $arrSet['tstamp'] = time();
	    $arrSet['startDate'] = $item['startDate'];
	    $arrSet['endDate'] = $item['endDate'];
	    $arrSet['status'] = $item['status'];
	    $this->insertItem($arrSet);
	}
    }

    private function insertItem($arrSet)
    {
	$this->Database->prepare("INSERT INTO tl_zibepla_availability_item %s")->set($arrSet)->execute();
    }

    private function deleteItems($pid)
    {
	$this->Database->prepare("DELETE FROM tl_zibepla_availability_item WHERE pid = ?")->execute($pid);
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
