<?php

importclass("permisos", BASEAPP);

class Plantilla extends Smarty {

    function __construct() {

        global $usuario, $ciudad, $siteadmin, $permisos, $baseMod, $token;

        parent::__construct();

        $this->template_dir = CONF_HOME . '/plantillas/';
        $this->compile_dir = CONF_HOME . '/smarty/templates_c/';
        $this->config_dir = CONF_HOME . '/smarty/configs/';
        $this->cache_dir = CONF_HOME . '/smarty/cache/';
        $this->caching = TRUE;
        $this->force_compile = TRUE;

        if ($usuario->id != 0) {
            $usu['id'] = $usuario->id;
            $usu['user'] = $usuario->user;
            $usu['email'] = $usuario->email;
            $usu['nombre'] = $usuario->nombre;
            $usu['apellidos'] = $usuario->apellidos;
            $usu['fullName'] = $usuario->nombre . " " . $usuario->apellidos;
            $usu['avatar'] = GetMediaFromModulo('usuario', $usuario->id);
        } else {
            $usu['id'] = null;
            $usu['user'] = null;
            $usu['email'] = null;
            $usu['nombre'] = null;
            $usu['apellidos'] = null;
            $usu['fullName'] = null;
            $usu['avatar'] = null;
        }

        $this->assign("usuario", $usu);
        $this->assign("baseurl", CONF_BASEURL);
        $this->assign("ciudad", $ciudad);
        $this->assign("titulopagina", CONF_TITULOPAGINA);
        $this->assign("urlreferencia", CONF_URLREF);
        $this->assign("siteadmin", $siteadmin);
        $this->assign("permisos", $permisos);
        $this->assign("organizacion", CONF_ORGANIZACION);
        $this->assign("refURL", base64_encode(curPageURL()));
        $this->assign("random", rand());
        $this->assign("token", $token);
        $this->assign("baseAPP", BASEAPP);


        $this->assign("fb_api_app_id", FB_API_APP_ID);
        $this->assign("app_titulopagina", CONF_TITULOPAGINA);
        $this->assign("app_autor", CONF_ORGANIZACION);
        $this->assign("app_descripcion", CONF_DESCRIPCION);
        $this->assign("app_full_url", "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        list($app_fb_img_w, $app_fb_img_h) = getimagesize(CONF_FB_IMG);
        $this->assign("app_fb_image", CONF_BASEURL . CONF_FB_IMG);
        $this->assign("app_fb_image_w", $app_fb_img_w);
        $this->assign("app_fb_image_h", $app_fb_img_h);
        $this->assign("app_tw_image", CONF_BASEURL . CONF_TW_IMG);
        $this->assign("app_tw_user", CONF_TW_USER);
        $this->assign("conf_logo", CONF_BASEURL . CONF_LOGO);
    }

    function plantilla($template) {
        $this->assign("plantilla", $template);
    }

    function botones($template) {
        //integra plantilla de botones en la toolbar
        $this->assign("botones", $template);
    }

    function asignar($variable, $valor) {
        $this->assign($variable, $valor);
    }

    function ver($baseTPL = NULL) {
        global $baseMod;
        if (!$baseTPL) {
            $this->display(CONF_HOME . 'tpl/default.tpl');
        } else {
            $this->display($baseTPL);
        }
    }

}
