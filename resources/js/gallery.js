var galleryJS = {
    init: function () {
        var galleries = $("[data-type=galleryJS]");
        for (var i = 0; i < galleries.length; i++) {
            var gallery = $(galleries.get(i));
            gallery.attr("data-id", i);
            this.gallery.init(gallery);
        }
    },
    gallery: {
        template: $("<div class=\"modal galleryJS fade\">"
                + "<div class=\"modal-dialog\">"
                + "<div class=\"modal-content\">"
                + "<div class=\"modal-header\">"
                + "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-remove\"></span></button>"
                + "<a type=\"button\" class=\"fullscreen\" onclick=\"galleryJS.gallery.toggleFullscreen()\" aria-label=\"Fullscreen\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-resize-full\"></span></a>"
                + "<h4 class=\"modal-title\">Modal title</h4>"
                + "</div>"
                + "<div class=\"controls\">"
                + "<a class=\"prev\" onclick=\"galleryJS.gallery.prev()\" href=\"#\"></a>"
                + "<a class=\"next\" onclick=\"galleryJS.gallery.next()\" href=\"#\"></a>"
                + "</div>"
                + "</div>"
                + "</div>"),
        init: function (gallery) {
            var modal = this.template.clone();
            modal.attr("data-gallery", gallery.attr("data-id"));
            modal.appendTo("body");
            var images = gallery.find("[data-type=galleryJS-thumbnail]");
            for (var i = 0; i < images.length; i++) {
                var thumbnail = $(images.get(i));
                thumbnail.attr("data-id", i);
                galleryJS.image.init(gallery.attr("data-id"), thumbnail);
            }
        },
        toggleFullscreen: function () {
            var target = $(event.currentTarget);
            var modal = target.parents(".modal.galleryJS");
            if (modal.hasClass("fullscreen")) {
                modal.removeClass("fullscreen");
                galleryJS.exitFullscreen();
            } else {
                modal.addClass("fullscreen");
                galleryJS.fullscreen(modal);
            }
        },
        size: function (gid) {
            var images = $("[data-type=galleryJS][data-id=" + gid + "]>[data-type=galleryJS-thumbnail]");
            return images.length;
        },
        prev: function () {
            var target = $(event.currentTarget);
            var modal = target.parents(".modal");
            var modal_content = modal.find(".modal-content");
            var curr = modal_content.find("img.current");
            var gid = parseInt(modal.attr("data-gallery"));
            var iid = curr.attr("data-image");
            iid--;
            if (iid < 0) {
                iid = galleryJS.gallery.size(gid) - 1;
            }
            galleryJS.image.add(gid, iid);
            galleryJS.image.show(gid, iid);
        },
        next: function () {
            var target = $(event.currentTarget);
            var modal = target.parents(".modal.galleryJS");
            var modal_content = modal.find(".modal-content");
            var curr = modal_content.find("img.current");
            var gid = parseInt(modal.attr("data-gallery"));
            var iid = parseInt(curr.attr("data-image"));
            iid++;
            if (iid >= galleryJS.gallery.size(gid)) {
                iid = 0;
            }
            galleryJS.image.add(gid, iid);
            galleryJS.image.show(gid, iid);
        }
    },
    image_loader: {
        loading: false,
        template: $('<img class="img-responsive loading" alt="" src="http://www.arabianbusiness.com/skins/ab.main/gfx/loading_spinner.gif" />'),
        lock: function () {
            this.loading = true;
        },
        unLock: function () {
            this.loading = false;
        },
        load: function (src) {
            var image = galleryJS.image_loader.template.clone();
            image.on("load", function () {
                image.removeClass("loading");
                image.delay(1000).fadeIn(500);
            });
            image.hide();
            image.attr("src", src);
            return image;
        }
    },
    image: {
        init: function (gallery_id, thumbnail) {
            thumbnail.attr("data-gallery", gallery_id);
            thumbnail.click(galleryJS.image.click);
        },
        click: function () {
            var target = $(event.currentTarget);
            var gid = target.attr("data-gallery");
            var iid = target.attr("data-id");
            galleryJS.image.add(gid, iid);
            galleryJS.image.show(gid, iid);
            event.preventDefault();
        },
        add: function (gid, iid) {
            var modal = $(".modal.galleryJS[data-gallery=" + gid + "]");
            var test_image = modal.find("img[data-image=" + iid + "]");
            if (test_image.length === 0) {
                var target = $("a[data-type=galleryJS-thumbnail][data-id=" + iid + "][data-gallery=" + gid + "]");
                if (target.length === 1) {
                    var image = galleryJS.image_loader.load(target.attr("href"));
                    image.attr("data-image", iid);
                    $(".modal.galleryJS[data-gallery=" + gid + "]").find(".modal-content").append(image);
                    return image;
                } else {
                    return false;
                }
            }
            return test_image;
        },
        show: function (gid, iid) {
            var modal = $(".modal.galleryJS[data-gallery=" + gid + "]");
            modal.modal("show");
            if (!galleryJS.image_loader.loading) {
                modal.find("img").removeClass("current").hide();
                modal.find("img[data-image=" + iid + "]").show().addClass("current");
                modal.find(".modal-title").html(galleryJS.image.getDescription(gid, iid));
            } else {
                setTimeout(function () {
                    galleryJS.image.show(gid, iid);
                }, 100);
            }
        },
        getDescription: function (gid, iid) {
            var element = $("a[data-type=gallery-thumbnail][data-id=" + iid + "][data-gallery=" + gid + "]>img");
            return element.attr("alt");
        }
    },
    fullscreen: function (jquery_object) {
        var element = jquery_object[0];
        // go full-screen
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
        if (element.exitFullscreen) {
            element.exitFullscreen();
        } else if (element.msExitFullscreen) {
            element.msExitFullscreen();
        } else if (element.mozCancelFullScreen) {
            element.mozCancelFullScreen();
        } else if (element.webkitExitFullscreen) {
            element.webkitExitFullscreen();
        }
    },
    exitFullscreen: function () {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    }
};
$(document).ready(function () {
    galleryJS.init();
});