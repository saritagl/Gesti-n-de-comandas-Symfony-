$('#picker-from').datetimepicker({
    format : "DD/MMM/YYYY",
    defaultDate: moment(new Date())
});
$('#picker-to').datetimepicker({
    format : "DD/MMM/YYYY",
    defaultDate: moment(new Date())
});
$("#picker-from").on("dp.change", function (e) {
    $('#picker-to').data("DateTimePicker").minDate(e.date);
});
$("#picker-to").on("dp.change", function (e) {
    $('#picker-from').data("DateTimePicker").maxDate(e.date);
});

$('#term').on('change', function(){
    if(this.value == 'custom'){

        $('#picker-to').data("DateTimePicker").enable();
        $('#picker-from').data("DateTimePicker").enable();

        mind = $('#picker-from').data("DateTimePicker").date();
        maxd = $('#picker-from').data("DateTimePicker").date();
        $('#picker-to').data("DateTimePicker").minDate(mind);
        $('#picker-from').data("DateTimePicker").maxDate(maxd);

    } else {

        $('#picker-to').data("DateTimePicker").disable();
        $('#picker-from').data("DateTimePicker").disable();
        $('#picker-to').data("DateTimePicker").minDate(false);
        $('#picker-from').data("DateTimePicker").maxDate(false);

        switch(this.value){
            case 'today':
                b = moment();
                e = b;
                break;
            case 'yesterday':
                b = moment().subtract(1, 'day');
                e = b;
                break;
            case 'current month':
                b = moment().date(1);
                e = moment();
                break;
            case 'last month':
                b = moment().date(1).subtract(1, 'month');
                e = moment().date(0);
                break;
        }
        $('#picker-from').data("DateTimePicker").date(b);
        $('#picker-to').data("DateTimePicker").date(e);
    }
});

$('#submit').click(function() {
    from = $('#picker-from').data("DateTimePicker").date().unix();
    to = $('#picker-to').data("DateTimePicker").date().unix();
    qtype = $('#type').val();

    $.get(baseurl + '/invoice/' + qtype + '/' + from + '/' + to,
    function(data, status){
        $('#report').html(data);
    });
});
