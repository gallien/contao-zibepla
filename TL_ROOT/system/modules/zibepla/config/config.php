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
 * Add back end modules
 */
array_insert($GLOBALS['BE_MOD']['content'], 3, array
(
    'availability' => array
    (
	'tables'       => array('tl_zibepla_availability', 'tl_zibepla_availability_item'),
	'icon'         => 'system/modules/zibepla/html/icon.gif',
	'stylesheet'   => 'system/modules/zibepla/html/style.css'
    )
));

/**
 * Add content elements
 */
array_insert($GLOBALS['TL_CTE'], 4, array
(
	'availabilities' => array
	(
		'availability' => 'ContentAvailability'
	)
));

?>
