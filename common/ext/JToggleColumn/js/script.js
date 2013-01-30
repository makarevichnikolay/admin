	
			const toOff = 0;
            const toOn = 86;
            var statusTumbler;
            function animateTumbler(destination, id)
            {
                $( "#"+id ).animate({
                    left: destination+'px'
                }, function(){
                    if(statusTumbler != $( "#"+id).attr('alt'))
                    $.ajax({
                        url: $( "#"+id).attr('data-url'),
                        error: function (data, textStatus) {
                            if (destination == toOn){
                                $( "#"+id).attr('alt','false');
                                $( "#"+id ).animate({
                                    left: toOff+'px'
                                });
                            }
                            if (destination == toOff){
                                $( "#"+id).attr('alt','true');
                                $( "#"+id ).animate({
                                    left: toOn+'px'
                                });
                            }
                        }
                    });
                });
            }
			
			function setDrug(imgClass)
			{
				$( "."+imgClass).draggable({
                axis:'x',
                containment:'parent',
                stop: function(event, ui) {
                    if (ui.position.left <= 43){
                        $( "#"+this.id).attr('alt','false');
                        animateTumbler(toOff, this.id);
                    }
                    if (ui.position.left >= 44){
                        $( "#"+this.id).attr('alt','true');
                        animateTumbler(toOn, this.id);
                    }
                },
                start: function(event, ui) {
                    statusTumbler = $( "#"+this.id).attr('alt');
                },
                drag: function(event, ui) {

                }
            });
			}

            function initializeDrag(imgClass)
            {
                jQuery('.'+ imgClass).live("mouseover", function() {

                    setDrug(imgClass);

                });

                $( "."+imgClass).live('click', function()
                {
                    statusTumbler = $( "#"+this.id).attr('alt');
                    if (this.alt=='true'){
                        animateTumbler(toOff, this.id)
                        $( "#"+this.id).attr('alt','false');
                    }
                    else {
                        animateTumbler(toOn, this.id)
                        $( "#"+this.id).attr('alt','true');
                    }
                });
            }

            $(document).ready(function() {
                initializeDrag("myImgExt");  //id need var
			});
