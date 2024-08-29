<?php

namespace app\controllers\admin;

use app\models\admin\Category;

/** @property Category $model */
class CategoryController extends AppController
{
    public function indexAction()
    {
        $this->setMeta('Bölmələr');
    }

    public function createAction()
    {
        if (!empty($_POST)) {
            if ($this->model->category_validate()) {
                $_SESSION['success'] = 'Kateqoriya saxlanildi';
            }
            redirect();
        }
        $this->setMeta('Yeni Bölmə');
    }

    public function deleteAction()
    {
        $categoryId = get('id');
        if ($this->model->category_delete($categoryId)) {
            $_SESSION['success'] = 'Kateqoriya silindi';
        }
        redirect();
    }
}