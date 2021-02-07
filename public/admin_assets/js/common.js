var common_func = {
    "getUrlParam": function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return unescape(r[2]);
        return null;
    },
    "weekday": function (day) {
        day = day.toString();
        switch (day) {
            case "0":
                return '日'
                break;
            case "1":
                return '一'
                break;
            case "2":
                return '二'
                break;
            case "3":
                return '三'
                break;
            case "4":
                return '四'
                break;
            case "5":
                return '五'
                break;
            case "6":
                return '六'
                break;
        }
    },
    "pageGen": function (now, all) {
        console.log(now, all)
        now = Number(now)
        // console.log(all)
        // all = Math.ceil(all / 10) ;
        // console.log(all)
        if (now == undefined) {
            $(".Page").addClass("dpn")
        } else {
            $(".Page").removeClass("dpn")
            var _html = '';
            var _startDisabled = '';
            var _endDisabled = '';
            var _nowActived = '';
            if (now == 1) {
                _startDisabled = 'disabled'
            }
            _html += '<li class="page-item ' + _startDisabled + '">';
            _html += '<a class="page-link" href="#" aria-label="Previous" data-page="' + (now - 1) + '">';
            _html += '<span aria-hidden="true">&laquo;</span>';
            _html += '</a>';
            _html += '</li>';
            for (var i = 0; i < all; i++) {
                if (now == (i + 1)) {
                    _nowActived = 'active'
                } else {
                    _nowActived = ''
                }
                _html += '<li class="page-item ' + _nowActived + '"><a class="page-link" href="#" data-page="' + (i + 1) + '" id="gotNowPage">' + (i + 1) + '</a></li>';
            }
            if (now == all) {
                _endDisabled = 'disabled'
            }
            _html += '<li class="page-item ' + _endDisabled + '">';
            _html += '<a class="page-link" @click="changePage" href="#" aria-label="Next" data-page="' + (now + 1) + '">';
            _html += '<span aria-hidden="true">&raquo;</span>';
            _html += '</a>';
            _html += '</li>';
            $(".pagination").html(_html)
        }
    },
    "pageClick": function (callback) {
        $("body").on("click", ".page-link", function (e) {
            e.preventDefault();
            var _needPage = $(this).attr("data-page");
            console.log(_needPage)
            callback(_needPage)
        })
    },
    "pageClickReload": function (url) {
        // 刷新頁面的版本
        $("body").on("click", ".page-link", function (e) {
            e.preventDefault();
            var _needPage = $(this).attr("data-page");
            location.href = url + "&now_page=" + _needPage
        })
    },
    "examination": function (type, alert = true) {
        // type為判斷必填的class名稱前綴
        // alert為未填寫是否顯示'請填寫提示欄位'

        // 判斷是否必填
        var els = document.getElementsByClassName(type + "-val")
        var _require_length = els.length; //必填欄位數

        // 刪除之前必填
        const elements = document.getElementsByClassName("is-invalid");
        while (elements.length > 0) elements[0].classList.remove("is-invalid");

        Array.prototype.forEach.call(els, function (el) {
            // Do stuff here
            if (el.value.length == 0) {
                $(el).addClass('is-invalid');
            } else {
                _require_length--
            }
        });
        if (_require_length == 0) {
            // 全部欄位填寫完成
            return true;
        } else {
            if (alert == true) {
                Swal.fire('請填寫提示欄位');
            }
            return false;
        }
    }
}