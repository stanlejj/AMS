<div id="page_content">
		<div id="content_wrapper" class="center-layout">
			<div class='clearfix'>
				&nbsp;
			</div>	
			<div class='title'>
				<h2>Single Account</h2>
			</div>
			<div id="account_info" class="filter ui-widget ui-widget-content ui-corner-all">
				<!--filter sections - with tab sliding effect-->
				<ul class='filter-tab'>
					<li id="general" rel="info_general"></li>
					<li id="ad_attr" rel="info_ad"></li>
					<li id="moodle_attr" rel="info_moodle"></li>
					<li id="gmail_attr" rel="info_gmail"></li>
				</ul>
				<div id="info_general" class="filter-selection">
					<div>
						<select>
							<option value='username'>Username (recommended)</option>
							<option value='lastname'>Lastname</option>
						</select>
					</div>
					<div>
						&nbsp;
					</div>
				</div>
				<div id="info_ad" class="filter-selection">
					<div>
						&nbsp;
					</div>
					<div>
						&nbsp;
					</div>
				</div>
				<div id="info_moodle" class="filter-selection">
					<div>
						&nbsp;
					</div>
					<div>
						&nbsp;
					</div>
				</div>
				<div id="info_gmail" class="filter-selection">
					<div>
						&nbsp;
					</div>
					<div>
						&nbsp;
					</div>
				</div>
				<div class="main-instruction">
					&nbsp;
				</div>
				<!-- current Filter Section List - Removal enabled-->	
				<div id="moodle_analyzer" class='sideblock'>
					<div class="sideblock-header ui-helper-clearfix ui-state-default ui-corner-all ui-helper-reset">Moodle Analyzer</div>
					<div class="sideblock-content">			
					</div>						
				</div>
				<div class="clear-float">&nbsp;</div>
				<div id="gmail_analyzer" class='sideblock'>
					<div class="sideblock-header ui-helper-clearfix ui-state-default ui-corner-all ui-helper-reset">Gmail Analyzer</div>
					<div class="sideblock-content">			
					</div>						
				</div>
				<div class="clear-float">&nbsp;</div>
				<div id="ad_analyzer" class='sideblock'>
					<div class="sideblock-header ui-helper-clearfix ui-state-default ui-corner-all ui-helper-reset">AD Analyzer</div>
					<div class="sideblock-content">			
					</div>						
				</div>	
			</div>
			<div class="button-row">
				<input type="button" value="Create User" class="ui-button ui-state-default ui-corner-all ui-button-text-only">
				<input type="button" value="Update User" class="ui-button ui-state-default ui-corner-all ui-button-text-only">
			</div>		
			<div class="report ui-tabs ui-widget ui-widget-content ui-corner-all">
				<ul class="ui-tabs-nav ui-helper-clearfix ui-widget-header ui-corner-all">
					<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
						<a href="#policy_tab">Policy</a></li>
					<li class="ui-state-default ui-corner-top">
						<a href="#search_tab">Search</a></li>
					<li class="ui-state-default ui-corner-top">
						<a href="#result_tab">Matched Accounts</a></li>	
				</ul>
				
				<div id='policy_tab' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom">
				<!--Sample Properties of a Workstation-->
				</div>
				<div id='search_tab' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
					Select The Module and Filter to generate report	
				</div>
				<div id='result_tab' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
					Reset here	
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
