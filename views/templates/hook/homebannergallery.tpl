{*
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
*}
<!-- homebannergallery module -->
                        <div class="mtd-row">
                            <div class="spacer-vertical-20p"></div>
                        </div>
                        <div class="mtd-row">
                            <div class="spacer-vertical-20p"></div>
                        </div>
                        <div class="mtd-row">
                            <a id="urlP" href="{$banner_linkp|escape:'htmlall':'UTF-8'}">
                                <img src="{$module_dir}{$banner_imgp|escape:'htmlall':'UTF-8'}" width="100%" alt="" class="img-responsive" />
                            </a>
                        </div>
                        {if $publi_activo eq 1}
                            <div style="background-color:{$publi_color|escape:'htmlall':'UTF-8'};padding: 2px; " class="mtd-row" id="publicidad">
                                <a href="{$publi_link|escape:'htmlall':'UTF-8'}">
                                    <p style="font-size: {$publi_texts|escape:'htmlall':'UTF-8'}px;color:{$publi_colort|escape:'htmlall':'UTF-8'};">
                                        {$publi_text|escape:'htmlall':'UTF-8'}
                                    </p>
                                </a>
                            </div>
                        {else}
                            <div id="quitar" class="mtd-row">
                                <div class="spacer-vertical-20p"></div>
                            </div>
                        {/if}
                        <div class="mtd-row">
                            <div class="mtd-cell-2">
                                <a id="urlD" href="{$banner_linkd|escape:'htmlall':'UTF-8'}">
                                    <img src="{$module_dir}{$banner_imgd|escape:'htmlall':'UTF-8'}" alt="" style="width: 100%;" class="img-responsive" />
                                </a>
                            </div>
                            <div class="mtd-cell-2">
                                <a id="urlI" href="{$banner_linki|escape:'htmlall':'UTF-8'}">
                                    <img src="{$module_dir}{$banner_imgi|escape:'htmlall':'UTF-8'}" alt="" style="width: 100%;" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                        <div class="mtd-row">
                            <div class="spacer-vertical-20p"></div>
                        </div>
                        <div class="mtd-row">
                            <div class="mtd-cell-4">
                                <ul class="tt-wrapper">
                                    <li>
                                        <a href="http://www.facebook.com/pages/Mulaya/220839104715220?ref=ts&amp;fref=ts">
                                            <img src="{$img_ps_dir}footer/facebook.png" border="0">
                                            <span>{l s='Facebook' mod='homebannergallery'}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://twitter.com/MULAYA_OFFICIAL">
                                            <img src="{$img_ps_dir}footer/twitter.png" border="0">
                                            <span>{l s='Twitter' mod='homebannergallery'}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://plus.google.com/u/0/114268668946917943438/posts?partnerid=gplp0">
                                            <img src="{$img_ps_dir}footer/googleplus.png" border="0">
                                            <span>{l s='Google Plus' mod='homebannergallery'}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://www.pinterest.com/mulaya/">
                                            <img src="{$img_ps_dir}footer/pinterest.png" border="0">
                                            <span>{l s='Pinterest' mod='homebannergallery'}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://instagram.com/mulaya_official">
                                            <img src="{$img_ps_dir}footer/instagram.png" border="0">
                                            <span>{l s='Instagram' mod='homebannergallery'}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mtd-cell-4">
                                <p class="center clearBoth " style="font-size:11px;">
                                    <a href="https://www.confianzaonline.es/empresas/Mulaya.htm" target="_blank">
                                        <img src="https://www.confianzaonline.es/sello70_44.gif" border="0" alt="Entidad adherida aConfianza Online"/>
                                    </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="http://www.tip-sa.com/" target="_blank">
                                        <img style="border:0px solid white;height:44px;" src="{$img_ps_dir}logotipo-tipsa.png"/>
                                    </a>
                                </p>
                            </div>

                            <div class="mtd-cell-4  align-right">
                                {l s='@ MULAYA 2014 | AVISO LEGAL' mod='homebannergallery'} 
                            </div>

                        </div>
                        <div class="mtd-row">
                            <div class="spacer-vertical-20p"></div>
                        </div>
<!-- /homebannergallery module -->
