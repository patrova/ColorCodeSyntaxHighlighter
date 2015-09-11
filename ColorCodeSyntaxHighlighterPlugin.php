<?php
/**
 * @package ColorCodeSyntaxHighlighter
 * @copyright Copyright 2015, Keith Gilbertson
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 or any later version
 */

class ColorCodeSyntaxHighlighterPlugin extends Omeka_Plugin_AbstractPlugin
{
    const OPTION_NAME = 'pdf_embed_settings';

    private static $types = array('text');
    private static $exts = array('css', 'cpp', 'java', 'perl', 'php');
    private static $defaultSettings = array(
        'fontsize' => 10,
        'highlighting_style' => 'default'
    );
    private static $settings = array();

    protected $_hooks = array('initialize',
        'config', 'config_form', 'install', 'public_head', 'uninstall'
    );

    public function hookInstall()
    {
        self::_setSettings(self::$defaultSettings);
    }

    public function hookUninstall()
    {
        delete_option(self::OPTION_NAME);
    }

    public function hookInitialize()
    {

        add_file_display_callback(
            array(
                'mimeTypes' => self::$types,
                'fileExtensions' => self::$exts
            ),
            'ColorCodeSyntaxHighlighterPlugin::displayCode',
            self::_getSettings()
        );
    }

    public function hookConfigForm()
    {
        $settings = self::_getSettings();
        include 'config-form.php';
    }

    public function hookConfig()
    {
        $settings['fontsize'] = (int) $_POST['fontsize'];
        $settings['highlighting_style'] = $_POST['highlighting_style'];

        self::_setSettings($settings);
    }

    public function hookPublicHead() 
    {
      
        $settings = self::_getSettings();
 
        $highlighting_style = $settings['highlighting_style'];
        queue_css_file($highlighting_style . '.min');
    }


    public static function displayCode($file, $options)
    {
        $fontsize = (int) $options['fontsize'];
        $settings['highlighting_style'] = $options['highlighting_style'];

        $scriptString = web_path_to('highlight-js/highlight.min.js');
         
          return "<script src=\"" . $scriptString . "\"></script>\n" . "<script>hljs.initHighlightingOnLoad();</script>\n" . "<pre><code id=\"codebox\" style=\"text-align: left; font-size: {$fontsize}px; line-height: normal;\"></code></pre>" . "<script type =\"text/javascript\">jQuery( '#codebox' ).load( \"" . $file->getWebPath('original') . "\" );setTimeout( function() {jQuery('#codebox').each(function(i, block) {\nhljs.highlightBlock(block);\n}); }, 1200);</script>";

    }

    public static function _getSettings()
    {
        if (!self::$settings) {
            $settings = json_decode(get_option(self::OPTION_NAME), true);
            self::$settings = $settings ? $settings : array();
        }
        return self::$settings;
    }

    public static function _setSettings($settings)
    {
        set_option(self::OPTION_NAME, json_encode($settings));
    }
}
