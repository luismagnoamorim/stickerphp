<?php

class Figurinha {


  public static function criarEditora($nomeEditora){
      self::configurar();
      $editora = R::dispense('editora');
      $editora -> nomeEditora = $nomeEditora ;
      R::store($editora);
  }

  public static function criarAlbum($tituloAlbum,$quantidadeCromos,$editora,$formato,$anoPublicacao,$idioma){
    self::configurar();
    $album = R::dispense('album');
    $album -> titulo  = $tituloAlbum;
    $album -> dataInclusao = date("d.m.Y");
    $album -> quantidadeCromos = $quantidadeCromos;
    $album -> editora = $editora;
    $album -> formato = $formato;
    $album -> anoPublicacao = $anoPublicacao;
    $album -> idioma        = $idioma;
    
    for ($i = 1; $i <= (int)$quantidadeCromos; $i++) {
      $cromo =  R::dispense('cromo');
      $cromo -> numero = $i; 
      $cromo -> nome   = ' ';
      $album -> ownCromoList[] = $cromo ;
      //unset($cromo);
    }
    
    R::store($album);
    }

  public static function listarAlbuns(){
      self::configurar();      
      $listaAlbuns = R::findAll('album');
    //  foreach( $album->ownCromoList as $cromo ) {
    //    $listaCromos[] = $cromo;
    //  }
      return $listaAlbuns;
  }  



  public static function detalharAlbum($albumId){
    self::configurar();
    $errMessage = '';
        
      
    if (!$albumId) {
     $errMessage = 'ERRO Identificacao do album nao informado';
     return $errMessage;
    } 
   
    if (!$errMessage) {
      $album = R::Load('album', $albumId );
      return $album;
    }
  } 


  public static function alteraCromo($idCromo,$numero,$nome){
    self::configurar();
    $cromo = R::findOne('cromo', 'cromo_id = :? ', $idCromo);
    $cromo->numero  = $numero;
    $cromo->nome  = $nome;
    R::store($cromo);
  }  

  public static function listarCromosAlbum($albumId){ //////////////////////////////// FUNCIONAMENTO OK
      self::configurar();      
      $cromos = R::findAll('cromo', 'album_id = :id ', [ ':id'=>$albumId ]);
      return $cromos;
  }  

  public static function incluirCromoColecao($colecaoId, $cromoId){ //////////////////////////////// F
    self::configurar();      

    $colecao  = R::Load('colecao' , $colecaoId);
    $cromo    = R::Load('cromo' ,  $cromoId );
    $colecao->sharedCromoList[] = $cromo;
    R::store($colecao);

    return $colecao;
  }

