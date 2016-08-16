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
 * Class Availability
 *
 * @copyright  Seleos UG (haftungsbeschränkt)
 * @author     Andreas Gallien
 * @package    Availability
 */
class AvailabilityCalendar
{
    protected $items = array();

    function __construct()
    {
    }

    public function initialize()
    {
	$item = array();
	$item['startDate'] = strtotime('2000-01-01');
	$item['endDate'] = strtotime('2037-12-31') - 1;
	$item['status'] = 'F';
	$this->addItem($item);
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addItems($items) {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function addItem($item)
    {
	$update = false;
	$count = count($this->items);
	for ($i = 0; $i < $count; $i++) {
	    if ($item['startDate'] <= $this->items[$i]['startDate'] &&
		$item['endDate'] >= $this->items[$i]['endDate']) {
		unset($this->items[$i]);

	    } else if ($item['startDate'] > $this->items[$i]['startDate'] &&
		       $item['endDate'] < $this->items[$i]['endDate']) {
		if ($item['status'] != $this->items[$i]['status']) {
		    $newItem = $this->items[$i];
		    $newItem['startDate'] = $item['endDate'] + 1;
		    $newItem['endDate'] = $this->items[$i]['endDate'];
		    $this->items[] = $newItem;
		    $this->items[$i]['endDate'] = $item['startDate'] - 1;
		    $this->items[] = $item;
		}
		$update = true;

	    } else if ($item['startDate'] >= $this->items[$i]['startDate'] &&
		       $item['startDate'] <= ($this->items[$i]['endDate'] + 1) &&
		       $item['endDate'] >= $this->items[$i]['endDate']) {
		if ($item['status'] == $this->items[$i]['status']) {
		    if(! $update) {
			$this->items[$i]['endDate'] = $item['endDate'];
		    } else {
			unset($this->items[$i]);
		    }
		} else {
		    $this->items[$i]['endDate'] = $item['startDate'] - 1;
		    if(! $update) {
			$this->items[] = $item;
		    }
		}
		$update = true;

	    } else if ($item['endDate'] <= $this->items[$i]['endDate'] &&
		       ($item['endDate'] + 1) >= $this->items[$i]['startDate'] &&
		       $item['startDate'] <= $this->items[$i]['startDate']) {
		if ($item['status'] == $this->items[$i]['status']) {
		    if(! $update) {
			$this->items[$i]['startDate'] = $item['startDate'];
		    } else {
			unset($this->items[$i]);
		    }
		} else {
		    $this->items[$i]['startDate'] = $item['endDate'] + 1;
		    if(! $update) {
			$this->items[] = $item;
		    }
		}
		$update = true;
	    }
	}
	if (! $update) {
	    $this->items[] = $item;
	}
	$this->items = array_values($this->items);
	usort($this->items, array($this, 'sort'));
    }

    public function date2days($tstamp = false)
    {
	$date = ($tstamp === false) ? getdate() : getdate($tstamp);
	$day = $date['mday'];
	$month = $date['mon'];
	$year = $date['year'];

	$century = (int) substr($year, 0, 2);
	$year = (int) substr($year, 2, 2);
	if ($month > 2) {
	    $month -= 3;
	} else {
	    $month += 9;
	    if ($year) {
		$year--;
	    } else {
		$year = 99;
		$century --;
	    }
	}

	return (floor((146097 * $century) / 4) +
		floor((1461 * $year) / 4) +
		floor((153 * $month + 2) / 5) +
		$day + 1721119);
    }

    public function days2date($days)
    {
	$days -= 1721119;
	$century = floor((4 * $days - 1) / 146097);
	$days = floor(4 * $days - 1 - 146097 * $century);
	$day = floor($days / 4);

	$year = floor((4 * $day +  3) / 1461);
	$day = floor(4 * $day +  3 - 1461 * $year);
	$day = floor(($day +  4) / 4);

	$month = floor((5 * $day - 3) / 153);
	$day = floor(5 * $day - 3 - 153 * $month);
	$day = floor(($day +  5) /  5);

	if ($month < 10) {
	    $month +=3;
	} else {
	    $month -=9;
	    if ($year++ == 99) {
		$year = 0;
		$century++;
	    }
	}

	$century = sprintf('%02d', $century);
	$year = sprintf('%02d', $year);
	$year = $century.$year;

	return mktime(0, 0, 0, $month, $day, $year);
    }

    public function getCalendar($months, $months_per_column, $cw = false, $edit = false)
    {
	$months = empty($months) ? 16 : $months;
	$months_per_column = empty($months_per_column) ? 4: $months_per_column;

	$weekday = array();
	for ($i = 0; $i < 7; $i++) {
	    $day = mktime(0, 0, 0, 1, $i + 1, 2000);
	    $day_name = $GLOBALS['TL_LANG']['ZIBEPLA']['DAYS'][date('w', $day)];
	    $day_of_week = date('N', $day);
	    $weekday[$day_of_week - 1] = utf8_substr($day_name, 0, 2);
	}

	$this->convertItems();

	$out = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"cal\">\n";

	$last_status = 'F';
	$days_today = $this->date2days();
	$start_month = date('n');
	$year = date('Y');
	$start_day = $this->date2days(mktime(0, 0, 0, $start_month, 1, $year));
	for ($m = 0; $m < $months; $m++) {
	    $month = ($start_month - 1 + $m) % 12;
	    if ($month == 0 && $m > 0) {
		$year++;
	    }

	    $ts_month = mktime(0, 0, 0, $month + 1, 1, $year);
	    $title = $GLOBALS['TL_LANG']['ZIBEPLA']['MONTHS'][$month] . ' ' . date('Y', $ts_month);
	    $calendar_week = date('W', $ts_month);
	    $days = date('t', $ts_month);
	    $before = (date('w', $ts_month) + 6) % 7;
	    $after = (7 - ($before + $days) % 7) % 7;

	    if ($m % $months_per_column == 0) {
		$out .= "<tr>\n";
	    }

	    $out .= "<td valign=\"top\">\n".
		    "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"table\">\n".
		    "<tr><td colspan=\"".($cw != false ? 8 : 7)."\" class=\"month\">".$title."</td></tr>\n".
		    "<tr>\n";

	    if ($cw != false) {
		 $out .= "<td class=\"cw\">".$cw."</td>\n";
	    }

	    for ($i = 0; $i < 7; $i++) {
		$out .= "<td class=\"day\">".$weekday[$i]."</td>\n";
	    }

	    $out .= "</tr>\n";

	    for($cell = 0; $cell < ($before + $days + $after); $cell++) {
		if ($cell % 7 == 0) {
		    /* Schreibt die Spalte mit der Kalenderwoche oder eine
		     * normale Spalte. */
		    if ($cw != false) {
			$out .= "<tr>\n";
			$out .= "<td class=\"week left\">".$calendar_week."</td>\n";
			$calendar_week++;
		    } else {
			$out .= "<tr class=\"".($edit ? 'login' : 'basic')."\">\n";
		    }
		}

		$class = 'n';
		$content = ' ';

		if ($cell >= $before && $cell < ($before + $days)) {
		    /* Ermittelt den Status und setzt entsprechend die
		     * Farbe der Zelle. */
		    $day = $cell - $before + 1;
		    $status = $this->getStatus($start_day);
		    /* In der Frontansicht werden überlappende Tage
		     * dargestellt. */
		    if ($status == 'F') {
		        switch ($last_status) {
		            case 'O':
		                $class = 'of';
		                break;
		            case 'R':
		                $class = 'rf';
		                break;
		            default:
		                $class = 'f';
		                break;
		        }
		    } else if ($status == 'O' || $status == 'B') {
		        switch ($last_status) {
		            case 'F':
		                $class = 'fo';
		                break;
		            case 'R':
		                $class = 'ro';
		                break;
		            default:
		                $class = 'o';
		                break;
		        }
                    } else if ($status == 'R') {
		        switch ($last_status) {
		            case 'F':
		                $class = 'fr';
		                break;
		            case 'O':
		                $class = 'or';
		                break;
		            default:
		                $class = 'r';
		                break;
		        }
		    } else {
			$class = 'n';
		    }
		    $content = $day;
		    if ($edit) {
			$checked = ($status != 'F') ? ' checked="checked"' : '';
			if ($start_day < $days_today || $status == 'U' || $status == 'B') {
			    $checked .= ' disabled="disabled"';
			}
			$content .= '<br /><input type="checkbox" name="occupied[]" value="'.$start_day.'"'.$checked.' />';
		    }
		    $start_day++;
		    $last_status = $status;
		}

		if ($cell % 7 == 0 && $cw == false) {
		    $class .= ' left';
		}
		$out .= "<td class=\"".$class."\">".$content."</td>\n";

		if($cell % 7 == 6 && $cell != $days) {
		    $out .= "</tr>\n";
		}
	    }
	    $out .= "</table>\n</td>\n";

	    if ($m % $months_per_column == $months_per_column - 1) {
		$out .= "</tr>\n";
	    }
	}
	$out .= "</table>\n";

	return $out;
    }

    private function isOccupied($startDate, $endDate)
    {
	$occupied = false;

	foreach ($this->items as $item) {
	    if ($item['status'] == 'O' &&
		(($startDate >= $item['startDate'] && $startDate <= $item['endDate']) ||
		 ($endDate >= $item['startDate'] && $endDate <= $item['endDate']) ||
		 ($startDate < $item['startDate'] && $endDate > $item['endDate']))) {
		$occupied = true;
		break;
	    }
	}

	return $occupied;
    }

    private function getStatus($days)
    {
	$status = 'U';

	foreach ($this->items as $item) {
	    if ($days >= $item['startDays']) {
		$status = $item['status'];
	    }
	}

	return $status;
    }

    private function convertItems()
    {
	foreach ($this->items as &$item) {
	    $item['startDays'] = $this->date2days($item['startDate']);
	}
    }

    private function sort($item1, $item2)
    {
       if ($item1['endDate'] < $item2['endDate']) {
	    return -1;
       } else if ($item1['endDate'] > $item2['endDate']) {
	    return 1;
       }

       return 0;
    }
}

?>
