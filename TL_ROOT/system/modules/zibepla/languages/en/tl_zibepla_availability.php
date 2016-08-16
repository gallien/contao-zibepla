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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_zibepla_availability']['title']  = array('Title', 'Please enter the availability calendar title.');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['maxMonths']  = array('Maximum number of months', 'Here you can limit the number of months.');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['monthsPerRow']  = array('Months per row', 'The number of months per row.');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['tstamp'] = array('Revision date', 'Date and time of the latest revision');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_zibepla_availability']['title_legend'] = 'Title';

/**
 * Reference
 */

$GLOBALS['TL_LANG']['tl_zibepla_availability']['deleteConfirm'] = 'Deleting a availability calendar will also delete all its availability items! Do you really want to delete availability calendar ID %s?';
$GLOBALS['TL_LANG']['tl_zibepla_availability']['resetConfirm'] = 'Resetting a availability calendar will also delete all its availability items! Do you really want to reset availability calendar ID %s?';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_zibepla_availability']['new']    = array('New availability calendar', 'Create a new availability calendar');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['show']   = array('Availability calendar details', 'Show the details of availability calendar ID %s');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['edit']   = array('Edit availability calendar', 'Edit availability calendar ID %s');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['copy']   = array('Duplicate availability calendar', 'Duplicate availability calendar ID %s');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['delete'] = array('Delete availability calendar', 'Delete availability calendar ID %s');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['item']   = array('Manage availability calendar', 'Manage availability calendar ID %s');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['items']  = array('Manage availability calendar', 'Manage availability calendar ID %s');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['reset']  = array('Reset availability calendar', 'Reset availability calendar ID %s');

?>
