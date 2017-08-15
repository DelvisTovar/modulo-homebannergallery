<?php
/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
    exit;

class Homebannergallery extends Module
{
    public function __construct()
    {
        $this->name = 'homebannergallery';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'DelvisTovar';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Home banner gallery');
        $this->description = $this->l('Configura el home banner y link.');
    }

    public function install()
    {
        Configuration::updateValue('HOMEBANNERGALLERY_IMGP', 'principal.jpeg');
        Configuration::updateValue('HOMEBANNERGALLERY_LINKP', '#');
        Configuration::updateValue('HOMEBANNERGALLERY_IMGD', 'derecho.jpg');
        Configuration::updateValue('HOMEBANNERGALLERY_LINKD', '#');
        Configuration::updateValue('HOMEBANNERGALLERY_IMGI', 'izquierdo.gif');
        Configuration::updateValue('HOMEBANNERGALLERY_LINKI', '#');
        Configuration::updateValue('BANNERPUBICIDAD_TEXT','Texto del banner publicidad');
        Configuration::updateValue('BANNERPUBICIDAD_COLOR','#004a4c');
        Configuration::updateValue('BANNERPUBICIDAD_COLORT','#ffffff');
        Configuration::updateValue('BANNERPUBICIDAD_TEXTS','25');
        Configuration::updateValue('BANNERPUBICIDAD_ACTIVO','1');
        Configuration::updateValue('BANNERPUBICIDAD_LINK','#');
        $this->_clearCache('homebannergallery.tpl');
        return parent::install() && $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        Configuration::deleteByName('HOMEBANNERGALLERY_IMGP');
        Configuration::deleteByName('HOMEBANNERGALLERY_LINKP');
        Configuration::deleteByName('HOMEBANNERGALLERY_IMGD');
        Configuration::deleteByName('HOMEBANNERGALLERY_LINKD');
        Configuration::deleteByName('HOMEBANNERGALLERY_IMGI');
        Configuration::deleteByName('HOMEBANNERGALLERY_LINKI');
        Configuration::deleteByName('BANNERPUBICIDAD_TEXT');
        Configuration::deleteByName('BANNERPUBICIDAD_COLOR');
        Configuration::deleteByName('BANNERPUBICIDAD_COLORT');
        Configuration::deleteByName('BANNERPUBICIDAD_TEXTS');
        Configuration::deleteByName('BANNERPUBICIDAD_ACTIVO');
        Configuration::deleteByName('BANNERPUBICIDAD_LINK');
        return parent::uninstall();
    }

