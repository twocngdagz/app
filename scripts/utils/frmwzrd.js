/* Created by jankoatwarpspeed.com */

(function($) {
    $.fn.formToWizard = function(options) {
        options = $.extend({  
            submitButton: "" 
        }, options); 
        
        var element = this;

        var steps = $(element).find("fieldset");
        var count = steps.size();
        var submmitButtonName = "#" + options.submitButton;
        $(submmitButtonName).hide();

        // 2
        $(element).before("<ul id='steps'></ul>");

        steps.each(function(i) {
            $(this).wrap("<div id='step" + i + "'></div>");
	    
            $(this).after("<div id='step" + i + "commands'></div>");

            // 2
            var name = $(this).find("legend").html();
            $("#steps").append("<li id='stepDesc" + i + "'>Step " + (i + 1) + "<span>" + name + "</span></li>");

            if (i == 0) {
                createNextButton(i);
                selectStep(i);

            }
            else if (i == count - 1) {
                $("#step" + i).hide();
                createPrevButton(i,'true');
		
            }
            else {
                $("#step" + i).hide();
                createPrevButton(i);
                createNextButton(i);
            }
        });

        function createPrevButton(i,b) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Prev' class='prev'>< Back</a>");
	    if(b)$("#" + stepName + "commands").append("<a href='#' onclick='buttonFunction("+i+","+'"submit"'+")' id='Finish' class='finish'>Finish</a>"); 
            $("#" + stepName + "Prev").bind("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i - 1)).toggle("slide");
                $(submmitButtonName).hide();
                selectStep(i - 1);
		buttonFunction (i,'prev');
            });

        }

        function createNextButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Next' class='next'>Submit</a>");

            $("#" + stepName + "Next").bind("click", function(e) {
                if (buttonFunction (i,'next')){
		$("#" + stepName).hide();
                $("#step" + (i + 1)).toggle("slide");
                if (i + 2 == count)
                    $(submmitButtonName).show();
                selectStep(i + 1);
		}
            });
        }

        function selectStep(i) {
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
        }

    }
})(jQuery); 