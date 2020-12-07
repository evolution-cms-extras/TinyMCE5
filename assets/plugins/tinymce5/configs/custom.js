let custom = {
    "selector": selector_custom,
    "document_base_url": modx_site_url,
    "language": lang,
    "language_url": modx_site_url + 'assets/plugins/tinymce5/langs/' + lang + '.js',
    "plugins": 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',

    "mobile": {
        "theme": 'silver',
        "plugins": 'print preview',
        "menubar": true,
        "toolbar": 'undo redo | bold italic'
    },

    "menubar": 'file edit view insert format tools table tc help',
    "toolbar": 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',

    "image_advtab": true,

    "importcss_append": true,

    "height": 600,
    "image_caption": true,
    "quickbars_selection_toolbar": 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    "noneditable_noneditable_class": 'mceNonEditable',
    "toolbar_mode": 'sliding',

    "contextmenu": 'link image imagetools table configurepermanentpen',
    "a11y_advanced_options": true,
    "skin": 'oxide',
    "content_css": 'default',
    "file_picker_callback": function(callback, value, meta) {
        filePicker(callback, value, meta)
    }
}
