// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());

Pancake = {
    toolbars: {
        basic: ["bold", "italic", "underline", "|", "h2", "h3", "h4", "|", "orderedlist", "unorderedlist"]
    },
    
    base_url: baseURL,
    site_url: siteURL
    
};

Pancake.Invoices = {
    
    add_payment_saved: true,
    
    /*
     * Shows the "Add Payment" facebox, allowing a user to enter payment details.
     * 
     * @param invoice_unique_id
     * @return true
     *
     */
    show_add_payment: function(invoice_unique_id) {
        
        if (empty(invoice_unique_id)) {
            return false;
        }
        
        $(document).bind('reveal.facebox', function() { 
            $('#facebox .not-uniform:not(.uniformized)').addClass('uniformized').uniform();
                
            $('#add_payment form').submit(function() {
                $(document).trigger('close.facebox');
                return false;
            });
                
            $('#add_payment .add_payment_button').click(function() {
                $(document).trigger('close.facebox');
                return false;
            });
        });
        $(document).bind('close.facebox', function() {
            if (!Pancake.Invoices.add_payment_saved) {
                Pancake.Invoices.add_payment_saved = true;
                var gateway = $('[name=payment-gateway]').val(),
                date = $('[name=payment-date]').val() / 1000,
                transaction_id = $('[name=payment-tid]').val(),
                fee = $('[name=transaction-fee]').val(),
                amount = $('[name=payment-amount]').val();
                Pancake.Invoices.add_payment(invoice_unique_id, gateway, date, transaction_id, fee, amount);
            }
        });
        Pancake.Invoices.add_payment_saved = false;
        jQuery.facebox({
            ajax: Pancake.base_url+'ajax/get_payment_details/'+invoice_unique_id+'/1/true'
        });
        return true;
    },
    
    /*
     * Adds a payment to an invoice.
     * 
     * @param string invoice_unique_id
     * @param string gateway (cash_m, paypal_m, etc.)
     * @param integer date (PHP UNIX Timestamp)
     * @param string transaction_id (Transaction ID, arbitrary)
     * @param float fee (Transaction Fee, arbitrary)
     * @param float amount (Payment Amount, arbitrary)
     * @return false
     *
     */
    add_payment: function(invoice_unique_id, gateway, date, transaction_id, fee, amount) {
        Pancake.Invoices.add_payment_saved = true;
        $.get(Pancake.base_url+'ajax/add_payment/'+invoice_unique_id+'/gateway-'+gateway+'/date-'+date+'/tid-'+transaction_id+'/fee-'+fee +'/amount-'+amount , function(data) {
            $('#main').load(window.location.href+' #main');
        });
    }
    
}

$('.add_payment').live('click', function() {
    Pancake.Invoices.show_add_payment($(this).data('invoice-unique-id'));
    return false;
});

function facebox_with_loading_image(url) {
    jQuery.facebox('<div style="text-align:center;padding: 40px 0;"><img src="'+$.facebox.settings.loadingImage+'"/><br /><br />'+lang_loading_please_wait+'</div>');
    jQuery.get(url, function(data) {
	jQuery.facebox(data);
    });
}

function process_import_table() {
    
    var records = [];
    
    $('#importer-table tbody tr').each(function() {
	var buffer = {};
	$(this).find('td').each(function() {
	    var field = $(this).data('field');
	    var value = $(this).data('real_value');
	    value = (value == undefined) ? '' : value;
	    
	    if (field == 'currency_id') {
		value = $(this).find('select').val();
	    }
	    
	    buffer[field] = value;
	    
	});
	
	records.push(buffer);
    });
    
    return records;
    
}

function add_hours() {
    var el = $('.invoice-block #add_hours_container').clone();
    el.find('select').removeClass('not-uniform');
    el.find('[name=add_hours_date]').addClass('datePicker');
    jQuery.facebox(el);
    return false;
}

