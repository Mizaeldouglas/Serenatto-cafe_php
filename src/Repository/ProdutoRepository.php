<?php

class ProdutoRepository
{
	private PDO $pdo;
	
	public function __construct (PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	private function formarObjeto ($dados)
	{
		return new Produto(
			$dados['id'],
			$dados['tipo'],
			$dados['nome'],
			$dados['descricao'],
			$dados['preco'],
			$dados['imagem']
		);
	}
	
	public function opcoesCafe (): array
	{
		$sql1 = "SELECT * FROM produtos WHERE tipo = 'Cafe' ORDER BY preco ";
		$statement = $this->pdo->query($sql1);
		$produtosCafe = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		return array_map(function ($cafe) {
			return $this->formarObjeto($cafe);
		}, $produtosCafe);
	}
	
	public function opcoesAlmoco (): array
	{
		$sql2 = "SELECT * FROM produtos WHERE tipo = 'Almoco' ORDER BY preco ";
		$statement = $this->pdo->query($sql2);
		$produtosAlmoco = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		return array_map(function ($almoco) {
			return $this->formarObjeto($almoco);
		}, $produtosAlmoco);
	}
	
	public function searchAll ()
	{
		$sql = "SELECT * FROM produtos ORDER BY preco";
		$statement = $this->pdo->query($sql);
		$dados = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$todosOsDados = array_map(function ($produto) {
			return $this->formarObjeto($produto);
		}, $dados);
		return $todosOsDados;
	}
	
	public function delete (int $id): void
	{
		$sql = "DELETE FROM produtos WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->execute();
		
	}
	
	public function insert (Produto $produto): void
	{
		$sql = "INSERT INTO produtos (tipo, nome, descricao, preco, imagem) VALUES (:tipo, :nome, :descricao, :preco, :imagem)";
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':tipo', $produto->getTipo());
		$statement->bindValue(':nome', $produto->getNome());
		$statement->bindValue(':descricao', $produto->getDescricao());
		$statement->bindValue(':preco', $produto->getPreco());
		$statement->bindValue(':imagem', $produto->getImagem());
		$statement->execute();
	}
	public function searchById (int $id): Produto
	{
		$sql = "SELECT * FROM produtos WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->execute();
		$dados = $statement->fetch(PDO::FETCH_ASSOC);
		
		return $this->formarObjeto($dados);
	}
	
	public function update (Produto $produto): void
	{
		$sql = "UPDATE produtos SET tipo = :tipo, nome = :nome, descricao = :descricao, preco = :preco, imagem = :imagem WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':id', $produto->getId(), PDO::PARAM_INT);
		$statement->bindValue(':tipo', $produto->getTipo());
		$statement->bindValue(':nome', $produto->getNome());
		$statement->bindValue(':descricao', $produto->getDescricao());
		$statement->bindValue(':preco', $produto->getPreco());
		$statement->bindValue(':imagem', $produto->getImagem());
		$statement->execute();
	}
	
	
}