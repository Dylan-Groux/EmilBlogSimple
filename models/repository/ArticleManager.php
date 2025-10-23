<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles() : array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }
    
    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id) : ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article) : void
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article) : void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article) : void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id) : void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Incrémente le nombre de vues pour un article donné.
     * @param int $articleId : l'id de l'article.
     * @return void
     */
    public function incrementViewCount(int $articleId): void {
        try {
            $sql = "UPDATE article SET view_count = view_count + 1 WHERE id = :id";
            $this->db->query($sql, ['id' => $articleId]);
        } catch (\Exception $e) {
            error_log("Erreur lors de l'incrémentation du nombre de vues pour l'article ID $articleId : " . $e->getMessage());
            // Gère l'exception selon ta logique (ex: throw new DatabaseException(...))
        }
    }

    /**
     * Récupère le nombre de vues pour un article donné.
     * @param int $articleId : l'id de l'article.
     * @return int|null : le nombre de vues.
     */
    public function getViewCountByArticleId(int $articleId): ?int {
        try {
            $sql = "SELECT view_count FROM article WHERE id = :id";
            $result = $this->db->query($sql, ['id' => $articleId]);
            $row = $result->fetch();
            return $row ? (int)$row['view_count'] : null;
        } catch (\Exception $e) {
            error_log("Erreur lors de la récupération du nombre de vues pour l'article ID $articleId : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupère le nombre de commentaires pour un article donné.
     * @param int $articleId : l'id de l'article.
     * @return int : le nombre de commentaires.
     */
    public function getArticlesCommentCounts(int $articleId): int
    {
        $sql = "SELECT COUNT(*) AS comment_count FROM comment WHERE id_article = :id_article";
        $result = $this->db->query($sql, ['id_article' => $articleId]);
        $row = $result->fetch();
        return $row ? (int)$row['comment_count'] : 0;
    }

    public function getAllArticlesDTO(): array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articlesDTO = [];

        while ($articleData = $result->fetch()) {
            $commentCount = $this->getArticlesCommentCounts($articleData['id']);
            $articlesDTO[] = new ArticleDTO($articleData, $commentCount);
        }
        return $articlesDTO;
    }
    
    /**
     * Trie un tableau d'objets ArticleDTO selon un champ et un ordre.
     * @param array $articles : tableau d'ArticleDTO
     * @param string $field : nom du champ (ex: 'dateCreation', 'title', 'commentCount')
     * @param string $order : 'asc' ou 'desc'
     */
    public function sortArticlesDTO(array &$articles, string $field, string $order = 'asc') {
        usort($articles, function($a, $b) use ($field, $order) {
            $valA = $a->$field;
            $valB = $b->$field;
            if ($valA instanceof DateTime) $valA = $valA->format('Y-m-d H:i:s');
            if ($valB instanceof DateTime) $valB = $valB->format('Y-m-d H:i:s');
            if ($order === 'asc') {
                return $valA <=> $valB;
            } else {
                return $valB <=> $valA;
            }
        });
    }
}
