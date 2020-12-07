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

        Event::listen('evolution.OnRichTextEditorInit', function ($params) {

            $selectorArr = array_map(function($val) { return '#'.$val;} , $params['elements']);

            return "
			<script src='".MODX_SITE_URL."assets/plugins/tinymce5/js/tinymce/tinymce.min.js'></script>
			<script>
			    let selectors = '".implode(',', $selectorArr). "';
			    let modx_site_url = '" . MODX_SITE_URL . "';
			    let lang = '" . evo()->getConfig('manager_language') . "';
			    let filePicker = function (callback, value, meta) {
               
                    let type = 'images';
                    if (meta.filetype == 'file') { type = 'files';}
                    
                    let windowManagerURL = '/manager/media/browser/mcpuk/browse.php?opener=tinymce4&field=src&type=' + type
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
            </script>
            <script src='".MODX_SITE_URL."assets/plugins/tinymce5/configs/test.js'></script>
			";
        });

    }
}