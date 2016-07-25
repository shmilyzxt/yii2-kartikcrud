/*!
 * Ajax Crud 
 * =================================
 * Use for shmilyxt/yii2-kartikcrud extension
 */
$(document).ready(function () {

    // Create instance of Modal Remote
    // This instance will be the controller of all business logic of modal
    // Backwards compatible lookup of old ajaxCrubModal ID
    if ($('#ajaxCrubModal').length > 0 && $('#ajaxCrudModal').length == 0) {
        modal = new ModalRemote('#ajaxCrubModal');
    } else {
        modal = new ModalRemote('#ajaxCrudModal');
    }

    // Catch click event on all buttons that want to open a modal
    $(document).on('click', '[role="modal-remote"]', function (event) {
        event.preventDefault();

        // Open modal
        modal.open(this, null);
    });

    // Catch click event on all buttons that want to open a modal
    // with bulk action
    $(document).on('click', '[role="modal-remote-bulk"]', function (event) {
        event.preventDefault();

        // Collect all selected ID's
        var selectedIds = [];
        $('input:checkbox[name="selection[]"]').each(function () {
            if (this.checked)
                selectedIds.push($(this).val());
        });

        if (selectedIds.length == 0) {
            window.BootstrapDialog.show({
                title: '提示',
                message: '请选择要删除的项目',
                buttons: [
                    {
                        label: '<i class="glyphicon glyphicon-ok"></i> 确定',
                        cssClass: 'btn btn-default',
                        action: function(dialog) {
                            dialog.close();
                        }
                    },
                ]
            });
           /* krajeeDialog.alert("请选择要删除的项目");
            // If no selected ID's show warning
            modal.show();
            modal.setTitle('未选择');
            modal.setContent('请选择要删除的项目');
            modal.addFooterButton("关闭",'button', 'btn btn-default', function (button, event) {
                this.hide();
            });*/
        } else {
            // Open modal
            modal.open(this, selectedIds);
        }
    });
});