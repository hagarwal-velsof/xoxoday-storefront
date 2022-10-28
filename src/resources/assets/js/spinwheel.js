var blkd = {
    init: function() {
        
    },
    api: {
        request: {
            get: function(url, successCallback, errorCallback, completeCallback, includeLoader) {
                return this.custom(url, {
                    method: "get"
                }, successCallback, errorCallback, completeCallback, includeLoader)
            },
            post: function(url, data, successCallback, errorCallback, completeCallback, includeLoader) {
                return this.custom(url, {
                    method: "post",
                    data: data
                }, successCallback, errorCallback, completeCallback, includeLoader)
            },
            custom: function(url, ajaxSettings, successCallback, errorCallback, completeCallback, includeLoader) {
                var that = this;
                successCallback = typeof successCallback === "undefined" ? null : successCallback;
                errorCallback = typeof errorCallback === "undefined" ? null : errorCallback;
                completeCallback = typeof completeCallback === "undefined" ? null : completeCallback;
                var $loader = this._showLoader(includeLoader);
                var settings = $.extend({
                    url: url,
                    dataType: "json",
                    success: function(data) {
                        if (successCallback) {
                            successCallback(data)
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        if (typeof xhr.aborted !== "undefined" && xhr.aborted) return;
                        if (errorCallback) {
                            errorCallback(xhr, ajaxOptions, thrownError)
                        } else {
                            console.log(xhr.statusText)
                        }
                    },
                    complete: function() {
                        if (completeCallback) {
                            completeCallback()
                        }
                        if ($loader) {
                            $loader.remove()
                        }
                    },
                }, ajaxSettings);
                return $.ajax(settings)
            },
            _showLoader: function(loaderData) {
                loaderData = typeof loaderData === "undefined" ? !0 : loaderData;
                if (!loaderData) return null;
                if (loaderData && loaderData instanceof jQuery) {
                    return blkd.util.loader.show(null, !0, loaderData)
                }
                if (Array.isArray(loaderData)) {
                    return blkd.util.loader.show(loaderData.length > 0 ? loaderData[0] : null, loaderData.length > 1 ? loaderData[1] : null, loaderData.length > 2 ? loaderData[2] : null)
                }
                return blkd.util.loader.show()
            },
        },
    },
    util: {
        javascript: {
            addAsyncScript: function(src, id, data) {
                var js, fjs = document.getElementsByTagName("script")[0];
                if (document.getElementById(id)) return;
                js = document.createElement("script");
                js.id = id;
                js.src = src;
                if (data) {
                    var $js = $(js);
                    $js.attr(data);
                    js = $js[0]
                }
                fjs.parentNode.insertBefore(js, fjs)
            },
        },
        loader: {
            template: '<div class="blkd-loader"><div class="back"><div class="lds-css ng-scope loading"><div class="lds-eclipse"><div></div></div><p class="text"></p></div></div></div>',
            show: function(text, coverContent, $specificElement) {
                $specificElement = typeof $specificElement === jQuery ? $specificElement : $("body");
                var $loader = this.make(text, coverContent, $specificElement.prop("tagName") !== "BODY");
                $specificElement.append($loader);
                return $loader
            },
            destroyByElement: function($specificElement) {
                if (!$specificElement) {
                    $specificElement = $("body")
                }
                var $loader = $specificElement.children(".blkd-loader");
                if ($loader.length) {
                    $loader.remove()
                }
            },
            make: function(text, coverContent, isAbsolute) {
                text = typeof text === "string" ? text : "Loading...";
                coverContent = typeof coverContent === "undefined" ? !0 : coverContent;
                var $loader = $(this.template);
                $loader.find(".text").html(text);
                if (coverContent === !1) {
                    $loader.css.background = "none"
                }
                if (isAbsolute) {
                    $loader.css.position = "absolute"
                }
                $loader.css.zIndex = isAbsolute ? 8999 : 9000;
                return $loader
            },
        },
        url: {
            addParams: function(url, params) {
                var that = this;
                var returnUrl = url;
                Object.keys(params).forEach(function(param) {
                    returnUrl = that.addParam(returnUrl, param, params[param])
                });
                return returnUrl
            },
            addParam: function(uri, param, value) {
                var re = new RegExp("([?&])" + param + "=.*?(&|$)", "i");
                var separator = uri.indexOf("?") !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, "$1" + param + "=" + value + "$2")
                } else {
                    return uri + separator + param + "=" + value
                }
            },
        },
        modal: {
            success: function(message, title, closeCallback, icon, delay, id) {
                if (!icon && icon !== !1) icon = "fa-check-circle";
                return this._alert(message, title, closeCallback, icon, delay, id, "success-modal")
            },
            warning: function(message, title, closeCallback, icon, delay, id) {
                if (!icon && icon !== !1) icon = "fa-exclamation-circle";
                return this._alert(message, title, closeCallback, icon, delay, id, "warning-modal")
            },
            error: function(message, title, closeCallback, icon, delay, id) {
                if (!icon && icon !== !1) icon = "fa-exclamation-circle";
                return this._alert(message, title, closeCallback, icon, delay, id, "error-modal")
            },
            content: function(body, title, footer, id, closeCallback) {
                var $modalTitle = "";
                if (title) {
                    $modalTitle = $("<h5></h5>").addClass("modal-title").append(title)
                }
                var $modalClose = $("<button></button>").prop("type", "button").addClass("close").attr("data-dismiss", "modal").attr("aria-label", "Close").html('<span aria-hidden="true"><i class="fa fa-close"></i></span>');
                var $modalHeader = $("<div></div>").addClass("modal-header").append($modalTitle).append($modalClose);
                var $modalBody = $("<div></div>").addClass("modal-body").html(body);
                var $modalFooter = "";
                if (footer) {
                    $modalFooter = $("<div></div>").addClass("modal-footer").append(footer)
                }
                var $modalContent = $("<div></div>").addClass("modal-content").append($modalHeader).append($modalBody).append($modalFooter);
                var $modalDialog = $("<div></div>").addClass("modal-dialog modal-dialog-centered").append($modalContent);
                var $modal = $("<div></div>").addClass("modal").append($modalDialog);
                if (id) $modal.prop("id", id);
                $modal.modal();
                if (closeCallback) {
                    $modal.off("hidden.bs.modal").on("hidden.bs.modal", closeCallback)
                }
                return $modal
            },
            _alert: function(message, title, closeCallback, icon, delay, extraClass) {
                var $modalTitle = "";
                if (title || icon) {
                    var $modalTitleIcon = "";
                    if (icon) {
                        $modalTitleIcon = $("<i></i>").addClass("fa").addClass(icon)
                    }
                    var $modalTitleSpan = "";
                    if (title) {
                        $modalTitleSpan = $("<span></span>").addClass("title").html(title)
                    }
                    $modalTitle = $("<div></div>").append($modalTitleIcon).append($modalTitleSpan)
                }
                var $modalCloseButton = $("<button></button>").prop("type", "button").addClass("btn btn-success").attr("data-dismiss", "modal").html("Close");
                if (delay) {
                    var that = this;
                    setTimeout(function() {
                        that.content(message, $modalTitle, $modalCloseButton, null, extraClass, closeCallback)
                    }, delay)
                } else {
                    return this.content(message, $modalTitle, $modalCloseButton, null, extraClass, closeCallback)
                }
            },
        },
        clipboard: {
            copyInput: function($input) {
                if (typeof window.clipboard !== "undefined" && window.clipboard.copy) {
                    window.clipboard.copy($input.val())
                } else {
                    $input.select();
                    document.execCommand("copy")
                }
            },
        },
        screen: {
            scrollTop: function($toElementTop, correction) {
                if (typeof correction === "undefined") {
                    correction = 0
                }
                var top = $toElementTop.offset().top + correction;
                if (top < 0) {
                    top = 0
                }
                $("html, body").animate({
                    scrollTop: top
                }, 1000, "easeOutCubic");
                if (typeof window.parentIFrame !== "undefined") {
                    window.parentIFrame.scrollTo(0, $(document).data("beeliked-iframe-scrollY") + top)
                }
            },
        },
    },
    browser: {
        isWebViewIOS: function() {
            var standalone = window.navigator.standalone,
                userAgent = window.navigator.userAgent.toLowerCase(),
                safari = /safari/.test(userAgent),
                ios = /iphone|ipod|ipad/.test(userAgent);
            if (ios) {
                if (!standalone && safari) {
                    return !1
                }
                if (standalone && !safari) {
                    return !0
                }
                if (!standalone && !safari) {
                    return !0
                }
            }
            return !1
        },
        isChromeIOS: function() {
            return navigator.userAgent.match("CriOS") ? !0 : !1
        },
        isMobileBrowser: function() {
            return this._getMobileBrowser() ? !0 : !1
        },
        isMobileAgentIOS: function() {
            return $.inArray(this._getMobileDevice(), ["iphone", "ipod", "ipad"])
        },
        isMobileAgentAndroid: function() {
            return this._getMobileDevice() === "android"
        },
        isOldMSIE: function() {
            return (navigator.appName == "Microsoft Internet Explorer" || !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/rv:11/)) || (typeof $.browser !== "undefined" && $.browser.msie == 1))
        },
        hasCSSFeature: function(featurename) {
            var feature = !1,
                domPrefixes = "Webkit Moz ms O".split(" "),
                elm = document.createElement("div"),
                featurenameCapital = null;
            featurename = featurename.toLowerCase();
            if (elm.style[featurename] !== undefined) {
                feature = !0
            }
            if (feature === !1) {
                featurenameCapital = featurename.charAt(0).toUpperCase() + featurename.substr(1);
                for (var i = 0; i < domPrefixes.length; i++) {
                    if (elm.style[domPrefixes[i] + featurenameCapital] !== undefined) {
                        feature = !0;
                        break
                    }
                }
            }
            return feature
        },
        _getMobileBrowser: function() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.exec(navigator.userAgent.toLowerCase())
        },
        _getMobileDevice: function() {
            var mobileBrowser = this.getMobileBrowser();
            if (!mobileBrowser) {
                return null
            }
            return mobileBrowser[0].replace(/ /g, "")
        },
    }
};


