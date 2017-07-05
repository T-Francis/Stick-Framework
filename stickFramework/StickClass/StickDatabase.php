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
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );

        $this->pdo = null;

    }

    /**
     * [getPDO méthode qui retourne une instance de PDO]
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
     * [runQuery Méthode qui fait appel a la fonction native query() de PDO pour effectuer une requete directe non préparer]
     * @param  [string]  $requete [requete a effectuer]
     * @param  boolean $fObject [bool qui decidera si on retourne le set de données en objet]
     * @param  boolean $lastId [bool qui retournera la derniere ID dans le cas d'un INSERT]
     * @return [mixed]           [retourne un set de données en tableaux par défault]
     */
    public function runQuery($requete, $fObject=false, $lastId=false){
        //on recupere une instance de PDO et on execute la requete
        $req = $this->getPDO()->query($requete);

        //fetch objet?
        if($fObject){
            $req->setFetchMode(PDO::FETCH_OBJ);
        }

        //SI la requete rourne un set de données supérieur a 1 ligne ET que c'est un select
        if($req->rowCount() > 1 && strpos($requete, 'SELECT') === 0) {
            //on FecthALL()
            $datas = $req->fetchAll();
        } else {
            // SINON on fetch()
            $datas = $req->fetch();
        }

        //lastID?
        if (strpos($requete, 'INSERT') === 0 && $lastId = true) {
            return $this->lastInsertId();
        }
        return $datas;
    }


     /**
      * [preparedQuery Méthode qui fait appel a la fonction native query() de PDO pour effectuer une requete directe non préparer]
      * @param  [string]  $requete [requete a préparé]
      * @param  [type]  $parametres [arguments pour préparer la requete]
      * @param  boolean $fObject [bool qui decidera si on retourne le set de données en objet]
      * @param  boolean $lastId [bool qui retournera la derniere ID dans le cas d'un INSERT]
      * @return [mixed]  $datas [retourne un set de données en tableaux par défault]
      */
    public function preparedQuery($requete, $parametres, $fObject=false, $lastId=false){
        //on recupere une instance de PDO et on prépare la requete
        $req = $this->getPDO()->prepare($requete);
        //on execute la requete avec les arguments en parametres
        $res = $req->execute($parametres);

        //fetch objet?
        if($fObject){
            $req->setFetchMode(PDO::FETCH_OBJ);
        }
        //SI la requete rourne un set de données supérieur a 1 ligne ET que c'est un select
        if($req->rowCount() > 1 && strpos($requete, 'SELECT') === 0) {
            //on FecthALL()
            $datas = $req->fetchAll();
        } else {
            // SINON on fetch()
            $datas = $req->fetch();
        }

        //lastID?
        if (strpos($requete, 'INSERT') === 0 && $lastId = true) {
            return $this->lastInsertId();
        }
        return $datas;
    }

    /**
     * [lastInsertId Méthode qui appel un instance de PDO et la fonction native lastInsertId()]
     * @return [mixed] [rtourne la derniere ID inserer par PDO]
     */
    public function lastInsertId(){
        return $this->getPDO()->lastInsertId();
    }

}

?>
