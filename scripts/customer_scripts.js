function customerPageOnload() {
    checkIfCancelAccTab();
    checkIfCancelProvTab();
}

//account tab
function checkIfCancelAccTab() {
    if($('#cust_account_form #cancel_no').is(":checked") == true) {
        cancelAccNo();
    }
}

function cancelAccYes() {
    $('#cust_account_form #cancel_reason').prop('disabled', false);
}

function cancelAccNo() {
    $('#cust_account_form #cancel_reason').prop('disabled', true);
}

//provisioning tab
function checkIfCancelProvTab() {
    if($('#cust_provisioning_form #cancel_no').is(":checked") == true) {
        cancelProvNo();
    }
}

function cancelProvYes() {
    $('#cust_provisioning_form #cancel_reason').prop('disabled', false);
}

function cancelProvNo() {
    $('#cust_provisioning_form #cancel_reason').prop('disabled', true);
}

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

//disable "enter" form submit
$('#cust_account_form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
});

$("#noid_cust_account_form").validate({
    ignore: "",
    rules: {
        cID: { 
            required: true 
        }
    },
    messages: {
        cID: {
            required: false
        }
    },
    focusInvalid: false,
    errorPlacement: function(){
        return false;
    },
    submitHandler: function(form) {
        form.submit();
    },
    showErrors: function(errorMap, errorList) {
        $(".form-errors").html("No customer selected");
    }
});

$("#cust_account_form").validate({
    rules: {
        acc_b_name: { 
            required:true 
        },
        acc_fname: { 
            required:true 
        },
        acc_lname: { 
            required:true 
        },
        acc_phone: {
            required:true
        },
        acc_email: {
            required:true
        },
        acc_bill_add_1: {
            required:true
        },
        acc_bill_city: {
            required:true
        },
        acc_bill_state: {
            required:true
        },
        acc_bill_zip: {
            required:true
        }
    },
    messages: {
        acc_b_name: "*",
        acc_fname: "*",
        acc_lname: "*",
        acc_phone: "*",
        acc_email: "*",
        acc_bill_add_1: "*",
        acc_bill_city: "*",
        acc_bill_state: "*",
        acc_bill_zip: "*"
    },
    focusInvalid: false,
    invalidHandler: function() {
        $(this).find(":input.error:first").focus();
    },
    submitHandler: function(form) {
        var errorForm = 0;

        //check primary phone
        var str = $('#acc_phone').val();
        var i = str.length;
        var count = 0;
        var res = "";
        while(count < i) {
            if(str[count] != '-') {
                res += str[count];
            }
            count++;
        }

        if(res.length != 11) {
            $('#errpp').text('must be 11 digits');
            $('#acc_phone').focus();
            errorForm = 1;
        } 

        //check office phone
        if($('#acc_office_phone').val() != null) {
            var str1 = $('#acc_office_phone').val();
            var i1 = str1.length;
            var count1 = 0;
            var res1 = "";
            while(count1 < i1) {
                if(str1[count1] != '-') {
                    res1 += str1[count1];
                }
                count1++;
            }

            if(res1.length != 11) {
                $('#errofficep').text('must be 11 digits');
                $('#acc_office_phone').focus();
                errorForm = 1;
            }
        }

        if($('#acc_bill_zip').val().length != 5) {
            $('#errzip').text('must be 5 digits');
            $('#acc_bill_zip').focus();
            errorForm = 1;
        }

        if(errorForm == 0) {
            form.submit();
        } else {
            return false;
        }
    }
});
    
$("#cust_provisioning_form").validate({
    rules: {
        bname: { 
            required:true 
        },
        b_email: { 
            required:true 
        }
    },
    messages: {
        bname: "*",
        b_email: "*"
    },
    focusInvalid: false,
    invalidHandler: function() {
        $(this).find(":input.error:first").focus();
    },
    submitHandler: function(form) {
        form.submit();
    }
});

$("#email_box").mousewheel(function(event, delta) {
    this.scrollLeft -= (delta * 30);
    event.preventDefault();
});

function KeyPressPrimeP(evt){
    $('#errpp').empty();
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if(charCode == 45) {
            return true;
        } else {
            return false; 
        }
    } else {
        return true; 
    } 
}

function KeyPressAltP(evt){
    $('#errofficep').empty();
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if(charCode == 45) {
            return true;
        } else {
            return false; 
        }
    } else {
        return true; 
    } 
}

function KeyPressMobileP(evt){
    $('#errmp').empty();
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if(charCode == 45) {
            return true;
        } else {
            return false; 
        }
    } else {
        return true; 
    } 
}

function KeyPressZIP(evt){
    $('#errzip').empty();
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true; 
    } 
}

function reEnrollCustomer(id) {
    window.open('register2?pn=1&cid='+id, '_blank');
    //alert(id);
}