<?php
$ow_menu = $this->requestAction('/ow_core/menus/request_menus');
echo $this->MenuHelp->getHTMLMenu($ow_menu); 
?>
<div class="clear"></div>