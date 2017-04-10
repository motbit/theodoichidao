<?php \App\Roles::accessView(Request::path()); ?>

<?php $__env->startSection('page-title'); ?>
    Nguồn chỉ đạo
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <script language="javascript">
        function xoanguoidung(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("steering_id").value = id;
                frmxoa.submit();
            }
        }

    </script>
    <style>
        select {
            height: 23px;
        }

        input {
            height: 23px;
        }

        #table_filter {
            display: none;
        }
    </style>


    <?php echo Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')); ?>

    <?php echo e(Form::hidden('id', 0, array('id' => 'steering_id'))); ?>

    <?php echo Form::close(); ?>


    <div class="text-center title">Nguồn chỉ đạo</div>
    <?php if(\App\Roles::accessAction(Request::path(), 'add')): ?>
        <a class="btn btn-my" href="sourcesteering/update?id=0">Thêm nguồn</a>
    <?php endif; ?>
    <table id="table" class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>Trích yếu<br><input type="text" style="width: 100%"></th>
            <th class="td-type">Loại nguồn
                <select style="max-width: 150px">
                    <option value=""></option>
                    <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->name); ?>"><?php echo e($t->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </th>
            <th class="td-code">Số kí hiệu<input type="text" style="max-width: 100px"></th>
            <th class="td-sign">Người ký
                <input type="text" style="max-width: 100px">
            </th>
            <th class="text-center align-top">File</th>
            <th class="td-date">Ngày ban hành
                <input type="text" class="datepicker" style="max-width: 100px">
            </th>
            <?php if(\App\Roles::accessAction(Request::path(), 'edit')): ?>
                <th class="td-action"></th>
            <?php endif; ?>
            <?php if(\App\Roles::accessAction(Request::path(), 'delete')): ?>
                <th class="td-action"></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($idx + 1); ?></td>
                <td><a href="steeringcontent?source=<?php echo e(urlencode($row->code)); ?>"><?php echo e($row->name); ?></a></td>
                <td><?php echo e($row->typename); ?></td>
                <td><?php echo e($row->code); ?></td>
                <td><?php echo e($row->sign_by); ?></td>
                <td class="text-center td-file">
                    <?php if($row->file_attach != ''): ?>
                        <a href="<?php echo e($_ENV['ALIAS']); ?>/file/<?php echo e($row->file_attach); ?>" download>Tải về</a>
                    <?php endif; ?>
                </td>
                <td><?php echo e(date("d/m/y", strtotime($row->time))); ?></td>
                <?php if(\App\Roles::accessAction(Request::path(), 'edit')): ?>
                    <td>
                        <?php if(\App\Roles::accessRow(Request::path(), $row->created_by)): ?>
                            <a href="<?php echo e($_ENV['ALIAS']); ?>/sourcesteering/update?id=<?php echo e($row->id); ?>"><img height="20"
                                                                                                    border="0"
                                                                                                    src="<?php echo e($_ENV['ALIAS']); ?>/img/edit.png"></a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
                <?php if(\App\Roles::accessAction(Request::path(), 'delete')): ?>
                    <td>
                        <?php if(\App\Roles::accessRow(Request::path(), $row->created_by)): ?>
                            <a href="javascript:xoanguoidung('<?php echo e($row->id); ?>')"><img height="20" border="0"
                                                                                   src="<?php echo e($_ENV['ALIAS']); ?>/img/delete.png"></a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <script>
        var current_date = "<?php echo e(date('d/m/y')); ?>";

        $(document).ready(function () {
            // DataTable
            var table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 6],
                            modifier: {
                                page: 'current'
                            },
                            format: {
                                header: function (data, row, column, node) {
                                    if (row === 2) return "Loại Nguồn";
                                    else return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ');
                                },
                                body: function (data, row, column, node) {
                                    return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ');
                                }
                            }
                        },
                        orientation: 'landscape',
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10;
                        },
                        text: 'Xuất ra PDF',
                    },
                    {
                        extend: 'excel',
                        text: 'Xuất ra Excel',
                        stripHtml: true,
                        decodeEntities: true,
                        columns: ':visible',
                        modifier: {
                            selected: true
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 6],
                            format: {
                                header: function (data, row, column, node) {
                                    if (row === 2) return "Loại Nguồn";
                                    else return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ');
                                },
                                body: function (data, row, column, node) {
                                    return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ');
                                }
                            }
                        }
                    }
                ],
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
                "language": {
                    "url": "<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Vietnamese.json"
                },
                "initComplete": function () {
                    $("#table_wrapper > .dt-buttons").appendTo("div.panel-button");
                }
            });

            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.header()).on('keyup change changeDate', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
                $('select', this.header()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                    }
                });
            });


        });

        function resetFromProgress() {
            $("#pr-note").val("");
            $("#progress_time").val(current_date);
            $("input[name=pr_status][value='-2']").prop('checked', true);
            $("#form-progress").hide();
        }
    </script>
    <div class="panel-button"></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>