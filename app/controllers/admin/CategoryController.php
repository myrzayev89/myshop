<?php

namespace app\controllers\admin;

use app\models\admin\Category;
use core\App;

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
                if ($this->model->category_save()) {
                    $_SESSION['success'] = 'Kateqoriya əlavə edildi';
                } else {
                    $_SESSION['errors'] = 'Xəta baş verdi!';
                }
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