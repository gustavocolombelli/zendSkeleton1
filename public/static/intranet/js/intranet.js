$(function() {

    $('#notas input[type=checkbox]').live('click', function(){
        var el = $(this);
        if( el.is(':checked') ) {
            $('#nota_' + el.attr('rel')).removeAttr('readonly');
        } else {
            $('#nota_' + el.attr('rel')).attr('readonly', 'readonly');
        }
    });


	$(".slugOrigem").stringToSlug({
		setEvents: 'keyup keydown blur',
		getPut: '.slugDestino',
		space: '-'
	});

	$( 'textarea.editor' ).ckeditor({
        filebrowserBrowseUrl: '/global/ckeditor/plugins/filemanager/index.html'});

    $('.datepicker').datepicker();
});

