<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');

require_once dirname(__FILE__).'/helper.php';
$data = muusaLoginHelper::getHalp();
?>
<?php if ($type == 'logout') : ?>
<form
   action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>"
   method="post" id="login-form">
   <?php if ($params->get('greeting')) :
   echo "   <div class='login-greeting'>\n";
   if($data[0]) {       // Registration is open
      if($data[3]) {    // Camper is registered
         // TODO: Add Workshop Logic
         if($data[5]) { // Camper balance without housing fees less than 0
            $gradientColor = "pink";
            $imagename = "owemoney";
            $direction =  "      Click the link above to remit payment via PayPal.\n";
         } else if($data[5]) { // Camper is over 17 and has no room assigned
            $gradientColor = "yellow";
            $imagename = "noroom";
            $direction =  "      Click the link above to select a room.\n";
         } else {
            $gradientColor = "lightgreen";
            $imagename = "ready";
            $direction =  "      You are ready for camp!\n";
         }
      } else {          // Camper is not registered
         $gradientColor = "darkgray";
         $imagename = "register";
         $direction =  "      Click the link above to register now.\n";
      }
   } else {            // Registration has not begun
      if($data[4]) {   // Camper is preregistered
         $gradientColor = "rgba(117, 167, 0, 0.9)";
         $imagename = "prereg";
         $direction =  "      <b>You are preregistered for camp</b>! Check back $data[1] for priority registration.\n";
      }else {
         $gradientColor = "lightgray";
         $imagename = "nostarted";
         $direction =  "      Check back $data[1] to register for camp.\n";
      }
   }
   if($data[2]) {      // Camper was recognized
      $namerow = "      Hello, $data[2].<br />\n";
   } else {            // Camper is new
      $imagename = "new";
      $namerow = "      Welcome to MUUSA!<br />\n";
   }
   echo  "      <div style='float:right;position:relative;right:45px;margin-top:-80px;'><img src='images/muusa/$imagename.png' style='position:absolute' /></div>\n";
   echo $namerow . $direction . "<br />\n";
   echo "   </div>\n";
   endif; ?>
   <div class="logout-button">
      <input type="submit" name="Submit" class="button"
         value="<?php echo JText::_('JLOGOUT'); ?>" /> <input
         type="hidden" name="option" value="com_users" /> <input
         type="hidden" name="task" value="user.logout" /> <input
         type="hidden" name="return" value="<?php echo $return; ?>" />
      <?php echo JHtml::_('form.token'); ?>
   </div>
</form>
<?php else : ?>
<form
   action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>"
   method="post" id="login-form">
   <?php if ($params->get('pretext')): ?>
   <div class="pretext">
      <p>
         <?php echo $params->get('pretext'); ?>
      </p>
   </div>
   <?php endif; ?>
   <fieldset class="userdata">
      <p id="form-login-username">
         <label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>
         </label> <input id="modlgn-username" type="text"
            name="username" class="inputbox" size="18" />
      </p>
      <p id="form-login-password">
         <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?>
         </label> <input id="modlgn-passwd" type="password"
            name="password" class="inputbox" size="18" />
      </p>
      <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
      <p id="form-login-remember">
         <label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?>
         </label> <input id="modlgn-remember" type="checkbox"
            name="remember" class="inputbox" value="yes" />
      </p>
      <?php endif; ?>
      <input type="submit" name="Submit" class="button"
         value="<?php echo JText::_('JLOGIN') ?>" /> <input
         type="hidden" name="option" value="com_users" /> <input
         type="hidden" name="task" value="user.login" /> <input
         type="hidden" name="return" value="<?php echo $return; ?>" />
      <?php echo JHtml::_('form.token'); ?>
   </fieldset>
   <ul>
      <li><a
         href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?>
      </a>
      </li>
      <li><a
         href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?>
      </a>
      </li>
      <?php
      $usersConfig = JComponentHelper::getParams('com_users');
      if ($usersConfig->get('allowUserRegistration')) : ?>
      <li><a
         href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
            <?php echo JText::_('MOD_LOGIN_REGISTER'); ?>
      </a>
      </li>
      <?php endif; ?>
   </ul>
   <?php if ($params->get('posttext')): ?>
   <div class="posttext">
      <p>
         <?php echo $params->get('posttext'); ?>
      </p>
   </div>
   <?php endif; ?>
</form>
<?php endif; ?>
<script>
      var gradientString = "\/* Mozilla Firefox */ background-image: -moz-linear-gradient(right, <?php echo $gradientColor; ?> 0%, rgba(255, 255, 255, 0) 50%);\
          /* Opera */ background-image: -o-linear-gradient(right, <?php echo $gradientColor; ?> 0%, rgba(255, 255, 255, 0) 50%);\
          /* Webkit (Safari/Chrome 10) */ background-image: -webkit-gradient(linear, right, left, color-start(0, <?php echo $gradientColor; ?>), color-stop(.5, rgba(255, 255, 255, 0)));\
          /* Webkit (Chrome 11+) */ background-image: -webkit-linear-gradient(right, <?php echo $gradientColor; ?> 0%, rgba(255, 255, 255, 0) 50%);\
          /* IE10+ */ background: -ms-linear-gradient(right,  <?php echo $gradientColor; ?> 0%, rgba(255, 255, 255, 0) 50%);\
          /* W3C */ background: linear-gradient(right,  <?php echo $gradientColor; ?> 0%, rgba(255, 255, 255, 0) 50%); color: #000";
      var form = document.getElementById("login-form").parentElement;
      form.setAttribute('style', form.getAttribute('style') + '; ' + gradientString);
      form.parentElement.style.paddingBottom = "10px";
</script>
