<?php
//require_once('Bcrypt.php');

class StickerBook
{

  public static function createStickerbook($tituloAlbum, $quantidadeCromo, $editora, $anoPublicacao, $idioma, $nomeImagem)
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
  public static function updateStickerbook($albumId, $tituloAlbum, $quantidadeCromo, $editora, $anoPublicacao, $idioma, $nomeImagem)
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
  public static function listStickerbooks(){
    self::setup();

    $stickerBooks = R::findAll('album');
    return $stickerBooks;
  }


  public static function detailStickerBook($albumId){
    self::setup();
    
    $album = R::Load('album', $albumId );
    return $album;
  }


// listar as colecoes de um usuario  
  public static function listUserCollection($usuarioId){
    self::setup();

    $listUserCollection = R::findAll('colecao' , 'usuario_id = :id' , [ ':id' => $usuarioId] );
    return $listUserCollection;
  }

// listar as colecoes de um usuario  
  public static function listUserCollectionByStickerbook($usuarioId, $albumId){
    self::setup();

    $listUserCollectionByStickerbook = R::findAll('colecao' , 'usuario_id = :id AND album_id = :albumId' , [ ':id' => $usuarioId , ':albumId' => $albumId] );
    return $listUserCollectionByStickerbook;
  }

//listar albuns que compoem a collection do usuario, e carrega os detalhes de cada album 
  public static function listStickerBookCollection($usuarioId){
    self::setup();

    $listaColecao = self::listUserCollection($usuarioId);
    $listaAlbunsColecao = null;

    foreach ($listaColecao as $itemColecao) {
      $album = R::load('album' , $itemColecao['album_id']);  
      $itemColecao -> album = $album;
      $listaAlbunsColecao[] = $itemColecao;
    }
    
    return $listaAlbunsColecao;
  }

//listar albuns que compoem a collection do usuario de um album especifico, e carrega os detalhes de cada album 
  public static function listStickerBookCollectionByEmail($usuarioEmail, $colecaoId)      {
    self::setup();

    $usuario = R::findOne('usuario' , 'email = :email' , [':email' => $usuarioEmail]);
    $colecaoDoUsuario = R::load('colecao', $colecaoId);
    $listaColecao = self::listUserCollectionByStickerbook($usuario->id, $colecaoDoUsuario->album_id);
    $listaAlbunsColecao = null;

    foreach ($listaColecao as $itemColecao) {
      $album = R::load('album' , $itemColecao['album_id']);  
      $itemColecao -> album = $album;
      $listaAlbunsColecao[] = $itemColecao;
    }
    
    return $listaAlbunsColecao;
  }  

  //adiciona stickers como componentes de um album
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

  //altera o atributo código de um sticker
  public static function updateSticker($stickerId, $novoCodigo){
    self::setup();
    $sticker = R::Load('cromo' , $stickerId);
    $sticker -> codigo = $novoCodigo; 
    R::store($sticker);
  }

