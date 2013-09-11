jQuery.validator.addMethod("validSSN", function(value, element, params) { 
             var D1 = parseInt(value.substr(0, 1));
            var D2 = parseInt(value.substr(1, 1));
            var M1 = parseInt(value.substr(2, 1));
            var M2 = parseInt(value.substr(3, 1));
            var Y1 = parseInt(value.substr(4, 1));
            var Y2 = parseInt(value.substr(5, 1));
            var I1 = parseInt(value.substr(6, 1));
            var I2 = parseInt(value.substr(7, 1));
            var I3 = parseInt(value.substr(8, 1));
            var K1 = parseInt(value.substr(9, 1));
            var K2 = parseInt(value.substr(10, 1));
            if(!isNaN(K2)){
                    var V1=(3*D1+7*D2+6*M1+M2+8*Y1+9*Y2+4*I1+5*I2+2*I3)%11;
                    if(V1 == 0) var tmpK1 = 0;
                    else var tmpK1 = 11-V1;

                    if(tmpK1 == K1){
                        var V2=(5*D1)+(4*D2)+(3*M1)+(2*M2)+(7*Y1)+(6*Y2)+(5*I1)+(4*I2)+(3*I3)+(2*K1);
                        V2 = V2%11;
                        if(V2 == 0) tmpK2 = 0;
                        else tmpK2 = 11-V2;
                        if(tmpK2 == K2) return true;

                    return false;
                }
            }
            return false;
			
}, jQuery.format("Du må fylle ut et gyldig personnummer"));

