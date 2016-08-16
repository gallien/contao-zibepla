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
 * Table tl_zibepla_availability
 */
$GLOBALS['TL_DCA']['tl_zibepla_availability'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'                   => 'Table',
		'ctable'                          => array('tl_zibepla_availability_item'),
		'switchToEdit'                    => true,
		'enableVersioning'                => false,
		'onload_callback' 		  => array
		(
			array('tl_zibepla_availability', 'load')
		),
		'onsubmit_callback' 	          => array(
			array('tl_zibepla_availability', 'submit')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'            => 'act=select',
				'class'           => 'header_edit_all',
				'attributes'      => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['edit'],
				'href'            => 'act=edit',
				'icon'            => 'edit.gif'
			),
			'copy' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['copy'],
				'href'            => 'act=copy',
				'icon'            => 'copy.gif'
			),
			'delete' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['delete'],
				'href'            => 'act=delete',
				'icon'            => 'delete.gif',
				'attributes'      => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['tl_zibepla_availability']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['show'],
				'href'            => 'act=show',
				'icon'            => 'show.gif'
			),
			'create' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['items'],
				'href'            => 'table=tl_zibepla_availability_item&act=create',
				'icon'            => 'system/modules/zibepla/html/calendar.gif'
			),
			'reset' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['reset'],
				'href'            => 'key=reset',
				'icon'            => 'deleteAll.gif',
				'attributes'      => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['tl_zibepla_availability']['resetConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                         => '{title_legend},title,maxMonths,monthsPerRow'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'       => true,
				'maxlength'       => 255,
				'unique'          => true
			)
		),
		'maxMonths' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['maxMonths'],
			'exclude'                 => true,
			'default'                 => '16',
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
		),
		'monthsPerRow' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_zibepla_availability']['monthsPerRow'],
			'exclude'                 => true,
			'default'                 => '4',
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
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
class tl_zibepla_availability extends Backend
{
    public function load(DataContainer $dc)
    {
	if ($this->Input->get('key') == 'reset') {
	    $id = $dc->Input->get('id');
	    $this->resetItems($id);
	}
    }

    public function submit(DataContainer $dc)
    {
	$act = $dc->Input->get('act');
	if ($act == 'create' || $act == 'edit') {
	    $id = $dc->Input->get('id');
	    $objAvailability = $this->Database->prepare('SELECT tstamp FROM tl_zibepla_availability WHERE id = ?')
	                                      ->execute($id);
	    if ($objAvailability->tstamp == 0) {
		$this->initializeItems($id);
	    }
	}
    }

    private function initializeItems($pid)
    {
	$arrSet = array();
	$arrSet['pid'] = $pid;
	$arrSet['tstamp'] = time();
	$arrSet['startDate'] = strtotime('2000-01-01');
	$arrSet['endDate'] = strtotime('2037-12-31');
	$arrSet['status'] = 'F';

	$this->insertItem($arrSet);
    }

    private function insertItem($arrSet)
    {
	$this->Database->prepare("INSERT INTO tl_zibepla_availability_item %s")->set($arrSet)->execute();
    }

    private function deleteItems($pid)
    {
	$this->Database->prepare("DELETE FROM tl_zibepla_availability_item WHERE pid = ?")->execute($pid);
    }

    private function resetItems($pid)
    {
	$this->deleteItems($pid);
	$this->initializeItems($pid);
    }
}

?>
