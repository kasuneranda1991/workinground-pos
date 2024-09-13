$(function () {
 
    // start form
    $('#billing_item_form_validation').validate({
        rules: {
            
            // start input validate
            selling_qty: {
                            required: true,
                            number: true,
                            min:0.00,
                        },
            // end input validate

            // start input validate
            selling_batch_no: {
                            required: true,
                            number: true,
                            min: 1,
                            step: 1,
                        },
            // end input validate

            // start input validate
            selling_discount: {
                            number: true,
                            min: 0.0,
                        },
            // end input validate
        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });
    // end form

    // start form
    $('#finishBillForm').validate({
        rules: {
            
            // start input validate
            cash_amount: {
                            required: true,
                            number: true,
                            min:0.00,
                        },
            // end input validate

            // start input validate
            customer_no: {
                            // required: true,
                            number: true,
                            min:0.00,
                            minlength:10,
                            maxlength:10,
                            step:1,
                        },
            // end input validate

        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
            $('#finishBillBtn').removeAttr('disabled');
        }
    });
    // end form

    // start form
    $('#returnItemFormnew').validate({
        rules: {
            
            // start input validate
            reason: {
                        required: true,
                        
                    },
            // end input validate

            // start input validate
            qty: {
                    required: true,
                    number: true,
                    min:1,
                },
            // end input validate
        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });
    // end form
});