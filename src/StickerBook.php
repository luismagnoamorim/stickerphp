<?php

class StickerBook
{

  public static function createStickerBook($tituloAlbum, $quantidadeCromo, $editora, $anoPublicacao, $idioma)
  {
    self::setup();
    $album = R::dispense('album');
    $album -> titulo            = $tituloAlbum;
    $album -> dataInclusao      = date("d.m.Y");
    $album -> quantidadeCromo   = $quantidadeCromo;
    $album -> editora           = $editora;
    $album -> anoPublicacao     = $anoPublicacao;
    $album -> idioma            = $idioma;
    
    R::store($album);
    return $album;
  }

  public static function addStickerToBook($albumId, $stickerList){
    self::setup();
    $album = R::Load('album' , $albumId);

    for ($i = 0; $i < count($stickerList); $i++) {
      if ($stickerList[$i] != '') {
        $cromo =  R::dispense('cromo');
        $cromo -> codigo = $stickerList[$i]; 
        $album -> ownCromoList[] = $cromo ;
      }
    }
    
    R::store($album);
  }  

  public static function updateSticker($stickerId, $novoCodigo){
    self::setup();
    $sticker = R::Load('cromo' , $stickerId);
    $sticker -> codigo = $novoCodigo; 
    R::store($sticker);
  }

  //atualiza dados do album
  public static function updateStickerBook($albumId, $tituloAlbum, $quantidadeCromo, $editora, $anoPublicacao, $idioma)
  {
    self::setup();
    $album = R::Load('album', $albumId);
    $album -> titulo            = $tituloAlbum;
    $album -> quantidadeCromo   = $quantidadeCromo;
    $album -> editora           = $editora;
    $album -> anoPublicacao     = $anoPublicacao;
    $album -> idioma            = $idioma;
   
    R::store($album);
    return $album;
  }

  public static function detailStickerBook($albumId){
    self::setup();
    
    $album = R::Load('album', $albumId );
    return $album;
  }
  
  public static function listSticker($albumId){ //////////////////////////////// FUNCIONAMENTO OK
      self::setup();      
      $stickers = R::findAll('cromo', 'album_id = :id ', [ ':id'=>$albumId ]);
      return $stickers;
  }  


/// -----------------colecao -------------------------------------------------------------------------------
// usuario escolhe album para colecionar
  public static function addStickerBookToCollection($albumId, $usuarioId){
    self::setup();

    $album = R::load('album' , $albumId);
    $usuario = R::load('usuario' , $usuarioId);

    $colecao = R::dispense('colecao');
    $colecao->usuario = $usuario;
    $colecao->album = $album;
    $colecao->dataInclusao = date("d.m.Y");
    $colecao->quantidadeCromos = 0;
    $colecao->dataUltimaAtualizacao = date("d.m.Y");
    R::store($colecao);

    return $album;
  }      

// listar stickers de uma collection do usuario
  public static function listStickerCollection($albumId, $colecaoId){
    self::setup();
    $album   = R::load('album' , $albumId);
    $colecao = R::load('colecao' , $colecaoId);

    $cromos = $colecao
        ->via( 'album' )
        ->sharedCromoList;

    return $cromos;
  }        

// incluir ou remover cromo da coleção 
  public static function updateCollection($colecaoId, $cromoId , $acao){
    self::setup();      

    $colecao  = R::load('colecao' , $colecaoId);
    $cromo    = R::load('cromo' ,  $cromoId );
    $colecao->sharedCromoList[] = $cromo;
    if ($acao == "add"){
      $colecao->sharedCromoList[] = $cromo;
    }
    else {
      unset($colecao->sharedCromoList[$cromoId] );
    }
    R::store($colecao);
    return $colecao;
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

  private static function setup()
  {
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