function get_browser() {
    var e = navigator.appName,
        t = navigator.userAgent,
        n;
    var r = t.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
    if (r && (n = t.match(/version\/([\.\d]+)/i)) != null) r[2] = n[1];
    r = r ? [r[1], r[2]] : [e, navigator.appVersion, "-?"];
    return r[0]
}

function GetWindowHeight() {
    var e = 0;
    if (typeof _Top.window.innerHeight == "number") {
        e = _Top.window.innerHeight
    } else if (_Top.document.documentElement && _Top.document.documentElement.clientHeight) {
        e = _Top.document.documentElement.clientHeight
    } else if (_Top.document.body && _Top.document.body.clientHeight) {
        e = _Top.document.body.clientHeight
    }
    return e
}

function GetWindowWidth() {
    var e = 0;
    if (typeof _Top.window.innerWidth == "number") {
        e = _Top.window.innerWidth
    } else if (_Top.document.documentElement && _Top.document.documentElement.clientWidth) {
        e = _Top.document.documentElement.clientWidth
    } else if (_Top.document.body && _Top.document.body.clientWidth) {
        e = _Top.document.body.clientWidth
    }
    return e
}

function GetWindowTop() {
    return _Top.window.screenTop != undefined ? _Top.window.screenTop : _Top.window.screenY
}

function GetWindowLeft() {
    return _Top.window.screenLeft != undefined ? _Top.window.screenLeft : _Top.window.screenX
}

function open_popunder(url) {
    var popURL = "about:blank";
    var popID = "pop_" + Math.floor(89999999 * Math.random() + 1e7);
    var pxLeft = 0;
    var pxTop = 0;
    pxLeft = GetWindowLeft() + GetWindowWidth() / 2 - PopWidth / 2;
    pxTop = GetWindowTop() + GetWindowHeight() / 2 - PopHeight / 2;
    if (puShown == true) {
        //return true
    }
    var PopWin = _Top.window.open(popURL, popID, "toolbar=0,scrollbars=1,location=1,statusbar=1,menubar=0,resizable=1,top=" + pxTop + ",left=" + pxLeft + ",width=" + PopWidth + ",height=" + PopHeight);
    if (PopWin) {
        puShown = true;
        if (PopFocus == 0) {
            PopWin.blur();
            if (navigator.userAgent.toLowerCase().indexOf("applewebkit") > -1) {
                _Top.window.blur();
                _Top.window.focus()
            }
        }
        PopWin.Init = function (e) {
            with (e) {
                Params = e.Params;
                Main = function () {
                    if (typeof window.mozPaintCount != "undefined") {
                        var e = window.open("about:blank");
                        e.close()
                    }
                    var t = Params.PopURL;
                    try {
                        opener.window.focus()
                    } catch (n) { }
                    window.location = t
                };
                Main()
            }
        };
        PopWin.Params = {
            PopURL: url
        };
        PopWin.Init(PopWin)
    }
    return PopWin
}

function initialize_popundr() {
    _Top = self;
    if (top != self) {
        try {
            if (top.document.location.toString()) _Top = top
        } catch (e) { }
    }
    if (document.attachEvent) {
        document.attachEvent("onclick", doEvent_popundr)
    } else if (document.addEventListener) {
        document.addEventListener("click", doEvent_popundr, false)
    }
}
var isClicked = false;
function doEvent_popundr(e) {
    if (isClicked) return;
    var elem;
    if (e.srcElement) elem = e.srcElement;
    else if (e.target) elem = e.target;
    var target = $(elem);
    if (target.attr("id") == "imgClose" ||target.hasClass("ad-img") || (target.html() == '-Close') || (target.html() == '+Open')){    
        return;
    }
    else if ($.session.get('popup') != "isPopup" && $(window).width() > 1024) {
        call_popunder(your_url);
    }    
}


function call_popunder(urls) {
    if ($.session.get('popup') != "isPopup") { 
        isClicked = true;       
        var t = get_browser();
        if (t == "Chrome" || t == "Safari") {
            for (i = 0; i < urls.length; i++) {
                url = urls[i];
                var n = document.createElement("a");
                n.href = url;
                n.target = "_blank";
                var r = document.createEvent("MouseEvents");
                r.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, true, false, false, false, 0, null);
                n.dispatchEvent(r);
            }
        } else {
            var i = i || window.event;
            for (i = 0; i < urls.length; i++) {
                url = urls[i];
                // var s = open_popunder(url);
                window.open(url, '_blank');                
            }
	    
        }        
        $.session.set('popup', 'isPopup');
    }
}
var puShown = false;
var PopFocus = 0;
var _Top = null;
var PopWidth = 900;
var PopHeight = 500;
var your_url = [];