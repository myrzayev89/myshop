<?php

namespace app\models\admin;

use RedBeanPHP\R;
use app\models\AppModel;

class Dashboard extends AppModel
{
    public function get_orders_count(): int
    {
        return R::count('orders');
    }
}