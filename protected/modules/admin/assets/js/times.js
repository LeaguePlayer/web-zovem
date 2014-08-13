String.prototype.ucfirst = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function u(fn){
  return fn.toString().split(/\/\*|\*\//g)[1];
}


function TimesGenerator() {
  if ( TimesGenerator.i !== undefined )
      return TimesGenerator.i;

  TimesGenerator.i = {


    fc: {
      calendar: $('#timesCalendar'),

      init: function(times) {
        tg.fc.calendar.fullCalendar({
            eventClick: function(calEvent, jsEvent, view) {
              tg._curEventId = calEvent.id;
              tg.showModal('update', undefined);
              tg._curEventId = null;
            }
        });


        tg.times = times;
        this.addTimes(times);
      },

      addTimes: function(newTimes) {
        for(var i=0; i<newTimes.length; i++) {
          tg.fc.calendar.fullCalendar('renderEvent', {
            title: newTimes[i].start + '—' + newTimes[i].end,
            start: $.fullCalendar.moment(newTimes[i].date + ' ' +newTimes[i].start),
            end: $.fullCalendar.moment(newTimes[i].date + ' ' +newTimes[i].end),
            id: newTimes[i].id,
          }, true);
        }
      },

      goToDate: function(newTimes) {
        tg.fc.calendar.fullCalendar('gotoDate', newTimes[newTimes.length - 1].date);
      },

      updateTime: function(id) {
        var event = tg.fc.calendar.fullCalendar('clientEvents', id)[0];

        event.title = tg.times[id].start + '—' + tg.times[id].end;
        event.start = $.fullCalendar.moment(tg.times[id].date + ' ' +tg.times[id].start);
        event.end = $.fullCalendar.moment(tg.times[id].date + ' ' +tg.times[id].end);

        tg.fc.calendar.fullCalendar('updateEvent', event);
        tg.fc.calendar.fullCalendar('rerenderEvents');
      },

      deleteTime: function(id) {
        tg.fc.calendar.fullCalendar('removeEvents', id);
        tg.fc.calendar.fullCalendar('rerenderEvents');
      },

    },


    times: [],
  	type: 'single',

  	singleTemplate: u(function(){/*
         <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	      <h3>{{ method }}</h3>
	    </div>
	  
	    <div class="modal-body">
	  
	      <form id="timeSingleForm" method="POST">
			
      <div class="control-group">
  			<label for="timeSingle['date']">Дата:</label>
  			<div class="input-append date" id="timeSingle['date']">
  			  <input class="datepicker" name="timeSingle['date']" id="timeDate" type="text">
  			  <span class="add-on"><i class="icon-calendar"></i></span>
  			</div>
      </div>

			<div style="margin-left: 30px">
				<div class="row">

					<div class="span6 control-group">
						<label for="timeSingle['start_time']">Время начала:</label>
						<div class="bootstrap-timepicker">
							<div class="input-append">
								<input id="start_time" name="start_time" type="text">
								<span class="add-on"><i class="icon-time"></i></span>
							</div>
						</div>
					</div>
					<div class="span6 control-group">
						<label for="timeSingle['end_time']">Время окончания:</label>
						<div class="bootstrap-timepicker">
							<div class="input-append">
								<input id="end_time" name="end_time" type="text">
								<span class="add-on"><i class="icon-time"></i></span>
							</div>
						</div>
					</div>

				</div>
			</div>

	      </form>
	    </div>
	    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
        {{ deleteButton }}
	      <button class="btn btn-primary timesSubmit" data-id="{{ data-id }}" data-method="{{ data-method }}" id="timeSingleSubmit">Сохранить</button>
	    </div>
	*/}),

    deleteButtonTemplate: u(function() {
      /*
        <button class="btn btn-danger timesDelete" data-id="{{ data-id }}">Удалить</button>
      */
    }),

  	init: function() {


  		//onchange time type
  		$(document.body).on('change', '#timesType', function() {
  			tg.type = $(this).val();
  		});
  		//onclick add button
  		$(document.body).on('click', '#timesModalTrigger', function() {
  			tg.showModal('create');

  			return false;
  		});

      //add single time
      $(document.body).on('click', '.timesSubmit', function() {

        if (tg.validate()) {
          if ($(this).data('method') == 'update') {
            //update existing event
            var id = $(this).data('id'),
                time = tg.times[id];
            time.date = $('#timeDate').val();
            time.start = $('#start_time').data("timepicker").getTime();
            time.end = $('#end_time').data("timepicker").getTime();
            tg.fc.updateTime(id); 
            tg.fc.goToDate([tg.times[id]]);
          }
          else {
            //new event
            var newTimes = tg.collect(tg.times.length);
            tg.times = tg.times.concat(newTimes);

            tg.fc.addTimes(newTimes);
            tg.fc.goToDate(newTimes);
          }

          tg.closeModal();
        }

        return false;
      });

      //add single time
      $(document.body).on('click', '.timesDelete', function() {
        var id = $(this).data('id');

        if (typeof tg.times[id]._id !== 'undefined')
          $.post('/admin/event/deleteTime/id/'+tg.times[id]._id);

        tg.fc.deleteTime(id);
        tg.times[id] = null;
        tg.closeModal();

        return false;
      });

      $(document.body).on('submit', '#event-form', function() {
        var form = $('#event-form');
        for(var i=0;i<tg.times.length;i++) {
          if ( ( typeof tg.times[i] !== 'undefined' ) && ( tg.times[i] ) ) {
            var input = $("<input>", { type: "hidden", name: "Times["+i+"][start_time]", value: tg.times[i].start }); 
            $(form).prepend($(input));

            input = $("<input>", { type: "hidden", name: "Times["+i+"][end_time]", value: tg.times[i].end }); 
            $(form).prepend($(input));

            input = $("<input>", { type: "hidden", name: "Times["+i+"][date]", value: tg.times[i].date }); 
            $(form).prepend($(input));

            if (typeof tg.times[i]._id !== 'undefined') {
              input = $("<input>", { type: "hidden", name: "Times["+i+"][_id]", value: tg.times[i]._id }); 
              $(form).prepend($(input));
            }
          }
        }
      });

  	},

  	showModal: function(method, type) {
  		if (typeof type == 'undefined')
  			type = 'single';

  		this.renderModal(method, type);

		  $('#timesModal').modal('show');
  	},

  	renderModal: function(method, type) {
  		if (typeof method == 'undefined')
  			method = 'create';

  		var template = this.renderTemplate(this[this.type+'Template'], { 'method': method} );
  		$('#timesModal').html(template);

  		this.initWidgets();
  	},

  	initDatePickers: function() {
  		var nowTemp = new Date();
		  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
  		
  		$('.modal .datepicker').datepicker({
  			clearBtn: true,
  			todayHighlight: true,
  			startDate: '+0d',
  			autoclose: true,
        format: 'yyyy-mm-dd',
  		});
  	},

  	initTimePickers: function() {
  		$('#start_time').timepicker({
  			template: 'dropdown',
  			showMeridian: false,
  		}).on('changeTime.timepicker');

  		$('#end_time').timepicker({
  			template: 'dropdown',
  			showMeridian: false,
  		}).on('changeTime.timepicker');
  	},

  	initWidgets: function() {
      if (tg._curEventId != null) 
        this.setInputsVal(this.times[tg._curEventId]);
  		this.initDatePickers();
  		this.initTimePickers();
  	},

    setInputsVal: function(event) {
      $('#timeDate').val(event.date);
      $('#start_time').val(event.start);
      $('#end_time').val(event.end);
    },

  	renderMethod: function(method) {
  		switch (method) {
  			case 'create':
  				return 'Добавление события'
  			case 'update':
  				return 'Редактирование события'
  		}
  	},

  	renderTemplate: function(template, options) {
  		var _template = template;

      _template = _template.replace('{{ method }}', this.renderMethod(options.method));
      _template = _template.replace('{{ data-method }}', options.method);
  		_template = _template.replace('{{ data-id }}', this._curEventId);

      if (options.method == 'create') 
        var deleteButton = '';
      else 
        var deleteButton = this.deleteButtonTemplate.replace('{{ data-id }}', this._curEventId);
      _template = _template.replace('{{ deleteButton }}', deleteButton);

  		return _template;
  	},

    validate: function() {
      var errors = [];
      
      if (tg.type == 'single') {

        //not empty
        for(var i = 0; i < $('#timesModal input').length; i++) {
          var el = $('#timesModal input:eq('+i+')');
          if (! $(el).val()) {
            if ($.inArray(el, errors) < 0)
              errors.push($(el));
          }
        }

        // end > start
        var start = $('#start_time').data("timepicker").getTime(),
            end = $('#end_time').data("timepicker").getTime();
        if (! tg.compareTimes(start, end)) {
          errors.push($('#start_time'));
          errors.push($('#end_time'));
        }

      }

      if (errors.length) {
        tg.showErrors(errors);
        return false;
      }
      else
        return true;
    },

    showErrors: function(errors) {
      for(var i = 0; i < errors.length; i++) {
        $(errors[i]).closest('.control-group').addClass('error').effect('shake', {distance: 10,});

        function removeErrors(i) {
          $(errors[i]).closest('.control-group').removeClass('error');
        }

        setTimeout(removeErrors.bind(this, i), 3000);
      }
    },

    compareTimes: function(d1, d2) {
      var someDate = "Sept 11, 2001 "; //lol
      return (new Date(someDate + d2) > new Date(someDate + d1));
    },

    collect: function(startIndex) {
      if (typeof startIndex == 'undefined')
        startIndex = 0;

      var _times = [];

      if (tg.type == 'single') {
        _times.push({
          date: $('#timeDate').val(),
          start: $('#start_time').data("timepicker").getTime(),
          end: $('#end_time').data("timepicker").getTime(),
          id: startIndex,
        });
      }

      return _times;
    },

    closeModal: function() {
      $('#timesModal').modal('hide');
    },

  }

  TimesGenerator.i.init();

  return TimesGenerator.i;
}


$(document).ready(function(){

  
	tg = new TimesGenerator;
  tg.fc.init(window.times);


});