<!DOCTYPE HTML>
<!--Ray-->
<html> 
	<head> 
		<title>Potato Pragmatism</title>
		<style>
			body
			{
				text-align: center;
			}
			#pointdiv, #valueclick, #idlevalue
			{
				color: white;
			}
			#bkimg
			{
				position: fixed; 
				top: 0; 
				left: 0; 
				min-width: 100%;
				min-height: 100%;
			}
			button
			{
				font: bold 10pt century gothic;
				color: green;
				border-radius: 5px;
			}
			#potato
			{
				display: inline-block;
				width: 100%;
				border: 6px dashed transparent;
				border-radius: 100px;
			}
			#uprow
			{
				border: thin solid green;
				font: bold 13pt helvetica;
				color: purple;
				background: skyblue;
				display: block;
				height: 10%;
			}
			#uprow:hover
			{
				background: pink;
				cursor: pointer;
			}
			#upgradepics
			{
				display: inline-block;
				position: relative;
				width: 20%;
				height: 100%;
			}
			#upgradebox
			{
				display: inline-block;
				position: relative;
				width: 40%;
				margin-left: 30%;
				margin-bottom: 30%;
			}
			.potatocontain
			{
				background: url('rain.gif');
				display: inline-block;
				border: 4px solid white;
				box-shadow: 10px 10px 20px white;
				margin-bottom: 10%;
			}
			.main
			{
				position: fixed;
				width: 25%;
				font: bold 15pt eras itc;
			}
			#swap
			{
				text-align: center;
			}
			#manrow
			{
				border: thin solid purple;
				font: bold 10pt arial;
				color: #1256CC;
				background: orange;
				display: block;
				height: 10%;
			}
			#manrow:hover
			{
				background: green;
				cursor: crosshair;
			}
			#messBox
			{
				color: limegreen;
			}
			#potato:hover
			{
				cursor: pointer;
			}
			#upgradebox
			{
				margin-top: 7%;
			}
			#moo
			{
				margin-left: 90%;
			}
			#bigboxie
			{
				border: thick inset goldenrod;
			}
			#hiscore
			{
				position: fixed;
				font: bold 13pt eras itc;
				z-index: 9999;
				width: 300px;
				background-color: orange;
				color: blue;
				border: thin solid black;
				border-radius: 5px;
				top: 50%;
				left: 40%;
				display: none;
			}
			#toodles
			{
				float: right;
				width: 30px;
			}
			#toodles:hover
			{
				cursor: pointer;
			}
		</style> 
		<script>
			function startup()
			{
				clickValue = 1;
				potatoCount = 0;
				totalIdle = 0;
				allButtons = document.getElementsByTagName("button");
				buttonDiv = document.getElementById('pointdiv');
				messageDisplay = document.getElementById('messBox');
				upBox = document.getElementById('upgradebox');
				idleContainer = document.getElementById('idleupgrades');
				manualContainer = document.getElementById("manualupgrades");
				gambleContainer = document.getElementById("gambleupgrades");
				showClickValue = document.getElementById('valueclick');
				showIdleValue = document.getElementById('idlevalue');
				setInterval(changeMessage, 60000);
				setInterval(display, 60000);
				swapUpgrades(idleContainer, manualContainer, gambleContainer, allButtons[0]);
				addGamble();
				gambleMessage = document.getElementById('board');
				hiScore = document.getElementById("hiscore");
				boardCloser = document.getElementById("toodles");
				boardCloser.setAttribute("onclick", "changeDisplay("+"'none'"+")");
				display();
				<?php
				$conn = new PDO("mysql:hostname=nelsonthepotato;dbname=raytato","root","");
				function getDBResults($cmd, $arrayType = PDO::FETCH_NUM)
				{
					global $conn;
					$result = $conn->prepare($cmd);
					$result->execute();
					return $result->fetchAll($arrayType);
				}
				echo "idleUpgrades = ".json_encode(getDBResults("SELECT * FROM `upgrades` WHERE `type`='idle'")).";";
				echo "manualUpgrades = ".json_encode(getDBResults("SELECT * FROM `upgrades` WHERE `type`='manual'")).";";
				if(isset($_POST['feature']))
				{
					if($_POST['feature'] == 'save')
					{
						getDBResults("INSERT INTO `score`(`name`, `score`) VALUES ('".$_POST['username']."','".$_POST['score']."')");
					}
				}
					?>
				for(var p = 0; p < idleUpgrades.length; p++)
				{
					makeIdleUpgrade(idleUpgrades[p][4], idleUpgrades[p][0], idleUpgrades[p][1], idleUpgrades[p][2]);
				}
				for(var t = 0; t < manualUpgrades.length; t++)
				{
					addManualUpgrade(manualUpgrades[t][4], manualUpgrades[t][0], idleUpgrades[t][1], idleUpgrades[t][2]);
				}
			}
			function makeIdleUpgrade(source, name, price, gain)
			{
				var upgrade = document.createElement('div');
				upgrade.id = "uprow";
				var icon = document.createElement('img');
				icon.id = "upgradepics";
				icon.src = "iconfolder/" + source + ".png";
				upgrade.appendChild(icon);
				var nick = document.createElement('div');
				nick.innerHTML = name;
				upgrade.appendChild(nick);
				var cost = document.createElement('div');
				cost.innerHTML = "Cost: " + price + " potatoes";
				upgrade.appendChild(cost);
				var benefit = document.createElement('div');
				benefit.innerHTML = "You get " + gain + " more potatoes per second."
				upgrade.appendChild(benefit);
				idleContainer.appendChild(upgrade);
				upgrade.setAttribute("onclick", "idleClick("+price+","+gain+")");
			}
			function addManualUpgrade(mike, andrew, sarah, pauline)
			{
				var upgrade = document.createElement('div');
				upgrade.id = 'manrow';
				var icon = document.createElement('img');
				icon.id = "upgradepics";
				icon.src = "iconfolder/" + mike + ".png";
				upgrade.appendChild(icon);
				var nick = document.createElement('div');
				nick.innerHTML = andrew;
				upgrade.appendChild(nick);
				var cost = document.createElement('div');
				cost.innerHTML = "Cost: " + sarah + " potatoes";
				upgrade.appendChild(cost);
				var benefit = document.createElement('div');
				benefit.innerHTML = "You get " + pauline + " more potatoes per click."
				upgrade.appendChild(benefit);
				manualContainer.appendChild(upgrade);
				upgrade.setAttribute("onclick", "changeClickValue("+sarah+","+pauline+")");
			}
			function addGamble()
			{
				var gambleStation = document.createElement('input');
				gambleStation.setAttribute("type", "number");
				gambleContainer.appendChild(gambleStation);
				gambleStation.id = 'gamblerstuff';
				var biddingButton = document.createElement('button');
				biddingButton.innerHTML = "I agree to the binding contract."
				biddingButton.setAttribute("onclick", "goGamble(document.getElementById('gamblerstuff').value)");
				gambleContainer.appendChild(biddingButton);
				var messageBoard = document.createElement('div');
				messageBoard.style.font = 'bold 14pt comic sans ms';
				messageBoard.style.color = 'red';
				messageBoard.innerHTML = "Didn't your parents tell you not to gamble?";
				messageBoard.id = 'board';
				gambleContainer.appendChild(messageBoard);
			}
			function goGamble(wager)
			{
				if(wager < 0 || wager > potatoCount)
				{
					gambleMessage.innerHTML = "Sorry kid, you're outta luck.";
				}
				else
				{
					potatoCount -= wager;
					display();
					var hao = parseInt(Math.random()*4);
					if(hao > 0)
					{
						var real = parseInt(Math.random()*3);
						if(real > 0)
						{
							var deal = parseInt(Math.random()*2);
							if(deal > 0)
							{
								potatoCount += (2*wager);
							}
							else gambleMessage.innerHTML = "I think you lost.";
						}
						else gambleMessage.innerHTML = "How pitiful.";
					}
					else gambleMessage.innerHTML = "You already lost?";
				}
				display();
			}
			function addClick()
			{
				potatoCount += clickValue;
				display();
			}
			function display()
			{
				buttonDiv.innerHTML = "You have " + potatoCount + " potatoes.";
				showClickValue.innerHTML = "Each time you click, you gain " + clickValue + " potatoes.";
				showIdleValue.innerHTML = "Every second, you are receiving " + totalIdle + " potatoes.";
				document.getElementById('scoring').value = potatoCount;
			}
			function idleClick(c, g)
			{
				if(potatoCount >= c)
				{
					potatoCount -= c;
					totalIdle += g;
					setInterval(function(){
					potatoCount += g;
					display();
					}, 1000);
				}
			}
			function changeClickValue(car, brian)
			{
				if(potatoCount >= car)
				{
					potatoCount -= car;
					clickValue += brian;
					display();
				}
			}
			function swapUpgrades(node1, node2, node3, myself)
			{
				node1.style.display = 'inline-block';
				node2.style.display = 'none';
				node3.style.display = 'none';
				for(var poop = 0; poop < allButtons.length; poop++)
				{
					allButtons[poop].style.backgroundColor = 'white';
				}
				myself.style.backgroundColor = 'yellow';
			}
			function changeMessage()
			{
				var crab = parseInt(Math.random()*2);
				var request = new XMLHttpRequest();
				request.onreadystatechange = function(){
					if(request.readyState == 4)
					{
						stringMessage = request.responseText;
						var respond = '';
						for(var i = 2; i<stringMessage.length-2; i++)
						{
							respond += stringMessage[i];
						}
						if(crab == 0)
						{
							messageDisplay.innerHTML = respond + '<br />' + "Your clicks are worth twice as much!";
							var storage = clickValue;
							clickValue = Math.round(clickValue*2);
							setTimeout(revertClickValue, 10000, storage);
						}
						else 
						{
							messageDisplay.innerHTML = respond + '<br />' + "Your clicks are worth half as much.";
							var storage = clickValue;
							clickValue = Math.round(clickValue/2);
							setTimeout(revertClickValue, 10000, storage);
						}
					}
				}
				var url = 'messages.php?javiy='+crab;
				request.open("GET", url, true);
				request.send(null);
			}
			function revertClickValue(original)
			{
				clickValue = original;
				messageDisplay.innerHTML = "Hello there.";
			}
			function borderChange(element, color)
			{
				element.style.border = "6px dashed " + color;
			}
			function changeDisplay(towhat)
			{
				hiScore.style.display = towhat;
			}
		</script>
	</head>
	<body onload = "startup();">
		<img src = 'letitglow.jpg' id = 'bkimg'/>
		<div class = 'main'>
			<div id = 'moo'><img src = 'test 1.png' /></div>
			<div class = 'potatocontain'>
				<img id = 'potato' onclick = 'addClick();' onmousedown = 'borderChange(this, "violet");' onmouseleave = 'borderChange(this, "transparent");' onmouseup = 'borderChange(this, "transparent");' src = 'button.png'/>
			</div>
			<br />
			<div id = 'pointdiv'></div>
			<div id = 'valueclick'></div>
			<div id = 'idlevalue'></div>
			<div id = 'bigboxie'>
				<span id = 'messBox'>Hello there.</span>	
			</div>
			<form method = 'post' action = "index.php">
				Name:<input type = 'text' name = 'username'>
				<br />
				I know that my progress will be erased upon clicking this button.<input type = 'radio' name = 'feature' value = 'save' checked>
				<input id = 'scoring' type = 'hidden' name = 'score'>
				<input type = 'submit'>
			</form>
			<button onclick = "changeDisplay('inline-block');">Check High Score</button>
			<?php
			?>
		</div>
		<?php
			$ternary = getDBResults("SELECT * FROM `score`");
			$min = -1;
			for($toot = 0; $toot < count($ternary); $toot++)
			{
				$comparison = $ternary[$toot][1];
				if($comparison > $min)
				{
					$hiscore = $toot;
					$min = $comparison;
				}
			}
			echo "<div id = 'hiscore'>The current highscore is ".$ternary[$hiscore][1]." potatoes, achieved by ".$ternary[$hiscore][0].".<img src = 'toodle.png' id = 'toodles'></div>";
		?>
		<div id = 'upgradebox'>
			<div id = 'swap'>
				<button onclick = 'swapUpgrades(idleContainer, manualContainer, gambleContainer, this)';>IDLE</button>
				<button onclick = 'swapUpgrades(manualContainer, idleContainer, gambleContainer, this)';>MANUAL</button>
				<button onclick = 'swapUpgrades(gambleContainer, idleContainer, manualContainer, this)';>GAMBLE</button>
			</div>
			<div id = "idleupgrades"></div>
			<div id = "manualupgrades"></div>
			<div id = "gambleupgrades"></div>
		</div>
	</body>
</html>