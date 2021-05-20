
// Forms-Text-Editor.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -


$(document).on('nifty.ready', function() {

    // SUMMERNOTE
    // =================================================================
    // Require Summernote
    // http://hackerwins.github.io/summernote/
    // =================================================================
    $('#summernote, #summernote-full-width').summernote({
        height : '230px'
    });




    // SUMMERNOTE AIR-MODE
    // =================================================================
    // Require Summernote
    // http://hackerwins.github.io/summernote/
    // =================================================================
    $('#summernote-airmode').summernote({
        airMode: true
    });





    // SUMMERNOTE CLICK TO EDIT
    // =================================================================
    // Require Summernote
    // http://hackerwins.github.io/summernote/
    // =================================================================
    $('#edit-text').on('click', function(){
        $('#summernote-edit').summernote({focus: true});
    });


    $('#save-text').on('click', function(){
        $('#summernote-edit').summernote('destroy');
    });

})
