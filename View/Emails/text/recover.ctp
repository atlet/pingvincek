Pozdravljeni,

zahtevali ste novo geslo.

Če ga želite spremeniti, kliknite na povezavo oz. jo prilepite v brskalnik:

<?php echo Router::url(array('controller' => 'users', 'action' => 'verify', $token), true); ?>


V kolikor niste zahtevali spremembe gesla, preprosto ignorirajte to sporočilo.
Na stran se prijavite na sledeči povezavi:

<?php echo Router::url(array('controller' => 'users', 'action' => 'index'), true); ?>


Hvala,
Kolektiv Pingvincek.com