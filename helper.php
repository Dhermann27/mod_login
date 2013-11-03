<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class muusaLoginHelper
{   
   static function getHalp()
   {
      $db =& JFactory::getDBO();
      $user = JFactory::getUser();
      $query = "SELECT IF(DATEDIFF(y.open, NOW())<0,1,0) zero, DATE_FORMAT(y.open, '%b %D') one, ";
      $query .= "      CONCAT(c.firstname, ' ', c.lastname) two, IF(ya.id,1,0) three, muusa_isprereg(c.id, y.year) four, ";
      $query .= "      IF(ya.roomid=0 AND muusa_getage(c.birthdate, y.year)>17,1,0) five, ";
      $query .= "      (SELECT IF(IFNULL(SUM(th.amount),0) < 0,1,0)) six ";
      $query .= "   FROM muusa_year y ";
      $query .= "   LEFT JOIN muusa_camper c ON c.email='$user->email' ";
      $query .= "   LEFT JOIN muusa_yearattending ya ON c.id=ya.camperid AND y.year=ya.year ";
      $query .= "   LEFT JOIN muusa_thisyear_charge th ON th.familyid=c.familyid AND th.chargetypeid!=1000 ";
      $query .= "   WHERE y.is_current=1"; // DEBUG
      $db->setQuery($query);
      return $db->loadRow();
   }
   
}
