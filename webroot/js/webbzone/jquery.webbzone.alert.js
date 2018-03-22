/**
 * --------------------------------------------------------------------
 * jQuery-Plugin - Datepicker
 * Version: 1.0, 27.02.2017
 *
 * by Mohamed Salman, http://phpwebb.com/salman
 *
 * Copyright (c) 2013 Mohamed Salman
 * --------------------------------------------------------------------
 * You are free:
 *       * to Share - to copy, distribute and transmit the work
 *       * to Remix - to adapt the work
 *
 * Under the following conditions:
 *       * Attribution. You must attribute the work in the manner specified
 *         by the author or licensor (but not in any way that suggests that
 *         they endorse you or your use of the work).
 * --------------------------------------------------------------------
 * Changelog:
 *    27.02.2017 initial Version 1.0
 */$(function(){var a,b='<div class="wz-box-wizard" id="wz_confirmbox_panel"><div class="wz-box-widget"><div class="wz-box-header"><span class="wz-box-title">{title}</span><span class="wz-box-close"><a href="#" id="dismiss_times_wzconfirmbox">&times;</a></span></div><div class="wz-box-body"><div id="wz_body_content">...</div></div><div class="wz-box-footer"><div class="wz_footer_content" id="wz_footer_panel">{buttonsHtml}</div></div></div></div>',c='<div class="wz-box-wizard wz-informbox" id="wz_informbox_panel"><div class="wz-box-widget"><div class="wz-box-header"><span class="wz-box-title">{title}</span><span class="wz-box-close"><a href="#" id="dismiss_wzconfirmbox">&times;</a></span></div><div class="wz-box-body"><div id="wz_body_content">...</div></div></div></div>';WEBBZONE={init:function(a,d){if("inform"===d)var e="&nbsp;";else var e="confirm"===d?"Please Confirm":"Alert";var f="undefined"!=typeof a.title?a.title:e,g="undefined"!=typeof a.body?a.body:"...",h="undefined"!=typeof a.cancelBtnText?a.cancelBtnText:"Cancel",i="undefined"!=typeof a.confirmBtnText?a.confirmBtnText:"Ok",j="";j+="confirm"===d?'<button type="button" id="wzCancelOption" class="wzbtn btngrey">'+h+'</button><button type="button" id="wzConfirmOption" class="wzbtn btngrey flt-right">'+i+"</button>":'<span type="button" id="" class="wzbtn wzvisihide">&nbsp;</span><button type="button" id="wzConfirmOption" class="wzbtn btngrey flt-right">'+i+"</button>";var k="inform"===d?c:b,l="inform"===d?'<div class="wzoverlay alert wzinform"></div>':'<div class="wzoverlay alert"></div>';k=k.replace("{title}",f),k=k.replace("{buttonsHtml}",j),$("#wz_confirmbox_panel, #wz_informbox_panel, .wzoverlay").remove(),$("body").addClass("wzwidgetopen"),$("body").append(l),$("body").append(k),"undefined"!=typeof a.isHtml&&a.isHtml===!1?$("#wz_body_content").text(g):$("#wz_body_content").html(g),$("#wz_body_content").ready(function(){if($(window).height()-$(".wz-box-widget").height()>0){var a=$(window).height()-$(".wz-box-widget").height(),b=a/2;$(".wz-box-widget").css("margin-top",b+"px")}}),$("#wzCancelOption").click(function(b){$("#wz_confirmbox_panel, #wz_informbox_panel, .wzoverlay").remove(),$("body").removeClass("wzwidgetopen"),"undefined"!=typeof a.onCancel&&a.onCancel(),b.stopImmediatePropagation()}),"undefined"!=typeof $("#wzConfirmOption").attr("id")&&$("#wzConfirmOption").click(function(b){$("#wz_confirmbox_panel, #wz_informbox_panel, .wzoverlay").remove(),$("body").removeClass("wzwidgetopen"),"undefined"!=typeof a.onConfirm&&a.onConfirm(),b.stopImmediatePropagation()}),$("#dismiss_wzconfirmbox").click(function(b){return $("#wz_confirmbox_panel, #wz_informbox_panel, .wzoverlay").remove(),$("body").removeClass("wzwidgetopen"),"undefined"!=typeof a.onCancel&&"confirm"===d&&a.onCancel(),"undefined"!=typeof a.onConfirm&&"alert"===d&&a.onConfirm(),"undefined"!=typeof a.onClose&&"inform"===d&&a.onClose(),b.stopImmediatePropagation(),!1}),$("#dismiss_times_wzconfirmbox").click(function(a){return $("#wz_confirmbox_panel, #wz_informbox_panel, .wzoverlay").remove(),$("body").removeClass("wzwidgetopen"),!1})},confirm:function(a){WEBBZONE.init(a,"confirm")},alert:function(a){WEBBZONE.init(a,"alert")},inform:function(a){WEBBZONE.init(a,"inform")},message:function(b){var c=["danger","success","info"],d='<div class="wz-box-message"><span class="messenger {MessageType}">...</span><span class="close_webbzone_message {MessageType}">&times;</span></div>',e="undefined"!=typeof b.type&&$.inArray(b.type,c)!==-1?b.type:"info";d=d.replace(/{MessageType}/g,e),$("body").append(d);var f="undefined"!=typeof b.msg?b.msg:"&nbsp;";if("undefined"!=typeof b.isHtml&&b.isHtml===!1?$(".wz-box-message").find(".messenger").text(f):$(".wz-box-message").find(".messenger").html(f),setTimeout(function(){$(".wz-box-message").addClass("wz-box-message-open")},10),"undefined"!=typeof a&&""!==a&&clearTimeout(a),"undefined"!=typeof b.autoClose&&1==b.autoClose){var g="undefined"!=typeof b.closeDelay&&$.isNumeric(b.closeDelay)?b.closeDelay:1e4;a=setTimeout(function(){$(".wz-box-message").removeClass("wz-box-message-open"),setTimeout(function(){$(".wz-box-message").remove()},50)},g)}$(".close_webbzone_message").click(function(){var a=$(this);a.closest(".wz-box-message").removeClass("wz-box-message-open"),setTimeout(function(){a.closest(".wz-box-message").remove()},50)})},loader:function(a){if("show"===a){var b='<div class="wz-progress-panel"><div class="wz-progress-bar"><div class="indeterminate"></div></div></div>';$("body").append(b)}"hide"===a&&$("body").find(".wz-progress-panel").remove()}}});