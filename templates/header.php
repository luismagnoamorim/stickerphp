<?php
	
    $navItem = isset($navItem)? $navItem: null;

    $user = isset($_SESSION["user"])? $_SESSION["user"]: null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="/js/jquery.slim.min.js"></script>
    <script src="/js/tether.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>  
    <script src="/js/custom.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body class="bg-faded">
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">
            <img src="/img/stickertrade-logo.png" width="200" height="30" alt="StickerTrade">
        </a>
        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="navbar-nav mr-auto">
                <?php if ($user != null) { ?>        
                    <li class="nav-item <?=$navItem == "stickerbooks"? "active" : "" ?>">
                        <a class="nav-link" href="/stickerbooks">Álbuns</a>
                    </li>
                    <li class="nav-item <?=$navItem == "collections"? "active" : "" ?>">
                        <a class="nav-link" href="/collections">Minhas coleções</a>
                    </li>
                    <li class="nav-item <?=$navItem == "trade"? "active" : "" ?>">
                        <a class="nav-link" href="/trades">Trocas</a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav">
                <?php if ($user != null) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbar-logged-user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<?=$user["email"] ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbar-logged-user">
                            <a class="dropdown-item" href="/user-account">
                                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;Meus dados
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;Sair
                            </a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item <?=$navItem == "create-user-account"? "active" : "" ?>">
                        <a class="nav-link" href="/create-user-account">Criar minha conta</a>
                    </li>
                    <li class="nav-item <?=$navItem == "login"? "active" : "" ?>">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?php if (isset($flash["info"])) { ?>
            <br>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?=$flash["info"] ?>
            </div>
        <?php } ?>
        <?php if (isset($flash["error"])) { ?>
            <br>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?=$flash["error"] ?>
            </div>
        <?php } ?>
    </div>