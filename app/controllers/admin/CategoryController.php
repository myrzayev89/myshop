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

    public function editAction()
    {
        $categoryId = get('id');
        if (!empty($_POST)) {
            debug($_POST, true);
            if ($this->model->category_validate()) {
                if ($this->model->category_update($categoryId)) {
                    $_SESSION['success'] = 'Kateqoriya redaktə edildi';
                } else {
                    $_SESSION['errors'] = 'Xəta baş verdi!';
                }
            }
            redirect();
        }
        $category = $this->model->get_category($categoryId);
        if (!$category) {
            throw new \Exception('Kateqoriya tapılmadı!', 404);
        }
        $this->setMeta($category[1]['title']);
        $this->set(compact('category'));
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