<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
        echo $this->Html->charset('UTF-8');

        echo $this->Html->css('screen', null, array('media' => 'screen, projection'));
        echo $this->Html->css('print', null, array('media' => 'print'));
        echo "<!--[if lt IE 8]>" . $this->Html->css('ie', null, array('media' => 'screen, projection')) . "<![endif]-->";
        echo $this->Html->css('menu_style');
        echo $this->Html->script('jquery-1.7.2.min');
        echo $this->Html->script('jquery-ui-1.8.19.custom.min');
        echo $this->Html->css('ui-lightness/jquery-ui-1.8.19.custom.css');
        echo $this->Html->css('jquery.lightbox-0.5');
        echo $this->Html->script('jquery.lightbox-0.5');
        echo $this->Html->css('stil1');
        echo $scripts_for_layout;
        ?>
        <title><?php echo $title_for_layout; ?></title>

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-4248880-3']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>

    <body>

        <div class="visina"></div>
        <div class="container">

            <div class="span-24 last">
                <div class="obroba">
                    <div class="naslov">
                        <span class="naslov">Pingvinček zasebni stiki</span>
                    </div>
                </div>
            </div>

                        <?php if ($prijavljen): ?>
                <div class="span-24 last">
                    <div class="obroba clearfix">
                        <ul id="menu">
                            <?php
                            //echo "<li>" . $this->Html->link('Profili', '/profiles') . "</li>";
                            echo "<li>" . $this->Html->link('Osebe v okolici', '/') . "</li>";
                            //echo "<li>" . $this->Html->link('Prijatelji', '/users/friends') . "</li>";
                            echo "<li>" . $this->Html->link('Priljubljeni', '/users/favorites') . "</li>";
                            if (isset($tmpMessageCount)) {
                                echo "<li>" . $this->Html->link('Pošta (' . $tmpMessageCount . ')', '/messages') . "</li>";
                            } else {
                                echo "<li>" . $this->Html->link('Pošta', '/messages') . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="span-24 last">
                    <div class="obroba clearfix">
                        <ul id="menu">
                            <?php
                            echo "<li>" . $this->Html->link('Zasebni stiki', '/') . "</li>";
                            echo "<li>" . $this->Html->link('Registracija', '/users/register') . "</li>";
                            echo "<li>" . $this->Html->link('Članki', '/articles') . "</li>";
                            ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>


            <div class="span-5">
                <?php
                if (isset($prijavljen)) {
                    if (!$prijavljen) {
                        echo $this->element('prijava');
                    } else {
                        echo $this->element('prijavljen');
                    }
                }

                if (isset($searchForm)) {
                    echo $this->element('search');
                }
                ?>
            </div>

            <div class="span-19 last obroba-prazno">
                <?php
                echo $this->Session->flash();
                echo $this->Session->flash('auth');
                echo $content_for_layout
                ?>
            </div>

            <div class="span-24 last">
                <div class="obroba">
                    <p>
                        <center><?php echo $this->Html->link('Članki', '/articles') . ' | ' . $this->Html->link('Zasebni stiki', 'http://www.pingvincek.com') . ' | ' . $this->Html->link('Zmenkarije', 'http://www.pingvincek.com'); ?> @2011</center>
                    </p>
                </div>
            </div>

        </div>

        <div id="support">
<?php
echo $this->Html->link(
        $this->Html->image("pomoc.png", array("alt" => "Potrebujete pomoč?")), "#", array('escape' => false, 'id' => "opensupport")
);
?>
        </div>

        <div id="supportdialog" title="Potrebujete pomoč?">
            <div id="tmpForm"></div>
        </div>

        <script>
            $(document).ready(function()
            {
                $(function() {
                    $("#supportdialog").dialog(
                            {
                                height: 580,
                                autoOpen: false,
                                width: 410,
                                modal: true,
                                buttons:
                                        {
                                            "Prekliči": function()
                                            {
                                                $(this).dialog("close");
                                            },
                                            "Pošlji": function()
                                            {
                                                $('#dodajBTN').click();
                                            }
                                        }
                            });

                });

                $("#opensupport").click(function() {
                    $.ajax(
                            {
                                url: '<?php echo $this->Html->url(array('controller' => 'supports', 'action' => 'sendsupport')); ?>/',
                                success: function(data)
                                {
                                    $("#supportdialog").dialog('open');
                                    $('#tmpForm').html(data);
                                }
                            });
                    return false;
                });
            });
        </script>
    </body>
</html>
