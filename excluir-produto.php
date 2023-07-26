<?php
require 'src/conexao-bd.php';
require 'src/Model/Produto.php';
require 'src/Repository/ProdutoRepository.php';

$productRepository = new ProdutoRepository($pdo);
$productRepository->delete($_POST['id']);

header('Location: admin.php');


