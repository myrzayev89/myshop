<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;

class Product extends AppModel
{
    public function get_products($langId, $start, $perpage): array
    {
        return R::getAll("SELECT p.*, pd.title FROM products p
            JOIN product_description pd ON p.id = pd.product_id
        WHERE pd.lang_id = ? LIMIT $start, $perpage", [$langId]);
    }
}