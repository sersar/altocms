;var ls = ls || {};

/**
 * Подписка
 */
ls.subscribe = (function ($) {

    /**
     * Подписка/отписка
     */
    this.toggle = function (sTargetType, iTargetId, sMail, iValue) {
        var url = ls.routerUrl('subscribe') + 'ajax-subscribe-toggle/';
        var params = {target_type: sTargetType, target_id: iTargetId, mail: sMail, value: iValue};

        ls.progressStart();
        ls.ajax(url, params, function (result) {
            ls.progressDone();
            if (!result) {
                ls.msg.error(null, 'System error #1001');
            } else if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                ls.msg.notice(null, result.sMsg);
                ls.hook.run('ls_subscribe_toggle_after', [sTargetType, iTargetId, sMail, iValue, result]);
            }
        });
        return false;
    };

    /**
     * Подписка/отписка
     */
    this.tracktoggle = function(sTargetType, iTargetId, iValue) {
        var url = ls.routerUrl('subscribe') + 'ajax-track-toggle/';
        var params = {target_type: sTargetType, target_id: iTargetId, value: iValue};

        ls.progressStart();
        ls.ajax(url, params, function(result) {
            ls.progressDone();
            if (!result) {
                ls.msg.error(null, 'System error #1001');
            } else if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                ls.msg.notice(null, result.sMsg);
                ls.hook.run('ls_track_toggle_after',[sTargetType, iTargetId, iValue, result]);
            }
        });
        return false;
    };

    return this;
}).call(ls.subscribe || {}, jQuery);