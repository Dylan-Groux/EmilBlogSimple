<?php
/**
 * Dashboard statistiques des articles : titre, nombre de commentaires, nombre de vues
 */
?>

<h2>Statistiques des articles</h2>
<a class="submit" href="index.php?action=dashboardArticles">Dashboard des articles</a>
<a class="submit" href="index.php?action=admin">Page d'administration</a>

<table class="statsTable" border="1">
	<thead>
		<tr>
			<th>
				Titre
				<a href="index.php?action=articlesStatistics&sort=title&order=asc" title="Tri croissant">▲</a>
				<a href="index.php?action=articlesStatistics&sort=title&order=desc" title="Tri décroissant">▼</a>
			</th>
			<th>
				Nombre de commentaires
				<a href="index.php?action=articlesStatistics&sort=commentCount&order=asc" title="Tri croissant">▲</a>
				<a href="index.php?action=articlesStatistics&sort=commentCount&order=desc" title="Tri décroissant">▼</a>
			</th>
			<th>
				Nombre de vues
				<a href="index.php?action=articlesStatistics&sort=viewCount&order=asc" title="Tri croissant">▲</a>
				<a href="index.php?action=articlesStatistics&sort=viewCount&order=desc" title="Tri décroissant">▼</a>
			</th>
			<th>
				Date de création
				<a href="index.php?action=articlesStatistics&sort=dateCreation&order=asc" title="Tri croissant">▲</a>
				<a href="index.php?action=articlesStatistics&sort=dateCreation&order=desc" title="Tri décroissant">▼</a>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($articles as $article) { ?>
			<tr>
				<td><?= htmlspecialchars($article->title) ?></td>
				<td><?= $article->commentCount ?></td>
				<td><?= $article->viewCount ?></td>
				   <td><?= $article->dateCreation instanceof DateTime ? $article->dateCreation->format('Y-m-d H:i:s') : $article->dateCreation ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
