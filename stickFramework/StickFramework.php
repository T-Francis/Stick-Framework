<?php
namespace StickFramework;
use StickFramework\StickClass\StickLogger as StickLogger;
use StickFramework\StickClass\StickRouter as StickRouter;
use StickFramework\StickClass\StickView as StickView;

class StickFramework
{
    public $stickLogger;
    public $stickRouter;
    public $stickView;

    public function __construct(){
        $this->stickLogger = new StickLogger;
        $this->stickRouter = new StickRouter;
        $this->stickView = new StickView;
    }

    /**
	 * debug() is a debugging functions that var_dump($anything);
	 * @param  [mixed] $data is the data you want to debug
	 * @param  [boolean] $die , true by default
	 * @return void
	 */
	public static function debug($data, $die=true) {
		echo'<pre>';
		var_dump($data);
		echo '</pre>';
		if ($die){
			die();
		}
    }

    public static function getSettings(){
        $file = require(ROOT.'/app/settings.php');
        $settings = array();
        foreach ($file as $Settings => $SettingsValue) {
            if (is_array($SettingsValue)) {
                foreach ($SettingsValue as $key => $value) {
                    $settings[$key] = $key;
                    $settings[$key] = $value;
                }
            } else {
                $settings[$Settings] = $Settings;
                $settings[$Settings] = $settingsValue;
            }
        }
        return $settings;
    }

    public static function notFound(){
        $StickView = new StickView();
        return $StickView->render('404', array());
    }
}
 ?>
