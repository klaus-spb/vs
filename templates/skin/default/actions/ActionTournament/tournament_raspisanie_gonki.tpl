{include file='header.tpl' menu_content='tournament' } 
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
 {*
<div class="login-form jqmWindow" id="kvalification_form">
<form action="javascript:kval_save();" >
	<a href="#" class="close jqmClose"></a>
	<p><label for="best_lap">Лучшее время</label><br />
	<input type="text" id="best_lap" class="input-text" /></p>
	<input id="gonshik_id" type="hidden" SIZE="3" maxlength="3"/>
	<input id="mapintournament_id" type="hidden" SIZE="3" maxlength="3"/>
	<input id="kval_id" type="hidden" SIZE="3" maxlength="3"/>
	<input type="submit" name="submit_login" class="button" value="Сохранить" /><br />
</form>
</div>

<div class="login-form jqmWindow" id="kvalification_form">
<form action="javascript:kval_save();" >
	<a href="#" class="close jqmClose"></a>
	<p><label for="best_lap">Лучшее время</label><br />
	<input type="text" id="best_lap" class="input-text" /></p> 
	<input type="submit" name="submit_login" class="button" value="Сохранить" /><br />
</form>
</div>

<div class="login-form jqmWindow" id="comment_form">
<form action="javascript:gonka_comment_save();" >
	<a href="#" class="close jqmClose"></a>
	<p><label for="comment">Комментарий</label><br />
	<textarea id="comment" class="comment_textarea" cols="1" rows="1"></textarea></p> 
	<input type="submit" name="submit_login" class="button" value="Сохранить" /><br />
</form>
</div>

<div class="login-form jqmWindow" id="gonka_form">
<form action="javascript:gonka_save();" >
	<a href="#" class="close jqmClose"></a>
	<p><label for="times">Время гонки</label><br />
	<input type="text" id="times" class="input-text" /></p>
	<p><label for="best_lap">Лучшее время</label><br />
	<input type="text" id="best_laps" class="input-text" /></p>
	<p><label for="points">Очки</label><br />
	<input type="text" id="points" class="input-text" /></p>
	<input id="gonshik_id" type="hidden" SIZE="3" maxlength="3"/>
	<input id="mapintournament_id" type="hidden" SIZE="3" maxlength="3"/>
	<input id="kval_id" type="hidden" SIZE="3" maxlength="3"/>
	<input type="submit" name="submit_login" class="button" value="Сохранить" /><br />
</form>
</div>
*}				
<p align="right">					

			<label for="speedB">Этап:</label>
			<select name="speedB" id="speedB" onchange="ls.au.simple_toggles(this,'map'); return false;">
			{foreach from=$aMapsInTournament item=oMapsInTournament name=el2}
				{assign var=oMap value=$oMapsInTournament->getMap()}
				<option value="{$oMapsInTournament->getId()}" {if $oMapsInTournament->getId()==$mapintournament_id}SELECTED{/if}>{$oMap->getName()} - {$oMap->getBrief()} | {if $oMapsInTournament->getDates()!='2015-01-01 00:00:00'}{$oMapsInTournament->getDates()|date_format :"%d %b в %H:%M по МСК"}{else}(дата заезда не определена){/if}</option>
			{/foreach}
				{*<option selected="selected">Гран При Австралии - Мельбурн | 18 марта в 15-00 по МСК (ещё не состоялся)</option>*} 

			</select>

</p>	
				<div class="block-content" id="div_raspisanie">

 


					{$sRaspisanie}

					</div>
				</div></div>
				<div class="bl"><div class="br"></div></div>

{literal}
<style>
span.gonschik{
 display: inline-block;
  width: 150px;
  vertical-align: top;
}
span.ava{
 display: inline-block;
  width: 55px;
  vertical-align: top;
}

span.bollid{
display: inline-block;
width: 110px;
vertical-align: top;
}
span.best_lap, span.times{
display: inline-block;
width: 100px;
}
 
span.gonka_points{
display: inline-block;
width: 50px;
font-weight: bold;
color: #686868;

}
span.gonka_comment{
display: inline-block;
width: 500px;
}

.zaezd li .uf-actions {float: right;}
.zaezd li { 
	{/literal}
	{if $admin=='yes'}
	cursor: pointer;
	{/if}
	{literal}
	margin-bottom: 1px;
	padding: 5px 5px;
	overflow: hidden;
	zoom: 1;
	line-height: 12px;
	color: #777;
}
span.gonka {
font-family: 'PT Sans Narrow',sans-serif;
font-weight: normal;
font-size: 22px;
color: #686868;
/*margin-left: 20px; */
font-weight: bold;
}