function save_hours() {
    var add_hours = $('#facebox #add_hours_container');
    var hours = add_hours.find('[name=hours]').val();
    var date = $('#facebox .hasDatepicker').datepicker('getDate').getTime() / 1000;
    var task = add_hours.find('[name=task_id]').val();
    var notes = add_hours.find('[name=note]').val();
    var project_id = add_hours.find('.invoice-block').data('project-id');
    $.post(submit_hours_url, {
        hours: hours,
        date: date,
        task: task,
        notes: notes,
        project_id: project_id
    }, function(response) {
        window.location.reload();
    });
    $.facebox.close();
}

function submit_import() {
    $.post(submit_import_url, {'records[]': process_import_table()}, function(data) {
	
    }, 'json');
}

$('#kitchen_route').live('keyup', function() {
    var val = $('#kitchen_route').val();
    if (val == '') {
	val = 'clients';
    }
    $('.kitchen_route_explain span').html($('.kitchen_route_explain span').data('url').replace('{ROUTE}', val));
});

$('form').live('submit', function() {
    $('.hasDatepicker').each(function() {
        $(this).datepicker('getDate') !== null && $(this).val($(this).datepicker('getDate').getTime());
	
	var el = $(this);
	var old_name = el.data('old-name');
	var val = el.val();
	if (val == '') {
	    $('[name='+old_name.replace('[', '\\[').replace(']', '\\]')+'][type=hidden]').val('');
	}
    });
});

$('.more-actions').live('mouseover', function() {
    var win = $(window);
    var el = $(this).find('ul');
    var winPos = win.scrollTop() + win.height();
    var elPos = el.offset().top + el.height();

    if( winPos <= elPos ) {
	// Send it above the gear icon.
	$(this).find('ul').css('top', -$('.more-actions ul:visible').height());
	$(this).find('.gear').addClass('top-menu');
    }
});

$('.more-actions').live('mouseout', function() {
    $(this).find('ul').css('top', '28px');
    $(this).find('.gear').removeClass('top-menu');
});

$('.import-currency-selector select').live('change', function() {
    $('.import-field select').change();
});

$('.import-field select').live('change', function() {
    
    var field = $(this).val();
    
    if (field == 'na' || field == 'select') {
		return;
    }
    
    // 1. If any other fields already have been matched to this field, reset them, BUT ONLY IF THEY'RE NOT THE CURRENT ELEMENT
    
    var matched  = $('.matched-'+field);
    var this_is_matched = $(this).parents('.import-field').hasClass('matched-'+field);
    
    if (matched.length > 0) {
		if (matched.length == 1 && this_is_matched) {
		    // don't do anything.
		} else {
		    matched.each(function() {
			$(this).removeClass('matched-'+field).data('matched', '');
			$(this).find('select').val('select').change();
			$.uniform.update('.import-field select');
		    });
		}
    }
    
    var import_field = $(this).parents('.import-field');
    
    // 2. If this field has already been matched to a row, empty that row.
    if (import_field.data('matched') != undefined && import_field.data('matched') != '' && import_field.data('matched') != 'currency_id') {
	$('table.records td.field-'+import_field.data('matched')).each(function() {
	    $(this).html('');
	});
	import_field.removeClass('matched-'+import_field.data('matched')).data('matched', '');
    }
    
    import_field.addClass('matched-'+field).data('matched', field);
    
    var original_field = import_field.data('field');
    
    $.each($('table.records td.field-'+field), function(i, obj) {
	
	obj = $(obj);
	var value = records[i][original_field];
	var real_value = value;
	var currency = obj.parents('tr').find('td.field-currency_id').find('span').html();
	
	switch (field) {
	    case 'invoice_number':
		real_value = ltrim(value, '0');
		value = '#'+real_value;
		break;
	    case 'amount':
		real_value = round(value, 2);
		value = currency+real_value;
		break;
	    case 'amount_paid':
		real_value = round(value, 2);
		value = currency+real_value;
		break;
	    case 'payment_date':
		real_value = strtotime(value);
		value = strtotime(value) == 0 ? '-' : date(php_date_format, real_value);
		break;
	    case 'date_entered':
		real_value = strtotime(value);
		value = strtotime(value) == 0 ? '' : date(php_date_format, real_value);
		break;
	    case 'currency_id':
		if (value.length == 3) {
		    value = value.toUpperCase();
		    real_value = value;
		    if (obj.find('[value='+value+']').length > 0) {
			obj.data('real_value', real_value);
			$(this).find('select').val(value).change();
			$.uniform.update('table.records select');
		    }
		}
		break;
	}
	
	if (field != 'currency_id') {
	    obj.html(value);
	    obj.data('real_value', real_value);
	}
    });
    
    $('table.records').show();
    
});

