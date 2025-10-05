$().ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

	$(".ctrl1").unbind("click").on('click', function(){
		if($("#floatingPassword").attr('type') == 'password') {
			$(this).addClass('view');
			$(this).html('hide');
			$('#floatingPassword').attr('type', 'text');
		}
		else {
			$(this).removeClass('view');
			$(this).html('show');
			$('#floatingPassword').attr('type', 'password');
		}
		return false;
	});

	$(".ctrl2").unbind("click").on('click', function(){
		if($(".floatingPassword2").attr('type') == 'password') {
			$(this).addClass('view');
			$(this).html('hide');
			$('.floatingPassword2').attr('type', 'text');
		}
		else {
			$(this).removeClass('view');
			$(this).html('show');
			$('.floatingPassword2').attr('type', 'password');
		}
		return false;
	});

	// If input is invalid, label is invalid also
	$('.is-invalid').next('label').addClass('label-floating-invalid');

	// For User Details Form. If input is empty, the border is red
	var form = $('#formUserDetails');
	if (form.length > 0) {
		form.find('input').each(function() {
			if ($(this).val() === '') {
				$(this).addClass('is-invalid');
			}
			$(this).on('input', function() {
				if ($(this).val() === '') {
					$(this).addClass('is-invalid');
				} else {
					$(this).removeClass('is-invalid');
				}
			});
		});
	}


});