</style>
<script language="JavaScript" type="text/javascript">
$('#kvalification_form').jqm(); 
$('#gonka_form').jqm();
$('#comment_form').jqm();  

 $("#gonka_list").sortable({ 
    update : function () { 
	var params = {};
	params['kval_gonka']= 0;
	params['mapintournament_id']=$('#speedB').val();
    params['order']  = $('#gonka_list').sortable('serialize');   
	  ls.ajax(aRouter['ajax']+'map/order/', params, function(result){
					if (!result) {
						ls.msg.error('Error14','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error15','Please try again later');
					} else {

					}
				});	
    } 
  });
  
 $("#kval_list").sortable({ 
    update : function () { 
	var params = {};
	params['kval_gonka']= 0;
	params['mapintournament_id']=$('#speedB').val();
    params['order']  = $('#kval_list').sortable('serialize');   
	  ls.ajax(aRouter['ajax']+'map/order/', params, function(result){
					if (!result) {
						ls.msg.error('Error14','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error15','Please try again later');
					} else {

					}
				});	
    } 
  });
  
	function gonka_save(){
		var params = {};
		params['kval_id'] = $('#kval_id').val();
		params['best_lap'] = $('#best_laps').val();
		params['times'] = $('#times').val();
		params['points'] = $('#points').val();
		ls.ajax(aRouter['ajax']+'map/resultgonkaset/', params, function(result){
					if (!result) {
						ls.msg.error('Error17','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error18','Please try again later');
					} else {
						$('#field_'+$('#kval_id').val()+' .best_lap').text($('#best_laps').val());
						$('#field_'+$('#kval_id').val()+' .times').text($('#times').val());
						$('#field_'+$('#kval_id').val()+' .gonka_points').text($('#points').val());
						$('#gonka_form').jqmHide();
					}
				});	
				
	
	}
	function  gonka_edit(id,map_id,user_id){
		$('#gonka_form').jqmShow(); 
		
		var params = {};
		params['mapintournament_id']=map_id;
		params['kval_id']= id;
		params['user_id']=user_id;
		params['security_ls_key']=LIVESTREET_SECURITY_KEY;
		$('#gonshik_id').val(user_id); 
		$('#kval_id').val(id); 
		$('#mapintournament_id').val(map_id);
		$('#best_laps').val('');
		$('#times').val('');
		$('#points').val('');
		
		ls.ajax(aRouter['ajax']+'map/resultgonkaget/', params, function(result){
					if (!result) {
						ls.msg.error('Error17','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error18','Please try again later');
					} else {
						$("#best_laps").val(result.best_lap);
						$("#times").val(result.times);
						$("#points").val(result.points);
					}
				});							
	}
	function kval_save(){
		var params = {};
		params['kval_id'] = $('#kval_id').val();
		params['best_lap'] = $('#best_lap').val();
		ls.ajax(aRouter['ajax']+'map/resultkvalset/', params, function(result){
					if (!result) {
						ls.msg.error('Error17','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error18','Please try again later');
					} else {
						$('#field_'+$('#kval_id').val()+' .best_lap').text($('#best_lap').val());
						$('#kvalification_form').jqmHide();
					}
				});	
				
	
	}
	
	function  kval_edit(id,map_id,user_id){
		$('#kvalification_form').jqmShow(); 
		
		var params = {};
		params['mapintournament_id']=map_id;
		params['kval_id']= id;
		params['user_id']=user_id;
		params['security_ls_key']=LIVESTREET_SECURITY_KEY;
		$('#gonshik_id').val(user_id); 
		$('#kval_id').val(id); 
		$('#mapintournament_id').val(map_id);
		$('#best_lap').val('');
		
		ls.ajax(aRouter['ajax']+'map/resultkvalget/', params, function(result){
					if (!result) {
						ls.msg.error('Error17','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error18','Please try again later');
					} else {
						  $("#best_lap").val(result.best_lap);
					}
				});							
	}
	
	function  kval_delete(id,map_id,user_id){
		 
		
		var params = {};
		params['mapintournament_id']=map_id;
		params['kval_id']= id;
		params['user_id']=user_id;
		params['security_ls_key']=LIVESTREET_SECURITY_KEY; 
		
		ls.ajax(aRouter['ajax']+'map/kvaldelete/', params, function(result){
					if (!result) {
						ls.msg.error('Error17','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error18','Please try again later');
					} else { 
					}
				});							
	}
	
	
