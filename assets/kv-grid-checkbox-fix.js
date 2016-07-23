/*!kartik-v checkbox的全选和取消全选在ajax的情况下存在bug，这里做修复
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   3.1.1
 *
 * Client actions for kartik\grid\CheckboxColumn
 * 
 * Author: Kartik Visweswaran
 * Copyright: 2015, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
var kvSelectRow;
(function ($) {
    "use strict";
    kvSelectRow = function (gridId, css) {
        var $grid = $('#' + gridId),
            kvHighlight = function ($el, $parent) {
                var $row = $el.closest('tr'), $cbx = $parent || $el;
                if ($cbx.is(':checked') && !$el.attr('disabled')) {
                    if(!$el.is(":checked")){
                        $el.prop("checked",true);
                    }
                    $row.removeClass(css).addClass(css);
                } else {
                    if($el.is(":checked")){
                        $el.prop("checked",false);
                    }
                    $row.removeClass(css);
                }
            },
            toggle = function ($cbx, all) {
                if (all === true) {
                    $grid.find(".kv-row-select input").each(function () {
                        kvHighlight($(this), $cbx);
                    });
                    return;
                }
                kvHighlight($cbx);
            };
        $grid.find(".kv-row-select input").on('change', function () {
            toggle($(this));
        }).each(function () {
            toggle($(this));
        });
        $grid.find(".kv-all-select input").on('change', function () {
            toggle($(this), true);
        });
    };
})(window.jQuery);