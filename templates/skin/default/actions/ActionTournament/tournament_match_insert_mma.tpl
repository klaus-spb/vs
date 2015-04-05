{include file='header.tpl' menu_content='tournament'}
<br/>
{literal}
<style>
.w200{width:200px;}
</style>
{/literal}

{if $oTournament->getKnownTeams()==3} 
	{assign var=oAwayUser value=$oMatch->getAwayteamtournament()->getUser1()}
	{assign var=oHomeUser value=$oMatch->getHometeamtournament()->getUser1()}
{else}
	{assign var=oAwayTeam value=$oMatch->getAwayteam()}
	{assign var=oHomeTeam value=$oMatch->getHometeam()} 
{/if}
<form action="{$oTournament->getUrlFull()}match_insert/{$oMatch->getMatchId()}{if $teamtournament_result!=$myteamtournament}/{$teamtournament_result}{/if}" onsubmit="return checkForm(this);"  method="post" id="form1" name="form1">

<p align="center">
	<span id="match_teams_teamplay"></span>
	<span id="vvel_teamplay"></span>
</p>
		
<table> 
	{if $oTournament->getKnownTeams()==3}

	<tr class="odd">
		<td class="w200">Ваш боец</td>
		<td >
			<select id="team_id" name="team_id" class="input">
				<option value="-1"> - </option>
				{assign var=league_id value=0}
				{foreach from=$aTeams item=oTeam}
					{*{if $oTeam->getLeagueId() != $league_id}
						{if $league_id != 0}</optgroup>{/if}
						{assign var=league_id value=$oTeam->getLeagueId()}
						<optgroup label="{$oTeam->getLeague()->getName()}">
					{/if}*}
			   
					<option value="{$oTeam->getTeamId()}" {if ($oMatchResult && $oMatchResult->getTeamId()==$oTeam->getTeamId()) || (!$oMatchResult && $oTeaminTournament && $oTeaminTournament->getTeamId()==$oTeam->getTeamId())}SELECTED{/if}>{$oTeam->getName()}</option>
				{/foreach}
				{*</optgroup>*}
			</select> 
		</td>
	</tr>
	{else}
		<input name="team_id"  type="hidden" id="team_id"  value="{if $oMatchResult}{$oMatchResult->getTeamId()}{else}{$oTeaminTournament->getTeamId()}{/if}"/>
	{/if}
	<tr class="odd">
		<td class="w200">Результат поединка</td>
		<td >
			<select id="result" name="result" class="input">
				<option value="-1"> - </option>
				<option value="0" {if $oMatchResult && $oMatchResult->getAway()==2}SELECTED{/if}>Победа {if $oTournament->getKnownTeams()==3}{$oAwayUser->getLogin()}{else}{$oAwayTeam->getName()}{/if}</option>
				<option value="1" {if $oMatchResult && $oMatchResult->getAway()==1}SELECTED{/if}>Ничья</option>
				<option value="2" {if $oMatchResult && $oMatchResult->getHome()==2}SELECTED{/if}>Победа {if $oTournament->getKnownTeams()==3}{$oHomeUser->getLogin()}{else}{$oHomeTeam->getName()}{/if}</option>
			</select> 
		</td>
	</tr>

	<tr class="odd">
		<td class="w200">Исход</td>
		<td >
			<select id="issue" name="issue" class="input-small">
				<option value="-1"> - </option>
				<option value="0" {if $oMatchResult && $oMatchResult->getKo()==1}SELECTED{/if}>нокаут</option>
				<option value="1" {if $oMatchResult && $oMatchResult->getTehko()==1}SELECTED{/if}>технический нокаут</option>
				<option value="2" {if $oMatchResult && $oMatchResult->getSubmission()==1}SELECTED{/if}>сдача</option>
				<option value="3" {if $oMatchResult && $oMatchResult->getDecision()==1}SELECTED{/if}>решение</option>
				<option value="4" {if $oMatchResult && $oMatchResult->getDisqualification()==1}SELECTED{/if}>дисквалификация</option>
			</select> 
		</td>
	</tr

	<tr class="odd">
		<td class="w200">Раунд окончания</td>
		<td >
			<select id="period" name="period" class="width_auto">
				<option value="-1"> - </option>
				<option value="1" {if $oMatchResult && $oMatchResult->getPeriod()==1}SELECTED{/if}>1</option>
				<option value="2" {if $oMatchResult && $oMatchResult->getPeriod()==2}SELECTED{/if}>2</option>
				<option value="3" {if $oMatchResult && $oMatchResult->getPeriod()==3}SELECTED{/if}>3</option>
				<option value="4" {if $oMatchResult && $oMatchResult->getPeriod()==4}SELECTED{/if}>4</option>
				<option value="5" {if $oMatchResult && $oMatchResult->getPeriod()==5}SELECTED{/if}>5</option>
		</select> 
		</td>
	</tr
	<tr class="odd">
		<td class="w200">Нокдауны</td>
		<td >
			<input name="knockdowns" class="input-mini" type="text" id="knockdowns" size="2" {if $oMatchResult}value="{$oMatchResult->getKnockdowns()}"{/if}/>
		</td>
	</tr>
	<tr class="odd">
		<td class="w200">Значимые удары (success/attemp)</td>
		<td >
			<input name="sig_strikes" class="input-mini" type="text" id="sig_strikes" size="2" {if $oMatchResult}value="{$oMatchResult->getSigStrikes()}"{/if}/>
			/<input name="sig_strikes_at" class="input-mini" type="text" id="sig_strikes_at" {if $oMatchResult}value="{$oMatchResult->getSigStrikesAt()}"{/if} size="2" />
		</td>
	</tr>
	<tr class="odd">
		<td class="w200">Ударов всего (success/attemp)</td>
		<td >
			<input name="total_strikes" class="input-mini" type="text" id="total_strikes" size="3" {if $oMatchResult}value="{$oMatchResult->getTotalStrikes()}"{/if}/>
			/<input name="total_strikes_at" class="input-mini" type="text" id="total_strikes_at" {if $oMatchResult}value="{$oMatchResult->getTotalStrikesAt()}"{/if} size="3" />
		</td>
	</tr>	

	<tr class="odd">
		<td class="w200">Тейкдауны (success/attemp)</td>
		<td >
			<input name="takedowns" class="input-mini" type="text" id="takedowns" size="2" {if $oMatchResult}value="{$oMatchResult->getTakedowns()}"{/if}/>
			/<input name="takedowns_at" class="input-mini" type="text" id="takedowns_at" {if $oMatchResult}value="{$oMatchResult->getTakedownsAt()}"{/if} size="2" />
		</td>
	</tr>
	<tr class="odd">
		<td class="w200">Попытки сабмишена</td>
		<td >
			<input name="submission_at" class="input-mini" type="text" id="submission_at" size="2" {if $oMatchResult}value="{$oMatchResult->getSubmissionAt()}"{/if}/>
		</td>
	</tr>
	<tr class="odd">
		<td class="w200">Ground</td>
		<td >
			<input name="ground" class="input-mini" type="text" id="ground" size="2" {if $oMatchResult}value="{$oMatchResult->getGround()}"{/if}/>
		</td>
	</tr>