jQuery.validator.addMethod("validName", function(value, element, params) { 

	return value.match(/([\.\'åøæÅØÆA-Za-z-]{2,50}\s[\.\'åøæÅØÆA-Za-z-]{2,50})+(\s[\.\'åøæÅØÆA-Za-z-]{2,50})*/g);
		
}, jQuery.format("Du må fylle ut et gyldig mobilnummer"));

jQuery.validator.addMethod("validCellphone", function(value, element, params) { 
	return value.match(/[4|9][0-9]{7}/g);
}, jQuery.format("Du må fylle ut et gyldig mobilnummer"));


jQuery.validator.addMethod("exactLength", function(value, element, param) {
 return value.length == param;
}, jQuery.format("Du må fylle inn riktig antall tegn"));

jQuery.validator.addMethod("validBirthdate", function(value, element, params) { 
    var currVal = value;
    if(currVal == '')
        return false;
    
    var rxDatePattern = /^(\d{8})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?
    
    if (dtArray == null) 
        return false;
    
    //Checks for ddmmyyyy format.
    dtDay = currVal.substring(0,2);
    dtMonth= currVal.substring(2,4);
    dtYear = currVal.substring(4,8);        

    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
            return false;
    }
    
    var minAge = 18;


    var mydate = new Date();
    mydate.setFullYear(dtYear, dtMonth-1, dtDay);

    var currdate = new Date();
    currdate.setFullYear(currdate.getFullYear() - minAge);

    return currdate > mydate;
}, jQuery.format("Du må være 18 år for å bestille"));


// theme js
jQuery(document).ready(function($) {
//$(document).ready(function() {
// Progressive disclosure elementer
$('.progressiv-choice').change(function () {
	//$(this).parent().parent().find('.progressiv-choice').next().next().slideToggle();
	$(this).next().next().slideToggle();
	$('.progressiv-choice').each(function () {
		if(!this.checked){
			$(this).next().next().slideUp();
		}
	});
});
//
$('.progressiv-choice').each(function () {
	if(!this.checked){
		$(this).next().next().hide();
	}
});

$('#new-new-number').click(function(event){
	event.preventDefault();
	$.ajax({
		url: "../lib/ajax-nlr.php?a=newNumbers",
		data: { noMsisdns: "7", msisdnType: "regular" },
		dataType: "json",
		success: function(result) {
			//$("#city").val(result.address_location);
			$(".new-number-holder.regular").html("");
			$.each(result, function(key, value) { 
					key = key+1;
					$(".new-number-holder.regular").append('<label class="choice newnumber"><input id="radio-number-new-'+key+'" type="radio" name="numbernew" tabindex="4" value="'+value+'"> '+value+'</label>');
			});	
		} ,
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}
	});
});
$('#new-number').click(function(event){
	event.preventDefault();
	$.ajax({
		url: "../lib/ajax-nlr.php?a=newNumbers",
		data: { noMsisdns: "7", msisdnType: "gold" },
		dataType: "json",
		success: function(result) {
			//$("#city").val(result.address_location);
			$(".new-number-holder.gold").html("");
			$.each(result, function(key, value) { 
					key = key+1;
					$(".new-number-holder.gold").append('<label class="choice newnumber"><input id="radio-number-gold-'+key+'" type="radio" name="numbernew" tabindex="4" value="'+value+'"> '+value+'</label>');
			});	
		} ,
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}
	});
});

// Start fokus til felt
$('.give-focus').focus();

// Sidebar som fÃ¸lger scrollen
$(window).scroll(function(){
	$("#sticky").css("top",Math.max(0,125-$(this).scrollTop()));
});

// TABS
$('ul.tab-controls').each(function(){
	// For each set of tabs, we want to keep track of
	// which tab is active and it's associated content
	var $active, $content, $links = $(this).find('a').not('.not_a_tab');
	// If the location.hash matches one of the links, use that as the active tab.
	// If no match is found, use the first link as the initial active tab.
	$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[1]);
	$active.addClass('active');
	$content = $($active.attr('href'));
	
	// Hide the remaining content
	$links.not($active).each(function () {
		$($(this).attr('href')).hide();
	});
	
	// Bind the click event handler
	$(this).on('click', 'a', function(e){
		// Make the old tab inactive.
		$active.removeClass('active');
		$content.hide();
		// Update the variables with the new link and content
		$active = $(this);
		$content = $($(this).attr('href'));
		// Make the tab active.
		$active.addClass('active');
		$content.show();
		// Prevent the anchor's default click action
		e.preventDefault();
	});
});
$('.folder-toggle').each(function(){
	$(this).children().next().hide();
});
$('.folder-toggle h2 a').click(function() {
	$(this).parent().next().slideToggle();
	if ($(this).hasClass( 'open')) {
		$(this).removeClass('open');
	} else {
		$('.open').parent().next().slideToggle(); // Remove other open toggles
		$('.open').removeClass('open');
		$(this).addClass('open');
	}
	return false;
});
$('#prototype-navigation a.toggle').click(function(){
	$('#prototype-navigation section').slideToggle();
});

// Tooltip only Text
$('.masterTooltip').hover(function(){
// Hover over code
var title = $(this).attr('title');
$(this).data('tipText', title).removeAttr('title');
$('<p class="tooltip"></p>')
.text(title)
.append('<div class="card-arrow"></div>')
.appendTo('body')
.show();
}, function() {
// Hover out code
$(this).attr('title', $(this).data('tipText'));
$('.tooltip').remove();
}).mousemove(function(e) {
//var mousex = e.pageX + 20; //Get X coordinates
//var mousey = e.pageY + 10; //Get Y coordinates
$('.tooltip')
.css({ top: $(this).offset().top + 38, left: $(this).offset().left - 28 }); //mousey, left: mousex })
});
 // Brukes i skjema for progressive disclousure av underliggende seksjoner når radiovalg blir endret
$("._toggleControl").click(function(){
	$(this).toggleClass('open');
	var id = $(this).attr("id");
	var target = $("#seksjon-" + id);
	$(target).slideToggle(200, function(){
		$(target).find('._toggleFocus').focus();
	});
	return false;
}); 	
var dateMin = new Date();
var dateMax = new Date();
var minDays = AddWeekDays(3);
var maxDays = AddWeekDays(14);
dateMin.setDate(dateMin.getDate() + minDays);
dateMax.setDate(dateMax.getDate() + maxDays);

function noWeekendsOrHolidays(date) {
	var noWeekend = $.datepicker.noWeekends(date);
	if (noWeekend[0]) {
		return noWeekend;
	}
}
function AddWeekDays(weekDaysToAdd) {
	var daysToAdd = 0
	var mydate = new Date()
	var day = mydate.getDay()
	weekDaysToAdd = weekDaysToAdd - (5 - day)
	if ((5 - day) < weekDaysToAdd || weekDaysToAdd == 1) {
		daysToAdd = (5 - day) + 2 + daysToAdd
	} else { // (5-day) >= weekDaysToAdd
		daysToAdd = (5 - day) + daysToAdd
	}
	while (weekDaysToAdd != 0) {
		var week = weekDaysToAdd - 5
		if (week > 0) {
			daysToAdd = 7 + daysToAdd
			weekDaysToAdd = weekDaysToAdd - 5
		} else { // week < 0
			daysToAdd = (5 + week) + daysToAdd
			weekDaysToAdd = weekDaysToAdd - (5 + week)
		}
	}
	return daysToAdd;
}
$.datepicker.regional['no'] = {
	monthNames: ['Januar','Februar','Mars','April','Mai','Juni','Juli','August','September','Oktober','November','Desember'],
	dayNames: ['Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag'],
	dayNamesShort: ['Søn','Man','Tir','Ons','Tor','Fre','Lør'],
	dayNamesMin: ['Sø','Ma','Ti','On','To','Fr','Lø'],
	dateFormat: 'dd/mm/yy', firstDay: 1
};
$.datepicker.setDefaults($.datepicker.regional['no']);
$( "#datepicker" ).datepicker({
	beforeShowDay: $.datepicker.noWeekends,
	minDate: dateMin,
	maxDate: dateMax,
	dateFormat: "dd.mm.yy"
});

$( "#datepicker" ).datepicker("setDate",dateMin);
//$("#next-button-step2").timer('start');
            //form validation rules
            $("#order-section-1").validate({
                rules: {
                    numberport: {
                        minlength: 8,
						validCellphone: true,
						required: {
							depends: function(element) {
								return $("radio-number-port:checked")
							}
						}
                    },
                    numbernew: {
						required: {
							depends: function(element) {
								return $("radio-number-new:checked")
							}
						}
                    }
                },
                messages: {
                    numberport: {
                        minlength: "Et mobilnummer er 8 siffer langt",
						validCellphone: "Fyll ut et gyldig mobilnummer",
						required: "Gi oss mobilnummeret ditt, så vi kan hjelpe deg videre"
                    },
                    numbernew: {
						required: "Velg et nytt mobilnummer nedenfor"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }, errorPlacement: function(error, element) {
					error.insertBefore(element);
				},
            });
            //form validation rules
            $("#order-section-2").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 4,
						validName: true
					},
					birthdate: {
                        required: {
							depends: function(element) {
								return $('#order-section-2 input[name="sub"]').val() == 'Kontant';
							}
						},
                        minlength: 8,
						validBirthdate: true
                    },
                    personalnumber: {
                        required: {
							depends: function(element) {
								return $('#order-section-2 input[name="sub"]').val() != 'Kontant';
							}
						},
                        minlength: 11,
						validSSN: true
                    },
                    address: {
                        required: {
							depends: function(element) {
								return $('#order-section-2 input[name="sub"]').val() == 'Kontant';
							}
						},
                        minlength: 2
                    },
                    city: {
                        required: {
							depends: function(element) {
								return $('#order-section-2 input[name="sub"]').val() == 'Kontant';
							}
						},
                        minlength: 2
                    },
                    zip: {
                        required: {
							depends: function(element) {
								return $('#order-section-2 input[name="sub"]').val() == 'Kontant';
							}
						},
                        exactLength: 4
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    name: {
                        required: "Glemt å skrive inn navnet ditt?",
                        minlength: "Skriv navnet slik det står i Folkeregisteret",
						validName: "Skriv hele navnet ditt"
                    },
                    personalnumber: {
                        required: "Glemt å skrive inn fødselsnummeret ditt (11 siffer)?",
                        minlength: "Et fødselsnummer er 11 siffer langt"
                    },
                    birthdate: {
                        required: "Glemt å skrive inn fødselsdatoen din (8 siffer)?",
                        minlength: "Skriv din fødselsdato på formatet DDMMYYYY"
                    },
                    address: {
                        required: "Glemt å skrive inn din folkeregistrerte adresse?",
                        minlength: "Skriv inn folkeregistrert adresse"
                    },
                    city: {
                        required: "Glemt å skrive inn poststed?",
                        minlength: "Fyll ut poststed"
                    },
                    zip: {
                        required: "Glemt å skrive inn postnummer?",
                        exactLength: "Fyll inn 4-sifret postnummer"
                    },
                    email: {
                        required: "Glemt å skrive inn en e-postadresse?",
                        email: "Skriv inn en gyldig e-postadresse vi kan nå deg på"
                    }
                 },
                submitHandler: function(form) {
                    //form.submit();
					//$("#next-button-step2").timer('start');
					//setTimeout(form.submit(), 5000);
					$('input[name="name"]').attr("readonly", "true");
					$('input[name="personalnumber"]').attr("readonly", "true");
					$('input[name="email"]').attr("readonly", "true");
					$('input[name="otheruser"]').attr("readonly", "true");
					$('input[name="username"]').attr("readonly", "true");
					$('input[name="userpersonalnumber"]').attr("readonly", "true");
					$("#next-button-step2").attr("disabled", "disabled");
					$("#loader-premessage").hide();
					$("#loader-view").show();
					//$("#next-button-step2").click(function() {
						   $.ajax({
								url: "../lib/ajax-nlr.php?a=lookupAddress",
								data: { name: $("#input-name").val(),
									cellphone: $("#input-cellnum").val(), 
									ssnumber: $("#input-personalnumber").val()},
								dataType: "json",
								success: function(result) {
									$("#city").val(result.address_location);
									form.submit();
								} ,
								error: function(jqXHR, textStatus, errorThrown) {
									alert(errorThrown);
								}
							});
					//		alert('ok');
							
					//});
					/*
					$("#next-button-step2").timer({
						delay: 5500,
						repeat: 1,
						autostart: true,
						callback: function() { }
					});*/
					
				}, errorPlacement: function(error, element) {
					error.insertBefore(element);
				}
            });
            //form validation rules
            $("#order-section-3").validate({
				rules: {
					sim: {
						required: {
							depends: function(element) {
								return $("radio-delivery-mail:checked")
							}
						}
					},
					conditions: "required"
				},
				messages: {
					sim: {
						required: "Glemt å velge hvilken type SIM-kort du trenger?",
					},
					conditions: "Les og godta vilkårene, er du grei"
				},
				submitHandler: function(form) {
					form.submit();
				}, errorPlacement: function(error, element) {
					error.insertBefore(element);
				},
			});
			function init() {
			$('[placeholder]').placeholder();
			}
			
			// Handle folder-toggle with hash-tags in URL.
			if (window.location.hash) {
				var hash = window.location.hash;
				$(hash).click();
			}
			
			