$(document).bind('reveal.facebox', function() {
    var new_height = $('#facebox').height() + 225;
    var height = $('#wrapper .w2').height();
    
    $('#wrapper .w2').height((new_height > height) ? new_height : height);
});

$(document).bind('close.facebox', function() {
    $('#wrapper .w2').css('height', '100%');
});

$('a.mark-as-sent').live('click', function() {
    invoice_unique_id = $(this).data('invoice-unique-id');
    $.get(baseURL+'ajax/mark_as_sent/'+invoice_unique_id, function () {$('#main').load(window.location.href+' #main');});
    return false;
});


$('a.partial-payment-details').live('click', function() {
    ppm_key = $(this).data('details');
    if ($(this).is('.more-actions .partial-payment-details')) {
	is_more_actions = true;
	invoice_unique_id = $(this).data('invoice-unique-id');
    }
    $(document).bind('reveal.facebox', function() { 
	$('#facebox .not-uniform:not(.uniformized)').addClass('uniformized').uniform();
                
	$('#partial-payment-details form').submit(function() {
	    $(document).trigger('close.facebox');
	    return false;
	});
                
	$('.savepaymentdetails').click(function() {
	    $(document).trigger('close.facebox');
	    return false;
	});
    });
    $(document).bind('close.facebox', function() {
	savePaymentDetails();
    });
    paymentDetailsSaved = false;
    jQuery.facebox({
	ajax: baseURL+'ajax/get_payment_details/'+invoice_unique_id+'/'+ppm_key
	});
    return false;
});

is_more_actions = false;
paymentDetailsSaved = false;

function savePaymentDetails() {
    if (!paymentDetailsSaved) {
        paymentDetailsSaved = true;
	
	// Change to Payment Details if is_paid, otherwise change to Mark As Paid
	if ($('[name=payment-status]').val() != '' || $('[name=payment-gateway]').val() != '') {
	    $('.partial-payment-details.invoice_'+invoice_unique_id+'.key_'+ppm_key+' span, .partial-inputs .partial-payment-details.key_'+ppm_key+' span').html(lang_paymentdetails);
	} else {
	    $('.partial-payment-details.invoice_'+invoice_unique_id+'.key_'+ppm_key+' span, .partial-inputs .partial-payment-details.key_'+ppm_key+' span').html(lang_markaspaid);
	}
	
        $.get(baseURL+'ajax/set_payment_details/'+invoice_unique_id+'/'+ppm_key+'/status-'+$('[name=payment-status]').val()+'/gateway-'+$('[name=payment-gateway]').val()+'/date-'+($('[name=payment-date]').val()/1000)+'/tid-'+$('[name=payment-tid]').val()+'/fee-'+$('[name=transaction-fee]').val() , function(data) {
            if (is_more_actions) {
		// Refresh the row.
		$('#main').load(window.location.href+' #main');
		is_more_actions = false;
	    }
        });
    }
}

function get_widest_width(elements) {
    var widest = null;
    $(elements).each(function() {
      if (widest == null)
	widest = $(this);
      else
      if ($(this).width() > widest.width())
	widest = $(this);
    });
    
    return widest.width();
}

function hide_notification(notification_id) {
    $.get(baseURL+'ajax/hide_notification/'+notification_id);
}

