<script type="text/javascript">
	var MyTable = $('#list-data').dataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false
		});

	window.onload = function() {
		tampilPengguna();
		<?php
			if ($this->session->flashdata('msg') != '') {
				echo "effect_msg();";
			}
		?>
	}

	function myFunction() {
	  var x = document.getElementById("password");
	  if (x.type === "password") {
	      x.type = "text";
	  } else {
	      x.type = "password";
	  }
	}

	function myFunction2() {
	  var x = document.getElementById("password2");
	  if (x.type === "password") {
	      x.type = "text";
	  } else {
	      x.type = "password";
	  }
	}

	function refresh() {
		MyTable = $('#list-data').dataTable();
	}

	function effect_msg_form() {
		// $('.form-msg').hide();
		$('.form-msg').show(1000);
		setTimeout(function() { $('.form-msg').fadeOut(1000); }, 3000);
	}

	function effect_msg() {
		// $('.msg').hide();
		$('.msg').show(1000);
		setTimeout(function() { $('.msg').fadeOut(1000); }, 3000);
	}

	function tampilPengguna() {
		$.get('<?php echo base_url('Pengguna/tampil'); ?>', function(data) {
			MyTable.fnDestroy();
			$('#data-pengguna').html(data);
			refresh();
		});
	}

	var id_pengguna;
	$(document).on("click", ".konfirmasiHapus-pengguna", function() {
		id_pengguna = $(this).attr("data-id");
	})
	$(document).on("click", ".hapus-dataPengguna", function() {
		var id = id_pengguna;
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Pengguna/delete'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#konfirmasiHapus').modal('hide');
			tampilPengguna();
			$('.msg').html(data);
			effect_msg();
		})
	})

	
	$(document).on("click", ".update-dataPengguna", function() {
		var id = $(this).attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Pengguna/update'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#tempat-modal').html(data);
			$('#update-pengguna').modal('show');
		})
	})

	$('#form-tambah-pengguna').submit(function(e) {
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Pengguna/prosesTambah'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilPengguna();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-tambah-pengguna").reset();
				$('#tambah-pengguna').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$(document).on('submit', '#form-update-pengguna', function(e){
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Pengguna/prosesUpdate'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilPengguna();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-update-pengguna").reset();
				$('#update-pengguna').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$('#tambah-pengguna').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	$('#update-pengguna').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	$('.select2').select2({
	    sortResults: function(results, container, query) {
	        if (query.term) {
	            // use the built in javascript sort function
	            return results.sort(function(a, b) {
	                if (a.text.length > b.text.length) {
	                    return 1;
	                } else if (a.text.length < b.text.length) {
	                    return -1;
	                } else {
	                    return 0;
	                }
	            });
	        }
	        return results;
	    }
	});
	
	$('inputxxx').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue',
        increaseArea: '20%' // optional
    });
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    	
</script>