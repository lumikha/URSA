function cancelCall() {
    $('.cs_loading').addClass("hidden");
    $('#call_body').removeClass("hidden");
    $('#cancel').val("No");
    $('#cancel').removeClass("btn-danger");
    $('#cancel').addClass("btn-default");
    $('#yes').removeClass("hidden");
    history.back()
}
function callNtext() {
    $('.cs_loading').removeClass("hidden");
    $('#call_body').addClass("hidden");
    $('#cancel').val("Cancel");
    $('#cancel').removeClass("btn-primary");
    $('#cancel').addClass("btn-danger");
    $('#yes').addClass("hidden");
}
function callTwilio(){
    $("#callTwilio").modal("show");
}