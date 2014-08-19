function sliderCount(sliderWidth, count) {
	var containerWidth = $('.wrap').width()
	var screenCount = Math.floor(containerWidth/sliderWidth);
	if (count == undefined) {
		return screenCount;
	}
	else {
		if (count/screenCount <= 2) {
			return count - screenCount;
		}
		else {
			return screenCount;
		}
	}
}

function normalizeExhibitions() {
	var normalPadding = 10;
	var maxHeight = 0;
	for ( var i = 0; i < $('.events-scale .exhibition').length; i++ ) {
		var exhibition =$('.events-scale .exhibition').get(i);
		if ($(exhibition).height() > maxHeight) {
			maxHeight = $(exhibition).height()
		}
	}
	$('.events-scale .cols > li').css('padding-bottom', maxHeight+normalPadding+'px' )
}

function toggleDropdown(el) {
	$(el).parents('*[role="dropdown-parent"]').find('.dropdown-list').slideToggle(300);
	var shadow = $(el).parents('*[role="dropdown-parent"]').find('.noshadow');
	if (shadow.is(":visible")) {
		shadow.delay(300).toggle(0);
	}
	else {
		shadow.toggle();
	}
}

/*function showBacklight(el) {
	$('.events-scale .backlight').stop();
	
	$('.events-scale p.date').removeClass('current');

	var hour = $(el).parent().parent().parent().find('.date').data('hour');
	var period = $(el).parent().data('period');
	var start = parseInt(period.substr(0,2));
	var end = parseInt(period.substr(3,2));
	if (start > end) {
		end = 25;
	}

	for (var i = start; i<end; i++) {
		$('.events-scale p.date[data-hour="'+i+'"]').addClass('current');
	}

	var startColumn = $('.events-scale p.date[data-hour="'+start+'"]');

	var backlightPadding = 5;
	var columnCount = end - start;
	var columnWidth = $('.events-scale .events').width();
	var columnPadding = 10;

	$('.events-scale .backlight').css('width', columnPadding + columnCount*columnWidth + (columnCount-1)*columnPadding);
	$('.events-scale .backlight').css('left', $(startColumn).offset().left - backlightPadding - $('.events-scale').offset().left);

	$('.events-scale .backlight').fadeIn(300);
}


function hideBacklight(el) {
	$('.events-scale .backlight').stop();
	
	$('.events-scale p.date').removeClass('current');

	$('.events-scale .backlight').fadeOut(300);
}*/

