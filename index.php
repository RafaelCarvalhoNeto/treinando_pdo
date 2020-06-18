<!DOCTYPE html>
<html lang = "pt">
<head>
    <meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Ubuntu:wght@300;700&display=swap" rel="stylesheet">
    <title>Treinando PDO</title>
</head>
<body>
    

<?php
    require_once("conexao.php");

    if(isset($_POST)&&$_POST){

        $title = $_POST["title"];
        $rating = $_POST["rating"];        
        
        $query = $db->prepare("insert into movies (title, rating) values (:title, :rating)");
    
        $cadastrou = $query->execute([
            ":title"=>$title,
            ":rating"=>$rating
        ]);

    }

    
    if(isset($_GET) && $_GET){
        $id = $_GET["id"];

        $query = $db->prepare("delete from movies where id = :id");

        $excluiu = $query->execute([
            ":id"=>$id
        ]);
    };

    //Pesquisando todos os itens da base de dados
    $query = $db->query("select * from movies order by rating desc");
    $listaFilmes = $query->fetchALL(PDO::FETCH_ASSOC);


    //Contando quanto itens existem na base

    // Forma 1
    $teste = $db->query("select count(*) as total from movies");
    $teste = $teste->fetch();
    $totalFilmes = $teste["total"];

    // Forma 2
    // $totalFilmes = count($listaFilmes);

    // Forma 3
    // $teste = $db->query("select * from movies");
    // $totalFilmes = $query->rowCount();


    $last = $db->query("select * from movies order by id desc");
    $ultimoFilme = $last->fetch();
    $ultimoFilme= $ultimoFilme["title"];

?>

    <h1>Adicionando Movies</h1>
    <form action="index.php" method="POST">

        <div class="field-group">

            <div class="field">
                <label for="title">Filme</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="field">
                <label for="rating">Rating</label>
                <input type="text" name="rating" id="rating" required>
            </div>

        </div>

        <button type="submit">Enviar</button>
    </form>
    <div>
        <?php
            if(isset($_POST) && $_POST){
                if ($cadastrou){
                    echo "<p class='ok'>Filme cadastrado com sucesso!</p>";
                } else{
                    echo "<p class='nok'>Problemas com o cadastro</p>";
                }   
            }
            if (isset($_GET)&& $_GET){
                if ($excluiu){
                    echo "<p class='nok'>Excluido com sucesso</p>";
                }
            }
        ?>
    </div>
    <main>
        <h2>Total de filmes - <?=$totalFilmes;?> filmes</h2>
        <p>O ultimo filme adicionado foi: <strong><?=$ultimoFilme;?></strong></p>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>#</th>
                    <th>Filme</th>  
                    <th>Avaliação</th>  
                    <th>Excluir</th>  
                </tr>


            </thead>
            <tbody>
                <?php
                $n=1;
                foreach ($listaFilmes as $filme): ?>
                    <tr>
                        <td><?=$filme["id"];?></td>
                        <td><?=$n;?></td>
                        <td><?=$filme["title"];?></td>
                        <td><?=$filme["rating"];?></td>
                        <td><a href="#bg<?=$filme["id"];?>">&times;</a></td>
                        <div id="bg<?=$filme["id"];?>" class="bg">
                            <div class="box">
                                <a class="excluir" href="index.php?id=<?=$filme["id"]?>">Confirmar Exclusão de<br><strong><?=$filme["title"];?></strong>?</a>
                                <a href="#" id="close">&times;</a>
                            </div>
                        </div>
                    </tr>
                <?php $n++; endforeach;?>

            </tbody>
        
        </table>
    </main>

    <!-- <a href="#bg1">Janela</a>
    <div id="bg1" class="bg">
        <div class="box">
            <a class="excluir" href="index.php?id=<?=$filme["id"]?>">Confirmar Exclusão?</a>
            <a href="" id="close">X</a>
        </div>
    </div> -->







</body>


</html>
