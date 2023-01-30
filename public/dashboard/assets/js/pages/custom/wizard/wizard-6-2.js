"use strict";

// Class definition
var KTWizard6 = function () {
    // Base elements
    var _wizardEl;
    var _formEl;
    var _wizardObj;
    var _validations = [];

    // Private functions
    var _initWizard = function () {
        // Initialize form wizard
        _wizardObj = new KTWizard(_wizardEl, {
            startStep: 1, // initial active step number
            clickableSteps: false  // allow step clicking
        });

        // Validation before going to next page
        _wizardObj.on('change', function (wizard) {
            if (wizard.getStep() > wizard.getNewStep()) {
                return; // Skip if stepped back
            }

            // Validate form before change wizard step
            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        wizard.goTo(wizard.getNewStep());

                        KTUtil.scrollTop();
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light"
                            }
                        }).then(function () {
                            KTUtil.scrollTop();
                        });
                    }
                });
            }

            return false;  // Do not change wizard step, further action will be handled by he validator
        });

        // Change event
        _wizardObj.on('changed', function (wizard) {
            KTUtil.scrollTop();
        });

        // Submit event
        _wizardObj.on('submit', function (wizard) {
            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    _formEl.submit(); // Submit form

                } else {
                    Swal.fire({
                        text: "عفوا لم يتم ادخال جميع البيانات المطلوبه  ",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "حسنا !",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light"
                        }
                    }).then(function () {
                    });
                }
            });
        });
    }

    var _initValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
              // Step 1

       _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                  
                    fpuid: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    national_id: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                  
                    country_id: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    birth_date: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    type: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    religion: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    }

                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));

        // Step 2
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    job_num: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    start_job_date: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    mainJob_id: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    bonuses_id: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    subJob_id: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                   
                    public_cost: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    software_cost: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    cost_and_sustainability: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    cost_of_documentation: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    governance_cost: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    contract_duration: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    emp_insurance_percent: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    }

                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));
        
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {

                    contract_num: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    start_contract_date: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    decision_point: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    },
                    end_contract_date: {
                        validators: {
                            notEmpty: {
                                message: 'field  is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));
    }

    return {
        // public functions
        init: function () {
            _wizardEl = KTUtil.getById('kt_wizard2');
            _formEl = KTUtil.getById('kt_form2');

            _initWizard();
            _initValidation();
        }
    };
}();

jQuery(document).ready(function () {
    KTWizard6.init();
});