/*			$("#module-blioppringt-form").submit(function(e){
				return false; // not to trigger any 
			}*/
			$("#module-blioppringt-submit").click(function(){
				if($("#module-blioppringt-form").valid()){
					$.ajax({
								url: "../lib/ajax-nlr.php?a=callMe",
								data: $("#module-blioppringt-form").serialize(),
								dataType: "json",
								success: function(result) {
									//$("#city").val(result.address_location);
									//form.submit();
									$("#module-blioppringt-form").hide();
									if (result.result == "OK"){
										$("#module-blioppringt-feedback").show();
									}else{
										$("#module-blioppringt-feedbackerror .errortext").html(result.result);
										$("#module-blioppringt-feedbackerror").show();
									}
								} ,
								error: function(jqXHR, textStatus, errorThrown) {
									alert(errorThrown);
								}
							});
				}
			});
            //form validation rules
            $("#module-blioppringt-form").validate({
                rules: {
                    callmename: {
                        required: true,
                        minlength: 3
					},
                    callmephone: {
                        required: true,
						digits: true,
                        minlength: 8,
                        maxlength: 8
                    }
                },
                messages: {
                    callmename: {
                        required: "Fyll inn navn",
                        minlength: "Skriv hele navnet"
                    },
                    callmephone: {
                        required: "Fyll inn nummer",
						digits: "Bruk bare tall",
                        minlength: "8-sifret nummer",
                        maxlength: "8-sifret nummer"
                    }
                },
                submitHandler: function(form) {
					
				}, errorPlacement: function(error, element) {
					error.insertBefore(element);
				}
            });
 			
			
	$('#countrysearchfield').click(function(event){
		event.preventDefault();
		$(".countries li").hide();
		$(".countries li[class*="+$('#countrysearchfield').val().toLowerCase()+"]").show();
		$(".letterwrapper").show();
		$(".letterwrapper").not(":has(li:visible)").hide();
		
	});
	$('#countrysearchfield').keyup(function() {
		
		$(".countries li").hide();
		$(".countries li[class*="+$(this).val().toLowerCase()+"]").show();

		$(".letterwrapper").show();
		$(".letterwrapper").not(":has(li:visible)").hide();
		//$(".letterwrapper:has(li:visible)").show();
		//$(".letterwrapper:not:has(.li:visible)").hide();
		//if($(".letterwrapper .li:visible").length > 0) 
		//var count = $(".countries li li:visible").length;
	});	
});
function showOrderHelp(url){
// Ã¥pne lightboks her
return false;
}
function backButton(url) {
jQuery('form').unbind('submit');
$('form').attr('action', url);
$('form').submit();
}
function nextWithDelay() {
$("#next-button-step2").timer('start');
return false;
}

