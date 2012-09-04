/**
 * jQuery.ScrollTo - Easy element scrolling using jQuery.
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 */
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);

;(function(a){a.fn.TextAreaExpander=function(e,d){var c=!(a.browser.msie||a.browser.opera);function b(i){i=i.target||i;var j=i.value.length,g=i.offsetWidth;if(j!=i.valLength||g!=i.boxWidth){if(c&&(j<i.valLength||g!=i.boxWidth)){i.style.height="0px"}var f=Math.max(i.expandMin,Math.min(i.scrollHeight,i.expandMax));i.style.overflow=(i.scrollHeight>f?"auto":"hidden");i.style.height=f+"px";i.valLength=j;i.boxWidth=g}return true}this.each(function(){if(this.nodeName.toLowerCase()!="textarea"){return}var f=this.className.match(/expand(\d+)\-*(\d+)*/i);this.expandMin=e||(f?parseInt("0"+f[1],10):0);this.expandMax=d||(f?parseInt("0"+f[2],10):99999);b(this);if(!this.Initialized){this.Initialized=true;a(this).css("padding-top",0).css("padding-bottom",0);a(this).bind("keyup",b).bind("focus",b)}});return this}})(jQuery);

/* Modernizr 2.0.6 (Custom Build) | MIT & BSD
 * Contains: csstransitions | testprop | testallprops | domprefixes
 */
;window.Modernizr=function(a,b,c){function z(a,b){var c=a.charAt(0).toUpperCase()+a.substr(1),d=(a+" "+m.join(c+" ")+c).split(" ");return y(d,b)}function y(a,b){for(var d in a)if(j[a[d]]!==c)return b=="pfx"?a[d]:!0;return!1}function x(a,b){return!!~(""+a).indexOf(b)}function w(a,b){return typeof a===b}function v(a,b){return u(prefixes.join(a+";")+(b||""))}function u(a){j.cssText=a}var d="2.0.6",e={},f=b.documentElement,g=b.head||b.getElementsByTagName("head")[0],h="modernizr",i=b.createElement(h),j=i.style,k,l=Object.prototype.toString,m="Webkit Moz O ms Khtml".split(" "),n={},o={},p={},q=[],r,s={}.hasOwnProperty,t;!w(s,c)&&!w(s.call,c)?t=function(a,b){return s.call(a,b)}:t=function(a,b){return b in a&&w(a.constructor.prototype[b],c)},n.csstransitions=function(){return z("transitionProperty")};for(var A in n)t(n,A)&&(r=A.toLowerCase(),e[r]=n[A](),q.push((e[r]?"":"no-")+r));u(""),i=k=null,e._version=d,e._domPrefixes=m,e.testProp=function(a){return y([a])},e.testAllProps=z;return e}(this,this.document);
$('html').addClass(Modernizr.csstransitions ? 'csstransitions' : 'no-csstransitions');

$(window).load(function() {
    $("#page-list-container").mCustomScrollbar();
    
    $('#page-list').on('click', "a", function(event){
        var anchor = $(this);
 
        $('html, body').stop().animate({
            scrollTop: $('#'+anchor.attr('href').split('#')[1]).offset().top
        }, 1000,'easeInOutExpo');
        /*
        if you don't want to use the easing effects:
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1000);
        */
        event.preventDefault();
    });    
    
});


function fillFaceboxFromIframe(href, klass, height) {
    $.facebox.reveal('<iframe scrolling="no" marginwidth="0" width="920" frameborder="0" src="' + href + '" marginheight="0"></iframe>', klass)
}

function fixIframeHeight() {
    $('iframe').each(function() {
        var newHeight = $(this).contents().find('#wrapper').height();
        if ($('.no-csstransitions').length != 0) {
            $('iframe').animate({
                height: newHeight
              }, 200);
        }else {
            $(this).height(newHeight);
        }
        
    });
}

setInterval(fixIframeHeight, 100);

saving = false;
redirect = false;

function getProposalFieldValue(field, section) {
    var buffer = null;
    
    if (section) {
        buffer = section.find('.'+field);
    } else {
        buffer = $('.'+field);
    }
    
    if (parseInt(buffer.data('estimate-id')) > 0) {return buffer.data('estimate-id');}
    
    var val = '';
    
    if (buffer.find('textarea').length != 0) {
        val = buffer.find('textarea').parents('.section-contents').length == 0 ? buffer.find('textarea').val().replace(/\n/g, "<br />\n") : buffer.find('textarea').val();
    } else {
        if (!buffer.hasClass('empty-stuffs')) {
            val = buffer.html();
        }
    }
    
    return val;
}

