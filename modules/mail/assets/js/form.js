$(function(){
	var form = $('#template-form'),
		hidden = form.find("input[data-hidden], select[data-hidden]"),
		radioButtons = $('#template-radio-buttons').find('input[type=radio]'),
		bodyTextarea = $('#template-body-textarea'),
		bodyTextareaName = bodyTextarea.attr("name"),
		bodyRedactor = $('#template-body-redactor').parents(".redactor_box"),
		pseudo = $("#template-show-hidden"),
		eventsSelect = $("#template-events"),
		manualBox = $("#template-ajax-manual");

	radioButtons.change(function(){
		if($(this).is(':checked')){
			if($(this).val() == '2'){
				bodyTextarea.attr('name', bodyTextareaName);
				bodyTextarea.show();
				bodyRedactor.hide();
			}else{
				bodyTextarea.attr('name', '');
				bodyTextarea.hide();
				bodyRedactor.show();
			}
		}	
	}).trigger('change');
	
	var hTotal = 0,
		hShown = 0;
	hidden.each(function(){
		hTotal++;
		if($(this).is('input') && $(this).val().length){
			hShown++;
		}else if($(this).is('select') && $(this).val() != '0'){
			hShown++;
		}else{
			$(this).parents(".control-group").hide();
		}
	});
	if(hShown == hTotal){
		pseudo.parents(".control-group").hide();
	}
	pseudo.click(function(e){
		e.preventDefault();
		$(this).parents(".control-group").hide();
		hidden.parents(".control-group").show();
	});
	
	eventsSelect.change(function(){
		manualBox.html();
		var val = $(this).val();
		if(val.length){
			$.ajax({
				url: $(this).data('manual-url'),
				data : {id:val},
				success: function(data){
					manualBox.html(data);
				}
			});
		}
	}).trigger('change');
});