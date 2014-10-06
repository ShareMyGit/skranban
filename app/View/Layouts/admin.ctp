<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Skranban
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('style');
		echo $this->Html->css('cake.generic');		
		echo $this->Html->css('ext/jquery-ui-1.11.1.custom/jquery-ui.theme.min');
		echo $this->Html->css('ext/jquery-simplecolorpicker-master/jquery.simplecolorpicker');
		echo $this->Html->css('ext/jquery-simplecolorpicker-master/jquery.simplecolorpicker-glyphicons');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');		
		
		echo $this->Html->script('ext/jquery-2.1.1.min');
		echo $this->Html->script('ext/jquery-ui-1.11.1.custom/jquery-ui.min');
		echo $this->Html->script('dragAndDrop');
		echo $this->Html->script('ext/jquery-simplecolorpicker-master/jquery.simplecolorpicker');
		echo $this->Html->script('colorPicker');
	?>
</head>
<body>
	<nav></nav>
	<header>
		<div id="menu_top">
			<?php
				echo $this->element('admin_menu');
			?>
		</div>
	</header>
	<div id="container">
		<div id="header">
			<h1>
			<?php
				echo $this->Html->link(
						'Skranban', 
						'/',
						array('escape' => false)
				);
			?>
			</h1>
			<div style="float: left;">
				<?php
					if(isset($lastProjectId)) {
						echo $this->Form->create('Page', array("class" => false));
						echo $this->element('user_projects_combobox');
						echo $this->Form->end('Select');
					}
				?>
			</div>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<footer>
	</footer>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
