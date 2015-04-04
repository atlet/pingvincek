<?php
echo $this->Html->meta(
		'description', 'Spoznajte nove osebe v vaši okolici za druženje, zmenke, resno zvezo ali avanturo. Brezplačno in enostavno na zmenkarije Pingvinček zasebni stiki.'
);
?> 

<div class="span-19 landingpage">
    <h1>Najenostavnejši način spoznavanja novih oseb v vaši okolici!</h1>
	
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
	<div class="fb-like" data-layout="button_count" style="margin-left: 20px;" data-href="http://www.pingvincek.com" data-send="true" data-width="340" data-show-faces="false"></div>
	<div class="g-plusone" data-size="medium"></div>
</p>
<p>Prijavite se in takoj pričnite s spoznavanjem novih prijateljev v vaši okolici. Poiščite partnerja za zmenke, resno zvezo ali katero drugo aktivnost.    </p>
<p>
<center><?php echo $this->Html->link($this->Html->image('pridruzi-se.png'), array('controller' => 'users', 'action' => 'register'), array('escape' => false)); ?></center>
</p>
</div>

<div class="span-9 append-1 landingpage">
    <h2>Iskanje oseb</h2>
    <p>
		<?php echo $this->Html->image('1338641673_web_search.png', array('align' => 'left')); ?>
        Sami določite, koliko oddaljene osebe od vašega kraja boste iskali. Ali jih želite iskati samo v vaši bližini ali po celotni Sloveniji - odločitev je vaša.
    </p>
</div>

<div class="span-9 last landingpage">
    <h2>Zasebna sporočila</h2>
    <p>
		<?php echo $this->Html->image('1338641714_message2.png', array('align' => 'left')); ?>
        Osebi, ki vam je všeč, lahko pošljete zasebno sporočilo in tako pričnete s spoznavanjem.
    </p>
</div>

<div class="span-9 append-1 landingpage">
    <h2>Samo prave identitete</h2>
    <p>
		<?php echo $this->Html->image('1338641567_identity.png', array('align' => 'left')); ?>
        Vse lažne profile odstranimo takoj, ko jih zasledimo.
    </p>
</div>

<div class="span-9 last landingpage">
    <h2>Brezplačno</h2>
    <p>
		<?php echo $this->Html->image('1338641525_sign_free.png', array('align' => 'left')); ?>
        Uporaba naše spletne strani za zasebne stike je popolnoma brezplačna.
    </p>
</div>