</table>    
  

	<tr>
		<td colspan="4"><h2>{$aLang.plugin.vs.press}</h1></td>
	</tr>
	<tr>
		<p>
			<textarea id="comment" name="comment" class="comment_textarea" cols="1" rows="1">{if $oMatchResult}{$oMatchResult->getComment()}{/if}</textarea>
		</p>
	</tr>
<p>
	<input type="submit" value="Submit" name="submit">
</p>

</form>		
{literal}
<style>
.comment_textarea{
width: 99%;
height: 200px;
}
</style>
<script>
$(document).ready(function() {
	var params = {};
	params['match_id']={/literal}{$oMatch->getMatchId()}{literal};
	params['security_ls_key']=LIVESTREET_SECURITY_KEY;
	$('#teamintournament_id').val('{/literal}{$teamtournament_result}{literal}');
	$('#team_id').val({/literal}{$team_id}{literal});
	$('#match_id').val(params['match_id']);
	params['team_id']=$('#team_id').val(); 
	params['teamintournament_id']=$('#teamintournament_id').val();
	$('#result_edit').val(0); 
	
	ls.ajax(aRouter['ajax']+'match/resultgetadmin/', params, function(result){
				if (!result) {
					ls.msg.error('Error15','Please try again later');
				}
				if (result.bStateError) {
					ls.msg.error('Error16','Please try again later');
				} else {
					if(result.away_team!==undefined){
						$("#match_teams_teamplay").html(result.away_team+" - " +result.home_team);
					}else{
						$("#match_teams_teamplay").html(result.away_user+" - " +result.home_user);
					}
						if(result.yess){
						
						ot="";
						so="";
						ko="";
						submission="";
						tko="";
						decision="";						
						period="";
						leftside="";
						rightside="";
						
						if(result.ot==1)ot=" OT";
						if(result.so==1)so=" SO";
						if(result.ko==1){
							ko=" KO";
							$('#issue').val(0);
						}
						if(result.tko==1){
							tko=" TKO";
							$('#issue').val(1);
						}
						if(result.sub==1){
							submission=" SUB";
							$('#issue').val(2);
						}
						if(result.dec==1){
							decision=" DEC";
							$('#issue').val(3);
						}
						
						if(result.period && result.period!=0){
							period=" Round " + result.period;
							$('#period').val(result.period);
						}
						if(result.away==0)leftside="L";
						if(result.away==1)leftside="T";
						if(result.away==2)leftside="W";
						
						if(result.home==0)rightside="L";
						if(result.home==1)rightside="T";
						if(result.home==2)rightside="W";
						
						
						$("#vvel_teamplay").html("(" +leftside+" : " +rightside+ot+so+ko+tko+submission+decision+period+")");								 
					}					
				}
			});
});
var players='{/literal}<option value="0">Bot</option>{foreach from=$aPlayercards item=oPlayercards name=el2}{assign var=oUser value=$oPlayercards->getUser()}<option value="{$oPlayercards->getPlayercardId()}">{*{$oPlayercards->getFio()} *}{$oPlayercards->getFamily()|escape:'html'} {$oPlayercards->getName()|escape:'html'|truncate:2:'.'}({$oUser->getLogin()})</option>{/foreach}{literal}';