var newwin = null;
function do_payment_Popup(paytype, myform, windowname, subscriber)
{
        if(paytype == 'refill'){
                var c = parseInt(myform.CELLPHONE.value);
                var a = parseInt(myform.amount.value);
                if(c > 39999999 && (a > 99 && a < 100000)){
                        //document.getElementById('fielderror').style.display = 'none';
                        window.name="OCpaymentParent_refill";
                        if (! window.focus) return true;
                        newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        newpaywin.focus();
                        return true;
                } else { //document.getElementById('fielderror').style.display = '';
                        return false;
                }
        }else if(paytype == 'dashboardrefill'){
                var c = parseInt(myform.CELLPHONE.value);
                var a = parseInt(myform.amount.value);
                if(c > 39999999 && (a > 99 && a < 100000)){
                        //document.getElementById('fielderror').style.display = 'none';
                        window.name="OCpaymentParent_dashboardrefill";
                        if (! window.focus) return true;
                        newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        newpaywin.focus();
                        return true;
                } else { //document.getElementById('fielderror').style.display = '';
                        return false;
                }
        }else if(paytype == 'newcustomerrefill'){
                var c = parseInt(myform.CELLPHONE.value);
                var a = parseInt(myform.amount.value);
                if(c > 39999999 && (a > 99 && a < 100000)){
                        //document.getElementById('fielderror').style.display = 'none';
                        window.name="OCpaymentParent_newcustomerrefill";
                        if (! window.focus) return true;
                        newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        newpaywin.focus();
                        return true;
                } else { //document.getElementById('fielderror').style.display = '';
                        return false;
                }
        }else if(paytype == 'paynewnumber'){
                        window.name="OCpaymentParent_paynewnumber";
                        if (! window.focus) return true;
                        newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        newpaywin.focus();
        }else if(paytype == 'paygoldnumber'){
                        window.name="OCpaymentParent_paygoldnumber";
                        if (! window.focus) return true;
                        newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        newpaywin.focus();
        }else if(paytype == 'paynumber'){
                        window.name="OCpaymentParent_paynumber";
                        if (! window.focus) return true;
                        newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        newpaywin.focus();
        }else if(paytype == 'payorder'){
                var a = 3000;
                if(a > 99 && a < 100000){
                        window.name="OCpaymentParent_payorder";
                        if (! window.focus) return true;
                        newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        newpaywin.focus();
                } else {
                        return false;
                }
        }else if(paytype == 'ccreg'){
                document.ccreg_form.subscriber.value=subscriber;
                window.name="OCpaymentParent_ccreg";
                if (! window.focus) return true;
                newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                myform.target=windowname;
                newpaywin.focus();
                return true;
        }else if(paytype == 'regccreg'){
                document.regccreg_form.subscriber.value=subscriber;
                window.name="OCpaymentParent_regccreg";
                if (! window.focus) return true;
                newpaywin = window.open('', windowname, 'scrollbars,status,width=550,height=600');
                myform.target=windowname;
                newpaywin.focus();
                return true;
        }else if(paytype == 'advpayment'){
                var checkOK = "0123456789";
                var a = myform.amount.value;
                var allValid = true;
                var allNum = "";
                for (i = 0;  i < a.length;  i++)
                {
                        ch = a.charAt(i);
                        for (j = 0;  j < checkOK.length;  j++)
                        if (ch == checkOK.charAt(j)) break;
                        if (j == checkOK.length)
                        {
                                allValid = false;
                                break;
                        }
                        if (ch != ",") allNum += ch;
                }
                if (!allValid)
                {
                         //document.getElementById('fielderror').style.display = '';
                        return (false);
                }

                if(a >= 10  && a <= 10000){
                        //document.getElementById('fielderror').style.display = 'none';
                        window.name="OCpaymentParent_advpayment";
                        if (! window.focus) return true;
                        window.open('', windowname, 'scrollbars,status,width=550,height=600');
                        myform.target=windowname;
                        windowname.focus();
                        return true;
                        //return false;
                } else {
                        //document.getElementById('fielderror').style.display = '';
                        return false;
                }

        }
}
