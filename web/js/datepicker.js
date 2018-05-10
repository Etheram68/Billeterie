$(document).ready(function() {


    var d = new Date();
    var hour = d.getHours();
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var today = day + "/" + month + "/" + year;

    $( ".datepicker-book" ).datepicker({
        showOn: "focus",
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        showWeek: false,
        beforeShowDay: DisabledDays,
        showAnim: "show",
        onSelect: manageTypeTickets
    });

    var FreeDays = ['01/05', '01/11', '25/12'];

    function DisabledDays(date)
    {
        if($.inArray($.datepicker.formatDate('dd/mm', date), FreeDays) > - 1)
        {
            return [false, "", "Unavaible"];
        }
        else if(date.getDay() === 2)
        {
            return [false, "", "Unavaible"];
        }
        else
        {
            return [true];
        }
    }

    function manageTypeTickets()
    {

        var inputWatched = $('.datepicker-book').val();
        var a = $('.typePick option[value=1]');
        var b = $('.typePick option[value=0]');

        if (hour >= 14 && inputWatched === today)
        {

            a.prop( "disabled", true );
            b.prop("selected", true);
        }
        else
            a.prop( "disabled", false );

    }


});