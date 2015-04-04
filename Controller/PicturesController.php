<?php

class PicturesController extends AppController
{

    var $name = 'Pictures';
    var $helpers = array('Html', 'Form');

    function index()
    {
        $this->Picture->recursive = -1;
        $this->set('pictures', $this->Picture->find('all', array('conditions' => array('Picture.user_id' => $this->Auth->user('id')))));
    }

    function setasprofilepicture($id = NULL)
    {
        if (!isset($id))
        {
            $this->Session->setFlash(__('Tako se pa ne dela!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }

        $tmpPicture = $this->Picture->findById($id);
        if ($tmpPicture['Picture']['user_id'] != $this->Auth->user('id'))
        {
            $this->Session->setFlash(__('Tako se pa ne dela!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }

        $this->loadModel('User');
        $this->User->id = $this->Auth->user('id');
        $this->User->saveField('picture_id', $id);

        $this->Session->setFlash(__('Slika profila je bila uspešno spremenjena.'), 'flash_success');
        $this->redirect(array('action' => 'index'));
    }

    function delete($id = NULL)
    {
        if (!isset($id))
        {
            $this->Session->setFlash(__('Tako se pa ne dela!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }

        $tmpPicture = $this->Picture->findById($id);
        if ($tmpPicture['Picture']['user_id'] != $this->Auth->user('id'))
        {
            $this->Session->setFlash(__('Tako se pa ne dela!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }

        if ($tmpPicture['Picture']['id'] == $this->Auth->user('picture_id'))
        {
            $this->Picture->User->read(null, $this->Auth->user('id'));
            $this->Picture->User->set('picture_id', '0');
            $this->Picture->User->save();
        }

        $tmpFileToDeleteFile = explode('.', $tmpPicture['Picture']['picture']);
        $tmpFileToDelete1 = 'img/' . $tmpPicture['Picture']['directory'] . $tmpFileToDeleteFile[0] . '-s.' . $tmpFileToDeleteFile[1];
        $tmpFileToDelete2 = 'img/' . $tmpPicture['Picture']['directory'] . $tmpPicture['Picture']['picture'];

        unlink($tmpFileToDelete1);
        unlink($tmpFileToDelete2);

        $this->Picture->delete($id);
        
        $this->loadModel('User');
        $tmpUser = $this->User->findById($this->Auth->user('id'));
        if ($tmpUser['User']['picture_id'] == $id)
        {
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('picture_id', 0);
        }

        $this->Session->setFlash(__('Slika je bila uspešno zbrisana!'), 'flash_success');
        $this->redirect(array('action' => 'index'));
    }

    function add()
    {
        if (!empty($this->request->data))
        {
            $jeOk = FALSE;
            
            if (!($this->Picture->userPictureCount($this->Auth->user('id')) < 9))
            {
                $this->Session->setFlash(__('Več kot 9 fotografij ne morete imeti.'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            
            if (!empty($this->request->data))
            {
                $ext = $this->findexts(strtolower($this->request->data['Picture']['picture']['name']));
                if ($ext == "png")
                {
                    $jeOk = TRUE;
                }
                elseif ($ext == "jpg" || $ext == "jpeg")
                {
                    $jeOk = TRUE;
                }
                elseif ($ext == "gif")
                {
                    $jeOk = TRUE;
                }
            }

            if (!$jeOk)
            {
                $this->Session->setFlash(__('Datoteka je napačna! Datoteke, ki so podprte: jpg, jpeg, png ter gif.'), 'flash_success');
                $this->redirect(array('action' => 'add'));
            }

            if (!empty($this->request->data) && isset($this->request->data['Picture']['picture']) && $jeOk)
            {
                $uploaddir = 'img/pictures/' . date('Y') . '/' . date('n') . '/';
                $dbuploaddir = 'pictures/' . date('Y') . '/' . date('n') . '/';
                $tmpUid = uniqid();
                $profilePicName = $tmpUid . '.' . $this->findexts($this->request->data['Picture']['picture']['name']);
                $profilePicNameSmall = $tmpUid . '-s.' . $this->findexts($this->request->data['Picture']['picture']['name']);
                $uploadfile = $uploaddir . basename($profilePicName);
                $uploadfileSmall = $uploaddir . basename($profilePicNameSmall);

                if (!is_dir($uploaddir))
                {
                    mkdir($uploaddir, 0777, true);
                }

                // Izdelava velike slike
                if (move_uploaded_file($this->request->data['Picture']['picture']['tmp_name'], $uploadfile))
                {
                    $ext = $this->findexts(strtolower($profilePicName));
                    $source = "";
                    if ($ext == "png")
                    {
                        $source = imagecreatefrompng($uploadfile);
                    }
                    elseif ($ext == "jpg" || $ext == "jpeg")
                    {
                        $source = imagecreatefromjpeg($uploadfile);
                    }
                    elseif ($ext == "gif")
                    {
                        $source = imagecreatefromgif($uploadfile);
                    }

                    $target_width = 800;
                    $target_height = 600;
                    $JeOkVelikost = FALSE;

                    $width = imagesx($source);
                    $height = imagesy($source);

                    if (($width > $target_width) && ($height > $target_height))
                    {
                        $JeOkVelikost = TRUE;
                    }

                    if ($JeOkVelikost)
                    {
                        $imgratio = ($width / $height);

                        if ($imgratio > 1)
                        {
                            $new_width = $target_width;
                            $new_height = ($target_width / $imgratio);
                        }
                        else
                        {
                            $new_height = $target_height;
                            $new_width = ($target_height * $imgratio);
                        }

                        $new_image = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        //ImageCopyResized($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        imagejpeg($new_image, $uploadfile);
                        $image_buffer = ob_get_contents();
                        ImageDestroy($new_image);
                    }
                }
                else
                {
                    $this->Session->setFlash(__('Ooo, tako se pa ne dela!'), 'flash_success');
                    $this->redirect(array('action' => 'add'));
                }

                // Izdelava male slike
                if (copy($uploadfile, $uploadfileSmall))
                {
                    $ext = $this->findexts(strtolower($profilePicNameSmall));
                    $source = "";
                    if ($ext == "png")
                    {
                        $source = imagecreatefrompng($uploadfileSmall);
                    }
                    elseif ($ext == "jpg" || $ext == "jpeg")
                    {
                        $source = imagecreatefromjpeg($uploadfileSmall);
                    }
                    elseif ($ext == "gif")
                    {
                        $source = imagecreatefromgif($uploadfileSmall);
                    }

                    $target_width = 173;
                    $target_height = 129.75;
                    $JeOkVelikost = FALSE;

                    $width = imagesx($source);
                    $height = imagesy($source);

                    if (($width > $target_width) && ($height > $target_height))
                    {
                        $JeOkVelikost = TRUE;
                    }

                    if ($JeOkVelikost)
                    {
                        $imgratio = ($width / $height);

                        if ($imgratio > 1)
                        {
                            $new_width = $target_width;
                            $new_height = ($target_width / $imgratio);
                        }
                        else
                        {
                            $new_height = $target_height;
                            $new_width = ($target_height * $imgratio);
                        }

                        $new_image = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        //ImageCopyResized($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        imagejpeg($new_image, $uploadfileSmall);
                        $image_buffer = ob_get_contents();
                        ImageDestroy($new_image);
                    }

                    ImageDestroy($source);

                    chmod($uploadfile, 0777);

                    $tmpPictureData = array();
                    $tmpPictureData['Picture']['user_id'] = $this->Auth->user('id');
                    $tmpPictureData['Picture']['picture'] = $profilePicName;
                    $tmpPictureData['Picture']['directory'] = $dbuploaddir;
                    $tmpPictureData['Picture']['description'] = $this->request->data['Picture']['description'];

                    if ($this->Picture->save($tmpPictureData))
                    {
                        $this->loadModel('User');
                        $tmpUser = $this->User->findById($this->Auth->user('id'));
                        if ($tmpUser['User']['picture_id'] == 0)
                        {
                            $this->User->id = $this->Auth->user('id');
                            $this->User->saveField('picture_id', $this->Picture->id);
                        }
                        $this->Session->setFlash(__('Slika je bila uspešno naložena.'), 'flash_success');
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else
                {
                    $this->Session->setFlash(__('Ooo, tako se pa ne dela!'), 'flash_success');
                    $this->redirect(array('action' => 'add'));
                }
            }
            else
            {
                $this->Session->setFlash(__('Prišlo je do napake!'), 'flash_success');
                $this->redirect(array('action' => 'add'));
            }
        }
    }

    function findexts($filename)
    {
        $filename = strtolower($filename);
        $exts = split("[/\\.]", $filename);
        $n = count($exts) - 1;
        $exts = $exts[$n];
        return $exts;
    }

}

?>