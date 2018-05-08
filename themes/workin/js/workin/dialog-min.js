/*!
 * jQuery UI Dialog 1.11.4
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 *
 * http://api.jqueryui.com/dialog/
 */
(function(e) {
    typeof define == "function" && define.amd ? define(["jquery", "./core", "./widget", "./button", "./draggable", "./mouse", "./position", "./resizable"], e) : e(jQuery)
})(function(e) {
    return e.widget("ui.dialog", {
        version: "1.11.4",
        options: {
            appendTo: "body",
            autoOpen: !0,
            buttons: [],
            closeOnEscape: !0,
            closeText: "Close",
            dialogClass: "",
            draggable: !0,
            hide: null,
            height: "auto",
            maxHeight: null,
            maxWidth: null,
            minHeight: 150,
            minWidth: 150,
            modal: !1,
            position: {
                my: "center",
                at: "center",
                of: window,
                collision: "fit",
                using: function(t) {
                    var n = e(this).css(t).offset().top;
                    n < 0 && e(this).css("top", t.top - n)
                }
            },
            resizable: !0,
            show: null,
            title: null,
            width: 300,
            beforeClose: null,
            close: null,
            drag: null,
            dragStart: null,
            dragStop: null,
            focus: null,
            open: null,
            resize: null,
            resizeStart: null,
            resizeStop: null
        },
        sizeRelatedOptions: {
            buttons: !0,
            height: !0,
            maxHeight: !0,
            maxWidth: !0,
            minHeight: !0,
            minWidth: !0,
            width: !0
        },
        resizableRelatedOptions: {
            maxHeight: !0,
            maxWidth: !0,
            minHeight: !0,
            minWidth: !0
        },
        _create: function() {
            this.originalCss = {
                display: this.element[0].style.display,
                width: this.element[0].style.width,
                minHeight: this.element[0].style.minHeight,
                maxHeight: this.element[0].style.maxHeight,
                height: this.element[0].style.height
            },
            this.originalPosition = {
                parent: this.element.parent(),
                index: this.element.parent().children().index(this.element)
            },
            this.originalTitle = this.element.attr("title"),
            this.options.title = this.options.title || this.originalTitle,
            this._createWrapper(),
            this.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(this.uiDialog),
            this._createTitlebar(),
            this._createButtonPane(),
            this.options.draggable && e.fn.draggable && this._makeDraggable(),
            this.options.resizable && e.fn.resizable && this._makeResizable(),
            this._isOpen = !1,
            this._trackFocus()
        },
        _init: function() {
            this.options.autoOpen && this.open()
        },
        _appendTo: function() {
            var t = this.options.appendTo;
            return t && (t.jquery || t.nodeType) ? e(t) : this.document.find(t || "body").eq(0)
        },
        _destroy: function() {
            var e, t = this.originalPosition;
            this._untrackInstance(),
            this._destroyOverlay(),
            this.element.removeUniqueId().removeClass("ui-dialog-content ui-widget-content").css(this.originalCss).detach(),
            this.uiDialog.stop(!0, !0).remove(),
            this.originalTitle && this.element.attr("title", this.originalTitle),
            e = t.parent.children().eq(t.index),
            e.length && e[0] !== this.element[0] ? e.before(this.element) : t.parent.append(this.element)
        },
        widget: function() {
            return this.uiDialog
        },
        disable: e.noop,
        enable: e.noop,
        close: function(t) {
            var n, r = this;
            if (!this._isOpen || this._trigger("beforeClose", t) === !1) return;
            this._isOpen = !1,
            this._focusedElement = null,
            this._destroyOverlay(),
            this._untrackInstance();
            if (!this.opener.filter(":focusable").focus().length) try {
                n = this.document[0].activeElement,
                n && n.nodeName.toLowerCase() !== "body" && e(n).blur()
            } catch(i) {}
            this._hide(this.uiDialog, this.options.hide,
            function() {
                r._trigger("close", t)
            })
        },
        isOpen: function() {
            return this._isOpen
        },
        moveToTop: function() {
            this._moveToTop()
        },
        _moveToTop: function(t, n) {
            var r = !1,
            i = this.uiDialog.siblings(".ui-front:visible").map(function() {
                return + e(this).css("z-index")
            }).get(),
            s = Math.max.apply(null, i);
            return s >= +this.uiDialog.css("z-index") && (this.uiDialog.css("z-index", s + 1), r = !0),
            r && !n && this._trigger("focus", t),
            r
        },
        open: function() {
            var t = this;
            if (this._isOpen) {
                this._moveToTop() && this._focusTabbable();
                return
            }
            this._isOpen = !0,
            this.opener = e(this.document[0].activeElement),
            this._size(),
            this._position(),
            this._createOverlay(),
            this._moveToTop(null, !0),
            this.overlay && this.overlay.css("z-index", this.uiDialog.css("z-index") - 1),
            this._show(this.uiDialog, this.options.show,
            function() {
                t._focusTabbable(),
                t._trigger("focus")
            }),
            this._makeFocusTarget(),
            this._trigger("open")
        },
        _focusTabbable: function() {
            var e = this._focusedElement;
            e || (e = this.element.find("[autofocus]")),
            e.length || (e = this.element.find(":tabbable")),
            e.length || (e = this.uiDialogButtonPane.find(":tabbable")),
            e.length || (e = this.uiDialogTitlebarClose.filter(":tabbable")),
            e.length || (e = this.uiDialog),
            e.eq(0).focus()
        },
        _keepFocus: function(t) {
            function n() {
                var t = this.document[0].activeElement,
                n = this.uiDialog[0] === t || e.contains(this.uiDialog[0], t);
                n || this._focusTabbable()
            }
            t.preventDefault(),
            n.call(this),
            this._delay(n)
        },
        _createWrapper: function() {
            this.uiDialog = e("<div>").addClass("ui-dialog ui-widget ui-widget-content ui-corner-all ui-front " + this.options.dialogClass).hide().attr({
                tabIndex: -1,
                role: "dialog"
            }).appendTo(this._appendTo()),
            this._on(this.uiDialog, {
                keydown: function(t) {
                    if (this.options.closeOnEscape && !t.isDefaultPrevented() && t.keyCode && t.keyCode === e.ui.keyCode.ESCAPE) {
                        t.preventDefault(),
                        this.close(t);
                        return
                    }
                    if (t.keyCode !== e.ui.keyCode.TAB || t.isDefaultPrevented()) return;
                    var n = this.uiDialog.find(":tabbable"),
                    r = n.filter(":first"),
                    i = n.filter(":last");
                    t.target !== i[0] && t.target !== this.uiDialog[0] || !!t.shiftKey ? (t.target === r[0] || t.target === this.uiDialog[0]) && t.shiftKey && (this._delay(function() {
                        i.focus()
                    }), t.preventDefault()) : (this._delay(function() {
                        r.focus()
                    }), t.preventDefault())
                },
                mousedown: function(e) {
                    this._moveToTop(e) && this._focusTabbable()
                }
            }),
            this.element.find("[aria-describedby]").length || this.uiDialog.attr({
                "aria-describedby": this.element.uniqueId().attr("id")
            })
        },
        _createTitlebar: function() {
            var t;
            this.uiDialogTitlebar = e("<div>").addClass("ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix").prependTo(this.uiDialog),
            this._on(this.uiDialogTitlebar, {
                mousedown: function(t) {
                    e(t.target).closest(".ui-dialog-titlebar-close") || this.uiDialog.focus()
                }
            }),
            this.uiDialogTitlebarClose = e("<button type='button'></button>").button({
                label: this.options.closeText,
                icons: {
                    primary: "ui-icon-closethick"
                },
                text: !1
            }).addClass("ui-dialog-titlebar-close").appendTo(this.uiDialogTitlebar),
            this._on(this.uiDialogTitlebarClose, {
                click: function(e) {
                    e.preventDefault(),
                    this.close(e)
                }
            }),
            t = e("<span>").uniqueId().addClass("ui-dialog-title").prependTo(this.uiDialogTitlebar),
            this._title(t),
            this.uiDialog.attr({
                "aria-labelledby": t.attr("id")
            })
        },
        _title: function(e) {
            this.options.title || e.html("&#160;"),
            e.text(this.options.title)
        },
        _createButtonPane: function() {
            this.uiDialogButtonPane = e("<div>").addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"),
            this.uiButtonSet = e("<div>").addClass("ui-dialog-buttonset").appendTo(this.uiDialogButtonPane),
            this._createButtons()
        },
        _createButtons: function() {
            var t = this,
            n = this.options.buttons;
            this.uiDialogButtonPane.remove(),
            this.uiButtonSet.empty();
            if (e.isEmptyObject(n) || e.isArray(n) && !n.length) {
                this.uiDialog.removeClass("ui-dialog-buttons");
                return
            }
            e.each(n,
            function(n, r) {
                var i, s;
                r = e.isFunction(r) ? {
                    click: r,
                    text: n
                }: r,
                r = e.extend({
                    type: "button"
                },
                r),
                i = r.click,
                r.click = function() {
                    i.apply(t.element[0], arguments)
                },
                s = {
                    icons: r.icons,
                    text: r.showText
                },
                delete r.icons,
                delete r.showText,
                e("<button></button>", r).button(s).appendTo(t.uiButtonSet)
            }),
            this.uiDialog.addClass("ui-dialog-buttons"),
            this.uiDialogButtonPane.appendTo(this.uiDialog)
        },
        _makeDraggable: function() {
            function r(e) {
                return {
                    position: e.position,
                    offset: e.offset
                }
            }
            var t = this,
            n = this.options;
            this.uiDialog.draggable({
                cancel: ".ui-dialog-content, .ui-dialog-titlebar-close",
                handle: ".ui-dialog-titlebar",
                containment: "document",
                start: function(n, i) {
                    e(this).addClass("ui-dialog-dragging"),
                    t._blockFrames(),
                    t._trigger("dragStart", n, r(i))
                },
                drag: function(e, n) {
                    t._trigger("drag", e, r(n))
                },
                stop: function(i, s) {
                    var o = s.offset.left - t.document.scrollLeft(),
                    u = s.offset.top - t.document.scrollTop();
                    n.position = {
                        my: "left top",
                        at: "left" + (o >= 0 ? "+": "") + o + " " + "top" + (u >= 0 ? "+": "") + u,
                        of: t.window
                    },
                    e(this).removeClass("ui-dialog-dragging"),
                    t._unblockFrames(),
                    t._trigger("dragStop", i, r(s))
                }
            })
        },
        _makeResizable: function() {
            function o(e) {
                return {
                    originalPosition: e.originalPosition,
                    originalSize: e.originalSize,
                    position: e.position,
                    size: e.size
                }
            }
            var t = this,
            n = this.options,
            r = n.resizable,
            i = this.uiDialog.css("position"),
            s = typeof r == "string" ? r: "n,e,s,w,se,sw,ne,nw";
            this.uiDialog.resizable({
                cancel: ".ui-dialog-content",
                containment: "document",
                alsoResize: this.element,
                maxWidth: n.maxWidth,
                maxHeight: n.maxHeight,
                minWidth: n.minWidth,
                minHeight: this._minHeight(),
                handles: s,
                start: function(n, r) {
                    e(this).addClass("ui-dialog-resizing"),
                    t._blockFrames(),
                    t._trigger("resizeStart", n, o(r))
                },
                resize: function(e, n) {
                    t._trigger("resize", e, o(n))
                },
                stop: function(r, i) {
                    var s = t.uiDialog.offset(),
                    u = s.left - t.document.scrollLeft(),
                    a = s.top - t.document.scrollTop();
                    n.height = t.uiDialog.height(),
                    n.width = t.uiDialog.width(),
                    n.position = {
                        my: "left top",
                        at: "left" + (u >= 0 ? "+": "") + u + " " + "top" + (a >= 0 ? "+": "") + a,
                        of: t.window
                    },
                    e(this).removeClass("ui-dialog-resizing"),
                    t._unblockFrames(),
                    t._trigger("resizeStop", r, o(i))
                }
            }).css("position", i)
        },
        _trackFocus: function() {
            this._on(this.widget(), {
                focusin: function(t) {
                    this._makeFocusTarget(),
                    this._focusedElement = e(t.target)
                }
            })
        },
        _makeFocusTarget: function() {
            this._untrackInstance(),
            this._trackingInstances().unshift(this)
        },
        _untrackInstance: function() {
            var t = this._trackingInstances(),
            n = e.inArray(this, t);
            n !== -1 && t.splice(n, 1)
        },
        _trackingInstances: function() {
            var e = this.document.data("ui-dialog-instances");
            return e || (e = [], this.document.data("ui-dialog-instances", e)),
            e
        },
        _minHeight: function() {
            var e = this.options;
            return e.height === "auto" ? e.minHeight: Math.min(e.minHeight, e.height)
        },
        _position: function() {
            var e = this.uiDialog.is(":visible");
            e || this.uiDialog.show(),
            this.uiDialog.position(this.options.position),
            e || this.uiDialog.hide()
        },
        _setOptions: function(t) {
            var n = this,
            r = !1,
            i = {};
            e.each(t,
            function(e, t) {
                n._setOption(e, t),
                e in n.sizeRelatedOptions && (r = !0),
                e in n.resizableRelatedOptions && (i[e] = t)
            }),
            r && (this._size(), this._position()),
            this.uiDialog.is(":data(ui-resizable)") && this.uiDialog.resizable("option", i)
        },
        _setOption: function(e, t) {
            var n, r, i = this.uiDialog;
            e === "dialogClass" && i.removeClass(this.options.dialogClass).addClass(t);
            if (e === "disabled") return;
            this._super(e, t),
            e === "appendTo" && this.uiDialog.appendTo(this._appendTo()),
            e === "buttons" && this._createButtons(),
            e === "closeText" && this.uiDialogTitlebarClose.button({
                label: "" + t
            }),
            e === "draggable" && (n = i.is(":data(ui-draggable)"), n && !t && i.draggable("destroy"), !n && t && this._makeDraggable()),
            e === "position" && this._position(),
            e === "resizable" && (r = i.is(":data(ui-resizable)"), r && !t && i.resizable("destroy"), r && typeof t == "string" && i.resizable("option", "handles", t), !r && t !== !1 && this._makeResizable()),
            e === "title" && this._title(this.uiDialogTitlebar.find(".ui-dialog-title"))
        },
        _size: function() {
            var e, t, n, r = this.options;
            this.element.show().css({
                width: "auto",
                minHeight: 0,
                maxHeight: "none",
                height: 0
            }),
            r.minWidth > r.width && (r.width = r.minWidth),
            e = this.uiDialog.css({
                height: "auto",
                width: r.width
            }).outerHeight(),
            t = Math.max(0, r.minHeight - e),
            n = typeof r.maxHeight == "number" ? Math.max(0, r.maxHeight - e) : "none",
            r.height === "auto" ? this.element.css({
                minHeight: t,
                maxHeight: n,
                height: "auto"
            }) : this.element.height(Math.max(0, r.height - e)),
            this.uiDialog.is(":data(ui-resizable)") && this.uiDialog.resizable("option", "minHeight", this._minHeight())
        },
        _blockFrames: function() {
            this.iframeBlocks = this.document.find("iframe").map(function() {
                var t = e(this);
                return e("<div>").css({
                    position: "absolute",
                    width: t.outerWidth(),
                    height: t.outerHeight()
                }).appendTo(t.parent()).offset(t.offset())[0]
            })
        },
        _unblockFrames: function() {
            this.iframeBlocks && (this.iframeBlocks.remove(), delete this.iframeBlocks)
        },
        _allowInteraction: function(t) {
            return e(t.target).closest(".ui-dialog").length ? !0 : !!e(t.target).closest(".ui-datepicker").length
        },
        _createOverlay: function() {
            if (!this.options.modal) return;
            var t = !0;
            this._delay(function() {
                t = !1
            }),
            this.document.data("ui-dialog-overlays") || this._on(this.document, {
                focusin: function(e) {
                    if (t) return;
                    this._allowInteraction(e) || (e.preventDefault(), this._trackingInstances()[0]._focusTabbable())
                }
            }),
            this.overlay = e("<div>").addClass("ui-widget-overlay ui-front").appendTo(this._appendTo()),
            this._on(this.overlay, {
                mousedown: "_keepFocus"
            }),
            this.document.data("ui-dialog-overlays", (this.document.data("ui-dialog-overlays") || 0) + 1)
        },
        _destroyOverlay: function() {
            if (!this.options.modal) return;
            if (this.overlay) {
                var e = this.document.data("ui-dialog-overlays") - 1;
                e ? this.document.data("ui-dialog-overlays", e) : this.document.unbind("focusin").removeData("ui-dialog-overlays"),
                this.overlay.remove(),
                this.overlay = null
            }
        }
    })
});