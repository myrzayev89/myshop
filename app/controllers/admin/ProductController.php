<?php

namespace app\controllers\admin;

use app\models\admin\Product;
use RedBeanPHP\R;
use core\App;
use core\Pagination;

/** @property Product $model */
class ProductController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $page = get('page', 's');
        $total = R::count('products');
        $perpage = App::$app->getProperty('pagination');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $products = $this->model->get_products($lang['id'], $start, $perpage);
        $this->setMeta('Mallar');
        $this->set(compact('products', 'pagination'));
    }
}