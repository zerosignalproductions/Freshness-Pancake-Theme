function getRemainingAmount() {
    
    var amount = 0;
    
    if ($('[name=type]:checked').val() != "SIMPLE") {
        $('#invoice-items .details').each(function() {
            var el = $(this);
            var qty = el.find('.item_quantity').val();
            var rate = el.find('.item_rate').val();
            var tax = el.find('.tax_id option:selected').html();
            tax = parseFloat(GetBetween(tax, '(', '%)'));
            tax = tax / 100;
            if (tax > 0) {
                tax = ((qty * rate) * tax);
            } else {
                tax = 0;
            }
            amount = amount + (qty * rate) + tax;
        });
    } else {
        amount = parseFloat($('[name=amount]').val());
    }
        
    var amount_left = amount;
    
    $('.partial-inputs').each(function() {
        var val = $(this).find('input.partial-amount').val();
        var is_percentage = $(this).find('.partial-percentage select').val();
       
        if (is_percentage == '1') {
            amount_left = amount_left - (amount * (val / 100));
        } else {
            if (amount == 0) {
                amount_left = 0;
                return;
            } else {
                amount_left = amount_left - val;
            }
        }
    });
    
    if (amount_left.toFixed(2) == 0.00) {
        return 0;
    }
    
    return amount_left;
            
}
function fix_item_cost_width() {
    $('span.item_cost').css('width', 'auto');
    var width = get_widest_width('span.item_cost');
    $('span.item_cost').css({
        display: 'block'
    }).width(width);
    $('#invoice-items th:nth-child(5)').width(width + 30);
}

function hideMultiparts() {
    $('.partial-addmore a span').html($('.partial-addmore a').data('disabled'));
    $('.partial-addmore a').addClass('disabled');
    
    if ($('.partial-inputs').length > 1) {
        $('.partial-inputs:not(:first-child)').slideUp();
        $('.partial-inputs:first-child .partial-amount').data('old-value', $('.partial-inputs:first-child .partial-amount').val()).val(100);
        $('.partial-inputs:first-child .partial-percentage select').data('old-value', $('.partial-inputs:first-child .partial-percentage select').val()).val(1);
        $('.partial-inputs:first-child .partial-percentage .selector span').html($('.partial-inputs:first-child .partial-percentage select option:selected').html());
    }
}

