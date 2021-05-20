
// Form-Component.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -


$(document).on('nifty.ready', function() {


    // CHOSEN
    // =================================================================
    // Require Chosen
    // http://harvesthq.github.io/chosen/
    // =================================================================
    $('#chosen-select').chosen();
    $('#cs-multiselect').chosen({width:'100%'});



    // DEFAULT RANGE SLIDER
    // =================================================================
    // Require noUiSlider
    // http://refreshless.com/nouislider/
    // =================================================================
    var rs_def = document.getElementById('range-def');
    var rs_def_value = document.getElementById('range-def-val');

    noUiSlider.create(rs_def,{
        start   : [ 20 ],
        connect : 'lower',
        range   : {
            'min': [  0 ],
            'max': [ 100 ]
        }
    });

    rs_def.noUiSlider.on('update', function( values, handle ) {
        rs_def_value.innerHTML = values[handle];
    });




    // RANGE SLIDER - SLIDER STEP BY STEP
    // =================================================================
    // Require noUiSlider
    // http://refreshless.com/nouislider/
    // =================================================================

    var rs_step = document.getElementById('range-step');
    var rs_step_value = document.getElementById('range-step-val');


    noUiSlider.create(rs_step,{
        start   : [ 20 ],
        connect : 'lower',
        step    : 10,
        range   : {
            'min': [  0 ],
            'max': [ 100 ]
        }
    });

    rs_step.noUiSlider.on('update', function( values, handle ) {
        rs_step_value.innerHTML = values[handle];
    });





    // RANGE SLIDER - SLIDER STEP BY STEP
    // =================================================================
    // Require noUiSlider
    // http://refreshless.com/nouislider/
    // =================================================================

    var rs_disabled = document.getElementById('range-disabled');

    noUiSlider.create(rs_disabled,{
        start   : [ 20 ],
        connect : 'lower',
        range   : {
            'min': [  0 ],
            'max': [ 100 ]
        }
    });



    // VERTICAL RANGE SLIDER
    // =================================================================
    // Require noUiSlider
    // http://refreshless.com/nouislider/
    // =================================================================
    var rs_range_ver1 = document.getElementById('range-ver1');
    var rs_range_ver2 = document.getElementById('range-ver2');
    var rs_range_ver3 = document.getElementById('range-ver3');
    var rs_range_ver4 = document.getElementById('range-ver4');
    var rs_range_ver5 = document.getElementById('range-ver5');


    noUiSlider.create(rs_range_ver1,{
        start: [ 80 ],
        connect: 'lower',
        range: {
            'min':  [20],
            'max':  [100]
        },
        orientation: 'vertical',
        direction: 'rtl'
    });


    noUiSlider.create(rs_range_ver2,{
        start: [ 50 ],
        connect: 'lower',
        range: {
            'min':  [20],
            'max':  [100]
        },
        orientation: 'vertical',
        direction: 'rtl'
    });

    noUiSlider.create(rs_range_ver3,{
        start: [ 30 ],
        connect: 'lower',
        range: {
            'min':  [20],
            'max':  [100]
        },
        orientation: 'vertical',
        direction: 'rtl'
    });

    noUiSlider.create(rs_range_ver4,{
        start: [ 50 ],
        connect: 'lower',
        range: {
            'min':  [20],
            'max':  [100]
        },
        orientation: 'vertical',
        direction: 'rtl'
    });

    noUiSlider.create(rs_range_ver5,{
        start: [ 80 ],
        connect: 'lower',
        range: {
        'min':  [20],
        'max':  [100]
        },
        orientation: 'vertical',
        direction: 'rtl'
    });


    // RANGE SLIDER - DRAG
    // =================================================================
    // Require noUiSlider
    // http://refreshless.com/nouislider/
    // =================================================================
    var rs_range_drg = document.getElementById('range-drg');

    noUiSlider.create(rs_range_drg, {
        start: [ 40, 60 ],
        behaviour: 'drag',
        connect: true,
        range: {
        'min':  20,
        'max':  80
        }
    });




    // RANGE SLIDER - DRAG-FIXED
    // =================================================================
    // Require noUiSlider
    // http://refreshless.com/nouislider/
    // =================================================================
    var rs_range_fxt = document.getElementById('range-fxt');

    noUiSlider.create(rs_range_fxt, {
        start: [ 40, 60 ],
        behaviour: 'drag-fixed',
        connect: true,
        range: {
            'min':  20,
            'max':  80
        }
    });





    // RANGE SLIDER PIPS
    // =================================================================
    var range_all_sliders = {
        'min': [ 0 ],
        '25%': [ 50 ],
        '50%': [ 100 ],
        '75%': [ 150 ],
        'max': [ 200 ]
    };



    // RANGE SLIDER - HORIZONTAL PIPS
    // =================================================================
    // Require noUiSlider
    // http://refreshless.com/nouislider/
    // =================================================================
    var rs_range_hpips = document.getElementById('range-hpips');

    noUiSlider.create(rs_range_hpips, {
        range: range_all_sliders,
        connect: 'lower',
        start: 90,
        pips: { // Show a scale with the slider
            mode: 'steps',
            density: 2
        }
    });




    // SELECT2 SINGLE
    // =================================================================
    // Require Select2
    // https://github.com/select2/select2
    // =================================================================
    $("#select2").select2();




    // SELECT2 PLACEHOLDER
    // =================================================================
    // Require Select2
    // https://github.com/select2/select2
    // =================================================================
    $("#select2-placeholder").select2({
        placeholder: "Select a state",
        allowClear: true
    });



    // SELECT2 SELECT BOXES
    // =================================================================
    // Require Select2
    // https://github.com/select2/select2
    // =================================================================
    $("#select2-multiple-selects").select2();




    // BOOTSTRAP TIMEPICKER
    // =================================================================
    // Require Bootstrap Timepicker
    // http://jdewit.github.io/bootstrap-timepicker/
    // =================================================================
    $('#tp-com').timepicker();



    // BOOTSTRAP TIMEPICKER - COMPONENT
    // =================================================================
    // Require Bootstrap Timepicker
    // http://jdewit.github.io/bootstrap-timepicker/
    // =================================================================
    $('#tp-textinput').timepicker({
        minuteStep: 5,
        showInputs: false,
        disableFocus: true
    });


    // BOOTSTRAP DATEPICKER
    // =================================================================
    // Require Bootstrap Datepicker
    // http://eternicode.github.io/bootstrap-datepicker/
    // =================================================================
    $('#dp-txtinput input').datepicker();


    // BOOTSTRAP DATEPICKER WITH AUTO CLOSE
    // =================================================================
    // Require Bootstrap Datepicker
    // http://eternicode.github.io/bootstrap-datepicker/
    // =================================================================
    $('#dp-component .input-group.date').datepicker({autoclose:true});


    // BOOTSTRAP DATEPICKER WITH RANGE SELECTION
    // =================================================================
    // Require Bootstrap Datepicker
    // http://eternicode.github.io/bootstrap-datepicker/
    // =================================================================
    $('#dp-range .input-daterange').datepicker({
        format: "MM dd, yyyy",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });


    // INLINE BOOTSTRAP DATEPICKER
    // =================================================================
    // Require Bootstrap Datepicker
    // http://eternicode.github.io/bootstrap-datepicker/
    // =================================================================
    $('#dp-inline div').datepicker({
    format: "MM dd, yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
    });



    // SWITCHERY - CHECKED BY DEFAULT
    // =================================================================
    // Require Switchery
    // http://abpetkov.github.io/switchery/
    // =================================================================
    new Switchery(document.getElementById('sw-checked'));


    // SWITCHERY - UNCHECKED BY DEFAULT
    // =================================================================
    // Require Switchery
    // http://abpetkov.github.io/switchery/
    // =================================================================
    new Switchery(document.getElementById('sw-unchecked'));


    // SWITCHERY - CHECKING STATE
    // =================================================================
    // Require Switchery
    // http://abpetkov.github.io/switchery/
    // =================================================================
    var changeCheckbox = document.getElementById('sw-checkstate'), changeField = document.getElementById('sw-checkstate-field');
    new Switchery(changeCheckbox)
    changeField.innerHTML = changeCheckbox.checked;
    changeCheckbox.onchange = function() {
        changeField.innerHTML = changeCheckbox.checked;
    };


    // SWITCHERY - COLORED
    // =================================================================
    // Require Switchery
    // http://abpetkov.github.io/switchery/
    // =================================================================
    new Switchery(document.getElementById('sw-clr1'), {color:'#489eed'});
    new Switchery(document.getElementById('sw-clr2'), {color:'#35b9e7'});
    new Switchery(document.getElementById('sw-clr3'), {color:'#44ba56'});
    new Switchery(document.getElementById('sw-clr4'), {color:'#f0a238'});
    new Switchery(document.getElementById('sw-clr5'), {color:'#e33a4b'});
    new Switchery(document.getElementById('sw-clr6'), {color:'#2cd0a7'});
    new Switchery(document.getElementById('sw-clr7'), {color:'#8669cc'});
    new Switchery(document.getElementById('sw-clr8'), {color:'#ef6eb6'});


    // SWITCHERY - SIZES
    // =================================================================
    // Require Switchery
    // http://abpetkov.github.io/switchery/
    // =================================================================
    new Switchery(document.getElementById('sw-sz-lg'), { size: 'large' });
    new Switchery(document.getElementById('sw-sz'));
    new Switchery(document.getElementById('sw-sz-sm'), { size: 'small' });


});
