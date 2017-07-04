<?php
namespace StickFramework\StickClass;
use StickFramework\StickFramework as StickFramework;

/**
 * [final description]
 * @var [type]
 */
final class StickView
{

    public function __construct() {
        $this->pathViews = StickFramework::getSettings()['paths']['pathViews'];
        $this->pathPublic = StickFramework::getSettings()['paths']['pathPublic'];
        $this->appName = StickFramework::getSettings()['appName'];
        $this->sessionFlashName = 'flashmsgservice';
        }

    /**
     * [render description]
     * @param  [type]  $controllerName [description]
     * @param  [type]  $datas          [description]
     * @param  boolean $extracted      [description]
     * @param  [type]  $title          [description]
     * @return [type]                  [description]
     */
    public function render($controllerName,$datas,$extracted=false,$title=null){

        $pathViews = $this->pathViews;
        if ($title === null) {
            $title = StickFramework::getSettings()['appName'];
        }

        is_dir($this->pathViews.$controllerName)
        ? $subDir = $controllerName."/"
        : $subDir = "";

        file_exists($this->pathViews.$subDir.$controllerName.'.nav.html')
        ? $pathToNav = $this->pathViews.$subDir.$controllerName.'.nav.html'
        : $pathToNav = $pathViews.'base.nav.html';

        file_exists($this->pathViews.$subDir.$controllerName.'.header.html')
        ? $pathToHeader = $this->pathViews.$subDir. $controllerName.'.header.html'
        : $pathToHeader = $pathViews.'base.header.html';

        file_exists($this->pathViews.$subDir.$controllerName.'.content.html')
        ? $pathToContent = $this->pathViews.$subDir.$controllerName.'.content.html'
        : $pathToContent = $pathViews.'base.content.html';

        file_exists($this->pathViews.$subDir.$controllerName.'.footer.html')
        ? $pathToFooter = $this->pathViews.$subDir.$controllerName.'.footer.html'
        : $pathToFooter = $pathViews.'base.footer.html';

        file_exists($this->pathPublic.'css/'.$controllerName.'.css')
        ? $loadCss = true
        : $loadCss = false;

        file_exists($this->pathPublic.'js/'.$controllerName.'.js')
        ? $loadJs = true
        : $loadJs = false;

        if ($extracted) {
            extract($datas);
        }

        $flashMessage = $this->checkFlash();
        require_once ($pathViews."base.html");
    }

    /**
     * [setFlash description]
     * @param [type] $msg [description]
     */
    public function setFlash($msg){
        $_SESSION[$this->sessionFlashName] = $msg;
    }

    /**
     * [checkFlash description]
     * @return [type] [description]
     */
    public function checkFlash(){
        if (isset($_SESSION[$this->sessionFlashName])){
            $flash = $_SESSION[$this->sessionFlashName];
            unset($_SESSION[$this->sessionFlashName]);
            return $flash;
        } else {
            $flash='';
        }
    }

    /**
     * [debug description]
     * @param  [type] $datas [description]
     * @param  [type] $die   [description]
     * @return [type]        [description]
     */
    public function debug($datas,$die){
        return StickFramework::debug($datas,$die);
    }

}

?>
