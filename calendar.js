$(document).ready(function() {

    $('#exampleModalCenter').on('hidden.bs.modal', function () {
        $("#addForm").trigger("reset");
    });

    $('#group_filter_form').hide();
    $('#calendar_filter').change(function(){
        if($('#calendar_filter').val() == "All"){
            $('#group_filter_form').hide();
            $('#group_filter').empty();
        }else{
            console.log($('#calendar_filter').val());
            var val = $('#calendar_filter').val();
            $('#group_filter').empty();
            $.ajax({
                type: 'POST',
                url: 'calendar/filterGrp.php',
                data: { val: val},
                
                success: function(groupsArr){
                    console.log(groupsArr);
                    var data = JSON.parse(groupsArr);
                    // groupsArr.forEach(addGroupFilter);
                    $.each(data, function( index, value ) {
                        console.log(value);
                        $('#group_filter').append('<option id="'+value+'">'+value+'</option>');
                    });
                }
            });
            $('#group_filter_form').show();

        }
    });
   
    // function addGroupFilter(item){
    //     $('#group_filter').append('<option id="'+item+'">'+item+'</option>');
    // }
    $('#calendar_filter, #group_filter').change(function(){
        $('#calendar').fullCalendar('refetchEvents');
    });

    window.mobilecheck = function() {
        var check = false;
        console.log("checking");
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

    var calendar = $('#calendar').fullCalendar({
        height: 750,
        editable:true,
        selectable:true,
        selectHelper:true,
        eventLimit: true,
        themeSystem: 'bootstrap',
        dayMaxEvents: true,
        nowIndicator: true,
        displayEventEnd: true,
        defaultView: window.mobilecheck() ? "listMonth" : "month"   ,

        dayPopoverFormat:{ month: 'long', day: 'numeric', year: 'numeric' }
        ,
        header: {
            left: ' title',
            center: 'month, agendaWeek, agendaDay, listMonth',
            right: 'today, prev,next'
        },
        buttonText: {
            today:    'Today',
            month:    'Month',
            week:     'Week',
            day:      'Day',
            list:     'List'
        },
        showNonCurrentDates: false,
        fixedWeekCount: false,
        longPressDelay: 100,
        events: 'calendar/load.php',

        eventRender: function eventRender( event ) {
            if($('#calendar_filter').val() === "All"){
                return ['All', event.calendar].indexOf($('#calendar_filter').val()) >= 0;
            }else{
                return ['All', event.calendar].indexOf($('#calendar_filter').val()) >= 0 &&
                ['All', event.group].indexOf($('#group_filter').val()) >= 0;
            }
        },
        
        select: function(start, end, allDay){

            console.log("Event Start date: " + moment(start).format('DD-MM-Y'),
                "Event End date: " + moment(end).subtract(1, "days").format('DD-MM-YYYYTHH:mm:ss'),
                "AllDay: " + allDay);

            $('#exampleModalCenter').modal('show');
            
            $('#addForm').on('submit', function(e){
                e.preventDefault();
                var title = $('#ttTitle').val();
                var ttCalendar = $('#ttCalendar').val();
                var group = $('#ttGroup').val();
                var color = $('#ttColor').val();
                var fromTime = $('#fromTime').val();
                var toTime = $('#toTime').val();
                var ttDesc = $('#ttDesc').val();
                console.log(title, fromTime.toString(), toTime.toString);
                $.ajax({
                    type: 'POST',
                    url: 'calendar/insert.php',
                    data: $('#addForm').serialize(),
                    
                    success: function(){
                        console.log("added");
                        $('#exampleModalCenter').modal('hide');

                        $('#exampleModalCenter').on('hidden.bs.modal', function () {
                            $("#addForm").trigger("reset");
                        });
                        console.log(ttCalendar);
                        // $('#calendar_filter').append(`<option id="${ttCalendar}" value="${ttCalendar}"> 
                        //         ${ttCalendar} 
                        //           </option>`); 
                        // $('#group_filter').append(`<option id="${group}" value="${group}"> 
                        //         ${group} 
                        //      </option>`);
                        calendar.fullCalendar('refetchEvents');
                    }
                });
            });
            
        },
        eventClick:function(event){

            var id = event.id;
            var group = event.group;
            var ttCalendar = event.calendar;
            $('#editModalCenter').modal('show');
            
            console.log(moment(event.start).format(), moment(event.end).format());
            $('#editTitle').val(event.title);
            $('#editCalendar').val(event.calendar);
            $('#editGroup').val(event.group);
            $('#editColor').val(event.backgroundColor);
            $('#editFromTime').val(moment(event.start).format());
            $('#editToTime').val(moment(event.end).format());
            $('#editDesc').val(event.descs);
            $('#deleteButton').on('click', function(e){
                e.preventDefault();
                console.log(id);
                console.log(ttCalendar);
                $.ajax({
                    type: 'POST',
                    url: 'calendar/delete.php',
                    data: {
                        id: id,
                        group: group,
                        calendar: ttCalendar
                    },
                    
                    success: function(){
                        console.log("deleted");
                        $('#editModalCenter').modal('hide');
                        $('#editModalCenter').on('hidden.bs.modal', function () {
                            $(this).find("input,textarea").val('').end();
                        });
                        
                        calendar.fullCalendar('refetchEvents');
                    }
                });
            });
            // Update on Save
            $('#saveButton').on('click', function(e){
                e.preventDefault();
                var title = $('#ttTitle').val();
                var ttCalendar = $('#ttCalendar').val();
                var group = $('#ttGroup').val();
                var color = $('#ttColor').val();
                
                var fromTime = $('#fromTime').val();
                var toTime = $('#toTime').val();
                var ttDesc = $('#ttDesc').val();
                console.log($('#editForm').serialize()+"&eventId="+id);
                var finalData = $('#editForm').serialize()+"&eventId="+id;
                $.ajax({
                    type: 'POST',
                    url: 'calendar/update.php',
                    data: finalData,
                    
                    success: function(){
                        console.log("update");
                        $('#editModalCenter').modal('hide');
                        $('#editModalCenter').on('hidden.bs.modal', function () {
                            $(this).find("input,textarea").val('').end();
                        });
                        calendar.fullCalendar('refetchEvents');
                    }
                });
            });
        },
        eventResize: function(event){
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            var id = event.id;
            console.log(start, end);
            $.ajax({
                url:'calendar/updateTime.php',
                type: 'POST',
                data: {
                    start: start,
                    end: end,
                    id: id,
                },
                success: function(){
                    console.log("update");
                    calendar.fullCalendar('refetchEvents');
                }
            });
        },
        eventDrop: function(event) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            var id = event.id;
            console.log(start, end);
            $.ajax({
                url:'calendar/updateTime.php',
                type: 'POST',
                data: {
                    start: start,
                    end: end,
                    id: id,
                },
                success: function(){
                    console.log("update");
                    calendar.fullCalendar('refetchEvents');
                }
            });
        }

    });
    
});