function getProposalObject() {
    var proposal = {};
    proposal.title = getProposalFieldValue('proposalTitle');
    proposal.client_id = getProposalFieldValue('clientId');
    proposal.client_company = getProposalFieldValue('clientCompany');
    proposal.client_address = getProposalFieldValue('clientAddress');
    proposal.client_name    = getProposalFieldValue('clientName');
    proposal.sections = []
    $('.section:not(.sampleSection)').each(function() {
        var section = {};
        section.page_key = $(this).parents('.page').data('key');
        section.proposal_id = parseInt($('.proposalId').text());
        section.key = $(this).data('key');
        if ($(this).is('.subsection')) {
            section.parent_id = $(this).parents('.page').data('key')+'-'+$(this).parents('.section').data('key');
            alert($(this).parents('.page').data('key')+'-'+$(this).parents('.section').data('key'));
        } else {
            section.parent_id = 0;  
        }
        section.title = getProposalFieldValue('section-title', $(this));
        section.subtitle = getProposalFieldValue('section-subtitle', $(this));
        section.contents = getProposalFieldValue('section-contents', $(this));
        section.section_type = $(this).data('type') ? $(this).data('type') : 'section';
        proposal.sections.push(section);
    });
    return proposal;
}

function hideSaving(element) {
    
    var is_saving = $(element).data('currentlySaving') ? $(element).data('currentlySaving') : saving;
    
    if (!is_saving) {
        $(element).html($(element).data('saved')).removeClass('saving').addClass('saved');
        setTimeout(function() {
            $(element+'.saved').html($(element).data('save')).removeClass('saved');
        }, 500);
    }
}

function showSaving(element) {
    setTimeout("hideSaving('"+element+"');", 500);
    $(element).html($(element).data('saving')).addClass('saving');
}

function autosave() {
    if (!saving) {
        saving = true;
        
        showSaving('.saveProposal');
        
        $.post(proposalSaveUrl, getProposalObject(), function(data) {
            hideSaving('.saveProposal');
            saving = false;
            
            if (redirect) {
                window.location.href = redirect;
                return;
            }
        });
    }
}

function fixKeys() {
    $('.page:not(:last-child):not(.samplePage)').each(function() {if ($(this).find('.section').length == 0) {$(this).remove()}});
    
    $('.sidebar, .pageContainer').each(function() {
        var page_key = 1;
        $(this).find('.page:not(.samplePage)').each(function() {
            $(this)
                .removeClass('page-'+$(this)
                .data('key'))
                .data('key', page_key)
                .addClass('page-'+page_key)
                .find('.pageCount')
                .html(pagexofcount.replace(':1', page_key)
                .replace(':2', '<span class="pageTotal">'+$('.sidebar .page').length+'</span>'));
            page_key++;
            var key = 1;
           $(this).find('.section').each(function() {
               $(this).removeClass('section-'+$(this).data('key')).data('key', key).addClass('section-'+key);
               key++;
           });
        });
    });
    
    autosave();
}

function addDeleteSectionButtons() {
   $('.sidebar .section > span:not(.closed)').addClass('closed').prepend('<a class="close" href="">X</a>');
   $('.sidebar .close').click(function() {
       var sectionKey = $(this).parents('.section').data('key');
       var pageKey = $(this).parents('.page').data('key');
       $('.page-'+pageKey+' .section-'+sectionKey).remove();
       fixKeys();
       autosave();
       return false;
   });
}

var addingSection = false;

