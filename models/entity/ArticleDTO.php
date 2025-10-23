<?php

/**
*Data Transfer Object pour un article avec nombre de commentaires
*/
class ArticleDTO
{
    public int $id;
	public int $idUser;
	public string $title;
	public string $content;
	public ?DateTime $dateCreation;
	public ?DateTime $dateUpdate;
	public int $viewCount;
	public int $commentCount;

	/**
	*@param array $articleData : données de l'article (depuis la BDD)
	*@param int $commentCount : nombre de commentaires
	*/
	public function __construct(array $articleData, int $commentCount)
	{
		$this->id = $articleData['id'] ?? -1;
		$this->idUser = $articleData['id_user'] ?? -1;
		$this->title = $articleData['title'] ?? '';
		$this->content = $articleData['content'] ?? '';
		$this->dateCreation = isset($articleData['date_creation']) && $articleData['date_creation'] !== null
		? new DateTime($articleData['date_creation'])
		: null;
		$this->dateUpdate = isset($articleData['date_update']) && $articleData['date_update'] !== null
			? new DateTime($articleData['date_update'])
			: null;
		$this->viewCount = $articleData['view_count'] ?? 0;
		$this->commentCount = $commentCount;
	}
}
