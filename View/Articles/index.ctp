<?php
echo $this->Html->meta(
        'description', 'Raznorazni članki o spletnih zmenkarija, ter ostalih zanimivih temah.'
);
?>

<h1>Članki</h1>

<p>
	<?php
		foreach ($articles as $article)
		{
			echo $this->Html->link($article['Article']['title'], array('action'=>'view', $article['Article']['slug'], 'admin' => FALSE)) . '<br>';
		}
	?>
</p>