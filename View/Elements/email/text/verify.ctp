Pozdravljeni,

uspešno vam je bilo dodeljeno novo geslo.
Novi podatki za prijavo so:

Uporabniško ime: <?php echo $user['User']['username']; ?>

Geslo: <?php echo $password; ?>


Geslo lahko spremenite med nastavitvami.
Na stran se prijavite na sledeči povezavi:

<?php echo Router::url(array('controller' => 'users', 'action' => 'index'), true); ?>


Hvala,
Kolektiv Pingvincek.com