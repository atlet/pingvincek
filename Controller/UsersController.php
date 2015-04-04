<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    var $helpers = array('Html', 'Form', 'Time', 'Js');
    var $components = array('RequestHandler');
    var $uses = array('User', 'Message', 'City');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'recover', 'verify', 'listcities', 'uspesnaprijava', 'register');
    }

    function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->User->id = $this->Auth->User('id');
                $this->User->saveField('lastlogin', date('Y-m-d H:i:s'));

                $this->loadModel("Login");
                $tmpLoginData = array();
                $tmpLoginData['Login']['user_id'] = $this->Auth->User('id');
                $tmpLoginData['Login']['ip'] = $this->RequestHandler->getClientIp();

                $this->Login->save($tmpLoginData);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Uporabniško ime ali geslo je napačno!'), 'flash_success', array(), 'auth');
            }
        }
    }

    function logout() {
        return $this->redirect($this->Auth->logout());
    }

    function index() {
        if ($this->Session->check('Auth.User.id')) {
            $this->redirect(array('action' => 'browse'));
        } else {
            $this->set('title_for_layout', 'Spoznate nove osebe v okolici | zmenkarije Pingvinček zasebni stiki');
        }
    }

    function uspesnaprijava() {

    }

    function register() {
        if (!empty($this->request->data)) {
            $this->User->create();
            $this->request->data['User']['group_id'] = $this->Config->get('skupina');
            $tmpPassword = $this->generatePassword(8);
            $this->request->data['User']['password'] = $tmpPassword;
            if ($this->User->save($this->request->data)) {
                //$this->Session->setFlash(__('The User has been saved'));
                $this->set('tmpWWW', $this->Config->get('wwwNaslov'));
                $this->Email->to = $this->request->data['User']['username'];
                $this->Email->from = $this->Config->get('email');
                $this->Email->subject = '[www.pingvincek.com] Pingvinček zasebni stiki - geslo za prijavo';
                $this->Email->template = 'new_user';
                $this->Email->sendAs = 'text';
                $this->set('tmpPassword', $tmpPassword);
                $this->Email->send();

                //$this->Session->setFlash(__('Uspešno ste se registrirali. Geslo je bilo poslano na vaš e-naslov.'), 'flash_success');
                $this->redirect(array('action' => 'uspesnaprijava'));
            } else {
                $this->Session->setFlash(__('Prosim, odpravite napake!'), 'flash_success');
            }
        }

        $genders = $this->User->Gender->find('list');
        $this->set(compact('genders'));

        $this->set('title_for_layout', 'Ustvari nov uporabniški račun in prični spoznavati osebe v okolici');
    }

    // Finding cities for jQuery autocomplete.
    function listcities() {
        //Configure::write('debug', 0);
        //$this->autoRender = false;
        $this->layout = 'ajax';
        $query = $this->request['url']['term'];
        $this->City->recursive = -1;
        $cities = $this->City->find('all', array('order' => array('name ASC'), 'conditions' => array('featureCode' => array('PPL', 'PPLC'), 'name LIKE' => $query . '%')));
        $i = 0;

        foreach ($cities as $city) {
            $response[$i]['value'] = $city['City']['geonameid'];
            $response[$i]['label'] = $city['City']['name'];
            $i++;
        }

	$this->set('cities', $response);
    }

    function browse() {
        $tmpSearch = NULL;
        $tmpSearch['User.id NOT'] = $this->Auth->User('id');

        $isProfileOk = TRUE;
        if (!$this->User->isProfileOk($this->Auth->user('id'))) {
            $isProfileOk = FALSE;
        }

        $this->set('isProfileOk', $isProfileOk);

        $pogoji = array();

        if ($this->request->is('post')) {
            $this->Session->write('Users.genders', $this->request->data['user']['genders']);
            $this->Session->write('Users.distance', $this->request->data['user']['distance']);
            $this->Session->write('Users.ageFrom', $this->request->data['user']['ageFrom']);
            $this->Session->write('Users.ageTo', $this->request->data['user']['ageTo']);
        } else {
            $this->request->data['user']['genders'] = $this->Session->read('Users.genders');
            $this->request->data['user']['distance'] = $this->Session->read('Users.distance');
            $this->request->data['user']['ageFrom'] = $this->Session->read('Users.ageFrom');
            $this->request->data['user']['ageTo'] = $this->Session->read('Users.ageTo');
        }

        if (isset($this->request->data['user']['genders']) && !empty($this->request->data['user']['genders'])) {
            $tmpSearch['User.gender_id'] = $this->request->data['user']['genders'];
        }

        if (isset($this->request->data['user']['distance']) && !empty($this->request->data['user']['distance'])) {
            $profileTMP = $this->City->findByGeonameid($this->Auth->user('city_id'));

            $lat = $profileTMP['City']['latitude'];  // latitude of centre of bounding circle in degrees
            $lon = $profileTMP['City']['longitude'];  // longitude of centre of bounding circle in degrees
            $rad = $this->request->data['user']['distance'];  // radius of bounding circle in kilometers

            $R = 6371;  // earth's radius, km
            // first-cut bounding box (in degrees)
            $maxLat = $lat + rad2deg($rad / $R);
            $minLat = $lat - rad2deg($rad / $R);
            // compensate for degrees longitude getting smaller with increasing latitude
            $maxLon = $lon + rad2deg($rad / $R / cos(deg2rad($lat)));
            $minLon = $lon - rad2deg($rad / $R / cos(deg2rad($lat)));

            // convert origin of filter circle to radians
            //$cityTMP = $this->City->find('all', array('fields' => array('(6371 * ACOS( COS( RADIANS( ' . $profileTMP['City']['latitude'] . ' ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( ' . $profileTMP['City']['longitude'] . ' ) ) + SIN( RADIANS( ' . $profileTMP['City']['latitude'] . ' ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance'), 'group' => array('City.geonameid HAVING distance < ' . $this->request->data['user']['distance'])));

            $tmpSearch['City.latitude >'] = $minLat;
            $tmpSearch['City.latitude <'] = $maxLat;
            $tmpSearch['City.longitude >'] = $minLon;
            $tmpSearch['City.longitude <'] = $maxLon;

            //$cityTMP = $this->City->find('all', array('fields' => array('geonameid', 'latitude', 'longitude'), 'conditions' => array('City.latitude >' => $minLat, 'City.latitude <' => $maxLat, 'City.longitude >' => $minLon, 'City.longitude <' => $maxLon)));
            //$cityTMParr = array();
            //foreach ($cityTMP as $cityTMP1):
            //    $cityTMParr[] = $cityTMP1['City']['geonameid'];
            //endforeach;
            //$cityTMP = $this->City->find('all', array('conditions' => array('City.geonameid' => $cityTMParr), 'fields' => array('(6371 * ACOS( COS( RADIANS( ' . $profileTMP['City']['latitude'] . ' ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( ' . $profileTMP['City']['longitude'] . ' ) ) + SIN( RADIANS( ' . $profileTMP['City']['latitude'] . ' ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance'), 'group' => array('City.geonameid HAVING distance < ' . $this->request->data['user']['distance'])));
            //$cityTMParr = array();
            //foreach ($cityTMP as $cityTMP1):
            //    $cityTMParr[] = $cityTMP1['City']['geonameid'];
            //endforeach;
            //$tmpSearch['User.city_id'] = $cityTMParr;
        }

        if (isset($this->request->data['user']['ageFrom']) && !empty($this->request->data['user']['ageFrom'])) {
            $ageFromTMP = date('Y-m-d', strtotime("-" . $this->request->data['user']['ageFrom'] . " years"));
            $tmpSearch['User.birthdate <='] = $ageFromTMP;
        }

        if (isset($this->request->data['user']['ageTo']) && !empty($this->request->data['user']['ageTo'])) {
            $ageFromTMP = date('Y-m-d', strtotime("-" . $this->request->data['user']['ageTo'] . " years"));
            $tmpSearch['User.birthdate >='] = $ageFromTMP;
        }

        $searchForm = TRUE;

        $this->paginate = array(
            'conditions' => array($tmpSearch, 'User.hideprofile' => 0),
            'limit' => 9,
            'contain' => array('City.name', 'Gender.title', 'Profilepicture.picture'),
            'fields' => array('User.nickName', 'User.yearOld', 'User.id', 'City.name', 'Gender.title', 'User.picture_id', 'Profilepicture.picture', 'Profilepicture.directory'),
            'order' => array('if(User.picture_id >= 1, 1, 0)' => 'DESC', 'User.created' => 'DESC')
            );

        $genders = $this->User->Gender->find('list');
        $this->set(compact('genders'));
        $this->set('users', $this->paginate('User'));
        $this->set('searchForm', $searchForm);
    }

    function edit() {
        if (!empty($this->request->data)) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Spremembe so bile uspešno shranjene'), 'flash_success');
                $this->redirect(array('controller' => 'users', 'action' => 'view'));
            } else {
                $this->Session->setFlash(__('Prosim, popravite napake.'), 'flash_success');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->User->findById($this->Auth->User('id'));
        }
        $genders = $this->User->Gender->find('list');

        $this->set(compact('genders'));

        $cities = $this->City->find('list', array('order' => array('name ASC'), 'conditions' => array('featureCode' => array('PPL', 'PPLC'))));
        $this->set(compact('cities'));
    }

    function view($id = NULL) {
        if ($id) {
            if (!$this->User->isProfileOk($this->Auth->user('id'))) {
                $this->Session->setFlash(__('Prosim, izpolnite profil, potem boste lahko gledali tudi druge profile!'), 'flash_success');
                $this->redirect(array('action' => 'browse'));
            }

            $this->set('myOwn', FALSE);

            $this->loadModel("Visit");
            $this->Visit->saveVisit($id, $this->Auth->user('id'));
        } else {
            $id = $this->Auth->user('id');
            $this->set('myOwn', TRUE);
        }

        $user = $this->User->find('first', array('conditions' => array('User.id' => $id), 'fields' => array('User.nickName', 'User.yearOld', 'User.id', 'User.created', 'User.aboutme', 'User.whywritetome', 'User.picture_id'), 'contain' => array('City.name', 'Gender.title', 'Profilepicture.picture', 'Profilepicture.directory', 'Picture')));
        $this->set('user', $user);
    }

    function home() {
        $numUnread = $this->Message->find('count', array('conditions' => array('Message.to_user_id' => $this->Auth->User('id'), 'toUserDelete' => 0, 'Message.status' => 0)));
        $sporocila = $this->Message->find('all', array('contain' => array('Fromuser'), 'conditions' => array('Message.to_user_id' => $this->Auth->User('id'), 'Message.status' => 0, 'toUserDelete' => 0), 'order' => array('Message.created DESC')));

        $this->set('numUnread', $numUnread);
        $this->set('sporocila', $sporocila);
    }

    function favorites() {
        $tmpSearch = NULL;
        $tmpSearch['Favorite.user_id'] = $this->Auth->User('id');

        $this->User->Favorite->recursive = -1;
        $this->User->Favorite->Behaviors->attach('Containable');

        $this->paginate = array(
            'conditions' => array($tmpSearch),
            'limit' => 9,
            'recursive' => -1,
            'contain' => array('Favoritep.City', 'Favoritep.Gender.title', 'Favoritep.nickName', 'Favoritep.yearOld', 'Favoritep.id', 'Favoritep.picture_id', 'Favoritep.Profilepicture')
            );

        $this->set('favorites', $this->paginate('Favorite'));
    }

    function removeFromFavorites($fid = NULL) {
        if (isset($fid)) {
            $tmpFP = $this->User->Favorite->findById($fid);

            if ($tmpFP['Favorite']['user_id'] == $this->Auth->user('id')) {
                $this->User->Favorite->deleteFromFavorite($fid, $this->Auth->User('id'));
                $this->Session->setFlash(__('Uporabnik je bil uspešno odstranjen iz priljubljenih.'), 'flash_success');
                $this->redirect(array('action' => 'favorites'));
            }
        }
    }

    function addToFavorites($fid = NULL) {
        if (isset($fid)) {
            $this->User->Favorite->addToFavorite($this->Auth->User('id'), $fid);
            $this->Session->setFlash(__('Uporabnik je bil uspešno dodan med priljubljene.'), 'flash_success');
            $this->redirect(array('action' => 'favorites'));
        }
    }

    /**
     * Allows the user to email themselves a password redemption token
     */
    function recover() {
        if ($this->Auth->user()) {
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }

        if (!empty($this->request->data['User']['username'])) {
            $Token = ClassRegistry::init('Token');
            $user = $this->User->findByUsername($this->request->data['User']['username']);

            if ($user === false) {
                $this->Session->setFlash(__('Ne najdem uporabnika!'), 'flash_success');
                return false;
            }

            $token = $Token->generate(array('User' => $user['User']));
            $this->Session->setFlash(__('Na vaš elektronski naslov smo vam poslali navodila, kako pridete do novega gesla.'), 'flash_success');
            $this->Email->to = $user['User']['username'];
            $this->Email->subject = 'Pozabljeno geslo';
            $this->Email->from = $this->Config->get('email');
            $this->Email->template = 'recover';
            $this->set('user', $user);
            $this->set('token', $token);
            $this->Email->send();
        }

        $this->set('title_for_layout', 'Ste pozabili geslo za dostop?');
    }

    /**
     * Accepts a valid token and resets the users password
     */
    function verify($token = null) {
        if ($this->Auth->user()) {
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }

        $Token = ClassRegistry::init('Token');
        if ($data = $Token->get($token)) {
            // Update the users password
            $password = $this->generatePassword();
            $this->User->id = $data['User']['id'];
            $this->User->saveField('password', $this->Auth->password($password));
            $this->set('success', true);

            // Send email with new password
            $this->Email->to = $data['User']['username'];
            $this->Email->subject = 'Sprememba gesla';
            $this->Email->from = $this->Config->get('email');
            $this->Email->template = 'verify';
            $this->set('user', $data);
            $this->set('password', $password);
            $this->Email->send();
        }
    }

    function generatePassword($length = 8) {
        $password = "";
        $possible = "0123456789bcdfghjkmnpqrstvwxyzABCDEFGHJKLMNPRSTUVZYXW";
        $i = 0;

        while ($i < $length) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);

            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }

        return $password;
    }

    function settings() {
        if (!empty($this->request->data)) {
            $podatki = $this->User->findById($this->Auth->user('id'));

            if ($podatki['User']['password'] == $this->Auth->password($this->request->data['User']['oldp'])) {
                if ($this->request->data['User']['newp1'] == $this->request->data['User']['newp2'] AND trim($this->request->data['User']['newp1']) != "") {
                    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['newp1']);
                    $this->request->data['User']['id'] = $this->Auth->user('id');

                    if ($this->User->save($this->request->data)) {
                        $this->Session->setFlash(__('Geslo je bilo uspešno spremenjeno!'), 'flash_success');
                    } else {
                        $this->Session->setFlash(__('Pri zamenjavi gesla je prišlo do napake!'), 'flash_success');
                    }
                } else {
                    $this->Session->setFlash(__('Novi gesli se ne ujemata!'), 'flash_success');
                }
            } else {
                $this->Session->setFlash(__('Staro geslo je napačno!'), 'flash_success');
            }
        }

        $this->request->data = $this->User->findById($this->Auth->user('id'));
    }

    function settingschange() {
        if (!empty($this->request->data)) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Spremembe so bile uspešno shranjene!'), 'flash_success');
                $this->redirect(array('action' => 'settings'));
            } else {
                $this->Session->setFlash(__('Prosim, popravite napake!'), 'flash_success');
                $this->redirect(array('action' => 'settings'));
            }
        }
    }

    function add() {
        if (!empty($this->request->data)) {
            $this->User->create();
            $this->request->data['User']['group_id'] = $this->Config->get('skupina');
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The User has been saved'));

                $this->Email->to = $this->request->data['User']['username'];
                $this->Email->from = $this->Config->get('email');
                $this->Email->template = 'new_user';
                $this->Email->sendAs = 'text';
                $this->Email->send();

                $this->Session->setFlash(__('Na vaš e-naslov je bilo poslano geslo.'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Prosim, popravite napake!'), 'flash_success');
            }
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for User'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->User->del($id)) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }

    function picture() {
        $this->set('user', $this->User->findById($this->Auth->user('id')));
    }

    function uw1() {

    }

    // http://odyniec.net/projects/imgareaselect/
    function uw2() {
        $jeOk = FALSE;

        if (!empty($this->request->data)) {
            $ext = $this->findexts(strtolower($this->request->data['User']['image']['name']));
            if ($ext == "png") {
                $jeOk = TRUE;
            } elseif ($ext == "jpg" || $ext == "jpeg") {
                $jeOk = TRUE;
            } elseif ($ext == "gif") {
                $jeOk = TRUE;
            }
        }

        if (!$jeOk) {
            $this->Session->setFlash(__('Datoteka je napačna! Datoteke, ki so podprte: jpg, jpeg, png ter gif.'));
            $this->redirect(array('action' => 'uw1'));
        }

        if (!empty($this->request->data) && isset($this->request->data['User']['image']) && $jeOk) {
            $uploaddir = 'img/upload/';
            $profilePicName = uniqid() . '.' . $this->findexts($this->request->data['User']['image']['name']);
            $uploadfile = $uploaddir . basename($profilePicName);


            if (move_uploaded_file($this->request->data['User']['image']['tmp_name'], $uploadfile)) {
                $this->set('profilePicName', $profilePicName);
                $ext = $this->findexts(strtolower($profilePicName));
                $source = "";
                $image = $uploadfile;
                if ($ext == "png") {
                    $source = imagecreatefrompng($image);
                } elseif ($ext == "jpg" || $ext == "jpeg") {
                    $source = imagecreatefromjpeg($image);
                } elseif ($ext == "gif") {
                    $source = imagecreatefromgif($image);
                }

                $tmpWidth = imagesx($source);

                if ($tmpWidth < 640) {
                    $tmpRatio = $tmpWidth * 100 / $tmpWidth;
                } else {
                    $tmpRatio = 640 * 100 / $tmpWidth;
                    $tmpWidth = 640;
                }

                $this->set('tmpRatio', $tmpRatio);
                $this->set('tmpWidth', $tmpWidth);

                chmod($uploadfile, 0777);
            } else {
                echo "Possible file upload attack!\n";
            }
        } else {
            echo "Napaca!";
        }
    }

    function uw3() {
        if (!empty($this->request->data)) {
            $uploaddir = 'img/upload/';
            $image = $uploaddir . $this->request->data['User']['tmpImageName'];

            // Izdelava velike slike
            $target_width = 1024;
            $target_height = 768;
            $JeOkVelikost = FALSE;

            $novoImeD = $this->Auth->User('id') . $this->request->data['User']['tmpImageName'];
            $tmpVelikaSlika = 'img/profilePictures/big/' . $novoImeD;
            copy($image, $tmpVelikaSlika);

            $extension = pathinfo($tmpVelikaSlika);
            $extension = $extension['extension'];

            if ($extension == "jpg" || $extension == "jpeg" || $extension == "JPG") {
                $tmp_image = imagecreatefromjpeg($tmpVelikaSlika);
            }

            if ($extension == "png") {
                $tmp_image = imagecreatefrompng($tmpVelikaSlika);
            }

            if ($extension == "gif") {
                $tmp_image = imagecreatefromgif($tmpVelikaSlika);
            }

            $width = imagesx($tmp_image);
            $height = imagesy($tmp_image);

            if (($width > $target_width) && ($height > $target_height)) {
                $JeOkVelikost = TRUE;
            }

            if ($JeOkVelikost) {
                $imgratio = ($width / $height);

                if ($imgratio > 1) {
                    $new_width = $target_width;
                    $new_height = ($target_width / $imgratio);
                } else {
                    $new_height = $target_height;
                    $new_width = ($target_height * $imgratio);
                }

                $new_image = imagecreatetruecolor($new_width, $new_height);
                ImageCopyResized($new_image, $tmp_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($new_image, $tmpVelikaSlika);
                $image_buffer = ob_get_contents();
                ImageDestroy($new_image);
            }
            ImageDestroy($tmp_image);
            ob_flush();
            flush();

            // Izdelava male slikce
            $mojRatio = 100 / $this->request->data['User']['tmpRatio'];
            $widthTMP = $this->request->data['User']['width'] * $mojRatio;
            $heigtTMP = $this->request->data['User']['height'] * $mojRatio;
            $newImage = imagecreatetruecolor($widthTMP, $heigtTMP);
            $ext = $this->findexts(strtolower($this->request->data['User']['tmpImageName']));
            $source = "";
            if ($ext == "png") {
                $source = imagecreatefrompng($image);
            } elseif ($ext == "jpg" || $ext == "jpeg") {
                $source = imagecreatefromjpeg($image);
            } elseif ($ext == "gif") {
                $source = imagecreatefromgif($image);
            }

            imagecopyresampled($newImage, $source, 0, 0, $this->request->data['User']['x1'] * $mojRatio, $this->request->data['User']['y1'] * $mojRatio, $this->request->data['User']['width'] * $mojRatio, $this->request->data['User']['height'] * $mojRatio, $this->request->data['User']['width'] * $mojRatio, $this->request->data['User']['height'] * $mojRatio); //$this->request->data['Profile']['x2'] * $mojRatio, $this->request->data['Profile']['y2'] * $mojRatio);
$image_p = imagecreatetruecolor(173, 173);

imagecopyresampled($image_p, $newImage, 0, 0, 0, 0, 173, 173, $widthTMP, $heigtTMP);
imagejpeg($image_p, $uploaddir . $this->request->data['User']['tmpImageName'], 90);

$novoImeD = $this->Auth->User('id') . $this->request->data['User']['tmpImageName'];
rename($image, 'img/profilePictures/' . $novoImeD);

$tmpStaroIme = $this->User->findById($this->Auth->User('id'));
if (!$tmpStaroIme['User']['picture'] == NULL) {
    $tmpStaroIme = $tmpStaroIme['User']['picture'];
    unlink(IMAGES . "profilePictures/" . $tmpStaroIme);
    unlink(IMAGES . "profilePictures/big/" . $tmpStaroIme);
}

$this->User->updateAll(
    array('User.picture' => "'$novoImeD'"), array('User.id' => $this->Auth->User('id'))
    );

$this->set('slikaProfila', $novoImeD);
}
}

function findexts($filename) {
    $filename = strtolower($filename);
    $exts = split("[/\\.]", $filename);
    $n = count($exts) - 1;
    $exts = $exts[$n];
    return $exts;
}

function removepicture() {
    $user = $this->User->findById($this->Auth->user('id'));
    if (!$user['User']['picture'] == NULL) {
        $tmpNamePic = $user['User']['picture'];
        $this->User->read(null, $user['User']['id']);
        $this->User->set('picture', NULL);
        $this->User->save();

        unlink(IMAGES . "profilePictures/" . $tmpNamePic);
        unlink(IMAGES . "profilePictures/big/" . $tmpNamePic);
    }

    $this->Session->setFlash(__('Slika profila je bila uspešno odstranjena!'));
    $this->redirect(array('action' => 'picture'));
}

function admin_sifranti() {

}

function admin_index() {
    $this->paginate = array
    (
        'order' => array
        (
            'User.created' => 'desc'
            )
        );

    $this->User->recursive = 0;
    $this->set('users', $this->paginate());
}

function admin_dashboard() {
    $this->User->recursive = -1;
    $this->set('zadnjiPrijavljeni', $this->User->find('all', array('order' => array('User.created DESC'), 'limit' => 5, 'fields' => array('User.id', 'User.nickName', 'User.username', 'User.ban', 'User.created', 'User.lastlogin'))));
    $this->set('stUporabnikov', $this->User->find('count', array()));
    $this->set('stUporabnikovBan', $this->User->find('count', array('conditions' => array('User.ban' => 1))));

    $this->loadModel('Report');
    $this->set('zadnjePrijave', $this->Report->find('all', array('limit' => 5, 'order' => array('Report.created DESC'))));

    $this->loadModel('Message');
    $this->set('zadnjiSpam', $this->Message->find('all', array('limit' => 5, 'order' => array('Message.created DESC'), 'conditions' => array('Message.spam' => 1), 'fields' => array('Message.subject', 'Message.message', 'Message.from_user_id', 'Message.created'))));
}

function admin_view($id = null) {
    if (!$id) {
        $this->Session->setFlash(__('Invalid User.'));
        $this->redirect(array('action' => 'index'));
    }
    $this->set('user', $this->User->read(null, $id));
}

function admin_add() {
    if (!empty($this->request->data)) {
        $this->User->create();
        if ($this->User->save($this->request->data)) {
            $this->Session->setFlash(__('The User has been saved'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The User could not be saved. Please, try again.'));
        }
    }
    $groups = $this->User->Group->find('list');
    $this->set(compact('groups'));
}

function admin_edit($id = null) {
    if (!$id && empty($this->request->data)) {
        $this->Session->setFlash(__('Invalid User'));
        $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->request->data)) {
        if ($this->User->save($this->request->data)) {
            $this->Session->setFlash(__('The User has been saved'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The User could not be saved. Please, try again.'));
        }
    }
    if (empty($this->request->data)) {
        $this->request->data = $this->User->read(null, $id);
    }
    $groups = $this->User->Group->find('list');
    $this->set(compact('groups'));
}

function admin_config() {
    if (!empty($this->request->data)) {
        $this->Config->store('email', $this->request->data['Privzete']['email']);
        $this->Config->store('skupina', $this->request->data['Privzete']['skupina']);
        $this->Config->store('wwwNaslov', $this->request->data['Privzete']['wwwNaslov']);
    }

    if (empty($this->request->data)) {
        $this->request->data['Privzete']['email'] = $this->Config->get('email');
        $this->request->data['Privzete']['skupina'] = $this->Config->get('skupina');
        $this->request->data['Privzete']['wwwNaslov'] = $this->Config->get('wwwNaslov');
    }
}

function admin_delete($id = null) {
    if (!$id) {
        $this->Session->setFlash(__('Invalid id for User'));
        $this->redirect(array('action' => 'index'));
    }
    if ($this->User->delete($id)) {
        $this->Session->setFlash(__('User deleted'));
        $this->redirect(array('action' => 'index'));
    }
}

function admin_actions() {
    if (!empty($this->request->data)) {
        $this->__processActions();
    }
    $this->__listActions();
}

// Add or delete actions
function __processActions() {

    $securityAccess = $this->request->data['Actions']['SecurityAccess'];

    $inflect = new Inflector();

    foreach ($securityAccess as $name_pair_key => $access_selection) {

        $name_pair = explode("__", $name_pair_key);

        $controller = $inflect->singularize($name_pair[0]);
        $action = $name_pair[1];

        if ($access_selection == 'delete') {

            $aco = new Aco();

            $aco_record = $aco->find(array(
                "Aco.model" => $controller,
                "Aco.alias" => $action));

            if (!empty($aco_record)) {

                $delete_id = $aco_record['Aco']['id'];
                $this->Acl->Aco->Delete($delete_id);
            }
        } elseif ($access_selection == 'include') {

            $parent_id = '0';

// Find the parent, if no parent, we create one
            $aco_parent = new Aco();
            $aco_parent_record = $aco_parent->find(
                array("Aco.model" => $controller,
                    "Aco.alias" => $name_pair[0]));

            if (empty($aco_parent_record)) {

                $aco_parent = new Aco();

                $aco_parent->create();
                $aco_parent->save(array('model' => $controller,
                    'foreign_key' => '',
                    'alias' => $name_pair[0],
                    'parent_id' => ''
                    ));

                $parent_id = $aco_parent->id;
            } else {

                $parent_id = $aco_parent_record['Aco']['id'];
            }

// now lets create the aco record itself
            $aco = new Aco();

            $aco->create();
            $aco->save(array('model' => $controller,
                'foreign_key' => '',
                'alias' => $action,
                'parent_id' => $parent_id
                ));
        }
    }
}

function __listActions() {

// get all the actions in the controllers

    $actions = array();

    App::import('File', 'Folder');

    $folder = new Folder(APP . 'controllers/');
    $folders = $folder->find();

    foreach ($folders as $file) {

        if (is_file(APP . 'controllers/' . $file)) {

            $file = new File(APP . 'controllers/' . $file);
            $file_contents = $file->read();
            $file->close();

// get the controller name
            $class_pattern = '/class [a-zA-Z0-9]*Controller extends AppController/';
            preg_match($class_pattern, $file_contents, $matches);
            $class_name_1 = str_replace('class ', '', $matches[0]);
            $class_name = str_replace(
                'Controller extends AppController', '', $class_name_1);

// get the action names
            $pattern = '/function [a-zA-Z0-9_]*\(/';
                preg_match_all($pattern, $file_contents, $matches);

// now gather action details together
                $action_group = array();

                $inflect = new Inflector();
                $class_name_sing = $inflect->singularize($class_name);

                $action_group['name'] = $class_name;
                $action_group['name_singular'] = $class_name_sing;
                $action_group['actions'] = $matches[0];

                $actions[] = $action_group;
            }
        }

        $this->set('actions', $actions);

// Get the full list of Aco records
        $aco = new Aco();

        $aco_list = $aco->find('all');

        $result = array();

        $inflect = new Inflector();

        foreach ($aco_list as $current_aco) {

            $key_0 = $current_aco['Aco']['model'];
            $key_1 = $current_aco['Aco']['alias'];

            $result[$key_0 . '__' . $key_1] = $current_aco;
        }

        $this->set('aco_list', $result);
    }

}

?>
