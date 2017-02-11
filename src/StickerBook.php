<?php

class StickerBook {


  public static function createStickerBook($tituloAlbum,$quantidadeCromos,$editora,$anoPublicacao,$idioma){
    self::configurar();
    $album = R::dispense('album');
    $album -> titulo            = $tituloAlbum;
    $album -> dataInclusao      = date("d.m.Y");
    $album -> quantidadeCromos  = $quantidadeCromos;
    $album -> editora           = $editora;
    $album -> anoPublicacao     = $anoPublicacao;
    $album -> idioma            = $idioma;
    
    for ($i = 1; $i <= (int)$quantidadeCromos; $i++) {
      $cromo =  R::dispense('cromo');
      $cromo -> numero = $i; 
      $cromo -> nome   = ' ';
      $album -> ownCromoList[] = $cromo ;
    }
    
    R::store($album);
  }

  public static function detailStickerBook($albumId){
    self::configurar();
    
    $album = R::Load('album', $albumId );
    return $album;
  }


// TODO Lógica do Negócio Aqui

// -------------- configuracao de ambiente -----------------------------------
  private static $ambiente    = null;
  private static $configurado = false;

  public static function obterAmbiente() {
        if (self::$ambiente == null) {
            $host = getenv('OPENSHIFT_MYSQL_DB_HOST');
            if (isset($host) && is_string($host) && !empty($host))
                self::$ambiente = 'producao';
            else
                self::$ambiente = 'localhost';
        }
        return self::$ambiente;
  }

  private static function configurar() {
        if (!self::$configurado) {
            // banco de dados
            $ambiente = self::obterAmbiente();
            if ($ambiente == 'producao') {
                // openshift
                $host     = getenv('OPENSHIFT_MYSQL_DB_HOST');
                $port     = getenv('OPENSHIFT_MYSQL_DB_PORT');
                $dbname   = getenv('OPENSHIFT_GEAR_NAME');
                $username = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
                $password = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
                //R::debug(true);
                //R::freeze(false);
            } else if ($ambiente == 'localhost') {
                // localhost
              
                $host     = '127.0.0.1';
                $port     = '3306';
                $dbname   = 'stickertrade';
                $username = 'root';
                $password = '';
            }
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;";
            R::setup($dsn, $username, $password);
            R::debug(true);
            //R::debug(false);
            R::freeze(false);
            self::$configurado = true;
        }
  }
}