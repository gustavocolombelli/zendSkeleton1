<?php

class site_IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }
    

    public function indexAction()
    {
        $banner = new Application_Model_Atena_BannerMdl();
        $this->view->banner = $banner->fetchAll(
            array(
                'ativo = ?' => 1)
        );
        $video = new Application_Model_Atena_VideoMdl();
        $this->view->video = $video->fetchAll(
            array(
                'ativo = ?' => 1)
        );

    }


}


