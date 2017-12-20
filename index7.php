<?php //поле с выюором оценки
$dbParams = require (
	'db.php'
);

$db=new PDO(
	"mysql: host=localhost; dbname=".
	$dbParams['database'].
	"; charset=utf8",// dbname- имя бд, host- имя хоста, charset-кодировка  (подключились к бд в резульитате создался PDO)
	$dbParams['username'],
	$dbParams['password']
); 
$marksSql= ' SELECT `student`.`lastName`, `subject`.`name`,`mark`.`value` FROM `mark`
INNER JOIN `student`
ON `student`.`id`=`mark`.`studentId`
INNER JOIN `course` ON `mark`.`courseId`=`course`.`id`
INNER JOIN `subject`ON `subject`.`id`=`course`.`subjectId`
';
$values=[];
if (isset ($_GET['name'])){
	$marksSql.='WHERE `lastName` LIKE :value';
	$values['value']= '%' .$_GET['name'].'%';
}	
$marksQuery=$db
->prepare ($marksSql);


$marksQuery
	->execute($values);
	
$marks=$marksQuery
-> fetchAll(PDO :: FETCH_ASSOC);



?>
<html>
	<body>
		<form>
			<label>
			Фамилия
			<input type="text" name="name" value="<?php
			if (isset ($_GET['name'])) {
					echo htmlspecialchars ($_GET['name']);
			}
			?>">
			</label>
			<input type="submit"  value="Поиск">
			<a href="index7.php">Все записи</a>
		</form>
			<table>
				<tr>
				<th>Фамилия</th>
				<th>Дисциплина</th>
				<th>Оценка</th>
			<tr>
			<?php foreach ($marks as $mark){ ?>
			<tr>
		
				<td><?=htmlspecialchars ($mark['lastName']) ?></td>
				<td><?=htmlspecialchars ($mark['name']) ?></td>
				<td><?=htmlspecialchars ($mark['value']) ?></td>
			<tr>
			<?php } ?>
		</table>
	</body>
</html>