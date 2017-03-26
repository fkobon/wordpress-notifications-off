<div class="debug-on-wrapper">
	<?php $debug_status = get_option( 'do_debug_status' ); ?>
	<h1>Notifications are <?php echo $debug_status;?></h1>
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
		
		<?php if($debug_status ==='activated'){
				echo 'checked: true';
			}else{
				echo 'checked: false';
			}
		?>
		});

	});
</script>