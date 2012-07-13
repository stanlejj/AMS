<div id="page_content">
		<div id="content_wrapper" class="center-layout">
			<div class='clearfix'>
				&nbsp;
			</div>	
			<div class='title'>
				<h2>Cross System Analysis</h2>
			</div>
			<div id="filter_criteria" class="filter ui-widget ui-widget-content ui-corner-all">				
				<!-- current Filter Section List - Removal enabled-->	
				<!-- current Filter Section List - Removal enabled-->	
				<div id="in_module" class='sideblock left'>
					<div class="sideblock-header ui-helper-clearfix ui-state-default ui-corner-all ui-helper-reset">In these systems</div>
					<div class="sideblock-content">			
					</div>						
				</div>
				<div id="action_row">
					<div>
						<input type="button" value="--->" class="ui-button ui-state-default ui-corner-all ui-button-text-only">
					</div>
					<div>
						<input type="button" value="<---" class="ui-button ui-state-default ui-corner-all ui-button-text-only">
					</div>	
				</div>
				<div id="notin_module" class='sideblock right'>
					<div class="sideblock-header ui-helper-clearfix ui-state-default ui-corner-all ui-helper-reset">But not in these systems</div>
					<div class="sideblock-content">			
					</div>						
				</div>										
			</div>			
			<div class="button-row">
					<div>Status: 0%</div>
					<input type="button" value="Continue" class="ui-button ui-state-default ui-corner-all ui-button-text-only">
			</div>		
			<div class="report ui-tabs ui-widget ui-widget-content ui-corner-all">
				<ul class="ui-tabs-nav ui-helper-clearfix ui-widget-header ui-corner-all">
					<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
						<a href="#policy">Policy</a></li>
					<li class="ui-state-default ui-corner-top">
						<a href="#result_tab">Results</a></li>					
				</ul>
				
				<div id='policy' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom">
				<!--Sample Properties of a Workstation-->
				</div>
				<div id='result_tab' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
					Select The Module and Filter to generate report	
				</div>				
			</div>			
		</div>
</div>

<script type="text/javascript">
	//tab sliding effect for filter
	$(function() {
		$(".filter-tab li").click(function(){
			//vanish the background main instruction
			$('.main-instruction').animate({opacity:0},"slow");
			
			//slide our tab
			var activeid = $(".tab-active").attr('rel');						
			$("#"+activeid).animate({width: '0px'},'slow', function(){
				$("#"+activeid).css('display','none');
			});
			$(".tab-active").animate({left: '-=520'},'slow');
			
			var divid;
			if (!$(this).hasClass('tab-active'))
			{
				divid = $(this).attr('rel');
				$(".tab-active").removeClass('tab-active');
				$(this).addClass('tab-active');
				$(this).animate({left: '+=520'},'slow');
				$("#"+divid).css('display','block');
				$("#"+divid).animate({width: '460px'},'slow');							
			}	
			else
			{
				$('.main-instruction').animate({opacity:1},"slow");
				$(this).removeClass('tab-active');
			}
			return false;	
		});
		
		//tab effect for report
		$( ".report" ).tabs();		
	});
</script>
