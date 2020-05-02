
$(document).ready(function() {
    $('.valied_number').on('input', function() {
    match = (/(\d{0,100})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
    this.value = match[1] + match[2];
  });

// discard form rule start

    $('#discardform').bootstrapValidator({

        feedbackIcons: {
            // valid: 'fa fa-check-square-o',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            // start field rule 
            qty: {
                validators: {
                    notEmpty: {
                        message: 'Discard Quantity is required'
                    }
                }
            },//end

            // start field rule 
            reason: {
                validators: {
                    notEmpty: {
                        message: 'Please Provide a reason for discard'
                    }
                }
            },//end
        }
    });
// end discard form rule

// additem form rule start

    $('#addNewItemForm').bootstrapValidator({

         feedbackIcons: {
            // valid: 'fa fa-check-square-o',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            // start field rule 
            count_type: {
                validators: {
                    notEmpty: {
                        message: 'The Count Type is required'
                    }
                }
            },

            // start field rule 
            item_type: {
                validators: {
                    notEmpty: {
                        message: 'The Item Type is required'
                    }
                }
            },
            // end field rule

            // start field rule 
            product_name: {
                validators: {
                    notEmpty: {
                        message: 'Product Name is required'
                    }
                }
            },
            // end field rule

            // start field rule 
            company_name: {
                validators: {
                    notEmpty: {
                        message: 'Company Name is required'
                    }
                }
            },
            // end field rule 

            // start field rule 
            qty: {
                validators: {
                    notEmpty: {
                        message: 'Item Qty is required'
                    },
                }
            },
            // end field rule
             
            // start field rule 
            unit_price: {
                validators: {
                    notEmpty: {
                        message: 'Unit Price is required'
                    }
                }
            },
            // end field rule

            // start field rule 
            selling_price: {
                validators: {
                    notEmpty: {
                        message: 'Unit Price is required'
                    }
                }
            },
            // end field rule

            // // start field rule 
            // expire_date: {
            //     validators: {
            //         date: {
            //             message: 'The Expire Date is not valid'
            //         },
            //     }
            // },
            // // end field rule

            // start field rule 
            alert: {
                validators: {
                    notEmpty: {
                        message: 'Out of remainder is Required'
                    }
                }
            },
            // end field rule
        }
    });
// end additem form rule

//start update form rule
$('#updateform').bootstrapValidator({

        feedbackIcons: {
            // valid: 'fa fa-check-square-o',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            // start field rule 
            qty: {
                validators: {
                    notEmpty: {
                        message: 'Update Quantity is required'
                    },
                }
            },//end

            // start field rule 
            unit_price: {
                validators: {
                    notEmpty: {
                        message: 'Please Provide Unit Price'
                    }
                }
            },//end
        }
    });
// end update form rule

// start add item form rule
$('#new_item_form').bootstrapValidator({

        feedbackIcons: {
            // valid: 'fa fa-check-square-o',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            // start field rule 
            count_type: {
                validators: {
                    notEmpty: {
                        message: 'The Count Type is required'
                    }
                }
            },

            // start field rule 
            item_type: {
                validators: {
                    notEmpty: {
                        message: 'The Item Type is required'
                    }
                }
            },
            // end field rule

            // start field rule 
            product_name: {
                validators: {
                    notEmpty: {
                        message: 'Product Name is required'
                    }
                }
            },
            // end field rule

            // start field rule 
            company_name: {
                validators: {
                    notEmpty: {
                        message: 'Company Name is required'
                    }
                }
            },
            // end field rule 

            // start field rule 
            qty: {
                validators: {
                    notEmpty: {
                        message: 'Item Qty is required'
                    },
                }
            },
            // end field rule
             
            // start field rule 
            unit_price: {
                validators: {
                    notEmpty: {
                        message: 'Unit Price is required'
                    }
                }
            },
            // end field rule

            // start field rule 
            selling_price: {
                validators: {
                    notEmpty: {
                        message: 'Unit Price is required'
                    }
                }
            },
            // end field rule

            // start field rule 
            expire_date: {
                validators: {
                    date: {
                        message: 'The Expire Date is not valid'
                    }
                }
            },
            // end field rule

            // start field rule 
            alert: {
                validators: {
                    notEmpty: {
                        message: 'Out of remainder is Required'
                    }
                }
            },
            // end field rule
        }
    });
// end add item form rule

// start get reservation form rule
$('#getReservationForm').bootstrapValidator({

        feedbackIcons: {
            // valid: 'fa fa-check-square-o',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            // start field rule 
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'First Name is Required'
                    }
                }
            },
            // end field rule 
            // start field rule 
            passport: {
                validators: {
                    notEmpty: {
                        message: 'Passport OR NIC Required'
                    }
                }
            },
            // end field rule 

            // start field rule 
            country: {
                validators: {
                    notEmpty: {
                        message: 'Passport OR NIC Required'
                    }
                }
            },
            // end field rule
            //start field rule 
            travel_agent: {
                validators: {
                    notEmpty: {
                        message: 'Passport OR NIC Required'
                    }
                }
            },
            // end field rule
        }
    });
// end get reservation form rule

// start reservation edit form rule
$('#editReservationForm').bootstrapValidator({

        feedbackIcons: {
            // valid: 'fa fa-check-square-o',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            // start field rule 
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'First Name is Required'
                    }
                }
            },
            // end field rule 
            // start field rule 
            passport: {
                validators: {
                    notEmpty: {
                        message: 'Passport OR NIC Required'
                    }
                }
            },
            // end field rule 

            // start field rule 
            country: {
                validators: {
                    notEmpty: {
                        message: 'Passport OR NIC Required'
                    }
                }
            },
            // end field rule
            //start field rule 
            travel_agent: {
                validators: {
                    notEmpty: {
                        message: 'Passport OR NIC Required'
                    }
                }
            },
            // end field rule
        }
    });
// end reservation edit form rule
});