function GetBetween($content, $start, $end) {
    var $r = explode($start, $content);
    if (!empty($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

function updatePaymentPlanTotals() {
    var invoice_type = $('[name=type]:checked').val();
    var amount = $('[name=amount]').val();
    amount = (amount == '') ? 0 : parseFloat(amount);
    // Fetch items and calculate their amounts.
        
    amount = 0;
        
    if (invoice_type != "SIMPLE") {
        $('#invoice-items .details').each(function() {
            var el = $(this);
            var qty = el.find('.item_quantity').val();
            var rate = el.find('.item_rate').val();
            var tax = el.find('.tax_id option:selected').html();
            tax = parseFloat(GetBetween(tax, '(', '%)'));
            tax = tax / 100;
            if (tax > 0) {
                tax = ((qty * rate) * tax);
            } else {
                tax = 0;
            }
            amount = amount + (qty * rate) + tax;
        });
    } else {
        amount = parseFloat($('[name=amount]').val());
    }
        
    var el = $('.payment-plan-amounts');
    el.find('.difference .value').html(amount.toFixed(2));
    //amountlefttobeadded
    var remaining = getRemainingAmount();
    if (remaining != 0) {
        el.find('.amount_left').addClass('remaining');
        el.find('.amount_left').html("<span class='label'>"+el.find('.amount_left').data(remaining > 0 ? 'amountlefttobeadded': 'amounttoobig')+"</span>: <span class='symbol'>"+el.find('.amount_left').data('symbol')+"</span><span class='value'></span>");
    } else {
        el.find('.amount_left').removeClass('remaining');
        el.find('.amount_left').html(el.find('.amount_left').data('noamountneeded'));
    }
    el.find('.amount_left .value').html(Math.abs(remaining).toFixed(2));
    
}

function showMultiparts() {
    $('.partial-addmore a span').html($('.partial-addmore a').data('enabled'));
    $('.partial-addmore a').removeClass('disabled');
    
    if ($('.partial-inputs').length > 1 && $('.partial-inputs:first-child .partial-amount').data('old-value') != undefined) {
        $('.partial-inputs:not(:first-child)').slideDown();
        $('.partial-inputs:first-child .partial-amount').val($('.partial-inputs:first-child .partial-amount').data('old-value'));
        $('.partial-inputs:first-child .partial-percentage select').val($('.partial-inputs:first-child .partial-percentage select').data('old-value'));
        $('.partial-inputs:first-child .partial-percentage .selector span').html($('.partial-inputs:first-child .partial-percentage select option:selected').html());
    }
}

$('.partial-payment-delete').live('click', function() {
    $(this).parents('.partial-inputs').slideUp(function() {
        $(this).remove();
        updatePaymentPlanTotals();
    });
    return false;
});

$('#invoice-items .delete').live('click', function() {
    if ($(this).parents('table:first').parents('tbody').children('tr').length > 1) {
        $(this).parents('table:first').parents('tr:first').fadeOut(function() {
            $(this).remove();
            updatePaymentPlanTotals();
        });
    }
    return false;
});


$(function(){
    fix_item_cost_width();
    if ($('.partial-payment-details').length == 0) {
        $('div.partial-inputs .partial-notes').width(470);
    }
	
    $('.partial-payment-delete:first').hide();
    
    currentSymbol = '';
    
    $('#currency').change(function() {
        currentSymbol = $(this).find(':selected').data('symbol');
        $('.partial-percentage option[value=0]').html(currentSymbol);
        $('.partial-percentage .selector').each(function() {
            if ($(this).find('select').val() == 0) {
                $(this).find('span').html(currentSymbol);
            }
        });
    });
    
    $('select[name^=partial-is_percentage]').change(function() {
        updatePaymentPlanTotals();
    });
        
    $('input.partial-amount').livequery(function() {
        $(this).forceNumeric();
    });
    
    $('#is_recurring').change(function() {
        if ($(this).val() == '1') {
            // This invoice is recurring, partial payments are disabled.
            hideMultiparts();
        } else {
            // This invoice is NOT recurring, partial payments are enabled.
            showMultiparts();
        }
    });
        
    $('.partial-addmore a').click(function() {
        if (!$(this).is(':disabled')) {
            // Button is not disabled, let's create another row for partial payments.
                
            newLength = ($('.partial-inputs').length + 1);
            // Destroy the first date picker, then rebuild it after cloning.
            $('.partial-inputs:first-child .datePicker').datepicker('destroy');
            newPartial = $('.partial-inputs:first-child').clone();
            newPartial.find('.datePicker').attr('name', 'partial-due_date'+'['+newLength+']').datepicker('destroy');
            // Set the new name, then call datepicker again.
            $('.partial-inputs:first-child .datePicker').each(function() {
                $(this).datepicker({
                    dateFormat: datePickerFormat, 
                    altFormat: '@',
                    altField: $('[name='+$(this).data('old-name').replace('[', '\\[').replace(']', '\\]')+']')
                });
            });
		
            newPartial.find('a').data('details', newLength).removeClass('key_1').addClass('key_'+newLength);
            newPartial.find('.partial-payment-details span').html($('.partial-input-container').data('markaspaid'));
            newPartial.find('input:not([type=checkbox])').val('');
            var remaining_amount = getRemainingAmount();
            remaining_amount = remaining_amount < 0 ? 0 : round(remaining_amount, 2);
            newPartial.find('input.partial-amount').val(remaining_amount);
            newPartial.find('input[type=checkbox]:checked').click();
            newPartial.find('input:not(.datePicker), select').each(function() {
                $(this).attr('name', $(this).attr('name').replace('[1]', '['+ newLength +']'))
            });
            select = newPartial.find('select');
            check = newPartial.find('input[type=checkbox]');
                
            check.attr('id', check.attr('id') + newLength);
            select.attr('id', select.attr('id') + newLength);
            select.val(0);
		
            newPartial.find('input[type=text]').each(function() {
                $(this).attr('id', $(this).attr('id') + newLength);
            });
                
            $(newPartial).find('.partial-percentage > .selector').replaceWith(select);
                
            $(newPartial).find('.checker').replaceWith(check);
            $(newPartial).find('.partial-payment-delete').show();
            newPartial.hide().appendTo('.partial-input-container');
            $('.partial-input-container *:hidden').slideDown('normal');
            $('.partial-payment-delete:first').hide();
            updatePaymentPlanTotals();
            return false;
                
        }
    });
        
    
    // Select wether its an invoice or payment request
    $('input[name=type]').live('change', function(){
        type = this.value;

        $('.type-wrapper').hide();
        if (type == 'ESTIMATE')
        {
            $('.hide-estimate').hide();
            type = 'DETAILED';
        }
        else
        {
            $('.hide-estimate').show();
        }

        $('#' + type + '-wrapper').show();
    });

    if( $('input[name=type]:checked').length == 0 )
    {
        $('input[name=type][value=REQ]').attr('checked', true);
    }

    $('input[name=type]:checked').change();

    $( "input.item_name" ).livequery(function(){
        
        var input = $(this);
        
        input.autocomplete({
            source: baseURL + 'admin/items/ajax_auto_complete',
            minLength: 2,
            select: function( event, ui ) {
				
                details = $(input).closest('tr.details');
                description = details.next('tr.description');
				
                cost = ui.item.qty * ui.item.rate;
				
                $('input.item_name', details).val(ui.item.name);
                $('input.item_quantity', details).val(ui.item.qty);
                $('input.item_rate', details).val(ui.item.rate);
                $('select.tax_id', details).val(ui.item.tax_id);
                $('input.item_cost', details).val( cost );
                $('span.item_cost', details).text( cost );
                fix_item_cost_width();
				
                $('textarea.item_description', description).val(ui.item.description);
				
                //$.uniform.update('.tax_id');
                updatePaymentPlanTotals();
            }
        });
    });

    // Count up a row total
    $('input.item_quantity, input.item_rate').forceNumeric().live('keyup', function(){
        row = $(this).closest('tr');
        qty = $('input.item_quantity', row).val();
        rate = $('input.item_rate', row).val();

		
        cost = (Math.round( (qty * rate ) *100)/100).toFixed(2);

        $('input.item_cost', row).val( cost );
        $('span.item_cost', row).text( cost );
        fix_item_cost_width();
    });

    // Add a new row
    $('a#add-row').click(function(){
        // Remove if there are others to clone
        details = $('#invoice-items tbody tr.details:first');
        description = $('#invoice-items tbody tr.description:first');
		
        if ($('#invoice-items tbody').children('tr.details:visible').length == 0) {
            details = details.show();
            description = description.show();
        }
        else {
            details = details.clone();
            description = description.clone();
        }

        $('input.item_name', details).val('');
        $('input.item_quantity', details).val(1);
        $('input.item_rate', details).val('1.00');
        $('input.tax_id', details).val('0');
        $('input.item_cost', details).val( '1.00' );
        $('span.item_cost', details).text( '1.00' );
        fix_item_cost_width();
		
        $('textarea.item_description', description).val('');
		
        $('#invoice-items > tbody').append('<tr><td colspan="6"><table></table></td></tr>');
		
        $('#invoice-items > tbody > tr:last table').append(details);
        $('#invoice-items > tbody > tr:last table').append(description);
        
        updatePaymentPlanTotals();
        return false;
    });
	
    $('.tax_id').live('change', function() {
        $.uniform.update(this);
    })
    // Remove (or at least hide) a row
    $('a.remove.icon').live('click', function(){

        // Last one, keep it!
        if( $('#invoice-items tbody').children('tr.details').length == 1)
        {
            row = $(this).closest('tr.details').hide();
            row.next('tr.description').hide();
            row.find('input').val('');
        }

        // Remove if there are others to clone
        else
        {
            row = $(this).closest('tr.details');
            row.next('tr.description').andSelf().remove();
        }
        return false;
    });

    $('#add-file-input').click(function (e) {
        e.preventDefault();
        $('#file-inputs').append('<li><input name="invoice_files[]" type="file" /></li>');
        $.uniform && $.uniform.update();
    });

    $('.remove_file').click(function () {
        $(this).parent().parent().toggleClass('file_remove');
    });

    $('#add_files_edit').click(function () {
        $('#files tbody').append('<tr><td colspan="4"><input name="invoice_files[]" type="file" /></td></tr>');
        return false;
    });

    /*	$('#description, #notes').htmlarea({
		toolbar: Pancake.toolbars.basic,
		css: Pancake.site_url+"third_party/themes/admin/pancake/css/jHtmlArea.Editor.css",
	});
*/

    $('select[name=is_recurring]').change(function() {

        this.value == 1
        ? $('div#recurring-options').slideDown('slow')
        : $('div#recurring-options').slideUp('slow')
			
        return false;
    }).change();
    
    $('body').on('change keyup', 'input.partial-amount, select[id^=partial-percentage], #invoice-items .item_quantity, #invoice-items .item_rate, #invoice-items .tax_id', updatePaymentPlanTotals);
    updatePaymentPlanTotals();
        
    $('table#invoice-items tbody.make-it-sortable').sortable({
        handle: 'a.sort	',
        items: '> tr'
    });
	
});