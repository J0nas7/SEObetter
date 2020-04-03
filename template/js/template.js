var themeColor;
$(document).ready(function() {

    if ($("body").hasClass("light")) {
		themeColor = "light";
	} else {
		themeColor = "dark";
	}

    $(".topbar .menuTrigger").click(function() {
        var topmenu = $(".topbar .topmenu");
        $(this).toggleClass("triggered");
        $(topmenu).toggleClass("open");
    });

    if ($(".actionWrapper").length) {
        $(".actionWrapper .actionTrigger").click(function() {
            var wrapper = $(this).parent();
            if ($(wrapper).hasClass("open")) {
                $(wrapper).removeClass("open");
            } else {
                $(".actionWrapper").removeClass("open");
                $(wrapper).addClass("open");
            }
        });
    }

    if ($("form.createTask .inputField.Task").length) {
        $("form.createTask .inputField.Task").focus();
    }

    if ($(".readall-list.mostused .todo").length) {
        $(".readall-list.mostused .todo").click(function() {
            $("body").addClass("cover");
            $(".mostused .mostused-controllers").show();
        });

        $(".mostused .mostused-controllers .close").click(function() {
            $("body").removeClass("cover");
            $(".mostused .mostused-controllers").hide();
        });
    }

    if ($(".readall-list .workable .ctrlBtn").length) {
        $(".readall-list .workable .ctrlBtn").click(function() {
            var work_title = $(this).closest(".workable").find(".work_title").html();
            var taskID = $(this).closest(".workable").find(".taskID").val();

            var taskData = {"startTaskID" : taskID};
            BackendAJAXcall("", taskData, function(res) {
                if (res !== "Already running") {
                    bottombarChange(res['taskTitle'], false);
                } else {
                    console.log(res);
                }
            });
        });
    }

    if ($(".bottombar .player .counter").length) {
        var timeCounter = $(".bottombar .player .counter");

        playerTimer = 0;
        var count = setInterval(function() {
            if ($(".bottombar .player .curTask").html()) {
                playerTimer++;
                var seconds = Number(playerTimer);
                var h = Math.floor(seconds / 3600);
                var m = Math.floor(seconds % 3600 / 60);
                var s = Math.floor(seconds % 3600 % 60);

                $(timeCounter).find(".H").html(("0" + h).slice(-2));
                $(timeCounter).find(".M").html(("0" + m).slice(-2));
                $(timeCounter).find(".S").html(("0" + s).slice(-2));
            } else {
                playerTimer = 0;
            }
        }, 1000);

        setTimeout(function() {
            var checkCurTask = {"checkCurTask" : true};
            BackendAJAXcall("", checkCurTask, function(res) {
                if (res !== "Pause/Stop") {
                    bottombarChange(res['taskTitle'], false);
                    var timestamp = new Date().getTime()/1000;
                    playerTimer = (timestamp-res['startTime']);
                }
            });
        }, 1500);

        $(".bottombar .player .ctrlBtn").click(function() {
            bottombarChange();
        });
        $(".bottombar .player .ctrlBtn2.stop").click(function() {
            stopCurrentTask();
        });
    }

    $("body").show();

});

function bottombarChange(theString = "", change = true) {
    playerTimer = 0;
    if (change) {
        var remove = (playerStatus == "play" ? "play" : "pause")+", stop";
        var add = (playerStatus == "play" ? "pause" : "play");
        playerStatus = (playerStatus == "play" ? "pause" : "play");
        $(".bottombar, .bottombar .player").removeClass(remove);
        $(".bottombar, .bottombar .player").addClass(add);
        $(".bottombar .player .ctrlBtn").removeClass(remove);
        $(".bottombar .player .ctrlBtn").addClass(add);
    } else {
        $(".bottombar, .bottombar .player").removeClass("pause, stop").addClass("play");
        $(".bottombar .player .ctrlBtn").removeClass("pause, stop").addClass("play");
    }
    if (theString) { $(".bottombar .player .curTask").html(theString); }
}

function stopCurrentTask() {
    var stopCurTask = {"stopCurTask" : true};
    BackendAJAXcall("", stopCurTask, function(res) {
        if (res == "OK") {
            $(".bottombar .player .curTask").html("");
            playerTimer = 0;
            $(".bottombar, .bottombar .player").addClass("stop").removeClass("play, pause");
            $(".bottombar .player .ctrlBtn").addClass("stop").removeClass("play, pause");
            $(".bottombar .player .counter").find(".H, .M, .S").html(("00").slice(-2));
        }
    });
}

window.BackendAJAXcall = function (AjaxUrl, customData, _callback = "") {
    AjaxUrl = "/applesign/backend/index.php?w=API&"+AjaxUrl;
	$.ajax({
		type: 'POST',
		url: AjaxUrl,
		dataType: 'json',
		cache: false,
		data: {
			Themecolor: themeColor,
			customData: customData
		},
		success: function(result) {
			if (_callback) {
				$(".AJAX_Loader").remove();
				_callback(result);
			}
		},
		error: function(err) {
			console.log("BackendAJAX error");
			console.log(err);
		}
	});
}