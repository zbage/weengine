var _env = (function() {
    var f = navigator.userAgent,
    b = null,
    c = function(h, i) {
        var g = h.split(i);
        g = g.shift() + "." + g.join("");
        return g * 1
    },
    d = {
        ua: f,
        version: null,
        ios: false,
        android: false,
        windows: false,
        blackberry: false,
        meizu: false,
        weixin: false,
        wVersion: null,
        touchSupport: ("createTouch" in document),
        hashSupport: !!("onhashchange" in window)
    };
    b = f.match(/MicroMessenger\/([\.0-9]+)/);
    if (b != null) {
        d.weixin = true;
        d.wVersion = c(b[1], ".")
    }
    b = f.match(/Android\s([\.0-9]+)/);
    if (b != null) {
        d.android = true;
        d.version = c(b[1], ".");
        d.meizu = /M030|M031|M032|MEIZU/.test(f);
        return d
    }
    b = f.match(/i(Pod|Pad|Phone)\;.*\sOS\s([\_0-9]+)/);
    if (b != null) {
        d.ios = true;
        d.version = c(b[2], "_");
        return d
    }
    b = f.match(/Windows\sPhone\sOS\s([\.0-9]+)/);
    if (b != null) {
        d.windows = true;
        d.version = c(b[1], ".");
        return d
    }
    var e = {
        a: f.match(/\(BB1\d+\;\s.*\sVersion\/([\.0-9]+)\s/),
        b: f.match(/\(BlackBerry\;\s.*\sVersion\/([\.0-9]+)\s/),
        c: f.match(/^BlackBerry\d+\/([\.0-9]+)\s/),
        d: f.match(/\(PlayBook\;\s.*\sVersion\/([\.0-9]+)\s/)
    };
    for (var a in e) {
        if (e[a] != null) {
            b = e[a];
            d.blackberry = true;
            d.version = c(b[1], ".");
            return d
        }
    }
    return d
} ()),
_ua = _env.ua,
_touchSupport = _env.touchSupport,
_hashSupport = _env.hashSupport,
_isIOS = _env.ios,
_isOldIOS = _env.ios && (_env.version < 4.5),
_isAndroid = _env.android,
_isMeizu = _env.meizu,
_isOldAndroid22 = _env.android && (_env.version < 2.3),
_isOldAndroid23 = _env.android && (_env.version < 2.4),
_clkEvtType = _touchSupport ? "touchstart": "click",
_movestartEvt = _touchSupport ? "touchstart": "mousedown",
_moveEvt = _touchSupport ? "touchmove": "mousemove",
_moveendEvt = _touchSupport ? "touchend": "mouseup";