<?php namespace EvolutionCMS\TinyMCE5;

use EvolutionCMS\ServiceProvider;
use Event;

class TinyMCE5ServiceProvider extends ServiceProvider
{

    protected $editorLabel = 'TinyMCE5';
    protected $namespace = '';

    public function boot()
    {
        if(IN_MANAGER_MODE) {
            $this->loadViewsFrom(__DIR__ . '/../views', 'tinymce5settings');
        }
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('evolution.OnRichTextEditorRegister', function ($params) {
            return $this->editorLabel;
        });

        Event::listen('evolution.OnInterfaceSettingsRender', function ($params) {
            $files = array_diff(scandir(MODX_BASE_PATH.'assets/plugins/tinymce5/configs'), array('.', '..', 'custom.js'));
            return \View::make('tinymce5settings::tinymce5settings', ['themes'=>$files])->toHtml();
        });


        Event::listen('evolution.OnRichTextEditorInit', function ($params) {
            if($params['editor'] != $this->editorLabel) {
                return '';
            }

            $defaultTheme = evo()->getConfig('tinymce5_theme') ?? 'custom';

            $richtextArr = [];
            foreach($params['elements'] as $richtext){
                if(isset($params['options'][$richtext]['theme'])){
                    $richtextArr[$params['options'][$richtext]['theme']][] = '#'.$richtext;
                }else{
                    $richtextArr[$defaultTheme][] = '#'.$richtext;
                }
            }

            $config = "
                <script src='" . MODX_SITE_URL . "assets/plugins/tinymce5/tinymce/tinymce.min.js'></script>
                <script>
                    let modx_site_url = '" . MODX_SITE_URL . "';
                    let lang = '" . evo()->getConfig('fe_editor_lang') . "';
                    let content_css = '" . evo()->getConfig('editor_css_path') . "';
                    let filePicker = function (callback, value, meta) {
                   
                        let type = 'images', windowtitle = 'Image';
                        if (meta.filetype == 'file') { type = 'files'; windowtitle = 'File'}
                        
                        let windowManagerURL = '/manager/media/browser/mcpuk/browse.php?opener=tinymce4&field=src&type=' + type
                        ;// filemanager path
                        window.tinymceCallBackURL = '';
                        window.tinymceWindowManager = tinymce.activeEditor.windowManager;
                    
                        tinymce.activeEditor.windowManager.open({
                            title: windowtitle,
                            size: 'large',
                            body: {
                            type: 'panel',
                                items: [{
                                    type: 'htmlpanel',
                                    html: '<iframe id=\"filemanager_iframe-popup\" src=\"' + windowManagerURL + '\" frameborder=\"0\" style=\"width:100%; height:100%\" onload=\"fileManagerFit();\"></iframe>'
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
                    function fileManagerFit(){
                        document.getElementById('filemanager_iframe-popup').parentElement.style.height = '100%';
                    }
                </script>
            ";
            foreach($richtextArr as $theme => $selector) {

                $config .= "
                <script>
                    let selector_".$theme." = '" . implode(',', $selector) . "';
                </script>
                <script src='" . MODX_SITE_URL . "assets/plugins/tinymce5/configs/".$theme.".js?v=".filemtime(MODX_BASE_PATH . "assets/plugins/tinymce5/configs/".$theme.".js")."'></script>
                <script> 
                    tinymce.init( ".$theme." );
                </script>";

            }
            return $config;
        });

    }
}