$('.gateway .enabled').live('click', function() {
    if ($(this).is(':checked')) {
	$(this).parents('.gateway').find('.gateway-fields').slideDown();
    } else {
	$(this).parents('.gateway').find('.gateway-fields').slideUp();
    }
});

$(function(){
    
    $('.gateway .enabled:not(:checked)').parents('.gateway').find('.gateway-fields').hide();
	
    $.fn.forceNumeric = function () {
        return this.each(function () {

            $(this).keydown(function() {$(this).data('old-val', $(this).val())}).keyup(function() {
                if ($(this).data('old-val') != $(this).val() && $(this).val().replace(/[^0-9\-\.]/g, '') != $(this).val()) {
                    $(this).val($(this).val().replace(/[^0-9\-\.]/g, ''));
                }
            });
        });
    };

	if ($.livequery != undefined) {
		
	    $("select:not(.not-uniform), textarea, input:not(.hidden-submit, .on_off), button").livequery(function () {
	        // Update uniform if enabled
	        if ($(this).attr('class') != 'tax_id')
	        {
	        	//$.uniform && $(this).uniform();
	        }
	    });
	    
	    $('label.use-label').livequery(function() {
		var placeholder = $(this).hide().html();
		var input = $('#'+$(this).attr('for')).addClass('placeholded-input');
		if (input.length != 0) {
		    var div = $('<div style="position:relative;float:left;" class="placeholded-input-container"></div>');
		    input.before(div);
		    div.append(input);
		    var placeholderel = $('<div class="placeholder">'+placeholder+'</div>');
		    input.before(placeholderel);
		    placeholderel.click(function() {$(this).siblings('.placeholded-input').focus();return false;})
		    input.css('padding-left', placeholderel.width() + 10);
		}
	    });
	    
	    $('.numeric').livequery(function() {
			$(this).forceNumeric();
		});

	    $('.colorPicker').livequery(function () {
			$(this).miniColors();
		});

    
	    $('.datePicker').livequery(function () {

			// Old name is put in data() for use by the partial payments.
			// The reason to do this is for partial payments to keep working.
			var name = $(this).data('old-name', $(this).attr('name')).attr('name');

                        var newField = $('[name='+name.replace('[', '\\[').replace(']', '\\]')+'][type=hidden]');

			if (newField.length == 0) {
				// If there's no hidden input for this datepicker yet, make one, and remove the name of the datepicker.
				var newField = $('<input type="hidden" name="'+name+'" />');
				$(this).parents('form').append(newField);
				$(this).attr('name', '');
			}
	
			$(this).datepicker({
				dateFormat: datePickerFormat,
				altFormat: '@',
				altField: newField
			});

			$(this).datepicker('getDate') !== null && newField.val($(this).datepicker('getDate').getTime());
		});
    
	} else {
	    $("select:not(.not-uniform), textarea, input:not(.hidden-submit, .on_off), button").each(function () {
	        // Update uniform if enabled
	        if ($(this).attr('class') != 'tax_id')
	        {
	                $.uniform && $(this).uniform();
	        }
	    });
	}

	$.uniform && $("select.tax_id").uniform();

	setTimeout(function() {$('.fadeable').css('overflow', 'hidden').slideUp(1000);}, 5000);

	if ($.facebox != undefined) {
		$('a[rel=facebox], a.modal').facebox();
	}
	
	
	$('.timer-button.running').each(function() {
		Tasks.continueTimer($(this));
	});

	$('.timer .timer-button').live('click', function() {		
		$(this).hasClass('running')
			? Tasks.stopTimer($(this))
			: Tasks.startTimer($(this));
	});
        
        $('.btns-list').on('click', '#add_hours', add_hours);
        $('body').on('keypress', '#facebox #add_hours_container input, #add_hours_container textarea', function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                save_hours();
            }
        });
        $('body').on('click', '#add_hours_container .submit_hours', save_hours);
	
	$('a.contact.phone, a.contact.mobile').each(function() {
		
		$link = $(this);
		
		type = $link.hasClass('phone') ? 'phone' : 'mobile';
		
		$link
			.attr('href', baseURL+'admin/clients/call/'+$(this).data('client')+'/'+type)
			.facebox();
	});
        
});

