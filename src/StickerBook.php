<?php

class StickerBook
{

  public static function createStickerBook($tituloAlbum, $quantidadeCromo, $editora, $anoPublicacao, $idioma, $nomeImagem)
  {
    self::setup();
    $album = R::dispense('album');
    $album -> titulo            = $tituloAlbum;
    $album -> dataInclusao      = date("d.m.Y");
    $album -> quantidadeCromo   = $quantidadeCromo;
    $album -> editora           = $editora;
    $album -> anoPublicacao     = $anoPublicacao;
    $album -> idioma            = $idioma;
    $album -> nomeImagem        = $nomeImagem;
    
    R::store($album);
    return $album;
  }

  //atualiza dados do album
  public static function updateStickerBook($albumId, $tituloAlbum, $quantidadeCromo, $editora, $anoPublicacao, $idioma, $nomeImagem)
  {
    self::setup();
    $album = R::Load('album', $albumId);
    $album -> titulo            = $tituloAlbum;
    $album -> quantidadeCromo   = $quantidadeCromo;
    $album -> editora           = $editora;
    $album -> anoPublicacao     = $anoPublicacao;
    $album -> idioma            = $idioma;
    $album -> nomeImagem        = $nomeImagem;
   
    R::store($album);
    return $album;
  }

  // listar todos os StickerBooks disponiveis
  public static function listStickerBooks(){
    self::setup();

    $stickerBooks = R::findAll('album');
    return $stickerBooks;
  }


  public static function detailStickerBook($albumId){
    self::setup();
    
    $album = R::Load('album', $albumId );
    return $album;
  }

//listar albuns que compoem a collection do usuario --- SEM USO
  public static function listStickerBookCollection($usuarioId){
    self::setup();

    $listaColecao = self::listUserCollection($usuarioId);
    $listaAlbunsColecao;

    foreach ($listaColecao as $itemColecao) {
      $album = R::load('album' , $itemColecao['album_id']);  
      $itemColecao -> album = $album;
      $listaAlbunsColecao[] = $itemColecao;
    }
    
    return $listaAlbunsColecao;
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

    return $colecao;
  }

// usuario escolhe album para colecionar
  public static function removeStickerBookFromCollection($colecaoId){
    self::setup();

    $colecao      = R::load('colecao' , $colecaoId);
    $album        = R::load('album' , $colecao->album_id);
    $cromosColecao = R::findAll('cromoColecao' , 'colecao_id = :id' , [ ':id' => $colecao->id]);
    R::trash($colecao);
    R::trashAll($cromosColecao);
    
    return $album;
  }



// listar as colecoes de um usuario
  public static function listUserCollection($usuarioId){
    self::setup();

    $listUserCollection = R::findAll('colecao' , 'usuario_id = :id' , [ ':id' => $usuarioId] );
    return $listUserCollection;
  }

// listar stickers de uma collection do usuario
  public static function listStickerCollection($colecaoId){
    self::setup();
    $listStickerCollection = R::findAll('cromoColecao' , 'colecao_id = :id' , [ ':id' => $colecaoId]);
    return $listStickerCollection;
  }

// localizar numero do album a partir da coleção
  public static function findAlbumByCollection($colecaoId){
    self::setup();      

    $colecao = R::load('colecao' , 'colecao_id = :id' , [ ':id' => $colecaoId]);
    $album   = R::load('album', 'album_id = :id' , [ ':id' => $colecao->album_id]);
    return $album;    
  }

// incluir ou remover cromo da coleção 
  public static function updateCollection($colecaoId, $cromoId , $acao){
    self::setup();      

    $colecao  = R::load('colecao' , $colecaoId);
    $cromo    = R::load('cromo' ,  $cromoId );
    
    if ($acao == "add"){
      $cromoColecao = R::findOrCreate( 'cromocolecao', [ 'colecao_id' => $colecaoId , 'cromo_id' => $cromoId]);
      
        if(is_null($cromoColecao->quantidade)){ // se registro esta sendo criado define quantidade 1
          $cromoColecao->quantidade = 1;
        }else{
          $cromoColecao->quantidade = $cromoColecao->quantidade + 1;
        }
      
    }
    else {
      $cromoColecao = R::findOne('cromocolecao' , 'colecao_id = :colecaoId AND cromo_id = :cromoId' , [ ':colecaoId' => $colecaoId , ':cromoId' => $cromoId]);
      if(!is_null($cromoColecao)){
        if ($cromoColecao->quantidade > 0){
          $cromoColecao->quantidade = $cromoColecao->quantidade - 1;
        }
      }
    }
    R::store($cromoColecao);
    return $cromoColecao;
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
            R::debug(false);
            R::freeze(false);
            self::$configurado = true;
        }
  }
}