function MyAdd(number) {
	var id = document.getElementById("id").value;
	if (number=='') number=0;

	id=parseInt(id);
	number=parseInt(number);
	if (number>id){
		id=parseInt(id)+1;
		for ( var i = id; i <=number; i++ ){
			$("#divTxt").append("<p class='result_scorer' id='row" + i + "'>P.<SELECT id='period" + i + "' NAME='period" + i + "' class='width_auto'><OPTION value=1>1</OPTION><OPTION value=2>2</OPTION><OPTION value=3>3</OPTION><OPTION value=4>OT</OPTION></SELECT> M.<SELECT id='minute" + i + "' NAME='minute" + i + "' class='width_auto'><OPTION value=0>0</OPTION><OPTION value=1>1</OPTION><OPTION value=2>2</OPTION><OPTION value=3>3</OPTION><OPTION value=4>4</OPTION><OPTION value=5>5</OPTION><OPTION value=6>6</OPTION><OPTION value=7>7</OPTION><OPTION value=8>8</OPTION><OPTION value=9>9</OPTION><OPTION value=10>10</OPTION><OPTION value=11>11</OPTION><OPTION value=12>12</OPTION><OPTION value=13>13</OPTION><OPTION value=14>14</OPTION><OPTION value=15>15</OPTION><OPTION value=16>16</OPTION><OPTION value=17>17</OPTION><OPTION value=18>18</OPTION><OPTION value=19>19</OPTION></SELECT> S. <SELECT id='secunde" + i + "' NAME='secunde" + i + "' class='width_auto'><OPTION value=0>0</OPTION><OPTION value=1>1</OPTION><OPTION value=2>2</OPTION><OPTION value=3>3</OPTION><OPTION value=4>4</OPTION><OPTION value=5>5</OPTION><OPTION value=6>6</OPTION><OPTION value=7>7</OPTION><OPTION value=8>8</OPTION><OPTION value=9>9</OPTION><OPTION value=10>10</OPTION><OPTION value=11>11</OPTION><OPTION value=12>12</OPTION><OPTION value=13>13</OPTION><OPTION value=14>14</OPTION><OPTION value=15>15</OPTION><OPTION value=16>16</OPTION><OPTION value=17>17</OPTION><OPTION value=18>18</OPTION><OPTION value=19>19</OPTION><OPTION value=20>20</OPTION><OPTION value=21>21</OPTION><OPTION value=22>22</OPTION><OPTION value=23>23</OPTION><OPTION value=24>24</OPTION><OPTION value=25>25</OPTION><OPTION value=26>26</OPTION><OPTION value=27>27</OPTION><OPTION value=28>28</OPTION><OPTION value=29>29</OPTION><OPTION value=30>30</OPTION><OPTION value=31>31</OPTION><OPTION value=32>32</OPTION><OPTION value=33>33</OPTION><OPTION value=34>34</OPTION><OPTION value=35>35</OPTION><OPTION value=36>36</OPTION><OPTION value=37>37</OPTION><OPTION value=38>38</OPTION><OPTION value=39>39</OPTION><OPTION value=40>40</OPTION><OPTION value=41>41</OPTION><OPTION value=42>42</OPTION><OPTION value=43>43</OPTION><OPTION value=44>44</OPTION><OPTION value=45>45</OPTION><OPTION value=46>46</OPTION><OPTION value=47>47</OPTION><OPTION value=48>48</OPTION><OPTION value=49>49</OPTION><OPTION value=50>50</OPTION><OPTION value=51>51</OPTION><OPTION value=52>52</OPTION><OPTION value=53>53</OPTION><OPTION value=54>54</OPTION><OPTION value=55>55</OPTION><OPTION value=56>56</OPTION><OPTION value=57>57</OPTION><OPTION value=58>58</OPTION><OPTION value=59>59</OPTION></SELECT> G. <SELECT id='goal" + i + "' NAME='goal" + i + "'  class='input-small'>"+ players +"</SELECT> 1a. <SELECT id='assist_" + i + "' NAME='assist_" + i + "' class='input-small'><OPTION value='-1'>-</OPTION>"+ players +"</SELECT> 2a. <SELECT id='assist__" + i + "' NAME='assist__" + i + "'  class='input-small'><OPTION value='-1'>-</OPTION>"+ players +"</SELECT><SELECT id='sostav" + i + "' NAME='sostav" + i + "'  class='input-small'><OPTION value=0>Normal </OPTION><OPTION value=1>Powerplay</OPTION><OPTION value=2>Penalty Kill</OPTION><OPTION value=3>Penalty shot</OPTION></SELECT> En?<input type='checkbox' id='PSH' name='PSH" + i + "' value='1'>");
		}
		
		id = parseInt(number);
		document.getElementById("id").value = id;
	}
	else if(number<id) 
	{
		for ( var i = id; i >number; i-- ){
			removeFormField("#row" + i);
		}
		id = parseInt(number);
		document.getElementById("id").value = id;
	}
}

