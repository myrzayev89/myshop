<?php

namespace app\controllers;

use core\Pagination;
use core\App;
use app\models\User;

/** @property User $model */
class UserController extends AppController
{
    public function signupAction()
    {
        if (User::checkAuth()) {
            redirect(base_url());
        }
        if (!empty($_POST)) {
            $data = $_POST;
            $this->model->load($data);
            if (!$this->model->validate($data) || !$this->model->checkUnique()) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $data;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('users')) {
                    $_SESSION['success'] = ___('user_signup_success_register');
                } else {
                    $_SESSION['errors'] = ___('user_signup_error_register');
                }
            }
            redirect();
        }
        $this->setMeta(___('tpl_signup'));
    }

    public function loginAction()
    {
        if (User::checkAuth()) {
            redirect(base_url());
        }
        if (!empty($_POST)) {
            if ($this->model->login()) {
                $_SESSION['success'] = ___('user_login_success_login');
                redirect(base_url());
            } else {
                $_SESSION['form_data'] = $_POST;
                $_SESSION['errors'] = ___('user_login_error_login');
                redirect();
            }
        }
        $this->setMeta(___('tpl_login'));
    }

    public function cabinetAction()
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }
        $this->setMeta(___('tpl_cabinet'));
    }

    public function ordersAction()
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }

        $page = get('page', 's');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_orders($_SESSION['user']['id']);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $orders = $this->model->get_user_orders($_SESSION['user']['id'], $start, $perpage);
        $this->setMeta(___('tpl_orders'));
        $this->set(compact('orders', 'pagination'));
    }

    public function orderAction()
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }

        $id = get('id');
        $order = $this->model->get_user_order($id);
        if (!$order) {
            $this->error_404();
            return;
        }
        $this->setMeta(___('tpl_orders_files'));
        $this->set(compact('order'));
    }

    public function filesAction()
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }

        $lang = App::$app->getProperty('language');
        $page = get('page', 's');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_files($_SESSION['user']['id']);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $files = $this->model->get_user_files($_SESSION['user']['id'], $start, $perpage, $lang['id']);
        $this->setMeta(___('tpl_orders_files'));
        $this->set(compact('files', 'pagination'));
    }

    public function credentialsAction()
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }
        $this->setMeta(___('tpl_user_credentials'));
    }

    public function logoutAction()
    {
        if (User::checkAuth()) {
            unset($_SESSION['user']);
        }
        redirect(base_url() . 'user/login');
    }
}