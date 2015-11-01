<?php 

// Str 1 = GTTCAAT
// Str 2 = CTTCGATT

	include_once("blosum62.php");

	if (!empty($_POST)) {
		$arrString1 = preg_split ('//', strtoupper($_POST['str1']));
		$arrString2 = preg_split ('//', strtoupper($_POST['str2']));
		
		array_pop($arrString1);
		array_pop($arrString2);

		$scoreTable = [];
		$max = -10;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Smith-Waterman</title>
	<style type="text/css">
	input {
		font-size: 24px;
	}
	td {
		font-size: 28px;
		padding: 5px 10px;
		text-align: center;
	}

	table, h2 {
		margin: 10px auto auto 60px;
	}
	</style>
</head>
<body>
<h1>Smith Waterman Algorithm</h1>
<form method="POST">
	String 1 : <input type="text" name="str1" style="width: 500px" value="<?php echo !empty($_POST['str1']) ? $_POST['str1'] : '' ?>" /><br/>
	String 2 : <input type="text" name="str2" style="width: 500px" value="<?php echo !empty($_POST['str2']) ? $_POST['str2'] : '' ?>" />
	<input type="submit" value="Submit" />
</form>

<hr/>

<?php if (!empty($_POST)) : ?>
	<table border="1">
		<?php for ($i = 0; $i < count($arrString2); $i++) : ?>
			<tr>
			<?php for ($j = 0; $j < count($arrString1); $j++) : ?>
				<?php $scoreTable[$i][$j] = 0; ?>
				<?php if ($i == 0) : ?>
					<td><?php echo $arrString1[$j]; ?></td>
				<?php elseif ($j == 0) : ?>
					<td><?php echo $arrString2[$i]; ?></td>
				<?php else : ?>
					<td>
						<?php 
							$choice1 = 0;
							$choice2 = $scoreTable[$i-1][$j-1] + blosum62($arrString1[$j], $arrString2[$i]);
							$choice3 = $scoreTable[$i-1][$j] - 1;
							$choice4 = $scoreTable[$i][$j-1] - 1;
							$scoreTable[$i][$j] = max($choice1, $choice2, $choice3, $choice4);
							if ($max < $scoreTable[$i][$j]) $max = $scoreTable[$i][$j];

							echo $scoreTable[$i][$j];
						?>
					</td>
				<?php endif; ?>
			<?php endfor; ?>
			</tr>
		<?php endfor; ?>

	</table>
<h2>BEST SCORE : <?php echo $max; ?></h2>
<?php endif; ?>
</body>
</html>