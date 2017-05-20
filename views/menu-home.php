<div class="notifications-off-wrapper">
	<?php $notifications_status = get_option( 'no_notifications_status' ); ?>
	<h1>Notifications are <?php echo $notifications_status;?></h1>
		<div class="switch-wrapper">
			<div id="switch-button"></div>
		</div>
</div>
<script type="text/javascript">
	jQuery(document).ready( function($){   

		// Initialize button switcher
		$("#switch-button").switchButton({
			width: 100,
			height: 40,
			button_width: 70,
		
		<?php if($notifications_status ==='on'){
				echo 'checked: true';
			}else{
				echo 'checked: false';
			}
		?>
		});

	});
</script>