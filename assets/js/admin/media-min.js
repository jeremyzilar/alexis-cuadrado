!function($){jQuery(document).ready(function(){$("#collection-list").height($("#topic-list").height()),$("#topic-list, #collection-list").sortable({opacity:.6,revert:!0,cursor:"move",connectWith:".connected_list",stop:function(t,e){var i=new Array;$("#collection-list li").each(function(){var t=$(this).attr("data-id");i.push(t)}),$("#collection_index").attr("value",i),$("#collection-list").height($("#topic-list").height())}}).disableSelection(),$("#refresh_headline").click(function(t){t.preventDefault();var e=$("#title").attr("value");$("#card_headline").attr("value",e)}),$("#refresh_deck").click(function(t){t.preventDefault();var e=$("#excerpt").val();$("#deck").val(e)})})}(jQuery);