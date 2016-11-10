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
        form.submit();
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