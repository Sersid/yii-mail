$(function(){
	var hidden = $('input[data-hidden]').parents('.control-group');
	$("#settings-radio-buttons").find('input[type=radio]').change(function(){
		if($(this).is(":checked")){
			if($(this).val() == 'smtp')
				hidden.show();
			else
				hidden.hide();
		}
	}).trigger('change')
});