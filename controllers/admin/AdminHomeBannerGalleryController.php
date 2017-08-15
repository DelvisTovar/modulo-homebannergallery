<?php
	class AdminHomeBannerGalleryController extends AdminController {

    public function __construct() {
        Tools::redirectAdmin('index.php?controller=AdminModules&configure=homebannergallery&token=' . Tools::getAdminTokenLite('AdminModules'));
    }

}
?>