var blkd_params = {
    "steps": {
        "success": {
            "name": "Result",
            "url": "share"
        }
    }
};

var blkd_presets = {};

blkd_presets.blkdSectionExecuteBlockSpinTheNeedle21 = {
    "needle-image": needle_image_url,
    "wheel-image": wheel_image_url,
    "no-tries-left-message": "",
    "no-tries-left-title": "No tries left",
    "feedback-message-winner": "Click continue to claim your prize",
    "feedback-message-try-again": "",
    "feedback-message-no-prize": "",
    "feedback-message-error-no-segments": "No more prizes available",
    "feedback-message-continue-button": "Continue",
    "segment-font-proportion": "2",
    "show-segment-labels": null
};


var initBlkdSectionExecuteBlockSpinTheNeedle21 = function(blkd_block, blkd_block_params, blkd_block_presets, blkd_params, blkd_context) {
    if (!blkd_block) return;
    var $blkd_block = $(blkd_block);
    var spinWheel = {
        _spin_button_element1: null,
        _spin_button_element: null,
        _feedback_element: null,
        _feedback_content_element: null,
        _rotation_element: null,
        _spin_count_element: null,
        _segments_list_element: null,
        _is_running: !1,
        _blkd_block_params: null,
        _spin_count: 0,
        _rotation: 0,
        init: function($blkd_block, blkd_block_params) {
            this._blkd_block_params = blkd_block_params;
            this._rotation_element = $blkd_block.find('.rotation-block');
            this._spin_button_element = $blkd_block.find('.spin-btn');
            this._spin_button_element1 = $('.spin-action-section').find(".spin-btn");
            this._feedback_element = $blkd_block.find('.feedback-block');
            this._feedback_content_element = this._feedback_element.find('.feedback-content');
            this._spin_count_element = $blkd_block.find('.spin-count-text');
            this._segments_list_element = $blkd_block.find('.segment-list');
            this._initEventHandlers();
            this._initCustomImages($blkd_block);
            this._initSegments(blkd_block_params.segments);
            if (blkd_block_params.show_begin_button) {
                var $signinBlock = $blkd_block.find('.sign-in-block');
                $signinBlock.show();
                $signinBlock.find('.enter-btn').attr('href', blkd_params.steps[blkd_context.next_step].url)
            } else {
                this._spin_button_element.show();
                this._spin_button_element1.show();
                
            }
        },
        _initCustomImages: function($blkd_block, segments) {
            if (blkd_block_presets['wheel-image']) {
                var $bottleContainer = $blkd_block.find('.bottle-container');
                $bottleContainer.find('.bg-area').css({
                    'background': 'url("' + blkd_block_presets['wheel-image'] + '") no-repeat center center',
                    'background-size': 'cover'
                })
            }
            if (blkd_block_presets['needle-image']) {
                this._rotation_element.find('.bottle').css({
                    'background': 'url(' + blkd_block_presets['needle-image'] + ') no-repeat center center',
                    'background-size': 'cover'
                })
            }
            if (!blkd_block_presets['show-segment-labels']) {
                $blkd_block.find('.circle-segments').hide()
            }
        },
        _initEventHandlers: function() {
            var that = this;
            this._spin_button_element.bind('click', function(e) {
                that._onSpinButtonClicked(e);
                // this._spin_button_element1.hide();
            })
            this._spin_button_element1.bind('click', function(e) {
                that._onSpinButtonClicked(e);
                // this._spin_button_element1.hide();
            })
        },
        _initSegments: function(segments) {
            var countSegments = segments.length;
            var anglePart = countSegments ? (360 / countSegments) : 360;
            if (!this._segments_list_element.hasClass('segment-count-' + countSegments)) {
                this._segments_list_element.addClass('segment-count-' + countSegments)
            }
            var liWidth = 50;
            if (countSegments > 2) {
                var borderSize = 6;
                var diameter = 100 - (countSegments * borderSize);
                liWidth = Math.sin(anglePart / diameter) * diameter
            }
            var liLeft = (100 - liWidth) / 2;
            var currentAngle = 0;
            var count = 0;
            var that = this;
            segments.forEach(function(segment) {
                count++;
                var liCss = "-webkit-transform: rotate(" + currentAngle + "deg);";
                liCss += "-moz-transform: rotate(" + currentAngle + "deg);";
                liCss += "-ms-transform: rotate(" + currentAngle + "deg);";
                liCss += "-o-transform: rotate(" + currentAngle + "deg);";
                liCss += "transform: rotate(" + currentAngle + "deg);";
                liCss += "zoom: 1; z-index: 10";
                var liLine = '<li data-id="' + segment.id + '" data-name="' + segment.label + '" data-min-deg="' + currentAngle + '" data-max-deg="' + (currentAngle + anglePart) + '" style="' + liCss + '"></li>';
                that._segments_list_element.append(liLine);
                var liCss = "-webkit-transform: rotate(" + (currentAngle + (anglePart / 2)) + "deg);";
                liCss += "-moz-transform: rotate(" + (currentAngle + (anglePart / 2)) + "deg);";
                liCss += "-ms-transform: rotate(" + (currentAngle + (anglePart / 2)) + "deg);";
                liCss += "-o-transform: rotate(" + (currentAngle + (anglePart / 2)) + "deg);";
                liCss += "transform: rotate(" + (currentAngle + (anglePart / 2)) + "deg);";
                liCss += "zoom: 1; z-index: 10; width: " + liWidth + "%; left: " + liLeft + "%";
                var textCss = ' style="height: ' + liWidth + '%"';
                liHtml = '<li class="segment-text segment-text-' + segment.id + '" style="' + liCss + '">';
                liHtml += '  <div class="text"' + textCss + '>' + segment.label + '</div>';
                liHtml += '</li>';
                that._segments_list_element.append(liHtml);
                currentAngle += anglePart
            });
            if ($.fn.fitText) {
                this._segments_list_element.find('li.segment-text').each(function() {
                    console.log("Proportion: " + blkd_block_presets['segment-font-proportion']);
                    $(this).fitText(blkd_block_presets['segment-font-proportion'])
                })
            } else {
                console.log('FitText not activated')
            }
        },
        _onSpinButtonClicked: function(e) {
            e.preventDefault();
            this._spin()
        },
        _spin: function() {
            if (this._is_running) {
                return
            }
            this._is_running = !0;
            this._spin_button_element.find('.ready').hide();
            this._spin_button_element.find('.loading').show();
            $(".spin-action-section").find(".spin-btn").attr("disabled", true);
            $(".spin-action-section").find(".spin-btn").addClass("spin-btn_disabled");
            var that = this;
            blkd.api.request.get(this._blkd_block_params.api.spin, function(data) {
                if (typeof data.error !== 'undefined' && data.error) {
                    that._loadErrorFeedback(data);
                    return
                }
                that._feedback_element.fadeOut('fast');
                that._spin_button_element.hide();
                that._rotation_element.addClass('spinning').removeClass('notransition').data('notransition', !1);
                that._spin_count += 1;
                that._spin_count_element.text(data.tries_left);
                var randomRotation = that._getRandomRotation(that._segments_list_element.find('li[data-id="' + data.segment + '"]').index(), that._segments_list_element.find('li').length);
                var additionalRotation = randomRotation + ((Math.floor(Math.random() * 10) + 6) * 360);
                that._rotation += additionalRotation;
                that._rotation_element.one("transitionend webkitTransitionEnd ontransitionend MSTransitionEnd oTransitionEnd", function(e) {
                    that._onRotationComplete(e, data)
                });
                that._rotateElement(that._rotation_element, that._rotation - 180)
            }, function(xhr) {
                blkd.util.modal.error('Failed to load spin wheel. Please try again later.')
            }, function() {
                that._spin_button_element.find('.ready').show();
                that._spin_button_element.find('.loading').hide();
                $(".spin-action-section").find(".spin-btn").attr("disabled", false);
                $(".spin-action-section").find(".spin-btn").removeClass("spin-btn_disabled");
                
                that._is_running = !1
            }, !1)
        },
        _loadFeedback: function(apiReturn) {
            this._feedback_content_element.html('');
            var $h2 = $('<h2></h2>').addClass('prize-text').html(apiReturn.feedback);
            this._feedback_content_element.append($h2);
            var $aContinue = $('<a></a>').attr('href', blkd_params.steps[blkd_context.next_step].url).addClass('btn btn-primary btn-lg get-prize-btn show-loading').html(blkd_block_presets['feedback-message-continue-button']);
            var $p = $('<p></p>').addClass('spin-count lead margin-b-0');
            if (apiReturn.has_prize) {
                $p.html(blkd_block_presets['feedback-message-winner'])
            } else if (apiReturn.tries_left > 0) {
                $p.html(blkd_block_presets['feedback-message-try-again'].replace('%spin_count%', '<span class="spin-count-text">' + apiReturn.tries_left + '</span>'));
                $aContinue = ''
            } else {
                $p.html(blkd_block_presets['feedback-message-no-prize'])
            }
            this._feedback_content_element.append($aContinue).append($p);
            var that = this;
            this._feedback_element.fadeIn(500, function() {
                setTimeout(function() {
                    if (apiReturn.tries_left === 0 && apiReturn.has_prize === !1) {
                        that._feedback_element.addClass('finished');
                        that._feedback_element.find('.get-prize-btn').remove();
                        document.location.href = blkd_params.steps[blkd_context.next_step].url
                    }
                }, 5500)
            })
        },
        _loadErrorFeedback: function(apiReturn) {
            var $h2 = $('<h2></h2>').addClass('prize-text').html(blkd_block_presets['feedback-message-error-no-segments']);
            this._feedback_content_element.append($h2);
            this._feedback_element.fadeIn(500)
        },
        _onRotationComplete: function(e, apiReturn) {
            if (this._rotation_element.data('notransition'))
                return;
            this._rotation_element.data('notransition', !0).addClass('notransition').removeClass('spinning');
            if (apiReturn.has_prize === !0) {
                this._feedback_element.find('p.spin-count').remove()
            }
            this._loadFeedback(apiReturn);
            if ((apiReturn.tries_left === 0) || (apiReturn.has_prize === !0)) {
                this._spin_button_element.hide();
                if (apiReturn.has_prize === !0) {
                    this._feedback_element.addClass('finished')
                }
                return
            }
            var that = this;
            setTimeout(function() {
                that._hideFeedback()
            }, 6300)
        },
        _hideFeedback: function() {
            this._feedback_element.fadeOut('fast').addClass('notransition').data('notransition', !1).css({
                '-webkit-transform': 'rotate(0deg)',
                '-moz-transform': 'rotate(0deg))',
                '-ms-transform': 'rotate(0deg)',
                '-o-transform': 'rotate(0deg)',
                'transform': 'rotate(0deg)',
                'zoom': 1
            });
            this._rotation = 0;
            this._spin_button_element.show()
        },
        _getRandomRotation: function(segmentIndex, segmentCount) {
            var segmentDegree = (360 / segmentCount);
            var randomMoviment = Math.floor(Math.random() * (segmentDegree - 1)) + 2;
            if (randomMoviment > Math.floor(segmentDegree * 0.9))
                randomMoviment = Math.floor(segmentDegree * 0.9);
            else if (randomMoviment < Math.floor(segmentDegree * 0.1))
                randomMoviment = Math.floor(segmentDegree * 0.1);
            var randomRotation = 180 + ((segmentIndex * segmentDegree) + randomMoviment);
            if(segmentIndex == 0) {
                return 225;
            } else if(segmentIndex == 2) {
                return 315;
            } else if(segmentIndex == 4) {
                return 405;
            } else if(segmentIndex == 6) {
                return 495;
            }
            return randomRotation
        },
        _rotateElement: function($element, degree) {
            $element.css({
                '-webkit-transform': 'rotate(' + degree + 'deg)',
                '-moz-transform': 'rotate(' + degree + 'deg)',
                '-ms-transform': 'rotate(' + degree + 'deg)',
                '-o-transform': 'rotate(' + degree + 'deg), translate3d(0, 0, 0)',
                'transform': 'rotate(' + degree + 'deg), translate3d(0, 0, 0)'
            })
        }
    };
    $.getScript('https://assets.beeliked.com/blkd/spin_the_wheel/jquery.fittext.min.js', function() {
        spinWheel.init($blkd_block, blkd_block_params)
    })
};