  //lista os sticker que compõem um stickerbook
  public static function listSticker($albumId){
      self::setup();      
      $stickers = R::findAll('cromo', 'album_id = :id ', [ ':id'=>$albumId ]);
      return $stickers;
  }  


/// -----------------colecao -------------------------------------------------------------------------------
// usuario escolhe stickerBook para colecionar e o inclui na sua collection
  public static function addStickerbookToCollection($albumId, $usuarioId){
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

  // recuperar detalhes de uma collection
  public static function detailCollection($colecaoId){
      self::setup();
      
      $collection = R::Load('colecao', $colecaoId );
      return $collection;
    }


// usuario remove um stickerBook da sua collection
  public static function removeStickerbookFromCollection($colecaoId, $usuarioId){
    self::setup();

    $colecao      = R::findOne('colecao' , 'id = :colecaoId AND usuario_id = :usuarioId' , [ ':colecaoId' => $colecaoId ,  ':usuarioId' => $usuarioId] );
    $album        = R::load('album' , $colecao->album_id);
    $cromosColecao = R::findAll('cromocolecao' , 'colecao_id = :id' , [ ':id' => $colecao->id]);
    R::trash($colecao);
    R::trashAll($cromosColecao);
    
    return $album;
  }

// listar stickers de uma collection do usuario
  public static function listStickerCollection($colecaoId){
    self::setup();
    $listStickerCollection = R::findAll('cromocolecao' , 'colecao_id = :id' , [ ':id' => $colecaoId]);
    return $listStickerCollection;
  }

// localizar numero do stickerbook a partir da collection
  public static function findAlbumByCollection($colecaoId){
    self::setup();      

    $colecao = R::load('colecao' , $colecaoId);
    $album   = R::load('album', $colecao->album_id);
    return $album;    
  }

// incluir ou remover sticker da collection 
  public static function updateCollection($colecaoId, $cromoId , $acao){
    self::setup();      

    $colecao  = R::load('colecao' , $colecaoId);
    if ($acao == "add"){
      $cromocolecao = R::findOrCreate( 'cromocolecao', [ 'colecao_id' => $colecaoId , 'cromo_id' => $cromoId]);
      
        if(is_null($cromocolecao->quantidade)){ // se registro esta sendo criado define quantidade 1
          $cromocolecao->quantidade = 1;
        }else{
          $cromocolecao->quantidade = $cromocolecao->quantidade + 1;
        }
        $colecao->quantidadeCromos = $colecao->quantidadeCromos + 1;
      
    }
    else {
      $cromocolecao = R::findOne('cromocolecao' , 'colecao_id = :colecaoId AND cromo_id = :cromoId' , [ ':colecaoId' => $colecaoId , ':cromoId' => $cromoId]);
      if(!is_null($cromocolecao)){
        if ($cromocolecao->quantidade > 0){
          $cromocolecao->quantidade = $cromocolecao->quantidade - 1;
        }
        $colecao->quantidadeCromos = $colecao->quantidadeCromos - 1;
      }
    }
    R::store($cromocolecao);

    $colecao->dataUltimaAtualizacao = date("d.m.Y");
    R::store($colecao);

    return $cromocolecao;
  }

// ------------------------------------------- funcoes de login / usuario ---------------------------------------------------------------------------------------
// -- inserir usuario basico, login e senha
  public static function insertBasicUser($email, $password){
    self::setup();      
    
    $usuario = R::dispense( 'usuario' );
    $usuario->email = $email;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); 
    //$hashedPassword = Bcrypt::hash($password);
    $usuario->senha = $hashedPassword;
    R::store($usuario);

    return $usuario;    
  }

// -- inserir usuario basico, login e senha
  public static function validateLogin($email, $password){
    self::setup();      
    
    $usuario = R::findOne('usuario' , 'email = :emailLogin' , [ ':emailLogin' => $email]);
    if(is_null($usuario)){
        return null;
    } else {
        if(password_verify($password, $usuario->senha)){
          return $usuario;
        }else{
          return null;
        }  
        //if (Bcrypt::check($password, $usuario->senha)) {
        //    return $usuario;
        //} else {
        //    return null;
        //}      
    }
  }  

// ------------------------------------ funcionalidades para troca de stickers entre usuarios ----------------------------------------------------------
// -- retornar JSON com emails dos usuarios cadastrados
  public static function listTraders($query){
    self::setup();      
      
    $traders = R::getAll('SELECT email, id FROM usuario WHERE email LIKE :emailPsq' , [ ':emailPsq' => '%' . $query . '%']);
    return $traders;

  }

// -- recuperar colecoes de outros usuarios a partir do identificador do album
  public static function listCollectionsByAlbum($albumId , $usuarioId){
    self::setup();      
    
    $collections = R::findAll('colecao' , 'albumId = :albumId AND usuario_id <> :usuarioId' , [ ':albumId' => $albumId , ':usuarioId' => $usuarioId]);
    return $collections;
  }

// -- listar figurinhas que falta na 'minhaColecao' e que existem na 'colecaoRepetida'
  public static function listMissingSticker($myCollectionId , $otherCollectionId){
    self::setup();      
    
    $colecao = R::load('colecao' , $myCollectionId);
        
    $result = R::getAll( "SELECT * FROM cromo 
                            WHERE album_id = :albumId 
                              AND id NOT IN (SELECT cromo_id FROM cromocolecao WHERE colecao_id = :myCollectionId AND quantidade <> 0)
                              AND id IN (SELECT cromo_id FROM cromocolecao 
                                          WHERE colecao_id = :otherCollectionId
                                            AND quantidade > 1)
                          ORDER BY id"
                         , [':albumId' => $colecao->album_id , ':myCollectionId' => $myCollectionId , ':otherCollectionId' => $otherCollectionId]);
    $missingStickers = R::convertToBeans('cromo', $result);
    //$missingSticker = R::findAll('cromocolecao' , 'colecao = :colecaoId' , [ ':colecaoId' => $minhaColecao , ':usuarioId' => $usuarioId]);

    return $missingStickers;
  }

// -- listar figurinhas que falta na 'minhaColecao' e que existem na 'colecaoRepetida'
  public static function listRepeatedSticker($myCollectionId){
    self::setup();      
    
    $colecao = R::load('colecao' , $myCollectionId);
    $result = R::getAll('SELECT * FROM cromo WHERE id IN 
                          (SELECT cromo_id FROM cromocolecao WHERE colecao_id = :myCollectionId AND quantidade > 1)
                        ORDER BY id', [':myCollectionId' => $myCollectionId]);
    $repeatedStickers = R::convertToBeans('cromo' , $result);

    return $repeatedStickers;
  }


// -- salvar trade - efetuar atualizacao na colecao adicionando cromos de entrada e subtraindo cromos de saída
  public static function saveTrade($usuarioId, $colecaoId , $arrEntrada , $arrSaida){
    self::setup();      

    $colecao = R::load('colecao' , $colecaoId);

    for ($i = 0; $i < count($arrEntrada); $i++) {
      $cromocolecao = R::findOrCreate( 'cromocolecao', [ 'colecao_id' => $colecaoId , 'cromo_id' => (int)$arrEntrada[$i]  ]);
      if(is_null($cromocolecao->quantidade)){ // se registro esta sendo criado define quantidade 1
        $cromocolecao->quantidade = 1;
      }else{
        $cromocolecao->quantidade = $cromocolecao->quantidade + 1;
      }
      R::store($cromocolecao);
      $colecao->quantidadeCromos = $colecao->quantidadeCromos + 1;
    }

    for ($i = 0; $i < count($arrSaida); $i++) {
      $cromocolecao = R::findOne('cromocolecao' , 'colecao_id = :colecaoId AND cromo_id = :cromoId' , [ ':colecaoId' => $colecaoId , ':cromoId' => (int)$arrSaida[$i] ]);
      $cromocolecao->quantidade = $cromocolecao->quantidade - 1;
      $colecao->quantidadeCromos = $colecao->quantidadeCromos - 1;
      R::store($cromocolecao);
    }
    $colecao->dataUltimaAtualizacao = date("d.m.Y");
    R::store($colecao);

    return $colecao;
  }


  // -- listar trocas pendentes solicitadas pelo usuário - aguardando confirmação pelo outro usuário
  public static function listPendindTradeIn($userId){
    self::setup();      

    $listaTroca = R::findAll('troca' , 'usuario_id_in = :usuarioId AND estado = 1' , [ ':usuarioId' => $userId ]);
        
    return $listaTroca;
  }

  // -- listar trocas pendentes solicitadas por outro usuário - aguardando confirmação do usuário proponente
  public static function listPendindTradeOut($userId){
    self::setup();      

    $listaTroca = R::findAll('troca' , 'usuario_id_out = :usuarioId AND estado = 1' , [ ':usuarioId' => $userId ]);
        
    return $listaTroca;
  }  

  // -- salvar trade - incluir proposta de troca com outro usuario
  public static function confirmTrade($colecaoAId , $colecaoBId , $arrEntrada , $arrSaida){
    self::setup();      

    $trade = R::dispense( 'troca' );
    $trade -> colecaoEntrada          = $colecaoAId;
    $trade -> colecaoSaida            = $colecaoBId;
    $trade -> dataInclusao            = date("d.m.Y");
    $trade -> estado                  = 1; //1 - Aguardando Confirmação
    $trade -> quantidadeCromoEntrada  = count($arrEntrada);
    $trade -> quantidadeCromoSaida    = count($arrSaida);


    //Tipo de Trade = 1-Entrada, 2-Saida
    for ($i = 0; $i < count($arrEntrada); $i++) {
      $cromoTroca = R::dispense( 'cromotroca' );     
      $cromoTroca -> tipoTroca = 1 ; //1-Entrada
      $cromoTroca -> codigo = (int)$arrEntrada[$i]; 
      $trade -> ownCromotrocaList[] = $cromoTroca ;
    }

    for ($i = 0; $i < count($arrSaida); $i++) {
      $cromoTroca = R::dispense( 'cromotroca' );
      $cromoTroca -> tipoTroca = 2 ; //1-Saida
      $cromoTroca -> codigo = (int)$arrSaida[$i]; 
      $trade -> ownCromotrocaList[] = $cromoTroca ;
    } 
    R::store($trade);

    return $trade;
  }
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