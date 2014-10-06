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
						'admin' => true),
					array()
				);
		?>
	</li>
	<li>
		<?php
			echo $this->Html->link('My projects', 
					array('controller' => 'projects', 
						'action' => 'index',
						AuthComponent::user('id'), 
						'admin' => true),
					array()
				);
		?>
	</li>
	<li>
		<?php
			echo $this->Html->link($this->Html->image('controls/man.png', 
										array('alt' => 'My account', 
											'border' => 'none', 
											'title' => 'My account', 
											'height' => '15', 
											'width' => '15')), 
										array('controller' => 'users', 'action' => 'view', 'admin' => true, AuthComponent::user('id')), 
										array('escape' => false));
		?>
	</li>
	<li class="home_button_end">
		<?php
			echo $this->Html->link($this->Html->image('controls/logout.png', 
										array('alt' => 'Logout', 
											'border' => 'none', 
											'title' => 'Logout', 
											'height' => '15', 
											'width' => '15')), 
										array('controller' => 'users', 'action' => 'logout', 'plugin' => null), 
										array('escape' => false));
		?>
	</li>
</ul>
