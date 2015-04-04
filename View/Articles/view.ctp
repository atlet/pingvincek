<?php
echo $this->Html->meta('description', $article['Article']['description'], array('inline' => false));
?>

<h1><?php echo $article['Article']['title']; ?></h1>

<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/sl_SI/all.js#xfbml=1&appId=344543705578963";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Place this tag after the last +1 button tag. -->
	<script type="text/javascript">
	window.___gcfg = {lang: 'sl'};

	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>

<p>
<div style="margin-left: 20px;" class="fb-like" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div>
<div class="g-plusone" data-size="medium"></div>
</p>

<?php echo $article['Article']['body']; ?>