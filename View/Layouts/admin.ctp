<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo __('Administracija: '); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('cake.generic.treplex');
		
		echo $this->Html->script('jquery-1.7.2.min');
		echo $this->Html->script('jquery-ui-1.8.19.custom.min');
		echo $this->Html->css('ui-lightness/jquery-ui-1.8.19.custom.css');
		
		echo $this->Html->script('ckeditor/ckeditor');
		echo $this->Html->script('ckeditor/adapters/jquery');

        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1>Administrativni kotiček</h1>
            </div>

            <div id="menu">
                <ul class="dropdown">
                    <li>
                        <?php echo $this->Html->link("Delovna tabla", array("controller" => "users", "action" => "dashboard", "admin" => true)); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link("Uporabniki", array("controller" => "users", "action"     => "index", "admin"      => true)); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link("Prijave", array("controller" => "reports", "action"     => "index", "admin"      => true)); ?>
                    </li>
					<li>
                        <?php echo $this->Html->link("Članki", array("controller" => "articles", "action"     => "index", "admin"      => true)); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link("Skupine", array("controller" => "groups", "action"     => "index", "admin"      => true)); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link("Šifranti", array("controller" => "users", "action"     => "sifranti", "admin"      => true)); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link("Privzete nastavitve", array("controller" => "users", "action"     => "config", "admin"      => true)); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link("Odjava", array("controller" => "users", "action"     => "logout", "admin"      => false)); ?>
                    </li>
                </ul>
            </div>

            <div id="content">

                <?php //$this->Session->flash(); ?>

                <?php echo $content_for_layout; ?>

            </div>
            <div id="footer">
                ...@2010
            </div>
        </div>
    </body>
</html>
