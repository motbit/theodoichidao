<?php $__env->startSection('page-title'); ?>
    Người Dùng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <script language="javascript">
        function xoanguoidung(id) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("nguoidung_id").value = id;
                frmxoanguoidung.submit();
            }


        }
    </script>

    

    <div>
        <div class="pull-left">
            <a href="viphuman/update?id=0"><i class="fa fa-plus"></i> Them moi</a>
        </div>
        <div class="pull-right">
            <form class="form" action="" method="get" id="searchform">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-content">
                            <input class="form-control" id="searchinput" type="text" name="k" value="<?php echo e($key); ?>" placeholder="Search username">
                        </div>
                        <div class="input-group-btn">
                            <button type="submit" value="search" class="btn btn-default" tabindex="-1"><i class="fa fa-search"></i>&nbsp;Search</button>
                        </div>
                    </div><!--end .input-group -->
                </div>
            </form>
        </div>
    </div>

    <?php echo Form::open(array('route' => 'viphuman-delete', 'class' => 'form', 'id' => 'frmxoanguoidung')); ?>

    <?php echo e(Form::hidden('id', 0, array('id' => 'nguoidung_id'))); ?>

    <?php echo Form::close(); ?>


    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th> STT </th>
            <th> Tên lãnh đạo </th>
            <th> Chức vụ </th>
            <th> Action </th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $nguoidung; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td> <?php echo e($row->id); ?> </td>
                <td> <?php echo e($row->name); ?> </td>
                <td> <?php echo e($row->description); ?> </td>
                <td>
                    <a href="javascript:xoanguoidung('<?php echo e($row->id); ?>')"><i class="fa fa-pencil"></i> Xóa</a> |
                    <?php echo e(Html::linkAction('ViphumanController@edit', 'sửa', array('id'=>$row->id))); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>