$(document).ready(function(){

	//магия дропдаунов

	$('.noshadow').each(function(){
		$(this).css('width', ($(this).parent().find('.dropdown-list').outerWidth()) + 'px');
	});

	$('a[role="login-toggle"]').bind('click', function(){
		$('.login .form').fadeIn(300);
		return false;
	});

	$('a[role="dropdown-trigger"]').bind('click', function(){
		toggleDropdown($(this));
		return false;
	});

	$('a[role="close"]').bind('click', function(){
		$('*[role="closeable"]').fadeOut(300);
		return false;
	});

	//====================================

	$('.content-items .item, .results .item').bind('click', function(){
		var link = $(this).find('h2 > a').attr("href")
		window.location = link
	});

	//затухание ссылки на профиль при заполнении
	$('.profile nobr').each(function(){
		var fakeLink = '<span class="fakelink">' + $(this).find('a').html() + '</span>';
		$('body').append(fakeLink);
		if ($(this).width() != $('.fakelink').width()) {
			$(this).addClass('overnobr');
		}
	});

	//слайдер шкалы мероприятий
	if ($("#events-slider").length) {
		adjustCells();
		var sudoSlider = $("#events-slider").sudoSlider({
	        moveCount: sliderCount(140),
	        slideCount: sliderCount(140),
			autoWidth: false,
			autoHeight: false,
			prevHtml:'<a href="#" class="prevBtn prevnext"><span></span></a>',
			nextHtml:'<a href="#" class="nextBtn prevnext"><span></span></a>'
		});
		$(window).scroll(function(){
		    //$(".events-scale .prevnext:before").css("top",Math.max(0,250-$(this).scrollTop()));
		    var offset = $(".events-scale .prevnext").offset();
			var posY = offset.top - $(window).scrollTop();
			if (posY<-100)
				$(".events-scale .prevnext span").css('top', -posY+200+'px');
		});
	}

	//слайдер избранного
	if ($(".results").length && ($('.wrap').width() < $(".results .event-preview").length*$(".results .event-preview").outerWidth(true))) {
		var eventsSlider = $(".results .slider").sudoSlider({
	        moveCount: sliderCount($('.event-preview').outerWidth(), $('.results .event-preview').length),
	        slideCount: sliderCount($('.event-preview').outerWidth()),
			autoWidth: false,
			autoHeight: false,
			continuous: true,
			prevHtml:'<a href="#" class="prevBtn prevnext"></a>',
			nextHtml:'<a href="#" class="nextBtn prevnext"></a>'
		});
	}

	//кастомизация файилинпута
	$('#file').change(function() {
		$('#file').each(function() {
			var name = this.value;
				reWin = /.*\\(.*)/;
			var fileTitle = name.replace(reWin, "$1");
			reUnix = /.*\/(.*)/;
			fileTitle = fileTitle.replace(reUnix, "$1");
		    $('#name').html(fileTitle);
		});
	});

	//выбор даты и времени
	if ($(".date input").length) {
		$(".date input").datepicker(

		);
	}
	if ($(".time input").length) {
		$(".time input").timepicker({ 'timeFormat': 'H:i' });
	}

	//Подсветка времени в таблице
	/*$(".events-scale ul li a").bind("mouseenter", function(){
		showBacklight($(this));
	});
	$(".events-scale ul li a").bind("mouseleave", function(){
		hideBacklight($(this));
	});*/

	//IE MUST UNDERSTAND CHECKED SIBLINGS!!!!!!!111111111111
	if ($("body").hasClass("ie8")) {
		$('.onoffswitch').removeClass('onoffswitch').addClass('ieswitch');
	}

	/* Добавление в избранное */
	if ($('.addToFavorites').length) {
		$('.addToFavorites').on('click', function(){
			var _that = $(this);
			$.post("/event/addToFavorites/time_id/"+$(this).data('id'), function(){
				alert('Мероприятие было успешно добавлено в избранное.');
				_that.after('<span class="button">В избранном</span>').remove();
			});
			return false;
		});
	}
});

function GeneticMisc() {
    if ( GeneticMisc.i !== undefined )
        return GeneticMisc.i;

   	GeneticMisc.i = {
   		MORNING_ENDING: 08,
   		toDate: function(date) { /* date = '23.06.1990'; */
   			var dateArray = date.split('.');
   			return new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);
   		},
   		tomorrow: function(date) { /* date = new Date(); */
   			return new Date(date.getTime() + 24 * 60 * 60 * 1000);
   		},
   		tomorrowStarts: function() {
   			var now = new Date();
   			var todayStarts = new Date(now.getFullYear(), now.getMonth(), now.getDate());
   			return GeneticMisc.i.tomorrow(todayStarts);
   		},
		getStart: function(item, date) { /* date = new Date(); */
			var start = $(item).data('period').substr(0,2);
			if (parseInt(start)<GeneticMisc.i.MORNING_ENDING) {
				start = 24 + parseInt(start);
			}
			return {
				hour: parseInt(start),
				date: date
			};
		},
		getEnd: function(item, date) { /* date = new Date(); */
			var hour = { 
				start: $(item).data('period').substr(0,2),
				end: $(item).data('period').substr(3,2),
			}; 
			endDate = date;
			if (hour.start > hour.end) {
				endDate = GeneticMisc.i.tomorrow(date);
			}
			if (endDate >= GeneticMisc.i.tomorrowStarts()) {
				hour.end = 24 + parseInt(hour.end);
			}
			return {
				hour: parseInt(hour.end),
				date: endDate
			};
		}
   	}

	return GeneticMisc.i;
}

