


class EventsManager {
    constructor() {
      self= this
        this.obtenerDataInicial()
    }


    obtenerDataInicial() {
        let url = '../server/getEvents.php'
        $.get(url, function(data){
          console.log(data);
          var respuesta = JSON.parse(data);
          console.log(respuesta[0]);
          console.log(respuesta[1]);
          if (respuesta[0]=="OK") {
            self.poblarCalendario(respuesta[1]);
          }else {
            alert(respuesta[0])
            window.location.href = 'index.html';
          }
        }).fail(function() {
          alert( "Se presentó un error" );
        });
        // $.ajax({
        //   url: url,
        //   cache: false,
        //   type: 'GET',
        //   success: (data) =>{
        //     var respuesta = JSON.parse(data);
        //     console.log(respuesta[0]);
        //     console.log(respuesta[1]);
        //     if (data.msg=="OK") {
        //       this.poblarCalendario(data.eventos)
        //     }else {
        //       alert(data.msg)
        //       window.location.href = 'index.html';
        //     }
        //   },
        //   error: function(){
        //     alert("error en la comunicación con el servidora");
        //   }
        // })

    }

    poblarCalendario(eventos) {
        $('.calendario').fullCalendar({
            header: {
        		left: 'prev,next today',
        		center: 'title',
        		right: 'month,agendaWeek,basicDay'
        	},
        	defaultDate: '2016-11-01',
        	navLinks: true,
        	editable: true,
        	eventLimit: true,
          droppable: true,
          dragRevertDuration: 0,
          timeFormat: 'H:mm',
          eventDrop: (event) => {
              this.actualizarEvento(event)
          },
          events: eventos,
          eventDragStart: (event,jsEvent) => {
            $('.delete-btn').find('img').attr('src', "img/trash-open.png");
            $('.delete-btn').css('background-color', '#a70f19')
          },
          eventDragStop: (event,jsEvent) =>{
            var trashEl = $('.delete-btn');
            var ofs = trashEl.offset();
            var x1 = ofs.left;
            var x2 = ofs.left + trashEl.outerWidth(true);
            var y1 = ofs.top;
            var y2 = ofs.top + trashEl.outerHeight(true);
            if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
                jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                  this.eliminarEvento(event, jsEvent)
                  $('.calendario').fullCalendar('removeEvents', event.id);
            }

          }
        })
    }

    anadirEvento(){
      var titulo = $('#login-form').find('#titulo').val()
      var start_date = $('#login-form').find('#start_date').val()
      var allDay = document.getElementById('allDay').checked
      if (!document.getElementById('allDay').checked) {
        var end_date = $('#login-form').find('#end_date').val()
        var end_hour = $('#login-form').find('#end_hour').val()
        var start_hour = $('#login-form').find('#start_hour').val()
      }else {
        var end_date = ""
        var end_hour = ""
          var start_hour = ""
      }
      var datos = {"titulo": titulo,"start_date":start_date,"allDay": allDay,"end_date":end_date,"end_hour": end_hour,"start_hour":start_hour,};
      $.ajax({
        url: '../server/new_event.php',
        cache: false,
        data: datos,
        type: 'POST',
        success: (data) =>{
          console.log(data);
          var respuesta = JSON.parse(data);
          if (respuesta[0]=="OK") {
          if (respuesta[1]=="OK") {
            alert('Se ha añadido el evento exitosamente')
            if (document.getElementById('allDay').checked) {
              $('.calendario').fullCalendar('renderEvent', {
                title: $('#titulo').val(),
                start: $('#start_date').val(),
                allDay: true
              })
            }else {
              $('.calendario').fullCalendar('renderEvent', {
                title: $('#titulo').val(),
                start: $('#start_date').val()+" "+$('#start_hour').val(),
                allDay: false,
                end: $('#end_date').val()+" "+$('#end_hour').val()
              })
            }

          }else {
            alert(respuesta[1])
          }
        }
        },
        error: function(){
          alert("error en la comunicación con el servidor");
        }
      })

    }

    eliminarEvento(event, jsEvent){

      var id = event.id
      console.log(jsEvent.id);
      console.log(event);
      var data = {"id": id};
      console.log(data);
      $.ajax({
        url: '../server/delete_event.php',
        cache: false,
        data: data,
        type: 'POST',
        success: (data) =>{
          var respuesta = JSON.parse(data);
          if (respuesta[0]=="OK") {
          if (respuesta[1]=="OK") {
            alert('Se ha eliminado el evento exitosamente')
          }else {
            alert(respuesta[1])
          }
        }
        },
        error: function(){
          alert("error en la comunicación con el servidor");
        }
      })
      $('.delete-btn').find('img').attr('src', "img/trash.png");
      $('.delete-btn').css('background-color', '#8B0913')
    }

    actualizarEvento(evento) {
        let id = evento.id,
            start = moment(evento.start).format('YYYY-MM-DD HH:mm:ss'),
            end = moment(evento.end).format('YYYY-MM-DD HH:mm:ss'),
            start_date,
            end_date,
            start_hour,
            end_hour;


        start_date = start.substr(0,10)
        end_date = end.substr(0,10)
        start_hour = start.substr(11,8)
        end_hour = end.substr(11,8)

     var data = {"id": id, start_date: start_date, "end_date": end_date, "start_hour": start_hour, "end_hour": end_hour};
        console.log(data);
        $.ajax({
          url: '../server/update_event.php',
          cache: false,
          data: data,
          type: 'POST',
          success: (data) =>{
            console.log(data);
            var respuesta = JSON.parse(data);
            if (respuesta[0]=="OK") {
            if (respuesta[1]=="OK") {
              alert('Se ha actualizado el evento exitosamente')
            }else {
              alert(respuesta[1])
            }
          }
          },
          error: function(){
            alert("error en la comunicación con el servidor");
          }
        })
    }

}


$(function(){
  initForm();
  var e = new EventsManager();
  $('form').submit(function(event){
    event.preventDefault()
    e.anadirEvento()
  })
});



function initForm(){
  $('#start_date, #titulo, #end_date').val('');
  $('#start_date, #end_date').datepicker({
    dateFormat: "yy-mm-dd"
  });
  $('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 30,
    minTime: '5',
    maxTime: '23:30',
    defaultTime: '7',
    startTime: '5:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
  $('#allDay').on('change', function(){
    if (this.checked) {
      $('.timepicker, #end_date').attr("disabled", "disabled")
    }else {
      $('.timepicker, #end_date').removeAttr("disabled")
    }
  })

}
