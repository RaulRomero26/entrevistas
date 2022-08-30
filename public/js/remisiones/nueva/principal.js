// Insert new chip
$("#Alias").keyup(function(event) {
    var data = this.value;
    if (data != "") {

        if (event.keyCode === 13) {
            $('<div class="chip"> ' + data + ' <span class="closebtn" >&times;</span></div>').appendTo('#contenido');
            $("#Alias").val(null);

            
        }
    }
});







// Remove chip
$(document).on('click', '.closebtn', function() {
    $(this).parent().remove();
});

function ventanaSecundaria(URL) {
    window.open(URL, '_blank', "width=500,height=500,scrollbars=YES,centerscreen")
}