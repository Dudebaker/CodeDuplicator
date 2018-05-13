<?php
	$data = new stdclass();
	$data->strFind 		= '';
	$data->intFind 		= null;
	$data->strReplace	= '';
	$data->intReplaceFrom	= null;
	$data->intReplaceTo	= null;
	$data->strSeparator	= '';
	$data->strCode		= '';
	$data->arrResult	= array();		

	if(isset($_POST) && count($_POST) == 7) duplicate($data);

	function duplicate(&$data){
		$data->strFind 		= (string)$_POST['strFind'];	 	
		$data->intFind 		= (int)$_POST['intFind'];
		$data->strReplace	= (string)$_POST['strReplace'];
		$data->intReplaceFrom 	= (int)$_POST['intReplaceFrom'];
		$data->intReplaceTo   	= (int)$_POST['intReplaceTo'];
		$data->strSeparator   	= (string)$_POST['strSeparator'];
		$data->strCode        	= (string)$_POST['strCode'];

		for($i = $data->intReplaceFrom; $i <= $data->intReplaceTo ; $i++){
			$data->arrResult[] = str_replace($data->strFind . $data->intFind, $data->strReplace . $i, $data->strCode);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Code Duplicator</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<style type="text/css" media="screen">
			.margin5{
				margin: 5px;
			}	

			.right{
				text-align: right;
			}

			.full{
				width: 100%;
			}

			.col1{
				width: 170px;				
			}

			label.col1{
				display: inline !important;
			}

			span.col1{
				display: inline-block;
			}

			.error{
				color: #FF0000;
			}

			#duplicatorResult{
				white-space: pre;
			}	

			.modal-lg {;
			    overflow-x: hidden;
			}		
		</style>
	</head>	
	<body>
		<hr class="container">
		<div class="container">
			<h3>Code Duplicator</h3>
			<h5>(created mainly for Rainmeter skin development)</h5>
			<form class="form-inline" id="duplicator" method="post">
				<div class="form-group full">
					<label class="margin5 col1 right" for="strFind">Find:</label>
					<input type="text" class="form-control margin5" id="strFind" required autocomplete="on" placeholder="Hello" name="strFind" value="<?=$data->strFind;?>" onkeyup="$('#resultFindString').html(this.value + $('#intFind').val())">
					<input type="text" class="form-control margin5" id="intFind" required autocomplete="on" placeholder="1" name="intFind" value="<?=$data->intFind;?>" onkeyup="$('#resultFindString').html($('#strFind').val() + this.value)">
				</div>
				<div class="form-group">
					<span class="margin5 col1 right">Resulting find string:</span><span id="resultFindString" class="margin5"><?=$data->strFind . $data->intFind;?></span>
				</div>
				<div class="form-group">
					<label class="margin5 col1 right" for="strReplace">Replace:</label>
					<input type="text" class="form-control margin5" id="strReplace" required autocomplete="on" placeholder="World" name="strReplace" value="<?=$data->strReplace;?>" onkeyup="$('#resultFindStringStart').html(this.value + $('#intReplaceFrom').val()); $('#resultFindStringEnd').html(this.value + $('#intReplaceTo').val())">
					<label class="margin5" for="intReplaceTo">Start:</label>
					<input type="text" class="form-control margin5" id="intReplaceFrom" required autocomplete="on" placeholder="2" name="intReplaceFrom" value="<?=$data->intReplaceFrom;?>" onkeyup="$('#resultFindStringStart').html($('#strReplace').val() + this.value);">
					<label class="margin5" for="intReplaceTo">End:</label>
					<input type="text" class="form-control margin5" id="intReplaceTo" required autocomplete="on" placeholder="10" name="intReplaceTo" value="<?=$data->intReplaceTo;?>" onkeyup="$('#resultFindStringEnd').html($('#strReplace').val() + this.value);">
				</div>
				<div class="form-group">
					<div class="full">
						<span class="margin5 col1 right">Duplication starts with:</span><span id="resultFindStringStart" class="margin5"><?=$data->strReplace . $data->intReplaceFrom;?></span>
					</div>
					<div class="full">
						<span class="margin5 col1 right">Duplication ends with:</span><span id="resultFindStringEnd" class="margin5"><?=$data->strReplace . $data->intReplaceTo;?></span>
					</div>
				</div>
				<div class="form-group full">
					<label class="margin5 col1 right" for="strSeparator">Separator:</label>
					<input type="text" class="form-control margin5" id="strSeparator" autocomplete="on" placeholder="\n" name="strSeparator" value="<?=$data->strSeparator;?>">
				</div>
				<div class="form-group full">
					<label class="margin5 col1 right" for="strCode">Code:</label>
					<textarea class="form-control margin5" id="strCode" style="resize: both;" rows="5" cols="94" required name="strCode"><?=$data->strCode;?></textarea>
				</div>				
				<input type="submit" class="btn btn-primary margin5 full" value="Duplicate"></input>
				(Caution: search & replace is case-sensitive!)
			</form>	
			<?php if(!empty($data->arrResult)){ ?>			
			<div class="modal" id="duplicatorResult">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Duplicator Result:</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<?php 
								$data->strSeparator = str_replace('PHP_EOL', PHP_EOL, $data->strSeparator);
								$data->strSeparator = str_replace('<br>', PHP_EOL, $data->strSeparator);
								$data->strSeparator = str_replace('\r\n', PHP_EOL, $data->strSeparator);
								$data->strSeparator = str_replace('\n', PHP_EOL, $data->strSeparator);
								$data->strSeparator = str_replace('\r', PHP_EOL, $data->strSeparator);
							?>
							<textarea class="form-control margin5" id="strResult" rows="10" style="resize: both;"><?php foreach($data->arrResult as $result) echo $result . $data->strSeparator; ?></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-info copyToClipboard" id="copyToClipboard" onclick="ToClipBoard()">Copy to clipboard</button>							
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				$(window).on('load',function(){
					$('#duplicatorResult').modal('show');
				});

				function ToClipBoard(){
					document.getElementById("strResult").select();
					document.execCommand("Copy");
					alert("Result copied to clipboard");
				};
			</script>			
			<?php } ?>
		</div>
	</body>
</html>
