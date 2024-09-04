<?php

namespace app\models\admin;

use RedBeanPHP\R;
use app\models\AppModel;
use core\App;

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

    public function category_save(): bool
    {
        R::begin();
        try {
            // add cat
            $langId = App::$app->getProperty('language')['id'];
            $category = R::dispense('categories');
            $category->parent_id = $_POST['parent_id'];
            $category_id = R::store($category);
            $category->slug = AppModel::create_slug(
                'categories',
                'slug',
                $_POST['category_description'][$langId]['title'],
                $category_id,
            );
            R::store($category);

            // add cat_desc
            foreach ($_POST['category_description'] as $lang_id => $item) {
                R::exec("INSERT INTO category_description (category_id, lang_id, title, excerpt, description, keywords) VALUES (?,?,?,?,?,?)", [
                    $category_id,
                    $lang_id,
                    $item['title'],
                    $item['excerpt'],
                    $item['description'],
                    $item['keywords'],
                ]);
            }
            return R::commit();
        } catch (\Exception $e) {
            R::rollback();
            // throw $e;
            return false;
        }
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