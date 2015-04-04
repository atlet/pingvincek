<div class="h1-naslov">
    <h1>Novo geslo</h1>
</div>
<?php if (isset($success)): ?>
    <p>
        Geslo je bilo uspešno spremenjeno! <br><br>
        Novo geslo je bilo poslano na vaš elektronski naslov.  <br>
        Geslo lahko kasneje spremenite v nastavitvah.
    </p>
    <?php else: ?>
    <p>
        Napačni podatki! <br>
        Ali ste pravilno kopirali link v brskalnik?
    </p>
 <?php endif; ?>