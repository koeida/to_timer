<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Twin Oaks Labor Timer</title>

		<script src="xdate.js"></script>
		<script>
			var timerStart = new XDate();
			var currentArea = 0;
			var quota = 6;
			var fulfilledQuota = 0;
			var userData = new Array();
			var debugAddition = 60 * 59 + 50;

			function startTimer(area) {
				timerStart = new XDate();
				$("#stop").show();
				$(".area").hide();
				$("#maintimer").show();
				$("#laborcredits").show();
				$(".progress").show();
				setTimeout(function(){updateTimer(area)},100);
			}

			function stopTimer() {
				var now = new XDate();
				$("#stop").hide();
				$(".area").show();
				$("#maintimer").hide();
				$("#laborcredits").hide();
				$("#lcprogress")[0].style.width = "0%";
				$("#lcprogress").attr("aria-valuenow",0);
				$(".progress").hide();
			}

			function laborCreditsFrom(start) {
				var now = new XDate();
				return (Math.floor(timerStart.diffSeconds(now) + debugAddition) / 60 / 60);
			}

			function updateTimer(area) {
				if(!$("#stop").is(":visible")) {
					return;
				}
				var now = new XDate();
				var debugHours = debugAddition / 60 / 60;
				if(debugHours + timerStart.diffHours(now) - fulfilledQuota > 1) {
					fulfilledQuota += 1;
				}
				var laborCredits = laborCreditsFrom(timerStart).toFixed(4);
				var secsDiff = timerStart.diffSeconds(now) + debugAddition;
				var minutes = Math.floor(secsDiff / 60);
				var seconds = Math.floor(secsDiff - (minutes * 60));	
				var timerOutput = toDoubleDigit(minutes) + ":" + toDoubleDigit(seconds);

				var progressBarStatus = laborCredits - fulfilledQuota;
				
				$("#lcprogress")[0].style.width = (progressBarStatus * 100) + "%";
				$("#lcprogress").attr("aria-valuenow",progressBarStatus);

				$("#laborcredits").html(laborCredits);
				$("#maintimer").html(timerOutput);
				setTimeout(function(){updateTimer(area)},100);
			}

			function toDoubleDigit(num) {
				if(num < 10) {
					return "0" + num;
				} else {
					return num;
				}
			}
		</script>

		<style>
			body {
				background-color: #608094 !important;
				color: white !important;
			}

			#maintimer {
				font-size: 86px;
				text-align: center;
			}

			#laborcredits {
				font-size: 24px;
				text-align: center;
			}

			#lcprogress {
				background-color: #65A184 !important;
			}

			div.progress {
				height: 50px !important;
				border: 1px solid #CCCCCC;
				background-color: #ABC8B9 !important;
			}

			button#stop {
				width: 100% !important;
				font-size: 50px;
			}

			button {
				font-size: 50px !important;
				color: white !important;
				background-color: #7C94A4 !important;
			}

			button:hover {
				font-size: 50px !important;
				color: white !important;
				background-color: #A1B2BD !important;
			}
			
			div.areas {
				width: 100% !important;
			}
			div.areas button.btn-default {
				width: 100% !important; 
			}

		</style>
    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12">
					<p>This is some content in the navbar</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="btn-group-vertical areas">
						<button onclick="startTimer(this)" type="button" class="btn btn-default area">Garden</button>
						<button onclick="startTimer(this)" type=button class="btn btn-default area">Fences</button>
						<button onclick="startTimer(this)" type=button class="btn btn-default area">Dairy</button>
					</div>
					<div class="progress">
						<div id=lcprogress class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="1" style="width:0%">
						</div>
					</div>
					<p id=maintimer></p>
					<p id=laborcredits></p>
					<button onclick="stopTimer(this)" id=stop type="button" class="btn btn-default" style="display:none">Stop</button>
				</div>
			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
  </body>
</html>