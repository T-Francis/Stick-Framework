<?php
namespace StickFramework\StickClass;

use \PDO;

/**
 * [StickDatabase description]
 */
class StickDatabase
{

    private $dbDriver;
    private $dbHost;
    private $dbName;
    private $dbLogin;
    private $dbPsw;
    private $dbCharset;
    private $dsn;
    private $opt;
    private $pdo;

    /**
     * [__construct description]
     * @param [type] $dbDriver  [description]
     * @param [type] $dbHost    [description]
     * @param [type] $dbName    [description]
     * @param [type] $dbLogin   [description]
     * @param [type] $dbPsw     [description]
     * @param [type] $dbCharset [description]
     */
    public function __construct($dbDriver,$dbHost,$dbName,$dbLogin,$dbPsw,$dbCharset){

        $this->dbDriver = $dbDriver;
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbLogin = $dbLogin;
        $this->dbPsw = $dbPsw;
        $this->dbCharset = $dbCharset;

        //on construit le datasourcename
        $this->dsn = $this->dbDriver.":host=".$this->dbHost.";dbname=".$this->dbName.";charset=".$this->dbCharset;

        //on définit les options de PDO
        $this->opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES   => false,
        );

        $this->pdo = null;

    }

    /**
     * [getPDO description]
     * @return [type] [description]
     */
    private function getPDO(){
        if($this->pdo === null){
            // on try catch
            try {
                // on instancie la connection a la base de données avec l'objet PDO et on lui passe en parametre le DSN, login et password
                $this->pdo = new PDO($this->dsn, $this->dbLogin, $this->dbPsw, $this->opt);
            } catch (PDOEception $e) {
                $this->error=$e->getMessage();
            }
        }
        return $this->pdo;
    }

    /**
     * [runQuery description]
     * @param  [type]  $requete [description]
     * @param  boolean $fObject [description]
     * @return [type]           [description]
     */
    public function runQuery($requete, $fObject=false){
        $req = $this->getPDO()->query($requete);
        if($fObject){
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_ASSOC);
        }
        if($req->rowCount() > 1 && strpos($requete, 'SELECT') === 0) {
            $datas = $req->fetchAll();
        } else {
            $datas = $req->fetch();
        }
        return $datas;
    }

    /**
     * [preparedQuery description]
     * @param  [type]  $requete    [description]
     * @param  [type]  $parametres [description]
     * @param  boolean $fObject    [description]
     * @return [type]              [description]
     */
    public function preparedQuery($requete, $parametres, $fObject=false){
        $req = $this->getPDO()->prepare($requete);
        $res = $req->execute($parametres);
        if($fObject){
            $req->setFetchMode(PDO::FETCH_OBJ);
        }
        if($req->rowCount() > 1 && strpos($requete, 'SELECT') === 0) {
            $datas = $req->fetchAll();
        } else {
            $datas = $req->fetch();
        }
        return $datas;
    }

    /**
     * [lastInsertId description]
     * @return [type] [description]
     */
    public function lastInsertId(){
        return $this->getPDO()->lastInsertId();
    }

}

?>