function gonka_comment_save(){
		var params = {};
		params['kval_id'] = $('#kval_id').val();
		params['comment'] = $('#comment').val();
		ls.ajax(aRouter['ajax']+'map/resultcommentset/', params, function(result){
					if (!result) {
						ls.msg.error('Error17','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error18','Please try again later');
					} else {
						$('#comment_form').jqmHide();
					}
				});	
				
	
	}
	
	function  gonka_comment_edit(id,map_id,user_id){
		$('#comment_form').jqmShow(); 
		
		var params = {};
		params['mapintournament_id']=map_id;
		params['kval_id']= id;
		params['user_id']=user_id;
		params['security_ls_key']=LIVESTREET_SECURITY_KEY;
		$('#gonshik_id').val(user_id); 
		$('#kval_id').val(id); 
		$('#mapintournament_id').val(map_id);
		$('#comment').val('');
		
		ls.ajax(aRouter['ajax']+'map/resultcommentget/', params, function(result){
					if (!result) {
						ls.msg.error('Error17','Please try again later');
					}
					if (result.bStateError) {
						ls.msg.error('Error18','Please try again later');
					} else {
						  $("#comment").val(result.comment);
					}
				});							
	}
	
	function  fill_uch(map_id){
		var params = {};
		params['mapintournament_id']=map_id;
		params['security_ls_key']=LIVESTREET_SECURITY_KEY;

		ls.ajax(aRouter['ajax']+'map/fill_uch/', params, function(result){
			if (!result) {
				ls.msg.error('Error17','Please try again later');
			}
			if (result.bStateError) {
				ls.msg.error('Error18','Please try again later');
			} else {
				ls.au.simple_toggles($('#SpeedB'),'map');
			}
		});	 					
	}
 
	var addressFormatting = function(text){
			var newText = text;
			//array of find replaces
			var findreps = [
				{find:/^([^\>]+) \- /g, rep: '<span class="ui-selectmenu-item-header">$1</span>'},
				{find:/([^\|><]+) \| /g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
				{find:/([^\|><\(\)]+) (\()/g, rep: '<span class="ui-selectmenu-item-content">$1</span>$2'},
				{find:/([^\|><\(\)]+)$/g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
				{find:/(\([^\|><]+\))$/g, rep: '<span class="ui-selectmenu-item-footer">$1</span>'}
			];
			
			for(var i in findreps){
				newText = newText.replace(findreps[i].find, findreps[i].rep);
			}
			return newText;
		}
		
	$('select#speedB').selectmenu({
				width: 300, 
				style:"popup",
				maxHeight:1000,
				format: addressFormatting
			});
</script>
<style>
/* Selectmenu
----------------------------------*/
.ui-selectmenu { display: block; display: inline-block; position: relative; height: 2.2em; vertical-align: middle; text-decoration: none; overflow: hidden; zoom: 1; }
.ui-selectmenu-icon { position:absolute; right:6px; margin-top:-8px; top: 50%; }
.ui-selectmenu-menu { padding:0; margin:0; position:absolute; top: 0; display: none; z-index: 1005;} /* z-index: 1005 to make selectmenu work with dialog */
.ui-selectmenu-menu  ul { padding:0; margin:0; list-style:none; position: relative; overflow: auto; overflow-y: auto ; overflow-x: hidden; -webkit-overflow-scrolling: touch;} 
.ui-selectmenu-open { display: block; }
ul.ui-selectmenu-menu-popup { margin-top: -1px; }
.ui-selectmenu-menu li { padding:0; margin:0; display: block; border-top: 1px dotted transparent; border-bottom: 1px dotted transparent; border-right-width: 0 !important; border-left-width: 0 !important; }
.ui-selectmenu-menu li a,.ui-selectmenu-status { line-height: 1.4em; display: block; padding: .405em 2.1em .405em 1em; outline:none; text-decoration:none; }
.ui-selectmenu-menu li.ui-state-disabled a, .ui-state-disabled { cursor: default; }
.ui-selectmenu-menu li.ui-selectmenu-hasIcon a,
.ui-selectmenu-hasIcon .ui-selectmenu-status { padding-left: 20px; position: relative; margin-left: 5px; }
.ui-selectmenu-menu li .ui-icon, .ui-selectmenu-status .ui-icon { position: absolute; top: 1em; margin-top: -8px; left: 0; }
.ui-selectmenu-status { line-height: 1.4em; }
.ui-selectmenu-menu li span,.ui-selectmenu-status span { display:block; margin-bottom: .2em; }
.ui-selectmenu-menu li .ui-selectmenu-item-header { font-weight: bold; }
.ui-selectmenu-menu li .ui-selectmenu-item-footer { opacity: .8; }
/* for optgroups */
.ui-selectmenu-menu .ui-selectmenu-group { font-size: 1em; }
.ui-selectmenu-menu .ui-selectmenu-group .ui-selectmenu-group-label { line-height: 1.4em; display:block; padding: .6em .5em 0; font-weight: bold; }
.ui-selectmenu-menu .ui-selectmenu-group ul { margin: 0; padding: 0; }
/* IE6 workaround (dotted transparent borders) */
* html .ui-selectmenu-menu li { border-color: pink; filter:chroma(color=pink); width:100%; }
* html .ui-selectmenu-menu li a { position: relative }
/* IE7 workaround (opacity disabled) */
*+html .ui-state-disabled, *+html .ui-state-disabled a { color: silver; }
</style>
{/literal}
{include file='footer.tpl'}