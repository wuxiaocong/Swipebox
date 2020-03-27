<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 可触摸的灯箱插件。
 *
 * @package Swipebox
 * @author 吴尼玛
 * @version 1.0.0
 * @link https://saikou.net
 */
class Swipebox_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate(){
		Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Swipebox_Plugin','btn_parse');
		Typecho_Plugin::factory('Widget_Archive')->header = array('Swipebox_Plugin','header');
		Typecho_Plugin::factory('Widget_Archive')->footer = array('Swipebox_Plugin','footer');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
	    $jquery = new Typecho_Widget_Helper_Form_Element_Radio(
        'jquery', array('0'=> '手动加载', '1'=> '自动加载'), 0, 'jQuery',
            '“手动加载”需要你手动加载jQuery，若选择“自动加载”，插件会自动加载jQuery，版本为1.9.1。');
        $form->addInput($jquery);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 插件实现方法
     *
     * @access public
     * @param Widget_Archive $archive
     * @return void
     */
	public static function btn_parse($content,$widget,$lastResult)
	{
		$content = preg_replace("/<img src=\"([^\"]*)\" alt=\"([^\"]*)\" title=\"([^\"]*)\">/i", "<a class=\"swipebox\" href=\"\\1\" title=\"\\3\"><img src=\"\\1\" alt=\"\\2\" title=\"\\3\"></a>", $content);
		return $content;
	}
	/**
	 * 头部css挂载
	 * 
     * @access public
	 * @return void
	 */
    public static function header(){
		if(Typecho_Widget::widget('Widget_Options')->Plugin('Swipebox')->jquery=='1'){
			echo '<script src="//lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>';
		}
	    echo '<link href="'.Helper::options()->pluginUrl.'/Swipebox/css/swipebox.min.css" rel="stylesheet">';
    }
	/**
	 * 尾部js挂载
	 *
     * @access public
	 * @return void
	 */
    public static function footer(){
	    echo '<script src="' . Helper::options()->pluginUrl . '/Swipebox/js/jquery.swipebox.min.js"></script>';
        echo "<script type=\"text/javascript\">
;( function( $ ) {

	$( '.swipebox' ).swipebox();

} )( jQuery );
</script>";
	}

}
