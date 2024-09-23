<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bölmələr</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN; ?>"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Bölmələr</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <a href="<?= ADMIN; ?>/category/create" class="btn btn-success">
                            <i class="fas fa-plus">&nbsp;Yeni Bölmə</i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php new \app\widgets\menu\Menu([
                                'class' => 'table table-bordered',
                                'cache' => 0,
                                'cacheKey' => 'admin_cat_table',
                                'tpl' => APP . '/widgets/menu/admin_category_table.php',
                                'container' => 'table',
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->