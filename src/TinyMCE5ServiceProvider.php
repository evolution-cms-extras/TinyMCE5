<?php namespace EvolutionCMS\TinyMCE5;

use EvolutionCMS\ServiceProvider;
use Event;

class TinyMCE5ServiceProvider extends ServiceProvider
{

    protected $namespace = '';
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('evolution.OnRichTextEditorRegister', function ($params) {
            return 'TinyMCE5';
        });

        Event::listen('evolution.OnWebAuthentication', function ($params) {

            //echo print_r($elements, 1);
            $script = "
			<script src='".MODX_SITE_URL."assets/plugins/tinymce5/js/tinymce/tinymce.min.js'></script>
			<script>
                tinymce.init({
                  selector: '#ta',
                  document_base_url:'".MODX_SITE_URL."',
                  language: 'ru',
                  plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                  
                  mobile: {
                    theme: 'silver',
                    plugins: 'print preview',
                    menubar: true,
                    toolbar: 'undo redo | bold italic'
                  },
                  
                  menubar: 'file edit view insert format tools table tc help',
                  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
                  
                  image_advtab: true,
                  
                  importcss_append: true,
                  
                  height: 600,
                  image_caption: true,
                  quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                  noneditable_noneditable_class: 'mceNonEditable',
                  toolbar_mode: 'sliding',
                 
                  contextmenu: 'link image imagetools table configurepermanentpen',
                  a11y_advanced_options: true,
                  skin: 'oxide',
                  content_css: 'default',
                  file_picker_callback: function (callback, value, meta) {
                  
                    var type = 'images';
                    if (meta.filetype == 'file') { type = 'files';}
                    
                    var windowManagerURL = '/manager/media/browser/mcpuk/browse.php?opener=tinymce4&field=src&type=' + type
                    ;// filemanager path
                    window.tinymceCallBackURL = '';
                    window.tinymceWindowManager = tinymce.activeEditor.windowManager;
                
                    tinymce.activeEditor.windowManager.open({
                        title: 'Image',
                        size: 'large',
                        body: {
                        type: 'panel',
                            items: [{
                                type: 'htmlpanel',
                                html: '<iframe src=\"' + windowManagerURL + '\" frameborder=\"0\" style=\"width:840px; height:500px\"></iframe>'
                            }]
                        },
                        buttons: [
                        ] ,
                    onClose: function () {
                        if (tinymceCallBackURL!='')
                            callback(tinymceCallBackURL, {});
                        } 
                    });
                }
                });
			</script>";
        });

    }
}