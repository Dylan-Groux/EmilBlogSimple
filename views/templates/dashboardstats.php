<?php
/**
 * Dashboard statistiques des articles : titre, nombre de commentaires, nombre de vues
 */
?>

<h2>Statistiques des articles</h2>

<table border="1" cellpadding="8" style="border-collapse:collapse; width:100%;">
	<thead>
		<tr>
			<th>Titre</th>
			<th>Nombre de commentaires</th>
			<th>Nombre de vues</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($articles as $article) { ?>
			<tr>
				<td><?= htmlspecialchars($article->title) ?></td>
				<td><?= $article->commentCount ?></td>
				<td><?= $article->viewCount ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
