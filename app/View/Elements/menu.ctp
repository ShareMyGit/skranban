<ul class="menu_links">
	<li class="home_button">
		<?php
			echo $this->Html->link(
					'Home', 
					'/',
					array('escape' => false)
			);
		?>
	</li>

<?php
?>
	<li>
		<?php
			echo $this->Html->link('Users', 
					array('controller' => 'users', 
						'action' => 'index',
						'plugin' => null, 
						'admin' => false),
					array()
				);
		?>
	</li>
	<li>
		<?php
			echo $this->Html->link('Projects', 
					array('controller' => 'projects', 
						'action' => 'index',
						'plugin' => null, 
						'admin' => false),
					array()
				);
		?>
	</li>
	<li class="home_button_end">
		<?php
			echo $this->Html->link($this->Html->image('controls/logon.png', 
										array('alt' => 'Login', 
											'border' => 'none', 
											'title' => 'Login', 
											'height' => '15', 
											'width' => '15')),
										array('controller' => 'users', 'action' => 'login', 'plugin' => null), 
										array('escape' => false)
									);
		?>
	</li>
</ul>
