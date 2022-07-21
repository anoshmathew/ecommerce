<!-- jQuery -->
<script src="<?=URLAD?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=URLAD?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=URLAD?>dist/js/adminlte.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=URLAD?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- bs-custom-file-input -->
<script src="<?=URLAD?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
		function click_button(id)
		{
			//alert(id);
			if(id==1)
			{
				$('.hide_div').hide();
				$('#adddiv').show();
			}
			if(id==2)
			{
				$('.hide_div').hide();
				$('#srdiv').show();
			}
		}
		</script>