    public function hookdisplayHome($params)
    {
        if (Configuration::get('PS_CATALOG_MODE'))
            return;
        if (!$this->isCached('homebannergallery.tpl', $this->getCacheId()))
        {
            $this->smarty->assign(array(
                'banner_imgp'  => 'img/'.Configuration::get('HOMEBANNERGALLERY_IMGP'),
                'banner_linkp' => Configuration::get('HOMEBANNERGALLERY_LINKP'),
                'banner_imgd'  => 'img/'.Configuration::get('HOMEBANNERGALLERY_IMGD'),
                'banner_linkd' => Configuration::get('HOMEBANNERGALLERY_LINKD'),
                'banner_imgi'  => 'img/'.Configuration::get('HOMEBANNERGALLERY_IMGI'),
                'banner_linki' => Configuration::get('HOMEBANNERGALLERY_LINKI'),
                'publi_text'   => Configuration::get('BANNERPUBICIDAD_TEXT'),
                'publi_color'  => Configuration::get('BANNERPUBICIDAD_COLOR'),
                'publi_colort'  => Configuration::get('BANNERPUBICIDAD_COLORT'),
                'publi_texts'   => Configuration::get('BANNERPUBICIDAD_TEXTS'),
                'publi_activo' => Configuration::get('BANNERPUBICIDAD_ACTIVO'),
                'publi_link'   => Configuration::get('BANNERPUBICIDAD_LINK')
            ));
        }
        return $this->display(__FILE__, 'homebannergallery.tpl', $this->getCacheId());
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitStoreConf'))
        {
            if (!is_numeric(Tools::getValue('BANNERPUBICIDAD_TEXTS')))
                return $this->displayError($this->l('El valor del campo Tamaño del texto publicicdad no es numerico por favor corregir'));

            Configuration::updateValue('HOMEBANNERGALLERY_LINKP', Tools::getValue('HOMEBANNERGALLERY_LINKP'));
            Configuration::updateValue('HOMEBANNERGALLERY_LINKD', Tools::getValue('HOMEBANNERGALLERY_LINKD'));
            Configuration::updateValue('HOMEBANNERGALLERY_LINKI', Tools::getValue('HOMEBANNERGALLERY_LINKI'));
            Configuration::updateValue('BANNERPUBICIDAD_TEXT', Tools::getValue('BANNERPUBICIDAD_TEXT'));
            Configuration::updateValue('BANNERPUBICIDAD_COLOR', Tools::getValue('BANNERPUBICIDAD_COLOR'));
            Configuration::updateValue('BANNERPUBICIDAD_COLORT', Tools::getValue('BANNERPUBICIDAD_COLORT'));
            Configuration::updateValue('BANNERPUBICIDAD_TEXTS', Tools::getValue('BANNERPUBICIDAD_TEXTS'));
            Configuration::updateValue('BANNERPUBICIDAD_ACTIVO', Tools::getValue('BANNERPUBICIDAD_ACTIVO'));
            Configuration::updateValue('BANNERPUBICIDAD_LINK', Tools::getValue('BANNERPUBICIDAD_LINK'));

            #Imagen principal
            if (isset($_FILES['HOMEBANNERGALLERY_IMGP']) && isset($_FILES['HOMEBANNERGALLERY_IMGP']['tmp_name']) && !empty($_FILES['HOMEBANNERGALLERY_IMGP']['tmp_name']))
            {
                if (ImageManager::validateUpload($_FILES['HOMEBANNERGALLERY_IMGP'], 4000000))
                    return $this->displayError($this->l('Invalid image'));
                else
                {
                    $ext = Tools::substr($_FILES['HOMEBANNERGALLERY_IMGP']['name'], Tools::strrpos($_FILES['HOMEBANNERGALLERY_IMGP']['name'], '.') + 1);
                    $file_name = md5($_FILES['HOMEBANNERGALLERY_IMGP']['name']).'.'.$ext;
                    if (!move_uploaded_file($_FILES['HOMEBANNERGALLERY_IMGP']['tmp_name'], dirname(__FILE__).'/img/'.$file_name))
                        return $this->displayError($this->l('An error occurred while attempting to upload the file.'));
                    else
                    {
                        $file_path = dirname(__FILE__).'/img/'.Configuration::get('HOMEBANNERGALLERY_IMGP');

                        if (Configuration::hasContext('HOMEBANNERGALLERY_IMGP', null, Shop::getContext()) &&
                            Configuration::get('HOMEBANNERGALLERY_IMGP') != $file_name &&
                            file_exists($file_path)
                        )

                        Configuration::updateValue('HOMEBANNERGALLERY_IMGP', $file_name);
                        $this->_clearCache('homebannergallery.tpl');
                    }
                }
            }

            #imagen derecha
            if (isset($_FILES['HOMEBANNERGALLERY_IMGD']) && isset($_FILES['HOMEBANNERGALLERY_IMGD']['tmp_name']) && !empty($_FILES['HOMEBANNERGALLERY_IMGD']['tmp_name']))
            {
                if (ImageManager::validateUpload($_FILES['HOMEBANNERGALLERY_IMGD'], 4000000))
                    return $this->displayError($this->l('Invalid image'));
                else
                {
                    $ext = Tools::substr($_FILES['HOMEBANNERGALLERY_IMGD']['name'], Tools::strrpos($_FILES['HOMEBANNERGALLERY_IMGD']['name'], '.') + 1);
                    $file_name = md5($_FILES['HOMEBANNERGALLERY_IMGD']['name']).'.'.$ext;
                    if (!move_uploaded_file($_FILES['HOMEBANNERGALLERY_IMGD']['tmp_name'], dirname(__FILE__).'/img/'.$file_name))
                        return $this->displayError($this->l('An error occurred while attempting to upload the file.'));
                    else
                    {
                        $file_path = dirname(__FILE__).'/img/'.Configuration::get('HOMEBANNERGALLERY_IMGD');

                        if (Configuration::hasContext('HOMEBANNERGALLERY_IMGD', null, Shop::getContext()) &&
                            Configuration::get('HOMEBANNERGALLERY_IMGD') != $file_name &&
                            file_exists($file_path)
                        )

                        Configuration::updateValue('HOMEBANNERGALLERY_IMGD', $file_name);
                        $this->_clearCache('homebannergallery.tpl');
                    }
                }
            }

            #imagen derecha
            if (isset($_FILES['HOMEBANNERGALLERY_IMGI']) && isset($_FILES['HOMEBANNERGALLERY_IMGI']['tmp_name']) && !empty($_FILES['HOMEBANNERGALLERY_IMGI']['tmp_name']))
            {
                if (ImageManager::validateUpload($_FILES['HOMEBANNERGALLERY_IMGI'], 4000000))
                    return $this->displayError($this->l('Invalid image'));
                else
                {
                    $ext = Tools::substr($_FILES['HOMEBANNERGALLERY_IMGI']['name'], Tools::strrpos($_FILES['HOMEBANNERGALLERY_IMGI']['name'], '.') + 1);
                    $file_name = md5($_FILES['HOMEBANNERGALLERY_IMGI']['name']).'.'.$ext;
                    if (!move_uploaded_file($_FILES['HOMEBANNERGALLERY_IMGI']['tmp_name'], dirname(__FILE__).'/img/'.$file_name))
                        return $this->displayError($this->l('An error occurred while attempting to upload the file.'));
                    else
                    {
                        $file_path = dirname(__FILE__).'/img/'.Configuration::get('HOMEBANNERGALLERY_IMGI');

                        if (Configuration::hasContext('HOMEBANNERGALLERY_IMGI', null, Shop::getContext()) &&
                            Configuration::get('HOMEBANNERGALLERY_IMGI') != $file_name &&
                            file_exists($file_path)
                        )

                        Configuration::updateValue('HOMEBANNERGALLERY_IMGI', $file_name);
                        $this->_clearCache('homebannergallery.tpl');
                    }
                }
            }

            $this->_clearCache('homebannergallery.tpl');
            Tools::redirectAdmin('index.php?tab=AdminModules&conf=6&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
        }

        return '';
    }

    public function getContent()
    {
        return $this->postProcess().$this->renderForm();
    }

    public function renderForm()
    {
        $fieldsForm = array();
        $fieldsForm[0]['form'] = array(
                'legend' => array(
                    'title' => $this->l('Configuración banner galeria'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'file',
                        'label' => $this->l('Block imagen principal'),
                        'name' => 'HOMEBANNERGALLERY_IMGP',
                        'thumb' => '../modules/'.$this->name.'/img/'.Configuration::get('HOMEBANNERGALLERY_IMGP'),
                        'desc' => $this->l('Proporciona una imagen para el banner principal "Dimensiones 1426×640".')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Imagen link principal'),
                        'name' => 'HOMEBANNERGALLERY_LINKP',
                        'desc' => $this->l('Proporciona un enlace para el banner principal "Vínculo de la imagen".')
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Block imagen izquierdo'),
                        'name' => 'HOMEBANNERGALLERY_IMGD',
                        'thumb' => '../modules/'.$this->name.'/img/'.Configuration::get('HOMEBANNERGALLERY_IMGD'),
                        'desc' => $this->l('Proporciona una imagen para el banner izquierdo "Dimensiones 668×606".')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Imagen link izquierdo'),
                        'name' => 'HOMEBANNERGALLERY_LINKD',
                        'desc' => $this->l('Proporciona un enlace para el banner izquierdo "Vínculo de la imagen".')
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Block Imagen derecho'),
                        'name' => 'HOMEBANNERGALLERY_IMGI',
                        'thumb' => '../modules/'.$this->name.'/img/'.Configuration::get('HOMEBANNERGALLERY_IMGI'),
                        'desc' => $this->l('Proporciona una imagen para el banner derecho "Dimensiones 668×606".')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Imagen link derecho'),
                        'name' => 'HOMEBANNERGALLERY_LINKI',
                        'desc' => $this->l('Proporciona un enlace para el banner derecho "Vínculo de la imagen".')
                    )
                )
            );
        $fieldsForm[1]['form'] = array(
                'legend' => array(
                    'title' => $this->l('Configuración Banner publicidad'),
                    'icon' => 'icon-cogs'
                ),
                'input'     => array(
                    array(
                        'type' => 'checkbox',
                        'name' => 'BANNERPUBICIDAD',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'ACTIVO',
                                    'name' => $this->l('Activar para que el banner publicidad este visible'),
                                    'val' => '1'
                                ),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Texto del banner publicidad'),
                        'name' => 'BANNERPUBICIDAD_TEXT',
                        #'autoload_rte' => true,
                        'hint' => $this->l('Añada un texto para su banner publicitario.'),
                        'hint' => $this->l('Invalid characters:').' <>;=#{}',
                        'cols' => 60,
                        #'lang' => true,
                        'rows' => 6
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Tamaño del texto publicidad'),
                        'name' => 'BANNERPUBICIDAD_TEXTS',
                        'desc' => $this->l('Proporciona un tamaño para el texto del banner publicidad.')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Link del banner publicidad'),
                        'name' => 'BANNERPUBICIDAD_LINK',
                        'desc' => $this->l('Proporciona un enlace para el banner publicidad.')
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Selecione su color'),
                        'name' => 'BANNERPUBICIDAD_COLOR',
                        'desc' => $this->l('Proporciona un color para el fondo del banner publicidad.')
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Selecione su color'),
                        'name' => 'BANNERPUBICIDAD_COLORT',
                        'desc' => $this->l('Proporciona un color para el texto del banner publicidad.')
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitStoreConf';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm($fieldsForm);
    }

    public function getConfigFieldsValues()
    {
        return array(
            'HOMEBANNERGALLERY_IMGP' => Tools::getValue('HOMEBANNERGALLERY_IMGP', Configuration::get('HOMEBANNERGALLERY_IMGP')),
            'HOMEBANNERGALLERY_LINKP' => Tools::getValue('HOMEBANNERGALLERY_LINKP', Configuration::get('HOMEBANNERGALLERY_LINKP')),
            'HOMEBANNERGALLERY_IMGD' => Tools::getValue('HOMEBANNERGALLERY_IMGD', Configuration::get('HOMEBANNERGALLERY_IMGD')),
            'HOMEBANNERGALLERY_LINKD' => Tools::getValue('HOMEBANNERGALLERY_LINKD', Configuration::get('HOMEBANNERGALLERY_LINKD')),
            'HOMEBANNERGALLERY_IMGI' => Tools::getValue('HOMEBANNERGALLERY_IMGI', Configuration::get('HOMEBANNERGALLERY_IMGI')),
            'HOMEBANNERGALLERY_LINKI' => Tools::getValue('HOMEBANNERGALLERY_LINKI', Configuration::get('HOMEBANNERGALLERY_LINKI')),
            'BANNERPUBICIDAD_TEXT' => Tools::getValue('BANNERPUBICIDAD_TEXT', Configuration::get('BANNERPUBICIDAD_TEXT')),
            'BANNERPUBICIDAD_COLOR' => Tools::getValue('BANNERPUBICIDAD_COLOR', Configuration::get('BANNERPUBICIDAD_COLOR')),
            'BANNERPUBICIDAD_COLORT' => Tools::getValue('BANNERPUBICIDAD_COLORT', Configuration::get('BANNERPUBICIDAD_COLORT')),
            'BANNERPUBICIDAD_TEXTS' => Tools::getValue('BANNERPUBICIDAD_TEXTS', Configuration::get('BANNERPUBICIDAD_TEXTS')),
            'BANNERPUBICIDAD_ACTIVO' => Tools::getValue('BANNERPUBICIDAD_ACTIVO', Configuration::get('BANNERPUBICIDAD_ACTIVO')),
            'BANNERPUBICIDAD_LINK' => Tools::getValue('BANNERPUBICIDAD_LINK', Configuration::get('BANNERPUBICIDAD_LINK')),
        );
    }
}
