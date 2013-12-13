<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 snowflake productions gmbh <support@snowflake.ch>
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
 ***************************************************************/

/**
 *
 * @author    Thomas Petersen <support@snowflake.ch>
 *
 */

class Sort
{


	/**
	 * public function getOutput()
	 * {
	 * if ($_POST['units'] == 'units=metric') {
	 * $formatTemp = 'C';
	 * $formatWind = 'kmh';
	 * } else {
	 * $formatTemp = 'F';
	 * $formatWind = 'mph';
	 * }
	 *
	 * $unit = date('U d/m/y @ H:m');
	 * //$unit = '<table><tr><td>Time:</td><td>' . date('Y-m-d') . '</td></tr>';
	 * $unit .= '<table><tr><td>Latitude:</td><td>' . $this->readJSONFile()->coord->lat . '&deg</td></tr>';
	 * $unit .= '<tr><td>Longitude:</td><td>' . $this->readJSONFile()->coord->lon . '&deg</td></tr>';
	 * $unit .= '<tr><td>City:</td><td>' . $this->readJSONFile()->name.', ' . $this->readJSONFile()->sys->country . '</td></tr>';
	 * //$unit .= '<tr><td>Description:</td><td>' . $this->readJSONFile()->weather->main . '</td></tr>';
	 * $unit .= '<tr><td>Temperature:</td><td>' . $this->readJSONFile()->main->temp . '&deg' . $formatTemp . '</td></tr>';
	 * $unit .= '<tr><td>Min Temperature:</td><td>' . $this->readJSONFile()->main->temp_min . '&deg' . $formatTemp . '</td></tr>';
	 * $unit .= '<tr><td>Max Temperature:</td><td>' . $this->readJSONFile()->main->temp_max . '&deg' . $formatTemp . '</td></tr>';
	 * $unit .= '<tr><td>Humidity:</td><td>' . $this->readJSONFile()->main->humidity .  '%</td></tr><br>';
	 * $unit .= '<tr><td>Wind:</td><td>' . number_format($this->readJSONFile()->wind->speed, 1) . ' ' . $formatWind . '</td></tr></table><br>';
	 * return $unit;
	 * }
	 *
	 *
	 *
	 *
	 *
	 * $unit = date('U d/m/y @ H:m');
	 * //$unit = "<table><tr><td>Time:</td><td>" . date('Y-m-d') . "</td></tr>";
	 * $unit .= "<table><tr><td>Latitude:</td><td>" . $this->readJSONFile()->coord->lat . "&deg</td></tr>";
	 * $unit .= "<tr><td>Longitude:</td><td>" . $this->readJSONFile()->coord->lon . "&deg</td></tr>";
	 * $unit .= "<tr><td>City:</td><td>" . $this->readJSONFile()->name.", " . $this->readJSONFile()->sys->country . "</td></tr>";
	 * //$unit .= "<tr><td>Description:</td><td>" . $this->readJSONFile()->weather->main . "</td></tr>";
	 * $unit .= "<tr><td>Temperature:</td><td>" . $this->readJSONFile()->main->temp . "&deg" . $formatTemp . "</td></tr>";
	 * $unit .= "<tr><td>Min Temperature:</td><td>" . $this->readJSONFile()->main->temp_min . "&deg" . $formatTemp . "</td></tr>";
	 * $unit .= "<tr><td>Max Temperature:</td><td>" . $this->readJSONFile()->main->temp_max . "&deg" . $formatTemp . "</td></tr>";
	 * $unit .= "<tr><td>Humidity:</td><td>" . $this->readJSONFile()->main->humidity .  "%</td></tr><br>";
	 * $unit .= "<tr><td>Wind:</td><td>" . number_format($this->readJSONFile()->wind->speed, 1) . " " . $formatWind . "</td></tr></table><br>";
	 * return $unit;
	 */
}