function GeneticKnapsack () {
    if ( GeneticKnapsack.i !== undefined )
        return GeneticKnapsack.i;

   	GeneticKnapsack.i = {
   		hours: [],
   		minHour: 0,
   		value: 0,
   		misc: new GeneticMisc,
   		init: function(events) {
   			GeneticKnapsack.i.minHour = $(events).children('li:first').data('hour');
   			for (var i=0; i<$(events).children('li').length; i++) {
   				var item = $(events).children('li:eq('+i+')');
   				var hourEvents = {
   					hour: $(item).find('.date').data('hour'),
   					date: GeneticKnapsack.i.misc.toDate($(item).find('.date').data('date')),
   					events: []
   				};
   				for (var j=0; j<$(item).find('.events').children('li').length; j++) {
   					var eventItem = $(item).find('.events').children('li:eq('+j+')');
   					hourEvents.events.push({
   						liIndex: hourEvents.hour - GeneticKnapsack.i.minHour,
   						start: GeneticKnapsack.i.misc.getStart(eventItem, hourEvents.date),
   						end: GeneticKnapsack.i.misc.getEnd(eventItem, hourEvents.date),
   						el: eventItem
   					});
   				}
   				GeneticKnapsack.i.hours.push(hourEvents);
   			}
   			GeneticKnapsack.i.population = GeneticKnapsack.i.creation();
   		},
   		population: [],
   		getRemaining: function(population) {
   			for (var i=0; i<population.length; i++) {
   				if (population[i].knapsack === false) 
   					return i;
   			}
   			return false;
   		},
   		checkAbility: function(individual, knapsack) {
   			for (var i=0; i<knapsack.length; i++) {
   				if  (Math.max(individual.start.hour, knapsack[i].start.hour) < Math.min(individual.end.hour, knapsack[i].end.hour))
   					return false;
   			}
   			return true;
   		},
   		creation: function() {
   			var result = {
   				individuals: [],
   				knapsacksCount: 0
   			};

   			for (var i = 0; i<GeneticKnapsack.i.hours.length; i++) {
   				for (var j = 0; j<GeneticKnapsack.i.hours[i].events.length; j++) {
   					result.individuals.push({
   						el: jQuery.extend({},GeneticKnapsack.i.hours[i].events[j]),
   						knapsack: false
   					});
   				}
   			}

   			var knapsacks = [];
   			var remaining = GeneticKnapsack.i.getRemaining(result.individuals);
   			while (remaining !== false) {
   				var fullKnapsacks = true;
   				for (var i=0; i<knapsacks.length; i++) {
   					if (GeneticKnapsack.i.checkAbility(result.individuals[remaining].el, knapsacks[i])) {
						result.individuals[remaining].knapsack = i;
   						knapsacks[i].push(result.individuals[remaining].el);
   						fullKnapsacks = false;
						break;
   					}
   				}
   				if (fullKnapsacks) {
   					knapsacks.push([result.individuals[remaining].el]);
   					result.individuals[remaining].knapsack = knapsacks.length-1;
   				}
   				remaining = GeneticKnapsack.i.getRemaining(result.individuals);   				
   			}
   			result.knapsacksCount = knapsacks.length;
   			return result;
   		}

   	} 

	return GeneticKnapsack.i;
}

