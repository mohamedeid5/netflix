@if(session('success'))

	<script type="text/javascript">
		new Noty({

			type: 'alert',
			layout: 'topRight',
			text: "{{ session('success') }}",
			timeout: 2000,
			killers: true

		}).show();
	</script>

@endif