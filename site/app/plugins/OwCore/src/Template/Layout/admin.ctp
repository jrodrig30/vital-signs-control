<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php __('OneWeb:'); ?> <?= $this->fetch('title') ?></title>
	<?php
		echo $this->Html->meta('icon');
                echo $this->Html->charset('UTF-8');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('cake.oneweb');
                echo $this->Html->css('admin');
                
                echo $this->Html->css('OwCore.superfish.css');
                echo $this->Html->css('OwCore.superfish-vertical.css');
                echo $this->Html->css('OwCore.menu.css');
                
                echo $this->Html->script('jquery.min.js');
                echo $this->Html->script('OwCore.superfish.js');
                echo $this->Html->script('OwCore.menu.js');
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    <script>
    window.URL_BASE = '<?php echo $this->Url->build('/') ?>';
    </script>
</head>
<body>
	<div id="container">
		<div id="header">
                    <?php 
                    echo $this->element('OwCore.menu');
                    ?>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					'OneWeb',
					'http://www.oneweb.com.br/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
</body>
</html>