  public static function retirarCromoColecao($colecaoId, $cromoId){ //////////////////////////////// F
      self::configurar();
      $colecao  = R::Load('colecao' , $colecaoId);
      $cromo    = R::Load('cromo' ,  $cromoId );      
      unset($colecao->sharedCromoList[$cromoId] );
      R::store($colecao);

      return $colecao;
  }

// usuario escolhe album para colecionar
  public static function incluirAlbumColecao($usuarioId, $albumId){
    self::configurar();

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
  
  public static function recuperarColecaoUsuario($albumId , $usuarioId){
    self::configurar();

    $colecao = R::findOne('colecao', 'album_id = :albumId AND usuario_id = :usuarioId', [ ':albumId'=>$albumId , ':usuarioId'=>$usuarioId ]);
    return $colecao;
  }    
	// TODO Lógica do Negócio Aqui
  
  // recuperar aspectos de um livro 
  public static function listarAspectos($textGoogleKey){
      self::configurar();
      $aspectos = R::findAll( 'aspecto' );
      
      $livro = R::findOne('livro', 'text_google_key = :textGoogleKey ', [ ':textGoogleKey'=>$textGoogleKey ]);
      
      foreach( $aspectos as &$aspecto) {
        $aspecto->valor = 0;
        if($livro){
          $avaliacoes  = R::find( 'avaliacao', ' livro_id = :livroId AND aspecto_id = :aspectoId ' , [ ':livroId'=>$livro->id, ':aspectoId'=>$aspecto->id ] );
          
          $count = count($avaliacoes);
          $soma = 0;
          $media = 0;
          //$count = 2;
          foreach( $avaliacoes as $avaliacao ) {
            $soma = $soma + $avaliacao->valor;
          }
        $media = $soma / ( $count == 0 ? 1 : $count ) ;
        $aspecto->valor = $media;
        }  
      }
      
      return $aspectos;
  }

  



  public static function pesquisarLivroGoogle($palavraChave){
    $errMessage = '';
    //$palavraChave = ''
    // excluir base.php
    //include_once "base.php";
  
    //set_include_path(get_include_path() . PATH_SEPARATOR . '/path/to/google-api-php-client/src');
    
    $client = new Google_Client();
    $client->setApplicationName("NextBook");
    // Warn if the API key isn't set.
    //if (!$apiKey = getApiKey()  ) {
    //if (!$apiKey = "AIzaSyCcuvhbNJZUXEMFQ2uvSTk6XFTTIK7SXac" ) {  
    if (!$apiKey = "AIzaSyBU8KdeR0FB-A_4SUzbAcL3nkgH0RTZ4tY" ){
     echo missingApiKeyWarning();
      exit;
    }
    
    $palavraChave = $_POST['palavraChave'];
    
    if (!$palavraChave) {
     $errMessage = 'Digite a palavra chave para pesquisa';
     return $errMessage;
    } 
   
    if (!$errMessage) {
      //startIndex --- utilizar para paginacao
       $optParams = array('printType' => 'books' , 'maxResults' => '40' , 'langRestrict' => 'pt' 
        , 'fields' => 'items(id,volumeInfo(authors,imageLinks/smallThumbnail,industryIdentifiers/identifier,publisher,title))');
       //items(accessInfo/country,id,kind,volumeInfo(authors,categories,description,imageLinks/smallThumbnail,industryIdentifiers/identifier,mainCategory,pageCount,publishedDate,publisher,subtitle,title))
       $client->setDeveloperKey($apiKey);
       $service = new Google_Service_Books($client);
       $results = $service->volumes->listVolumes($palavraChave, $optParams);

       return $results;
    }
  }

  // retornar lista com os livros com avaliacoes mais recentes
  public static function listarLivrosRecentes(){
      self::configurar();

      $aspectos = R::findAll( 'aspecto' );
      $livros = R::findAll('livro', ' ORDER BY data_inclusao DESC LIMIT 9 ');
      $listaLivrosRecentes ;

      foreach ($livros as $livro) {
        $livroGoogle = self::detalharLivroGoogle($livro->textGoogleKey);
        $livro->titulo = $livroGoogle['volumeInfo']['title'];
        $livro->autor = $livroGoogle['volumeInfo']['authors'][0];
        

        if ($livroGoogle['volumeInfo']['imageLinks']['thumbnail']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['thumbnail'];
        }
        else if ($livroGoogle['volumeInfo']['imageLinks']['smallThumbnail']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['smallThumbnail'];
        }
        else if($livroGoogle['volumeInfo']['imageLinks']['small']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['small'];
        }
        else if ($livroGoogle['volumeInfo']['imageLinks']['medium']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['medium'];
        }
        else if($livroGoogle['volumeInfo']['imageLinks']['large']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['large'];
        }
        else{
          $imagem = '../images/book-details/capaPadrao.jpg';            
        }
        $livro->imagem = $imagem;


        $livro->aspectos = self::listarAspectos ($livro->textGoogleKey);
        $listaLivrosRecentes[] = $livro;
      }
      
      return $listaLivrosRecentes;
  }

  // retornar lista com os livros com avaliacoes mais recentes
  public static function listarLivrosMaisAvaliados(){
      self::configurar();

      $aspectos = R::findAll( 'aspecto' );
      $livros = R::findAll('livro', ' ORDER BY quantidade_avaliacoes DESC LIMIT 9 ');
      $listaLivrosRecentes ;

      foreach ($livros as $livro) {
        $livroGoogle = self::detalharLivroGoogle($livro->textGoogleKey);
        $livro->titulo = $livroGoogle['volumeInfo']['title'];
        $livro->autor = $livroGoogle['volumeInfo']['authors'][0];
        

        if ($livroGoogle['volumeInfo']['imageLinks']['thumbnail']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['thumbnail'];
        }
        else if ($livroGoogle['volumeInfo']['imageLinks']['smallThumbnail']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['smallThumbnail'];
        }
        else if($livroGoogle['volumeInfo']['imageLinks']['small']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['small'];
        }
        else if ($livroGoogle['volumeInfo']['imageLinks']['medium']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['medium'];
        }
        else if($livroGoogle['volumeInfo']['imageLinks']['large']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['large'];
        }
        else{
          $imagem = '../images/book-details/capaPadrao.jpg';            
        }
        $livro->imagem = $imagem;


        $livro->aspectos = self::listarAspectos ($livro->textGoogleKey);
        $listaLivrosRecentes[] = $livro;
      }
      
      return $listaLivrosRecentes;
  }


  // retornar aspectos cadastrados para montar filtro de pesquisa de livros
  public static function listarAspectosPesquisa(){
      self::configurar();
      $aspectos = R::findAll( 'aspecto' );      
      return $aspectos;
  }


  // retornar lista com os livros com avaliacoes mais recentes
  public static function pesquisarLivroFiltro( $filtroAspectos ){
      self::configurar();

      $lista = R::getAll('SELECT livro.* FROM livro JOIN avaliacao ON livro.id = avaliacao.livro_id WHERE avaliacao.aspecto_id IN (' .R::genSlots( $filtroAspectos ). ')', $filtroAspectos );

      $livros = R::convertToBeans( 'livro', $lista );
      $listaLivroFiltro;

      foreach ($livros as $livro) {
        $livroGoogle = self::detalharLivroGoogle($livro->textGoogleKey);
        $livro->titulo = $livroGoogle['volumeInfo']['title'];
        $livro->autor = $livroGoogle['volumeInfo']['authors'][0];
        

        if ($livroGoogle['volumeInfo']['imageLinks']['thumbnail']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['thumbnail'];
        }
        else if ($livroGoogle['volumeInfo']['imageLinks']['smallThumbnail']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['smallThumbnail'];
        }
        else if($livroGoogle['volumeInfo']['imageLinks']['small']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['small'];
        }
        else if ($livroGoogle['volumeInfo']['imageLinks']['medium']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['medium'];
        }
        else if($livroGoogle['volumeInfo']['imageLinks']['large']){
          $imagem = $livroGoogle['volumeInfo']['imageLinks']['large'];
        }
        else{
          $imagem = '../images/book-details/capaPadrao.jpg';            
        }
        $livro->imagem = $imagem;


        $livro->aspectos = self::listarAspectos ($livro->textGoogleKey);
        $listaLivroFiltro[] = $livro;
    }
    
    if(isset($listaLivroFiltro)) return $listaLivroFiltro;
  }

    // validar dados preenchidos no formulario de login
  public static function validarLogin( $idLogin, $senhaLogin ){
    self::configurar();
    $u = R::findOne('usuario', 'login = :idLogin AND senha = :senhaLogin',  [ ':idLogin'=>$idLogin , ':senhaLogin'=>$senhaLogin ]);
    $usuario = array( 'id' =>  $u['id'] , 'nome' => $u['nome'] , 'dataNascimento' => $u['data_nascimento'] , 'sexo' => $u['sexo'] , 'email' => $u['email']);
    return $usuario;
  }
// ------------------------ metodos nao utilizados -------------------------------------

  public static function cadastrarUsuario($nomeUsuario, $dataNascimento, $sexo, $email, $login, $senha) {
    self::configurar();
    $u = R::dispense('usuario');

    $u -> nome           = $nomeUsuario ;
    $u -> dataNascimento = $dataNascimento ;
    $u -> sexo           = $sexo ;
    $u -> email          = $email ;
    $u -> login          = $login ;
    $u -> senha          = $senha ;
    $u -> nivel          = 1;
    R::store($u);

    $usuario = array( 'id' =>  $u['id'] , 'nome' => $u['nome'] , 'dataNascimento' => $u['data_nascimento'] , 'sexo' => $u['sexo'] , 'email' => $u['email']);

    return $usuario;
  }        

  public static function detalharLivroGoogle($livroId){
    $errMessage = '';
        
    $client = new Google_Client();
    $client->setApplicationName("NextBook");
    // Warn if the API key isn't set.
    //if (!$apiKey = getApiKey()  ) {
    //if (!$apiKey = "AIzaSyCcuvhbNJZUXEMFQ2uvSTk6XFTTIK7SXac" ) {  
    if (!$apiKey = "AIzaSyBU8KdeR0FB-A_4SUzbAcL3nkgH0RTZ4tY" ){
     echo missingApiKeyWarning();
      exit;
    }
    
    //$palavraChave = $_POST['palavraChave'];
    if (!$livroId) {
     $errMessage = 'ERRO Identificacao do livro nao informado';
     return $errMessage;
    } 
   
    if (!$errMessage) {
      //startIndex --- utilizar para paginacao
       $optParams = array('fields' => 'items(accessInfo/country,volumeInfo(authors,description,imageLinks(large,
        medium,small,smallThumbnail,thumbnail),industryIdentifiers,language,mainCategory,pageCount,publishedDate,publisher,title))' );
       $client->setDeveloperKey($apiKey);
       $service = new Google_Service_Books($client);
       $results = $service->volumes->get($livroId);//, $optParams);
       return $results;
    }
  } 

  public static function criarLivro(){
    self::configurar();
    $livro = R::dispense('livro');
    $livro -> textGoogleKey  = 'gwABDAAAQBAJ'; // pequeno principe
    $livro->dataInclusao = date("d.m.Y");
    $livro->quantidadeAvaliacoes = 1;
    $livro->dataUltimaAtualizacao = date("d.m.Y");
    $avaliacao = R::dispense('avaliacao');
    $avaliacao -> usuario = R::load('usuario' , 1); 
    $avaliacao -> aspecto = R::load('aspecto' , 1);
    $avaliacao -> valor = 1 ;
    $livro -> ownAvaliacaoList[] = $avaliacao ;
    R::store($livro);
  }
  

  
  public static function criarAspecto($nomeAspecto){
      self::configurar();
      $aspecto = R::dispense('aspecto');
      $aspecto -> nomeAspecto = $nomeAspecto ;
      R::store($aspecto);
  }

  public static function apagarAspecto(){
      self::configurar();
      R::wipe( 'aspecto' ); //burns all the books!
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
                $dbname   = 'figurinha';
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