function addSection(parentPage, type, estimate_id, contents, title, subtitle) {
    estimate_id = (estimate_id == undefined) ? 0 : estimate_id;
    type = (type == undefined) ? 'section' : type;
    title = (title == undefined) ? '' : title;
    subtitle = (subtitle == undefined) ? '' : subtitle;
    contents = (contents == undefined) ? '' : contents;
    
    if (!addingSection && type == 'estimate') {
        addingSection = true;

        $.get(proposalGetProcessedEstimate+'/'+estimate_id, function(data) {
            addSection(parentPage, type, estimate_id, data);
            addingSection = false;
        });

        return;
    }
    
    var parentPageKey = parentPage.data('key');
    var oldKey = parentPage.find('.section:last-child').data('key');
    var newKey = oldKey ? oldKey + 1 : 1;
    var newSection = $('.sampleSection').clone().removeClass('sampleSection').data('key', newKey).addClass('section-'+newKey).hide();
    newSection.find('.section-title').html($('.proposal').data('empty-title')).addClass('empty-stuffs');
    newSection.find('.section-subtitle').html($('.proposal').data('empty-subtitle')).addClass('empty-stuffs');
    newSection.find('.section-contents').html($('.proposal').data('empty-contents')).addClass('empty-stuffs');
    newSection.data('type', type);
    jQuery(document).trigger('close.facebox');
    if (type != 'section') {
        // It's either an estimate or a table of contents section.
        newSection.find('.section-contents').removeClass('editable').addClass(type).data('estimate-id', estimate_id).removeClass('empty-stuffs').html(contents);
    } else {
	if (title != '') {
	    newSection.find('.section-title').removeClass('empty-stuffs').html(title);
	}
	
	if (subtitle != '') {
	    newSection.find('.section-subtitle').removeClass('empty-stuffs').html(subtitle);
	}
	
	if (contents != '') {
	    newSection.find('.section-contents').removeClass('empty-stuffs').html(contents);
	}
    }
    parentPage.find('.sectionContainer').append(newSection.fadeIn());
    var newLi = $('<li class="section section-'+newKey+'" data-key="'+newKey+'"><span>'+newSection.find('.section-title').html()+'</span><ul></ul></li>').hide();
    $('.sidebar .page-'+parentPageKey+' > ul').append(newLi.fadeIn());  
    makeSortable();
    addDeleteSectionButtons();
    fixKeys();
    autosave();
}

function stopEditing(discard) {

    var textarea = $('.currentlyEditing textarea');
    
    if (textarea.length > 0) {
   
   
    try {
        ckeditor = textarea.ckeditorGet();
        if (typeof(ckeditor) != 'string') {
            ckeditor.destroy();
        } 
    } catch (e) {
        // Okay, so CKEditor isn't initialized, ignore that.
    }
    
        
    $('.editing-container').append($('.editing'));
        
    var old_val = textarea.data('old-value');    
    var val = discard ? ((old_val == undefined) ? '' : old_val) : textarea.val();
    var empty = (val == '');
        
    if (empty) {
        var parent = textarea.parent();
        var data = '';
        if (parent.hasClass('section-title')) {
            data = $('.proposal').data('empty-title');
        } else if (parent.hasClass('section-subtitle')) {
            data = $('.proposal').data('empty-subtitle');
        } else {
            data = $('.proposal').data('empty-contents');
        }
        parent.html(data).addClass('empty-stuffs');
    } else {
        val = textarea.parents('.section-contents').length == 0 ? val.replace(/\n/g, "<br />\n") : val;
        textarea.parent().html(val);
    }
                
                
    autosave();
    
    $('.currentlyEditing').removeClass('currentlyEditing');
    
    }
    
}

function makeSortable() {
    $( "#page-list > li > ul, #page-list > li > ul > li > ul" ).sortable('destroy');
    $( "#page-list > li > ul, #page-list > li > ul > li > ul" ).sortable({
        items: '> li', 
        connectWith: $( "#page-list > li > ul, #page-list > li > ul > li > ul" ),
        dropOnEmpty: true,
        placeholder: 'empty',
        forcePlaceholderSize: true,
        start: function(event, ui) {
            
            ui.item.data('old-page', ui.item.parents('.page').data('key'));

        }, 
        stop: function(event, ui) {
            
            var isChild = ui.item.parents('.section').length != 0;
            
            if (!isChild) {
                
                ui.item.removeClass('subsection');
            
                var newPage = ui.item.parents('.page').data('key');
                var oldKey = ui.item.data('key');
                var proposalSection = $('.proposal #wrapper .page-'+ui.item.data('old-page')+' .section-'+oldKey);
                var previousKey = ui.item.prev().data('key');


                if (previousKey == undefined) {
                    $('.proposal #wrapper .page-'+newPage+' .sectionContainer').prepend(proposalSection);
                } else {
                    $('.proposal #wrapper .page-'+newPage+' .section-'+previousKey).after(proposalSection);
                }

                fixKeys();
            
            } else {
                alert('subsection - process it; if it includes subsections of its own, remove them all and make them siblings; fix keys, process subsections in autosave(), and all that malarkey; rejecting drop for the time being');
                //ui.item.addClass('subsection');
                return false;
            }
            
        }
    });
$( ".sidebar > ul > li > ul, .sidebar > ul > li > ul > li > ul" ).disableSelection();
}