Tasks = {
	
	timer_intervals: [],

    toggleStatus: function(id)
    {
        $('#task-row-'+id).load(Pancake.site_url+'admin/projects/tasks/toggle_status/' + id + ' #task-row-'+id+' > *');
    },

    startTimer: function(button)
    {
		var timer = button.parents('.timer').addClass('running');
		button.addClass('running').html(button.data('stop'));
	
		var date = new Date();
		date.setTime(0); // Should be 0 hours.
		var time_difference = date.getHours();
		time_difference += (date.getMinutes() / 60);
		time_difference = (date.getFullYear() == 1969) ? (24 - time_difference) : -time_difference;
		time_difference = time_difference * 60 * 60 * 1000;
		
		date = new Date();
		
		timer.data('time-start', date.getTime());
		timer.data('time-difference', time_difference);
		
        $.post(Pancake.site_url+'admin/projects/times/ajax_start_timer', { 
			project_id : timer.data('project-id'),
			task_id : timer.data('task-id')
		});
		
		timer.data('interval', setInterval(function() {Tasks.updateTimer(timer)}, 1000));
    },

    continueTimer: function(button)
    {
		var date = new Date();
		date.setTime(0); // Should be 0 hours.
		var time_difference = date.getHours();
		time_difference += (date.getMinutes() / 60);
		time_difference = (date.getFullYear() == 1969) ? (24 - time_difference) : -time_difference;
		time_difference = time_difference * 60 * 60 * 1000;
		
		timer = button.parents('.timer');
		timer.data('time-difference', time_difference);
		timer.data('interval', setInterval(function() {Tasks.updateTimer(timer)}, 1000));
    },

    stopTimer: function(button)
    {
		button.removeClass('running').html(button.data('start'));
	    timer = button.parents('.timer');

		$.post(Pancake.site_url+'admin/projects/times/ajax_stop_timer', {
			project_id : timer.data('project-id'),
			task_id : timer.data('task-id')
		}, function(data) {
		    timer.find('.timer-time').text('00:00:00');

			timer.closest('tr').find('.tracked-hours').text(data.new_total_time);
		}, 'json');
	
		clearInterval(timer.data('interval'));
	},
	
	updateTimer: function (timer) {
		
	    var time_difference = timer.data('time-difference') == undefined ? 0 : timer.data('time-difference');
		
	    date = new Date();
	    date.setTime(date.getTime() - timer.data('time-start'));
	    date.setTime(date.getTime() + time_difference);
		
	    hours = date.getHours();
	    if (hours < 10) {hours = '0'+hours;}

	    minutes = date.getMinutes();
	    if (minutes < 10) {minutes = '0'+minutes;}
	
	    seconds = date.getSeconds();
	    if (seconds < 10) {seconds = '0'+seconds;}

	    timer.find('.timer-time').text(hours+':'+minutes+':'+seconds);
	}

}


function refreshTrackedHours(element) {
    var task_id = element.data('task-id');
    $.get(refreshTrackedHoursUrl+'/'+task_id, function(data) {
        element.html(data);
    });
}

$(function() {

	// Enable/Disable table action buttons
	$('input[name="action_to[]"], .check-all').live('click', function () {
		var check_all		= $(this),
			all_checkbox	= $(this).is('.grid-check-all')
				? $(this).parents(".list-items").find(".grid input[type='checkbox']")
				: $(this).parents("table").find("tbody input[type='checkbox']");

		all_checkbox.each(function () {
			if (check_all.is(":checked") && ! $(this).is(':checked'))
			{
				$(this).click();
			}
			else if ( ! check_all.is(":checked") && $(this).is(':checked'))
			{
				$(this).click();
			}
		});
	});
});