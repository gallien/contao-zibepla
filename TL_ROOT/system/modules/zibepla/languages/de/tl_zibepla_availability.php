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
$GLOBALS['TL_LANG']['tl_zibepla_availability']['title']  = array('Titel', 'Bitte geben Sie den Titel für den Belegungsplan ein.');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['maxMonths']  = array('Maximale Anzahl an Monaten', 'Hier können Sie die Anzahl der Monate für den Belegungsplan festlegen.');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['monthsPerRow']  = array('Monate pro Reihe', 'Die Anzahl an Monaten pro Reihe.');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['tstamp'] = array('Änderungsdatum', 'Datum und Uhrzeit der letzten Änderung');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_zibepla_availability']['title_legend'] = 'Titel';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_zibepla_availability']['deleteConfirm'] = 'Wenn Sie einen Belegungsplan löschen, werden auch alle darin enthaltenen Belegungszeiten gelöscht. Wollen Sie den Belegungsplan ID %s wirklich löschen?';
$GLOBALS['TL_LANG']['tl_zibepla_availability']['resetConfirm'] = 'Wenn Sie einen Belegungsplan zurücksetzen, werden auch alle darin enthaltenen Belegungszeiten gelöscht. Wollen Sie den Belegungsplan ID %s wirklich zurücksetzen?';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_zibepla_availability']['new']    = array('Neuer Belegungsplan', 'Einen neuen Belegungsplan anlegen');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['show']   = array('Belegungsplandetails', 'Details des Belegungsplans ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['edit']   = array('Belegungsplan bearbeiten', 'Belegungsplan ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['copy']   = array('Belegungsplan duplizieren', 'Belegungsplan ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['delete'] = array('Belegungsplan löschen', 'Belegungsplan ID %s löschen');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['item']   = array('Belegungsplan pflegen', 'Belegungsplan ID %s pflegen');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['items']  = array('Belegungsplan pflegen', 'Belegungsplan ID %s pflegen');
$GLOBALS['TL_LANG']['tl_zibepla_availability']['reset']  = array('Belegungsplan zurücksetzen', 'Belegungsplan ID %s zurücksetzen');

?>