function adjustCells() {
	if ($('.events-scale').length) {

		/*SHOULD BE DELETED ON PRODUCTION*/
		$('.events-scale .cols .date').each(function(){
			var date = new Date();
			if ($(this).hasClass('tomorrow')) {
				date = new Date(date.getTime() + 24 * 60 * 60 * 1000);
			}
			$(this).data('date', date.getDate()+'.'+(date.getMonth()+1)+'.'+date.getFullYear());
		});
		/*----------------------*/

		var g = new GeneticKnapsack;
		g.init('.events-scale .cols');
		var rowHeights = new Array(g.population.knapsacksCount);
		for (var i=0; i<rowHeights.length; i++) {
			rowHeights[i] = 0;
		}
		for (var i=0; i<g.population.individuals.length; i++) {
			if ($(g.population.individuals[i].el.el).find('a').outerHeight() > rowHeights[g.population.individuals[i].knapsack])
				rowHeights[g.population.individuals[i].knapsack] = $(g.population.individuals[i].el.el).find('a').outerHeight();
		}

		var marginBottom = 10;
		for (var i=0; i<rowHeights.length; i++) {
			rowHeights[i] += marginBottom;
		}
		var rowTops = rowHeights;
		for (var i=0; i<rowTops.length; i++) {
			if (i>0)
				rowTops[i] += rowTops[i-1];
		}

		var elWidth = 130;
		var elMargin = 10;
		var elPadding = 10;
		for (var i=0; i<g.population.individuals.length; i++) {
			var el = g.population.individuals[i];
			$(el.el.el).find('a').css('top', rowTops[el.knapsack]+'px');
			//$(el.el.el).find('a').html(el.knapsack+' '+el.el.start.hour+'-'+el.el.end.hour);
			var end = el.el.end.hour;
			if (end < el.el.start.hour)
				end += 24;
			$(el.el.el).find('a').css('width', (end-el.el.start.hour)*elWidth-elPadding*2+'px');
			$(el.el.el).find('a').css('left', (el.el.liIndex)*(elWidth+elMargin)+'px');
		}
		$('.events-slider').css('height', rowTops[rowTops.length-1]+30+'px');
		$('.events-slider .now').css('height', rowTops[rowTops.length-1]+30+'px').show();

		var maxHour = 0
		for (var i=0; i<g.population.individuals.length; i++) {
			if (g.population.individuals[i].el.end.hour>maxHour) 
				maxHour = g.population.individuals[i].el.end.hour;
		}
		var currentMaxHour = parseInt($('.events-scale .cols li:last-child p.date').data('hour'));
		var gm = new GeneticMisc;
		if (currentMaxHour<gm.MORNING_ENDING) 
			currentMaxHour += 24;
		for (i=(currentMaxHour+1);i<maxHour;i++) {
			var k = i
			if (k>24)
				k -= 24;
			if (k<10)
				k = '0'+k;
			$('.events-scale .cols').append('<li><p class="date">'+k+':00</p></li>')
		}
	}
}


jQuery(function($){

	$.datepicker.regional['ru'] = {
	        closeText: 'Закрыть',
	        prevText: '&#x3c;Пред',
	        nextText: 'След&#x3e;',
	        currentText: 'Сегодня',
	        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
	        'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
	        'Июл','Авг','Сен','Окт','Ноя','Дек'],
	        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
	        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
	        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	        weekHeader: 'Не',
	        dateFormat: 'dd.mm.yy',
	        firstDay: 1,
	        isRTL: false,
	        showMonthAfterYear: false,
	        yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});


        window.onload = function () {
        	if (document.getElementById("YMapsID")) {
            	var map = new YMaps.Map(document.getElementById("YMapsID"));
            	map.setCenter(new YMaps.GeoPoint(37.64, 55.76), 10);
	            var s = new YMaps.Style();
	            s.iconStyle = new YMaps.IconStyle();
	            s.iconStyle.href = "http://zovem.amobile2.tmweb.ru/img/map-icon-dinner.png";
	            s.iconStyle.size = new YMaps.Point(40, 46);
	            s.iconStyle.offset = new YMaps.Point(-20, -46);

	            s.iconStyle.shadow = new YMaps.IconShadowStyle();
				s.iconStyle.shadow.href = "http://zovem.amobile2.tmweb.ru/img/map-icon-shadow.png";
				s.iconStyle.shadow.size = new YMaps.Point(73, 37);
				s.iconStyle.shadow.offset = new YMaps.Point(-22, -33);

	            var placemark = new YMaps.Placemark(map.getCenter(), {style: s});
	            map.addOverlay(placemark);
        	}
        }