$('.cover-page .editable').each(function() {
    if ($(this).html() == '') {
        $(this).addClass('empty-stuffs').html($('.proposal').data('empty-contents'));
    }
});

$('.accept, .reject, .unanswer').click(function() {
    if ($(this).hasClass('accept')) {
        $('.accept, .reject').hide();
        $('.accepted, .proposal.admin .unanswer').show();
        $.get(proposalStatusUrl+'accept');
    } else {
        if ($(this).hasClass('reject')) {
            $('.accept, .reject').hide();
            $('.rejected, .proposal.admin .unanswer').show();
            $.get(proposalStatusUrl+'reject');
        } else {
            $('.accept, .reject').show();
            $('.accepted, .rejected, .unanswer').hide();
            $.get(proposalStatusUrl);
        }
    }   
    return false;
});

$('.accepted, .rejected').click(function(){return false;});

$('.proposal.not-admin .sidebar .section').live('click', function() {
    var page_key = $(this).parents('.page').data('key');
    var key = $(this).data('key');
    $('.pageContainer .section').scrollTo($(('.pageContainer .page-'+page_key+' .section-'+key)));
});

$('.proposal.admin').each(function() {
    
    $('.savePremadeSection').live('click', function() {
        
        var section = $(this).parents('.section');
        var page_key = $(this).parents('.page').data('key');
        
        showSaving('.page-'+page_key+' .section-'+section.data('key')+' .savePremadeSection');
        $(this).data('currentlySaving', true);
        
        $.post(proposalSavePremadeSectionUrl, {
            title: getProposalFieldValue('section-title', section),
            subtitle: getProposalFieldValue('section-subtitle', section),
            contents: getProposalFieldValue('section-contents', section)
        }, function() {
            hideSaving('.page-'+page_key+' .section-'+section.data('key')+' .savePremadeSection');
            $('.page-'+page_key+' .section-'+section.data('key')+' .savePremadeSection').data('currentlySaving', false);
        });
        
        return false;
    });
    
    $('.addEstimate').live('click', function() {
        addEstimatePage = $(this).parent('.page');
        jQuery.facebox({ajax: proposalGetEstimates.replace('{UNIQID}', (new Date()).getTime())});
        $(document).bind('close.facebox', function() {addEstimatePage = null;});
        return false;
    });
    
    $('.addPremadeSection').live('click', function() {
        addPremadeSectionPage = $(this).parent('.page');
        jQuery.facebox({ajax: proposalGetPremadeSections});
        $(document).bind('close.facebox', function() {addPremadeSectionPage = null;});
        return false;
    });
    
    $('.pickEstimate').live('click', function() {
        var estimate_id = $('#estimate-picker').val();
        $('.estimate-selector').html($('.estimate-selector').data('inserting'));
        addSection(addEstimatePage, 'estimate', estimate_id);
        return false;
    });
    
    $('.select-premade').live('click', function() {
	
	var premade_id = $(this).parents('.premadeSection').data('premade-id');
	var contents = $('.premade-contents.premade-'+premade_id).html();
	var title = $('.premade-title.premade-'+premade_id).html();
	var subtitle = $('.premade-subtitle.premade-'+premade_id).html();
	
	addSection(addPremadeSectionPage, 'section', 0, contents, title, subtitle);
	return false;
    });
    
    $('.delete-premade').live('click', function() {
	var premade_id = $(this).parents('.premadeSection').data('premade-id');
	$.get($(this).attr('href'));
	var parent = $(this).parents('.premadeSection');
	parent.fadeOut(function() {parent.remove();});
	return false;
	
    });
    
    setInterval('autosave();', 10000);
    
    $('html').live('click', function(event) {
        if (!$(event.target).hasClass('editable') && !$(event.target).hasClass('cke_dialog_background_cover') && $(event.target).parents('.cke_dialog_background_cover, .cke_skin_kama').length == 0) {
            stopEditing();
        }
    });
    
    $('.editing .confirm, .editing .cancel').live('click', function(event) {
        if ($(this).hasClass('confirm')) {
            stopEditing();
        } else {
            stopEditing(true);
        }
        event.stopPropagation();
        return false;
    });
    
    $('.currentlyEditing *').live('click', function(event){
        event.stopPropagation();
    }); 
    
    makeSortable();
    addDeleteSectionButtons();
    
    $('.saveProposal').click(function() {
        autosave();
        return false;
    });
    
    $('.addPage').click(function() {
        var newKey  = $('.page:last-child').data('key') + 1;
        var newPage = $('.samplePage').clone().removeClass('samplePage').data('key', newKey).addClass('page-'+newKey).hide();
        $(newPage).children("a").first().attr({ "name": 'page-'+newKey, "id": 'page-'+newKey } ).addClass("jumptarget");
        $('.pageContainer').append(newPage.fadeIn());
        pageCount = $('.pageContainer .page').length;
        $('.pageTotal').html(pageCount);
        var newpagexofcount = pagexofcount.replace(':1', newKey).replace(':2', '<span class="pageTotal">'+pageCount+'</span>');
        var newLi = $('<li class="page page-'+newKey+'" data-key="'+newKey+'"><a href="#page-'+newKey+'"><span class="pageCount">'+newpagexofcount+'</span></a><ul></ul></li>').hide();
        $('#page-list').append(newLi.fadeIn());
        $("#page-list-container").mCustomScrollbar("update");
        makeSortable();
        autosave();
        return false;
    });
    
    $('.addSection').live('click', function() {
        var parentPage = $(this).parent('.page');
        addSection(parentPage);
        return false;
    });
    
    $('.editable').live('click', function(e) {
        e.stopPropagation();
        
       if ($('.editable textarea').length > 0 && $(this).find('textarea').length == 0) {
           // There's another editing going on, let us fix it.
           stopEditing();
       }
        
        if (!$(this).hasClass('currentlyEditing')) {
            $(this).addClass('currentlyEditing');

            var text = '';
            if (!$(this).hasClass('empty-stuffs')) {
                if ($(this).hasClass('section-contents')) {
                    text = $(this).html();
                } else {
                       text = $(this).text();
                }
            } else {
                $(this).removeClass('empty-stuffs');
            }

            $(this).html('<textarea>'+text+'</textarea>').find('textarea').data('old-value', text).focus(function() {
                $(this).select();
            }).focus();

            $(this).append($('.editing'));

            $( '.section-contents textarea:not(.wysiwyg)' ).parents('.editable').addClass('ckediting');
            $( '.section-contents textarea:not(.wysiwyg)' ).addClass('wysiwyg').ckeditor();

            $('textarea:not(.autoResizeable):not(.wysiwyg)').addClass('autoResizeable').TextAreaExpander();
            $('textarea.autoResizeable').each(function() {
                var oldVal = $(this).val();
                $(this).keydown();
            });
        
        }
    });
    
    $('.section-title textarea').live('keyup', function() {
        var section = $(this).parents('.section');
        var key = section.data('key');
        var page_key = section.parents('.page').data('key');
        var val = '';
        if ($(this).val() != '') {
            val = $(this).val();
        } else {
            val = $('.proposal').data('empty-title');
        }
        $('.sidebar .page-'+page_key+' .section-'+key+' > span').removeClass('closed').html(val);
        addDeleteSectionButtons();
    });
    
    
    $('.clientCompany textarea').live('keyup', function() {
        
        $('.clientCompany').each(function() {
            if ($(this).find('textarea').length == 0) {
                if ($('.clientCompany textarea').val() != '') {
                    val = $('.clientCompany textarea').val().replace(/\n/g, "<br />\n");
                    $(this).removeClass('empty-stuffs');
                } else {
                    val = $('.proposal').data('empty-contents');
                    $(this).addClass('empty-stuffs');
                }
                $(this).html(val);
            }
        });
    });

	$('.not-admin .sidebar .section').live('click', function() {
	   $('.sectionContainer .section-'+$(this).data('key')).scrollTo();
	});
    
});