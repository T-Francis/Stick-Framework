<?php
namespace StickFramework\StickClass;
use StickFramework\StickFramework as StickFramework;

/**
 * [StickLogger description]
 */
class StickLogger
{
    public function __construct(){

    }

    /**
     * [logger description]
     * @param  array  $datas [description]
     * @return [type]        [description]
     */
    public function logger($datas=array()){
        $logfile = fopen(StickFramework::getSettings()['paths']['pathLogs'].'stickLogger.log', 'r+');
        foreach ($datas as $key => $value) {
            fseek($logfile, 0, SEEK_END);
            fputs($logfile, "[ ". strtoupper($key) ." ] le ". date('Y-m-d') . " a ". date('H:i') . " : " . $value . "\r");
        }
        fclose($logfile);
        return true;
    }

}

?>