function removeFormField(id) {
	$(id).remove();
}
 
function checkForm(form) {


	if (1==1 ){
		var value, 
		type,
		ipp,
		goal,
		assist_,
		assist__,
		sostav,
		bot=0; 
		var errorList = [];
		var t=0;
		var errorText = {
		1 : "Выберите вашего бойца",
		2 : "Укажите кто победил",
		3 : "Вы не указали исход",
		4 : "Вы не указали раунд",
		5 : "Значимых ударов не должно быть больше чем попыток значимых ударов",
		6 : "Всего ударов не должно быть больше чем попыток  ударов",
		7 : "Тейкдаунов не должно быть больше чем попыток тейкдаунов"
		}
		var team_id = document.getElementById("team_id").value;
		var result = document.getElementById("result").value;
		var issue = document.getElementById("issue").value;
		var period = document.getElementById("period").value;
		
		if(parseInt(team_id)==-1) errorList.push(1);
		if(parseInt(result)==-1) errorList.push(2);
		if(parseInt(issue)==-1) errorList.push(3);
		if(parseInt(period)==-1) errorList.push(4);
		
		if( parseInt(document.getElementById("sig_strikes").value) > parseInt(document.getElementById("sig_strikes_at").value) )errorList.push(5);
		if( parseInt(document.getElementById("total_strikes").value) > parseInt(document.getElementById("total_strikes_at").value) )errorList.push(6);
		if( parseInt(document.getElementById("takedowns").value) > parseInt(document.getElementById("takedowns_at").value) )errorList.push(7);
		
		
		
		
		if (!errorList.length) return true;
		var errorMsg = "Warning! Error:\n\n";
		for (i = 0; i < errorList.length; i++) {
			errorMsg += errorText[errorList[i]] + "\n";
		}
		alert(errorMsg);
		return false;
	}else {
		return false;
	}
}
function text1Change()
{


}
</script>
{/literal}
{include file='footer.tpl'}