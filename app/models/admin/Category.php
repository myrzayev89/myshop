<?php

namespace app\models\admin;

use RedBeanPHP\R;
use app\models\AppModel;

class Category extends AppModel
{
    public function category_validate(): bool
    {
        $errors = '';
        foreach ($_POST['category_description'] as $lang_id => $item) {
            $item['title'] = trim($item['title']);
            if (empty($item['title'])) {
                $errors .= "Bölmə adı boş qoyula bilməz! Tab #{$lang_id}<br>";
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

    public function category_delete($id): bool
    {
        R::begin();
        try {
            $children = R::count('categories', 'parent_id = ?', [$id]);
            $products = R::count('products', 'category_id = ?', [$id]);
            if ($children) {
                $_SESSION['errors'] = 'Kateqoriya aid alt kateqoriya var!';
                return false;
            }
            if ($products) {
                $_SESSION['errors'] = 'Kateqoriya aid məhsul var!';
                return false;
            }
            R::exec('DELETE FROM categories WHERE id = ?', [$id]);
            R::exec('DELETE FROM category_description WHERE category_id = ?', [$id]);
            return R::commit();
        } catch (\Throwable $th) {
            R::rollback();
            //throw $th;
            return false;
        }
    }
}