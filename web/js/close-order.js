$('#search-btn').click(function(){
    getClientName();
});

$('#client-ci').on('keypress', function(evt){
    if(evt.keyCode == 13){
        getClientName();
    }else{
        $('#client-name').val('');
    }
});

function getClientName(){
    $.get(baseurl + '/client/' + $('#client-ci').val() + '/ci',
    {
        attr: 'name'
    },
    function(data){
        $('#client-name').val(data);
    });
}
